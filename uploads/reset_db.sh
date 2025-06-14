#!/bin/bash
mysql -u root -e "DROP DATABASE IF EXISTS famjisbank"
mysql -u root -e "CREATE DATABASE famjisbank"
mysql -u root famjisbank < database.sql
rm -rf uploads/*