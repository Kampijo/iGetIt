read -p "Enter host: " host
read -p "Enter database name: " dbname
read -p "Enter UTORid: " utorid
read -s -p "Enter password: " password

sed -i "s/hosthere/$host/g" dbconn.php
sed -i "s/dbnamehere/$dbname/g" dbconn.php
sed -i "s/userhere/$utorid/g" dbconn.php
sed -i "s/passwordhere/$password/g" dbconn.php

export PGPASSWORD=$password
psql -h mcsdb.utm.utoronto.ca -d $dbname -U $utorid -f schema.sql
