#!/bin/bash

if systemctl status mysql | grep "active" > /dev/null
then
    echo Stopping MySQL DB..
    sudo systemctl stop mysql
    echo MySQL DB Status: Inactive!
else
    echo It\'s already down!
fi