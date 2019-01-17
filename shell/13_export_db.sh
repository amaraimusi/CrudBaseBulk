#!/bin/sh

echo '作業ディレクトリ'
pwd

echo "ローカルDBのパスワードを入力してください"
read pw

echo 'SQLをエクスポートします。'
mysqldump -uroot -p$pw crud_base_bulk > crud_base_bulk.sql
echo 'エクスポートしました。'


echo "------------ 終わり"
cmd /k