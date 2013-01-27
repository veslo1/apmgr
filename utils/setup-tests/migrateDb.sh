#!/bin/bash
USR=dev
PSWD=dev
DROPDB="DROP DATABASE apmgr_tests"
CREATEDB="CREATE DATABASE apmgr_tests"
APMGR=../cleanTableForTesting.sql

# Complete with your path if mysql is in another place
case "`uname`" in
  Darwin*)
      MYSQL=/opt/local/bin/mysql5
      MYSQLDUMP=/opt/local/bin/mysqldump5
    ;;
  Cygwin*)
      # not many things to do here
    ;;
  *)
  	MYSQL=/usr/bin/mysql
    MYSQLDUMP=/usr/bin/mysqldump
  ;;
esac

$MYSQL -u$USR -p$PSWD -e "$DROPDB"
$MYSQL -u$USR -p$PSWD -e "$CREATEDB"
$MYSQLDUMP -u$USR -p$PSWD --opt --skip-add-locks apmgr|$MYSQL -u$USR -p$PSWD -C apmgr_tests
$MYSQL -u$USR -p$PSWD apmgr_tests< "$APMGR" 
echo "Done"
