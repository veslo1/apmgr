#!/bin/bash
. bashFunctions.sh

# Mini application in bash
# Example aclTemplate string int
# string The mode of this app test|production. default test
# int The level of debug we use. Valid values are 1 to 3.>=2 we log to a file
# Author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>

# Variables
ENVIRONMENT=${1-"test"}
DEBUG=${2-"1"}
DBUSER=""
DBPASS=""
DBNAME=""
DBHOST=""
MYSQL=""
MYSQLDUMP=""
ACLUP="aclUp.sql"
TARGETS="actions controllers modules permission rolePermission reports"
REPORTBACKUP="report.log"
REPORTBACK=""

# We prepare the environmental variables
bootstrap $ENVIRONMENT

log4bash $DEBUG "<<Program initialized>>";
`touch $ACLUP`
prepareup $ACLUP

runup $ACLUP
prepareupend $ACLUP
echo -e "\033[1mDo not forget to remove the constraints from the CREATE TABLE\033[0m"
if [ -e "$REPORTBACKUP" ]
then
	REPORTBACK=`wc -l $ACLUP|awk '{print $1}'`
	if [ "$REPORTBACK" -gt "0" ]
	then
	reportrestore $ACLUP
	else
		if [ "$REPORTBACK" -eq "0" ]
		then
			echo "No reports to restore"
		fi
	fi
else
	log4bash $DEBUG "Notice!. Your application did not had a backup file for reports,so there is nothing to restore"
fi
log4bash $DEBUG "<<Program ends>>"