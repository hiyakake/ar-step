# Gulp設定

## ソースフォルダとビルドフォルダ

|説明|フォルダ名|
|:-|:-|
|ソースフォルダ|/Code|
|ビルドフォルダ|/Build|

## 各プロジェクトのソースフォルダとビルド先

|プロジェクト|ソースフォルダ|ビルド先|
|:-|:-|:-|
|PLATE_DB|/Code/PLATE_DB|[ドキュメント](/Docs/PLATE_DB/CSV_rule.md#ACFにCSVを読み込む方法)の方法でプラグインによってWordPressのDBに手動で登録する|
|MATCH_PLATE_API|/Code/MATCH_PLATE_API|/Build/wp-content/themes/AR_STEP|
|PLATE_SITE|/Code/PLATE_SITE|/Build/wp-content/themes/AR_STEP|
|AR_SCAN|/Code/AR_SCAN|/Build/wp-content/themes/AR_STEP|

## このプロジェクトのGulp環境

この[pakeageファイル](/package.json)を使って以下のコマンドを実行することで、同様の開発環境になります。
>npm install

## Gulpfile.js

このファイルが[Gulpfile.js](/gulpfile.js)です。

## 変更履歴

|日付|バージョン|変更内容|
|:-|:-|:-|
|2019/10/27|v0.1|[NEW] image&css&jsの変換を定義<br>[[issue]](https://github.com/LavP/ar-step/issues/1#issue-512923544) gulp-sassがロードされないためcssが動作しない|
