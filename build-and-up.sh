#!/bin/bash
set -e
cd /srv/apps/jyza-autoadmin

LOG=/tmp/jyza-build.log
echo "=== BUILD $(date) ===" | tee -a $LOG

docker compose -f docker-compose.prod.yml build --no-cache 2>&1 | tee -a $LOG
docker compose -f docker-compose.prod.yml up -d 2>&1 | tee -a $LOG

echo "=== DONE $(date) ===" | tee -a $LOG
