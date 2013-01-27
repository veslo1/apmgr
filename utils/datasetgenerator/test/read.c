#include <stdio.h>
#define KEYSIZE 100
int main() {
    char *buffer;
    fputs("enter some text: ", stdout);
    fflush(stdout);
    buffer = (char*) malloc(sizeof (char) * KEYSIZE);
    fgets(buffer, sizeof buffer*KEYSIZE, stdin);
    fflush(stdin);
    return 0;
}