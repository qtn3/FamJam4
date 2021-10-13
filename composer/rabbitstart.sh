#!/bin/bash

if systemctl status rabbitmq-server | grep "inactive" > /dev/null
then
    echo Starting RabbitMQ Server..
    sudo service rabbitmq-server start
    echo RabbitMQ Server Status: Active!
else
    echo It\'s already on!
fi
