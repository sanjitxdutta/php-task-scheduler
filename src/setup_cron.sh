#!/bin/bash

# Get the absolute path to cron.php
CRON_FILE="$(dirname "$(readlink -f "$0")")/cron.php"
LOG_FILE="$HOME/task_cron.log"

# Create the cron job line
CRON_JOB="0 * * * * /usr/bin/php $CRON_FILE >> $LOG_FILE 2>&1"

# Check if cron job already exists
(crontab -l 2>/dev/null | grep -v -F "$CRON_FILE"; echo "$CRON_JOB") | crontab -

echo "✅ CRON job has been set up to run every hour."
