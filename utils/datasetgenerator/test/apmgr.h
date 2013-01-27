/**
  * Apmgr
  * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
  * Misc utilities that are used in dataset generator
  */
#ifndef APMGR_H_
#define APMGR_H_
#define maximum 1000
#include <mysql.h>
typedef struct TableStack {
    char *value;
    struct TableStack *link;
} STACK;

typedef struct TableQueue {
    char *value;
    struct TableQueue *link;
} QUEUE;

char *str_explode(char *,char*);
void str_slice(char*,int,char*);
char *parse_file(FILE *,char *,char *);
void showMenu();
void pushElement(STACK **, char*);
int emptyStack(STACK **);
void printTableStack(STACK *);
void purgeStack(STACK*);
void enqueue(QUEUE **, QUEUE **, char*);
int emptyQueue(QUEUE *);
void printTableQueue(QUEUE *);
void purgeQueue(QUEUE **, QUEUE **);
void showTables(MYSQL *);
#endif
