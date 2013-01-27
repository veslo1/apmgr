#!/usr/bin/env bash
RSYNC=/usr/bin/rsync
RSYNCFLAGS=--compress-level=9 -e \"ssh -C\" -avz
#REMOTE=
LOCAL=/usr/local/www/apmgr/tests/logs/
echo "I will run $RSYNC $RSYNCFLAGS $LOCAL $REMOTE"
