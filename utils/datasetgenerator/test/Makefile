CC := gcc
SRC := $(PWD)
BINDIR := $(PWD)/bin/
AR := ar
RCS := rcs
MYSQLFLAGS = $(shell mysql_config --cflags)
MYSQLLIB = $(shell mysql_config --libs)

openfile:apmgr.a
	$(CC) -ggdb -o $(BINDIR)openfile $(SRC)/openFile.c -I$(BINDIR) -L$(BINDIR) -lapmgr 

apmgr.a:
	$(CC) -c $(SRC)/apmgr.c -o $(BINDIR)libapmgr.o $(MYSQLFLAGS) $(MYSQLLIB)
	$(AR) $(RCS) $(BINDIR)libapmgr.a $(BINDIR)libapmgr.o

ncurses:
	$(CC) -o $(BINDIR)ventanita $(SRC)/window.c -lncurses

#curses:
#	$(CC) -o $(BINDIR)vcurse $(SRC)/cursewindow.c -lcurses

stack:
	$(CC) -ggdb -o $(BINDIR)stack $(SRC)/stack.c

queue:
	$(CC) -ggdb -o $(BINDIR)queue $(SRC)/queue.c

read:
	$(CC) -ggdb -o $(BINDIR)read $(SRC)/read.c

writefile:
	$(CC) -ggdb -o $(BINDIR)writefile $(SRC)/write.c

clean:
	$(RM) $(BINDIR)*
	$(RM) *.swp
