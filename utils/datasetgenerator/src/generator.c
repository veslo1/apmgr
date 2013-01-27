/** 
 * File:   generator.c
 * Author: jvazquez
 *
 * Created on May 13, 2010, 10:13 PM
 */

#include <stdio.h>
#include <stdlib.h>
#include <mysql.h>
#include <string.h>
#include "apmgr.h"
#define SRC "/usr/local/www/apmgr/utils/datasetgenerator/conf/options.cnf"


int main(int argc, char** argv) {
    MYSQL *conn;
    FILE * config, *content;
    char *server, *user, *password, *database, *dest, *filename, *tablename;
    int option = 0;

    config = fopen(SRC, "r");
    if (config != NULL) {
        user = parse_file(config, (char*) "=", (char*) "user");
        server = parse_file(config, (char*) "=", (char*) "host");
        password = parse_file(config, (char*) "=", (char*) "pwd");
        database = parse_file(config, (char*) "=", (char*) "database");
        fclose(config);
    } else {
        fprintf(stderr, "We couldn't open the file,verify that options.cnf exists and is readable\n");
        exit(1);
    }
    conn = mysql_init(NULL);

    /* Connect to database */
    if (!mysql_real_connect(conn, server,
            user, password, database, 0, NULL, 0)) {
        fprintf(stderr, "%s\n", mysql_error(conn));
        exit(1);
    }

    do {
        showMenu();
        scanf("%d", &option);
        switch (option) {
            case 1:
                generateFlatFile(conn);
                break;
            case 2:
                showTables(conn);
                break;
            case 3:
                printf("Goodbye!!\n");
                break;
        }
    } while (option != 3);

    mysql_close(conn);

    return 0;
}
