# PLATE_DB
PLATE_DBは市販されているプレートの情報を格納したDBです。

プレートの情報をWordPressのカスタム投稿タイプとして保存します。<br>
保存する情報は次のとおりです。

|項目|ACFの型|ACFのslag|必須か|
|:-|:-|:-|:-|
|プレートの購入URL|URL|url|YES|
|プレートが室内用か外用か|RadioButton( inside / outside)|plate_is_use_for|YES|
|プレートの奥は何に接するか|RadioButton( ground / step)|plate_is_on|YES|
|プレートの横幅|数値(cm)|width|YES|
|プレートの最小の高さ|数値(cm)|min_height|YES|
|プレートの最大の高さ|数値(cm)|max_height|YES|
|プレートの奥行き|数値(cm)|depth|YES|
|複数つなげて使用できるか|RadioButton(yes / no)|can_bind|YES|
|画像URL|url|image_url|YES|


プレートの設置面がgの場合は底辺を入力し、sの場合は斜辺を入力します。

# なぜCSVなのか

ACFを使っていますが、情報の登録は、[CSVファイル](/Code/PLATE_DB/plates.csv)上に記載し、これをWordPressにインポートする形で行います。<br>
こうすることで、以下のメリットがあります。

- 不慮の事故によりDBのデータが失われた場合でも、データを守ることができます。
- 将来的にCMSをWordPressからNuxt.jsなどに移動する際もデータを安全に移行できます。

CSVの書き方のルールについては、この[ドキュメント](/Docs/PLATE_DB/CSV_rule.md)に定義しています。

# プレート情報収集の協力者募集！

>このサービスは、登録されるプレートの数が肝です。<br>
一緒にプレートの登録に協力してくれる仲間を募集しています🎉

興味がある方は、[私のTwitterにDM](https://twitter.com/nlavp)をください！

ステップを登録する作業は、[plates.csv](/Code/PLATE_DB/plates.csv)に新しい行を追加してプッシュするだけです。