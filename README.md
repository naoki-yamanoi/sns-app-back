## 環境
Laravel 11  
PHP 8.3

## awsデプロイまで参考にした記事
https://qiita.com/takahiro_fukushima/items/e2a19c4b2a55389a69cc
https://qiita.com/oono_dev/items/a4c143b87418e5fd43ff
https://zenn.dev/redheadchloe/articles/7967010478e9ba
https://qiita.com/chihiro1020/items/beadabc59ee747c43456

## コマンド
### コードチェック
・静的解析（Larastan）
```
./vendor/bin/phpstan analyse
```
・フォーマット修正（pint）
```
./vendor/bin/pint
```

### DB
・DBテストデータ挿入
```
php artisan db:seed
```
・DBデータ削除
```
php artisan migrate:refresh
```
