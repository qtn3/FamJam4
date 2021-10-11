#!/bin/bash

if systemctl status apache2 | grep "inactive" > /dev/null
then
    echo Starting Apache Server..
    sudo service apache2 start
    echo Apache Server Status: Active!
else
    echo It\'s already on!
fi