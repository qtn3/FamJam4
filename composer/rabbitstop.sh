#!/bin/bash

if systemctl status rabbitmq-server | grep "active" > /dev/null
then
    echo Starting RabbitMQ Server..
    sudo -u rabbitmq rabbitmqctl stop
    echo RabbitMQ Server Status: Active!
else
    echo It\'s already down!
fi