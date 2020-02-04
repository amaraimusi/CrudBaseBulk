#!/bin/sh
echo 'ソースコードを差分アップロードします。'

rsync -auvz ../app amaraimusi@amaraimusi.sakura.ne.jp:www/CrudBaseBulk
rsync -auvz ../doc amaraimusi@amaraimusi.sakura.ne.jp:www/CrudBaseBulk
rsync -auvz ../shell amaraimusi@amaraimusi.sakura.ne.jp:www/CrudBaseBulk

echo "------------ 送信完了"
#cmd /k