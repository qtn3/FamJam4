#!/bin/bash

if systemctl status mysql | grep "active" > /dev/null
then
    echo Starting MySQL DB..
    sudo systemctl stop mysql
    echo MySQL DB Status: Active!
else
    echo It\'s already down!
fi