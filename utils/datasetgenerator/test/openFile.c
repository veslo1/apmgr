#include <stdio.h>
#include <stdlib.h>
#include <string.h>

#define SRC "/usr/local/www/apmgr/utils/datasetgenerator/conf/options.cnf"

char *str_explode(char *,char*);
void str_slice(char*,int,char*);
char *parse_file(FILE *,char *,char *);

int main(){
  FILE * config;
  char *user,*host,*pwd,*db;
  config = fopen(SRC,"r");

  if( config!=NULL ) {
	user=parse_file(config,(char*)"=",(char*)"user");
	host=parse_file(config,(char*)"=",(char*)"host");
	pwd=parse_file(config,(char*)"=",(char*)"pwd");
	db = parse_file(config,(char*)"=",(char*)"database");
	printf("User=%s;Host=%s;Password=%s;Database=%s\n",user,host,pwd,db);
	fclose(config);
  } else {
	fprintf(stderr, "We couldn't open the file,verify that options.cnf exists and is readable\n");
    exit(1);
  }
  return 0;
}

char *parse_file(FILE *config,char *separator,char *key) {
  char line[1000];
  char buffer[1000];
  char *copy;
  while(fgets(line, 1000, config) != NULL) {
	 /* get a line, up to 1000 chars from line.  done if NULL */
	 sscanf (line, "%s", &buffer);
	 if( strstr(line,key) ) {
		copy = str_explode(buffer,separator);
		break;
	 }
	 /* convert the string to a long int */
	 //printf ("%s\n", buffer);
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
		printf("Separator found at %d in %s\n",i,buffer);
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
