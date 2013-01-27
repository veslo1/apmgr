#!/bin/bash

# log4bash
# The first parameter is the debug level.
# The second parameter is the text to debug
log4bash ( )
{
    LOG="aclTemplate.log"
    if [[ -n "$1"  && "$1" -ge  "2" && -n "$2" ]]
    then
    echo "$(date) ($1) $2">>$LOG
    fi
}

usage()
{
clear
echo -e "\033[1mSynopsis\033[0m"
echo -e "\033[1m\tUsage\033[0m"
printf "\t./app env loglevel\n"
echo -e "\033[1menv:\033[0m"
printf "\tThe valid values are test,development and production\n"
echo -e "\033[1mloglevel:\033[0m"
printf "\tThe valid values are 1 , 2 or 3\n"
}

#Prepare the files to contain the base migration part
prepareup()
{
echo "ALTER TABLE \`permission\` DROP FOREIGN KEY \`permission_ibfk_1\`;">$1
echo "ALTER TABLE \`rolePermission\` DROP FOREIGN KEY \`rolePermission_ibfk_1\`;">>$1
echo "ALTER TABLE \`rolePermission\` DROP FOREIGN KEY \`rolePermission_ibfk_2\`;">>$1
}

prepareupend()
{
echo "ALTER TABLE \`permission\` ADD CONSTRAINT \`permission_ibfk_1\` FOREIGN KEY ( \`moduleId\` ) REFERENCES \`apmgr\`.\`modules\` (\`id\`) ON DELETE CASCADE ON UPDATE CASCADE ;">>$1
echo "ALTER TABLE \`rolePermission\` ADD CONSTRAINT \`rolePermission_ibfk_1\` FOREIGN KEY ( \`roleId\` ) REFERENCES \`apmgr\`.\`role\` (\`id\`) ON DELETE CASCADE ON UPDATE CASCADE ;">>$1
echo "ALTER TABLE \`rolePermission\` ADD CONSTRAINT \`rolePermission_ibfk_2\` FOREIGN KEY ( \`permissionId\` ) REFERENCES \`apmgr\`.\`permission\` (\`id\`) ON DELETE CASCADE ON UPDATE CASCADE ;">>$1
}

# Execute the main sql query.
runup()
{
$MYSQLDUMP -u$DBUSER -p$DBPASS -K --skip-add-locks $DBNAME $TARGETS|grep -v '/\*'|grep -v '\-\-' >> $1
}

# This prepares the backup for reports by storing the current id's you have them
reportbackup()
{
$MYSQL -u$DBUSER -p$DBPASS --skip-column-names $DBNAME -e "SELECT R.name,R.moduleId,R.cacheTtl,R.urlPath,R.dateCreated,M.name FROM reports R INNER JOIN modules M ON R.moduleId=M.id">$REPORTBACKUP
log4bash $DEBUG "===="
log4bash $DEBUG "SELECT R.name,R.moduleId,R.cacheTtl,R.urlPath,R.dateCreated,M.name FROM reports R INNER JOIN modules M ON R.moduleId=M.id"
log4bash $DEBUG "===="
}

# We are going to read the output of the reports and prepare an insert again by calling the modules
# table and we get the new id if this one changed
reportrestore()
{
local ID=""
local REPORTNAME=""
local MODULEID=""
local CACHETTL=""
local DATECREATED=""
local MODULENAME=""
local SQL=""
local URL=""
while read line
do
REPORTNAME=`echo $line|awk '{print $1}'`
MODULEID=`echo $line|awk '{print $2}'`
CACHETTL=`echo $line|awk '{print $3}'`
URL=`echo $line|awk '{print $4}'`
DATECREATED=`echo $line|awk '{print $5,$6}'`
MODULENAME=`echo $line|awk '{print $7}'`
ID=`$MYSQL -u$DBUSER -p$DBPASS $DBNAME --skip-column-names -e "SELECT M.id FROM modules M WHERE M.name='"$MODULENAME"'"`
if [[ -n "$DEBUG"  && "$DEBUG" -ge  "2" && -n "$DEBUG" ]]
then
log4bash $DEBUG "===="
log4bash $DEBUG "Report name:$REPORTNAME"
log4bash $DEBUG "Module id $MODULEID"
log4bash $DEBUG "Cachettl $CACHETTL"
log4bash $DEBUG "Date Created:$DATECREATED"
log4bash $DEBUG "UrlPath:$URL"
log4bash $DEBUG "Module name:$MODULENAME"
log4bash $DEBUG "===="
fi
SQL="INSERT INTO reports(name,moduleId,cacheTtl,urlPath,dateCreated) VALUES ('$REPORTNAME',$MODULEID,$CACHETTL,'$URL','$DATECREATED')"
echo $SQL>>$1
SQL=""
done < $REPORTBACKUP
}


bootstrap()
{
case $1 in
"test")
DBUSER="dev"
DBPASS="dev"
DBNAME="apmgr_tests"
DBHOST="localhost"
;;
#"development"|"production") Works
"development")
DBUSER="dev"
DBPASS="dev"
DBNAME="apmgr"
DBHOST="localhost"
;;
"production")
DBUSER="dev"
DBPASS="dev"
DBNAME="apmgr"
DBHOST="localhost"
;;
*)
	log4bash 2 "No valid arguments received, here is the output for $0"
	for args in "$@" 
	do
	log4bash 2 "$args"
	done
	usage
	exit 1
;;
esac

# Prepare the mysqldump and mysql variables
OS=$(echo $(uname -s) | tr [:upper:] [:lower:])
case $OS in
"linux")
	log4bash 2 "Using linux"
	MYSQL=/usr/bin/mysql
	MYSQLDUMP=/usr/bin/mysqldump
;;
"darwin")
	log4bash 2 "Using MacOsX"
    MYSQL=/opt/local/bin/mysql5
    MYSQLDUMP=/opt/local/bin/mysqldump5
;;
*)
	log4bash 2 "Undefined OS.Program will not continue"
	exit 1
;;
esac
}
