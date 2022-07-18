# Spin

## 開発

### 初回実行時
```bash
# ライブラリ関連インストール
docker-compose run --rm frontend npm install
docker-compose run --rm backend composer install

# Envファイルの初期化(APP_KEY生成)
docker-compose run --rm backend cp .env.example .env
docker-compose run --rm backend php artisan key:generate

# Laravel Storageディレクトリのパーミッション変更
docker-compose run --rm backend chmod 757 -R /var/www/html/storage
```

### 通常実行時
```bash
docker-compose up
```

#### 注意
Next.jsのnode_modulesと、Laravelのvendorは、Docker動作高速化のためvolume化しています。  
そのため、エディター補完を利用する場合は、ローカルで以下のコマンドを実行する必要があります。(ローカルには、以下の環境がが必要です。)

| Library |   version   |
|:-------:|:-----------:|
|   php   |  \>= 8.1.8  |
| node.js | \>= 16.16.0 |

```bash
# Next.jsライブラリインストール
cd frontend && npm install

# Laravelライブラリインストール
cd backend && php composer.phar install
```