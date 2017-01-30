read -p "Enter database name: " dbname
read -p "Enter UTORid: " utorid
read -s -p "Enter password: " password

sed -i "s/dbnamehere/$dbname/g" dbconn.php
sed -i "s/usernamehere/$utorid/g" dbconn.php
sed -i "s/passwordhere/$password/g" dbconn.php

PGPASSWORD=$password
psql -h mcsdb.utm.utoronto.ca -d $dbname -U $utorid -f schema.sql
