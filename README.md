## 環境
Laravel 11  
PHP 8.3

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
