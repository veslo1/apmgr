#!/bin/bash
. bashFunctions.sh
# @author Jorge Omar Vazquez<jvazquez@debserverp4.com.ar>
# Variables
ENVIRONMENT=${1-"test"}
DEBUG=${2-"1"}
DBUSER=""
DBPASS=""
DBNAME=""
DBHOST=""
MYSQL=""
MYSQLDUMP=""
REPORTBACKUP="report.log"

# We prepare the environmental variables
bootstrap $ENVIRONMENT

# Backup the report tables
reportbackup
