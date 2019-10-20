#!/bin/sh

echo "ローカルDBのパスワードを入力してください"
read pw

mysql -u root -p$pw crud_base_bulk < crud_base_bulk.sql
echo 'インポートしました。'


echo "------------ 終わり"
#cmd /k