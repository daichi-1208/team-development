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

# 管理者画面

管理画面の生成などについては [こちらの記事](https://qiita.com/Dev-kenta/items/25ac692befe6f26f11cf) を参考にしてください。

## 初期データ投入
`migrate:fresh`や`初期構築`の際に以下を実行してください。
```bash
docker-compose run --rm backend php artisan db:seed --class=AdminTablesSeeder
```

## 開発
### ログイン
http://127.0.0.1:8080/admin/

#### 初期ログイン情報

|  ID   | PASSWORD |
|:-----:|:--------:|
| admin |  admin   |

### 各種URL情報

**画面作成次第追記してください**

|        対象テーブル | URL                                      |
|--------------:|:-----------------------------------------|
| メンテナンスモード状態一覧 | http://127.0.0.1:8080/admin/maintenances |
|        ユーザー一覧 | http://127.0.0.1:8080/admin/users        |
