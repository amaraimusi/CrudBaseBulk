﻿#!/bin/sh
echo 'database.phpを本番環境からローカル環境にコピーします。'

scp -r amaraimusi@amaraimusi.sakura.ne.jp:www/CrudBaseBulk/app/Config/database.php ../app/Config/database.php

echo "------------ コピー完了"
cmd /k