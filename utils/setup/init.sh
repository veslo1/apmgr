#!/usr/bin/env bash
#===============================================================================
#
#          FILE:  init.sh
# 
#         USAGE:  ./init.sh 
# 
#   DESCRIPTION:  Prepare the environment values and validate that we have the proper permissions
# 
#       OPTIONS:  ---
#  REQUIREMENTS:  ---
#          BUGS:  ---
#         NOTES:  ---
#        AUTHOR:   (jorge.vazquez@vazney.com), Jorge Omar Vazquez
#       COMPANY:  Vazney Corporation
#       VERSION:  1.0
#       CREATED:  03/05/2011 01:29:10 PM ART
#      REVISION:  ---
#===============================================================================

if [ -d $1 ] 
  then
TARGET=$(echo $1|grep /$)
  if [ -n "$TARGET" ]
  then
  $TARGET=$(echo $TARGET|sed -e 's/\/$//')
  else
  TARGET=$1
  fi
  CACHE="$TARGET/cache"
  LOGS="$TARGET/logs"
  $(chmod -R ug+rw $CACHE)
  $(chmod -R ug+rw $LOGS)

  case $(hostname) in
  archbox)
  GROUP=http
USER=$(whoami)
  ;;
  myhost)
  GROUP=http
USER=$(whoami) 
  ;;
  vazney)
  GROUP=http
USER=$(whoami) 
  ;;
  esac
  $(chown -R $USER:$GROUP $CACHE)
    $(chown -R $USER:$GROUP $LOGS)
  fi
