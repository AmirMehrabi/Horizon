#!/bin/bash

# Setup script for Supervisor configuration
# Run this script with sudo: sudo bash setup-supervisor.sh

echo "Setting up Supervisor configuration for Laravel Queue Worker and Scheduler..."

# Copy supervisor config files
cp /var/www/html/horizon/horizon-queue-worker.conf /etc/supervisor/conf.d/horizon-queue-worker.conf
cp /var/www/html/horizon/horizon-scheduler.conf /etc/supervisor/conf.d/horizon-scheduler.conf

# Create log directory if it doesn't exist
mkdir -p /var/www/html/horizon/storage/logs
chown -R ammir:ammir /var/www/html/horizon/storage/logs

# Reload supervisor
supervisorctl reread
supervisorctl update

# Start the services
supervisorctl start horizon-queue-worker:*
supervisorctl start horizon-scheduler

echo "Supervisor configuration complete!"
echo "Check status with: supervisorctl status"

