# OUR MISSION
店内のバリアフリーはイケてるのに、入り口だけがネックになって行くことができない。
そんなもったいないお店を減らすことがMISSIONです。

ARを使って入り口を撮影するだけで、お店にぴったりなステップを提案します。
高さや横幅・奥行き、を計測してお店にあったステップを探す...
そんな面倒な作業を簡略化することで、もっと多くのお店がステップを整備してくれると信じています。

車椅子ユーザーが、もっとたくさんのお店を楽しめますように。

# 制作物と各仕様
このプロジェクトを実現するWebアプリケーションを構成するするのは次の要素です。<br>
それぞれの詳しい役割や仕様は各ドキュメントに記載しています。

|制作物|これが何か|
|:-|:-|
|[PLATE_DB<br>(PDB)](/Docs/PLATE_DB/plate_db.md)|市販されているプレートの情報を格納したDB|
|[MATCH_PLATE_API<br>(MPA)](/Docs/MATCH_PLATE_API/match_plate_api.md)|条件に沿ったPLATEをDBから探し出しだす検索API|
|[PLATE_SITE<br>(PS)](/Docs/PLATE_SITE/plate_site.md)|Webアプリケーションのフロント|
|[AR_SCAN<br>(ARS)](/Docs/AR_SCAN/ar_scan.md)|ARを用いて段差の寸法を測量|

# ドキュメント内での用語

|用語|定義|
|:-|:-|
|ステップ / step|段差そのもののことを指します|
|プレート / plate|段差を解消するために設置するもののことを指します|

# 各ドキュメント

- [ソースコードと書き出し先の関係（Gulp）](/Docs/gulp_setting.md)
- [WordPress構造ドキュメント](/Docs/wordpress.md)
- [デザインルールドキュメント](/Docs/design_rule.md)
- [コーディングルールドキュメント](/Docs/coding_rule.md)

# プレート情報収集の協力者募集！

>このサービスは、登録されるプレートの数が肝です。<br>
一緒にプレートの登録に協力してくれる仲間を募集しています🎉

興味がある方は、[私のTwitterにDM](https://twitter.com/nlavp)をください！

ステップを登録する作業は、[plates.csv](/Code/PLATE_DB/plates.csv)に新しい行を追加してプッシュするだけです。

SVCファイルの詳しい書き方は[このドキュメント](/Docs/PLATE_DB/CSV_rule.md)に記しています。