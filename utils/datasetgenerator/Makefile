BINDIR := $(PWD)/bin/
CC := gcc
SRC := $(PWD)/src/
TESTDIR := $(PWD)/test/
LIBDIR :=$(SRC)lib/
INCLUDE :=$(PWD)/include
AR := ar
RCS := rcs
OS := $(shell uname)
#In mac change this to mysql_config5
MYSQLFLAGS = $(shell mysql_config --cflags)
MYSQLLIB = $(shell mysql_config --libs)
RM = rm

all: apmgr.a
	$(CC) -ggdb $(SRC)generator.c -I$(INCLUDE) -L$(INCLUDE) -lapmgr $(MYSQLFLAGS) $(MYSQLLIB)  -o $(BINDIR)generator

apmgr.a:
	$(CC) -ggdb -c $(SRC)apmgr.c -o $(INCLUDE)/libapmgr.o $(MYSQLFLAGS) $(MYSQLLIB)
	$(AR) $(RCS) $(INCLUDE)/libapmgr.a $(INCLUDE)/libapmgr.o

clean:
	$(RM) -f $(INCLUDE)/*
	$(RM) -f $(BINDIR)*
