#include <stdio.h>
#include <stdlib.h>
#include <string.h>

typedef struct TableQueue {
    char *value;
    struct TableQueue *link;
} QUEUE;

void enqueue(QUEUE **, QUEUE **, char*);
int emptyQueue(QUEUE *);
void printTableQueue(QUEUE *);
void purgeQueue(QUEUE **, QUEUE **);

int main() {
    QUEUE *head = NULL, *tail = NULL;

    enqueue(&head, &tail, (char*) "Prueba de dato numero uno");
    enqueue(&head, &tail, (char*) "Prueba de dato numero dos");
    enqueue(&head, &tail, (char*) "Prueba de dato numero tres");
    fputs("About to print", stdout);
    printTableQueue(head);
    purgeQueue(&head, &tail);
    fputs("End of run", stdout);
    return (EXIT_SUCCESS);
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
