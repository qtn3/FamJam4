#!/bin/bash

if systemctl status mysql | grep "inactive" > /dev/null
then
    echo Starting MySQL DB..
    sudo systemctl start mysql
    echo MySQL DB Status: Active!
else
    echo It\'s already on!
fi