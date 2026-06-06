#!/bin/bash
set -e
cd /srv/apps/jyza-autoadmin
docker compose -f docker-compose.prod.yml build --no-cache >> /tmp/jyza-build.log 2>&1
docker compose -f docker-compose.prod.yml up -d >> /tmp/jyza-build.log 2>&1
echo "DONE" >> /tmp/jyza-build.log
