#!/usr/bin/env bash

MYSQL=$1
DBUSER=$2
DBPASS=$3
DBNAME=$4
DBTEST=$5
STOREPROC=$6
MYSQLDUMP=$7
FLAGS=$8
echo "We start on "$(date)
echo "Dropping database"
$MYSQL -u$DBUSER -p$DBPASS -hlocalhost -e "DROP DATABASE $DBTEST"
echo "Creating database $DBTEST"
$MYSQL -u$DBUSER -p$DBPASS -hlocalhost -e "CREATE DATABASE $DBTEST"
echo "Updating Schema ($DBTEST)"
$MYSQLDUMP -u$DBUSER -p$DBPASS -hlocalhost $FLAGS $DBNAME |$MYSQL -u$DBUSER -p$DBPASS -hlocalhost $DBTEST
echo "Adding store-proc to $DBTEST"
$MYSQL -u$DBUSER -p$DBPASS -hlocalhost $DBTEST<$STOREPROC
echo "We finish on "$(date)