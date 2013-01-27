/**
  * Apmgr
  * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
  * Misc utilities that are used in dataset generator
  */
#ifndef APMGR_H_
#define APMGR_H_

#ifdef	__cplusplus
extern "C" {
#endif
#define maximum 1000
#define XMLHEADER "<?xml version=\"1.0\" encoding=\"UTF-8\"?>"
#define XMLROOTHEAD "<dataset>"
#define XMLROOTEND "</dataset>"
#define XMLSUFFIX ".xml"
#include <mysql.h>
typedef struct TableStack {
    char *key,*value;
    struct TableStack *link;
} STACK;

typedef struct TableQueue {
    char *key,*value;
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
void enqueue(QUEUE **, QUEUE **, char*,char*);
int emptyQueue(QUEUE *);
void printTableQueue(QUEUE *);
void purgeQueue(QUEUE **, QUEUE **);
void showTables(MYSQL *);
char * generateFilename(char*,char*);
void generateFlatFile(MYSQL *);
void writeFlatFile(QUEUE *,char *,FILE *);
FILE *prepareFlatFile();
void unsetFlatFile(FILE *);
int showFlatMenu();
void closeFile(FILE *);
void inputClean(char*);
FILE *openFile(char *, char *);
#ifdef	__cplusplus
}
#endif

#endif	/* _MODELAPMGR_H */