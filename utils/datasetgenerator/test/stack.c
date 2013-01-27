/*
 * File:   main.c
 * Author: jvazquez
 *
 * Created on May 16, 2010, 2:35 PM

#include <stdio.h>
#include <stdlib.h>
#include <string.h>

struct TableStack {
    char *value;
    struct TableStack *link;
};

typedef struct TableStack STACK;

void pushElement(STACK **, char*);
int emptyStack(STACK **);
void printTableStack(STACK *);
void purgeStack(STACK*);

int main(int *argc,char **argv) {
    STACK *myStack=NULL;

    pushElement(&myStack, (char*) "Prueba de dato");
    pushElement(&myStack, (char*) "Prueba de dato numero dos");
    printTableStack(myStack);
    purgeStack(myStack);
    fputs("End of run", stdout);
    return (EXIT_SUCCESS);
}


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

int emptyStack(STACK **head) {
    return *head==NULL;
}

void printTableStack(STACK *table) {
    while(table!=NULL) {
        printf("%s-->",table->value);
        table=table->link;
    }
    fputs("Head\n",stdout);
}

void purgeStack(STACK *table) {
    STACK *top = malloc(sizeof(STACK));
    while(table!=NULL) {
        top = table;
        table = (top)->link;
        free(top);
    }
}
*/
