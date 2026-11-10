# my-scholarship-simulator

Laravel 12 と PHP 8.4-FPM、nginx を使った奨学金返済シミュレーターです。

## 起動方法

Docker Desktop を起動し、リポジトリのルートで実行します。

```sh
docker compose up -d --build
```

ブラウザで [http://localhost:8080](http://localhost:8080) を開きます。ポートを変更する場合は `.env` に `WEB_PORT=8081` のように設定します。

## Artisan コマンド

```sh
docker compose exec app php artisan migrate
docker compose exec app php artisan make:controller ExampleController
```

データベースは SQLite を使い、`database/database.sqlite` に保存します。PHP の依存パッケージはプロジェクトの `vendor` ディレクトリを利用します。

## シミュレーション

返済総額、年利（％）、貸与終了年月を入力すると、毎月の返済額と返済計画表を表示します。初回返済月は貸与終了月の7か月後です（3月終了の場合は10月）。返済年月と予算額を追加すると、繰上返済後の返済総額と差額も試算できます。引落日は毎月27日を基準とし、土日は翌営業日に調整します。据置利息はRuby版に合わせて180日分で計算します。

計算ロジックは `ruby-scholarship` の `Scholarship.rb` にある返済年数区分、据置利息、月利計算、端数処理、繰上返済シミュレーションを Laravel のサービスに移植しています。

## 停止

```sh
docker compose down
```
