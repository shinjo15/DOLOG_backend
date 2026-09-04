# HIBILIO Backend

Laravel を Docker Compose で動かすバックエンドです。

## 必要環境

- Docker Engine
- Docker Compose v2 以降

PHP と Composer をホストへインストールする必要はありません。

## 起動

```bash
docker compose up --build --detach
```

アプリケーションは http://localhost:8001 で確認できます。

停止する場合:

```bash
docker compose down
```

## Laravel コマンド

すべて `app` コンテナ内で実行します。

```bash
# テスト
docker compose exec --no-TTY app php artisan test

# マイグレーション
docker compose exec --no-TTY app php artisan migrate

# Artisan コマンド一覧
docker compose exec --no-TTY app php artisan list
```

初期構成では SQLite を使用しています。MySQL、Redis、Mailpit などの依存サービスは、必要な機能が決まった時点で Compose に追加します。
