#!/bin/bash

if systemctl status apache2 | grep "active" > /dev/null
then
    echo Stopping Apache Server..
    sudo service apache2 stop
    echo Apache Server Status: Inactive!
else
    echo It\'s already down!
fi