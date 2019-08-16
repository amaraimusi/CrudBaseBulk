#!/bin/sh

echo '作業ディレクトリ'
pwd

mysql -u root -p crud_base_bulk < crud_base_bulk.sql
echo 'インポートしました。'


echo "------------ 終わり"
#cmd /k