#include <stdio.h>
#include <string.h>
#include <stdlib.h>
#define DESTDIR "/usr/local/www/apmgr/utils/datasetgenerator/test/xml/"
#define KEYSIZE 100
int main() {
  FILE *content;
  char *filename;
  fputs("enter some text: ", stdout);
  fflush(stdout);
  filename = (char*) malloc(sizeof (char) * KEYSIZE);
  fgets(filename, sizeof(filename)*KEYSIZE, stdin);
  fflush(stdin);
//  content = fopen(strcat(filename),"w");
 // if(content!=NULL) {
//	fputs("Opened",stdout);
//	fclose(content);
//  }
}

void generateFilename(char *xmlName) {
  char *buffer=DESTDIR;
}
