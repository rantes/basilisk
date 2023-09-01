#!/bin/bash
set -e
echo "Running migrations..."
php /usr/local/bin/dumbo migration run all
echo "Sowing the seeds..."
php /usr/local/bin/dumbo migration sow
echo "Running unit tests..."
php /usr/local/bin/dumboTest
