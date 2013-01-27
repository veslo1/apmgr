#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <mysql.h>
#include "apmgr.h"
/**
  * Parse a file that has a key=value type and return the specified key
  * FILE *config defined in SRC define
  * char *separator The separator that is used in the string of the file
  * char *key The key that you are looking for
  * @return string
  */
char *parse_file(FILE *config,char *separator,char *key) {
  char line[maximum];
  char buffer[maximum];
  char *copy;
  while(fgets(line, maximum, config) != NULL) {
	 /* get a line, up to 1000 chars from line.  done if NULL */
	 sscanf (line, "%s", &buffer);
	 if( strstr(line,key) ) {
		copy = str_explode(buffer,separator);
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
char *str_explode(char *subject,char *separator) {
  char *buffer,*match;
  int i,j=0,size;
  int found=0;

  if( strlen(subject)>0 ) {
	buffer = (char*) malloc(sizeof(char)*strlen(subject));
	memcpy(buffer,subject,strlen(subject)+1);
	size = strlen(buffer);
	for(i=0;i<size||found!=1;i++) {
	  if( buffer[i]==*separator ){
 /**
  ** The maximum size is now from the place i found the string until the maximum lenght of the string
  ** Generate a new string with space for size-i chars
  */
		match = (char*) malloc(sizeof(char)*(strlen(buffer)-i));
		found = 1;
		str_slice(buffer,i,match);
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
void str_slice(char *buffer,int source,char *dest) {
  int lenght,j;
  lenght = strlen(buffer)-source;
  j=0;
  source++;//skip separator
  while(j<lenght) {
	dest[j] = buffer[source];
	source++;
	j++;
  }
}

/**
** Displays the menu
*/
void showMenu() {
  printf("==========DatasetGenerator===========\n");
  printf("1-To Create a Flat Dataset\n");
  printf("2-To Create a Structured Dataset\n");
  printf("3-To Show the tables that you have\n");
  printf("4-To Exit\n");
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
        memcpy(buffer->value,value, strlen(value)+1);
        if( emptyStack(head) ) {
            buffer->link = NULL;
        } else {
            buffer->link = *head;
        }
        *head = buffer;
    } else {
        fputs("Not enough memory.", stdout);
        abort();
    }
}

/**
 * Corroborate if the stack is empty
 * @return int
 */
int emptyStack(STACK **head) {
    return *head==NULL;
}

/**
 * print the table to stdout
 */
void printTableStack(STACK *table) {
    while(table!=NULL) {
        printf("%s-->",table->value);
        table=table->link;
    }
    fputs("Head\n",stdout);
}

/**
 * Wipe out the stack
 */
void purgeStack(STACK *table) {
    STACK *top = malloc(sizeof(STACK));
    while(table!=NULL) {
        top = table;
        table = (top)->link;
        free(top);
    }
}

void enqueue(QUEUE **head, QUEUE **last, char *value) {
    QUEUE *buffer;
    buffer = malloc(sizeof (QUEUE));

    if (buffer != NULL) {
        buffer->value = (char*) malloc(sizeof (char) * strlen(value));
        memcpy(buffer->value, value, strlen(value) + 1);
        buffer->link = NULL;

        if (emptyQueue((*head))) {
            *head = buffer;
        } else {
            (*last)->link = buffer;
        }
        (*last) = buffer;
    } else {
        fputs("Not enough memory.", stdout);
        abort();
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
        printf("%s-->", head->value);
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
void showTables(MYSQL *con){
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
