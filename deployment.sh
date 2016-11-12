#!/bin/bash

git up
composer install
composer dump-autoload -o
sudo /bin/systemctl restart supervisor.service
