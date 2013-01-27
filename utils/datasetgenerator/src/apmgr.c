#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include "apmgr.h"
#include <mysql.h>
#include <ctype.h>
#define SRC "/usr/local/www/apmgr/utils/datasetgenerator/conf/options.cnf"

/**
 * Parse a file that has a key=value type and return the specified key
 * FILE *config defined in SRC define
 * char *separator The separator that is used in the string of the file
 * char *key The key that you are looking for
 * @return string
 */
char *parse_file(FILE *config, char *separator, char *key) {
    char *line = (char*) calloc(maximum, sizeof (char[maximum]));
    char *buffer = (char*) calloc(maximum, sizeof (char[maximum]));
    char *copy;
    while (fgets(line, maximum, config) != NULL) {
        /* get a line, up to 1000 chars from line.  done if NULL */
        sscanf(line, "%s", buffer);
        if (strstr(line, key)) {
            copy = str_explode(buffer, separator);
            break;
        }
    }
    rewind(config);
    return copy;
}

/**
 ** Explode a string by separator
 ** Once the needle is found, slice until the end to show the resulting string
 */
char *str_explode(char *subject, char *separator) {
    char *buffer = NULL, *match = NULL;
    int i = 0, j = 0, size;
    int found = 0;

    if (strlen(subject) > 0) {
        buffer = (char*) calloc(strlen(subject), sizeof (char[strlen(subject)]));
        memcpy(buffer, subject, strlen(subject) + 1);
        size = strlen(buffer);
        for (i = 0; i < size || found != 1; i++) {
            if (buffer[i] == *separator) {
                /**
                 ** The maximum size is now from the place i found the string until the maximum lenght of the string
                 ** Generate a new string with space for size-i chars
                 */
                match = (char*) calloc(strlen(buffer), sizeof (char[strlen(buffer)]));
                found = 1;
                str_slice(buffer, i, match);
            }
        }
    }
    return match;
}

/**
 ** Perform a copy of the string that is applied into dest
 ** char *buffer is the string that you are working on
 ** int source is the position from where you are starting to copy
 ** char *dest is the variable that retrieves the copy from
 */
void str_slice(char *buffer, int source, char *dest) {
    int lenght, j;
    lenght = strlen(buffer) - source;
    j = 0;
    source++; //skip separator
    while (j < lenght) {
        dest[j] = buffer[source];
        source++;
        j++;
    }
}

/**
 ** Displays the menu
 */
void showMenu() {
    printf("1-To Create a Flat Dataset\n");
    printf("2-To Show the tables that you have\n");
    printf("3-To Exit\n");
    printf("Press any other key to repeat this menu\n");
}

/**
 * Push one element in the stack
 * @param STACK **head pointer to the stack
 * @param char *value The value that you want to enqueue in the stack
 */
void pushElement(STACK **head, char *value) {
    STACK *buffer;
    buffer = malloc(sizeof (STACK));

    if (buffer != NULL) {
        buffer->value = (char*) malloc(sizeof (char) * strlen(value));
        memcpy(buffer->value, value, strlen(value) + 1);
        if (emptyStack(head)) {
            buffer->link = NULL;
        } else {
            buffer->link = *head;
        }
        *head = buffer;
    } else {
        perror("Not enough memory to push elements");
        exit(1);
    }
}

/**
 * Corroborate if the stack is empty
 * @return int
 */
int emptyStack(STACK **head) {
    return *head == NULL;
}

/**
 * print the table to stdout
 */
void printTableStack(STACK *table) {
    while (table != NULL) {
        printf("%s-->", table->value);
        table = table->link;
    }
    fputs("Head\n", stdout);
}

/**
 * Wipe out the stack
 */
void purgeStack(STACK *table) {
    STACK *top = malloc(sizeof (STACK));
    while (table != NULL) {
        top = table;
        table = (top)->link;
        free(top);
    }
}

/**
 * Push one element inside the queue
 */
void enqueue(QUEUE **head, QUEUE **last, char *key, char *value) {
    QUEUE *buffer;
    buffer = malloc(sizeof (QUEUE));

    if (buffer != NULL) {
        buffer->value = (char*) calloc(strlen(value), sizeof (char[strlen(value)]));
        buffer->key = (char*) calloc(strlen(value), sizeof (char[strlen(key)]));
        memcpy(buffer->value, value, strlen(value) + 1);
        memcpy(buffer->key, key, strlen(key) + 1);
        buffer->link = NULL;

        if (emptyQueue((*head))) {
            *head = buffer;
        } else {
            (*last)->link = buffer;
        }
        (*last) = buffer;
    } else {
        perror("Not enough memory to perform the operation");
    }
}

/**
 * Corroborate if the Queue is empty
 * @return int
 */
int emptyQueue(QUEUE *head) {
    return head == NULL;
}

void printTableQueue(QUEUE *head) {
    while (head != NULL) {
        printf("%s=%s-->", head->key, head->value);
        head = head->link;
    }
    fputs("End of Queue\n", stdout);
}

void purgeQueue(QUEUE **head, QUEUE **tail) {
    QUEUE *buffer = malloc(sizeof (QUEUE));
    if ((*head) != NULL) {
        while ((*head) != NULL) {
            buffer = *head;
            *head = buffer->link;
            free(buffer);
        }
        *tail = NULL;
    }
}

/**
 ** Show all the tables from the given database
 */
void showTables(MYSQL *con) {
    MYSQL_RES *res;
    MYSQL_ROW row;
    /* send SQL query */
    if (mysql_query(con, "show tables")) {
        fprintf(stderr, "%s\n", mysql_error(con));
        exit(1);
    }

    res = mysql_use_result(con);

    /* output table name */
    printf("MySQL Tables in mysql database:\n");
    while ((row = mysql_fetch_row(res)) != NULL)
        printf("%s \n", row[0]);

    /* close connection */
    mysql_free_result(res);
}

char * generateFilename(char *dest, char *xmlName) {
    char *buffer = NULL;
    if (strlen(xmlName) > 1) {
        xmlName[strcspn(xmlName, "\n")] = '\0';
        buffer = (char*) calloc(strlen(dest) + strlen(xmlName) + strlen(XMLSUFFIX), sizeof (char[strlen(dest) + strlen(xmlName) + strlen(XMLSUFFIX)]));
        strcat(buffer, dest);
        strcat(buffer, xmlName);
        strcat(buffer, XMLSUFFIX);
    }
    fputs(buffer, stdout);
    return buffer;
}

/**
 ** GEnerates the flat file with a regular xml file
 */
void generateFlatFile(MYSQL *con) {
    char *tablename = NULL, *value = NULL, *temp = NULL;
    MYSQL_RES *res;
    MYSQL_ROW row;
    QUEUE *head = NULL, *tail = NULL;
    FILE *content = NULL;
    int option, lock = 0;
    do {
        option = showFlatMenu();
        switch (option) {
            case 1:
                if (content == 0) {
                    content = prepareFlatFile();
                    if (content != NULL) {
                        lock = 1;
                    } else {
                        lock = 0;
                        fputs("Failed to prepare file\n", stdout);
                    }
                } else {
                    fputs("You already have the lock and you have written\n", stdout);
                }
                break;
            case 2:
                if (lock == 1) {
                    fputs("which table?:", stdout);
                    fflush(stdout);
                    //  Which table you want to query.We allocate memory, initialized
                    tablename = (char*) calloc(maximum, sizeof (char[maximum]));
                    scanf("%s", tablename);
                    tablename[strcspn(tablename, "\n")] = '\0';
                    //  Prepare the query
                    temp = (char*) calloc(maximum, sizeof (char[maximum]));
                    strcat(temp, "EXPLAIN ");
                    strcat(temp, tablename);
                    //  add a \0 in the end and remove the \n of tablename
                    temp[strcspn(temp, "\n")] = '\0';

                    if (mysql_query(con, temp)) {
                        fprintf(stderr, "%s\n", mysql_error(con));
                    } else {
                        //  Alocate memory for the value
                        value = (char*) calloc(maximum, sizeof (char[maximum]));
                        res = mysql_use_result(con);
                        printf("Field\tType\tNull\n");
                        while ((row = mysql_fetch_row(res)) != NULL) {
                            printf("%s-%s-%s:", row[0], row[1], row[3]);
                            while( strlen(value)<1 ) {
                                fflush(stdin);
                                fgets(value,maximum,stdin);
                            }
                            inputClean(value);
                            fgets(value, maximum, stdin);
                            enqueue(&head, &tail, (char*) row[0], value);
                        }
                        writeFlatFile(head, tablename, content);
                        purgeQueue(&head, &tail);
                    }
                } else {
                    fputs("You haven't opened the file still, please open the file with option 0\n", stdout);
                }
                break;
            case 3:
                if (lock == 1 && content != NULL) {
                    closeFile(content);
                }
                fputs("Back to the main menu\n", stdout);
                break;
        }
    } while (option != 3);
}

/**
 ** Write the content of the queue in the file
 */
void writeFlatFile(QUEUE *head, char *tablename, FILE *content) {
    if (content != NULL) {
        fputs("<", content);
        fputs(tablename, content);
        while (head != NULL) {
            fprintf(content," %s=\"%s\"",head->key,head->value);
//            fputs(" ", content);
//            fputs(head->key, content);
//            fputs("=\"", content);
//            fputs(head->value, content);
//            fputs("\"", content);
//            fputs(" ", content);
            head = head->link;
        }
        fputs("/>", content);
    } else {
        fputs("The directory did not exists or we don't have permisions.Please confirm that datasetgenerator/xml/ exists and is writtable\n", stdout);
    }
}

/**
 ** Open the file for writting data
 */
FILE *prepareFlatFile() {
    FILE *content = NULL, *options = NULL;
    char *filename;
    char *dest = (char*) calloc(maximum, sizeof (char[maximum]));

    //    Open the options file and determine the fullpath where we should store the file
    options = openFile(SRC, (char*) "r");
    if (options != NULL) {
        dest = parse_file(options, (char*) "=", (char*) "dest");
        printf("Filename will be saved in %s\n",dest);
        fputs("Please give me the filename you want to use:", stdout);
        filename = (char*) calloc(maximum, sizeof (char[maximum]));
        while( strlen(filename)<3 ) {
            fgets(filename,maximum,stdin);
        }
        
        inputClean(filename);
        strcat(dest, filename);
        content = fopen(dest, "w");
        if (content != NULL) {
            fputs(XMLHEADER, content);
            fputs("\n", content);
            fputs(XMLROOTHEAD, content);
            fputs("\n", content);
        }
    } else {
        perror("The configuration file is missing\n");
    }

    return content;
}

/**
 ** Display the menu for flatfiles
 ** @return int
 */
int showFlatMenu() {
    int option;
    printf("1-Prepare file\n");
    printf("2-Push data into the flatfile\n");
    printf("3-Finish writing the file and exit this menu\n");
    scanf("%d", &option);
    return option;
}

/**
 ** Close the file and save
 */
void closeFile(FILE *content) {
    if (content != NULL) {
        fputs("\n", content);
        fputs(XMLROOTEND, content);
        fclose(content);
    }
}

/**
 * Remove the trailing \n in a input string
 */
void inputClean(char *content) {
    content[strcspn(content, "\n")] = '\0';
    while(*content!='\0') {
        if( isspace(*content) ) {
            strcpy(content,"_");
        }
        content++;
    }
}

/**
 * Open a file and return a pointer to it
 */
FILE *openFile(char *stream, char *mode) {
    FILE *object = NULL;
    object = fopen(stream, mode);
    return object;
}
