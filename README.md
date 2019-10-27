# OUR MISSION
店内のバリアフリーはイケてるのに、入り口だけがネックになって行くことができない。
そんなもったいないお店を減らすことがMISSIONです。

ARを使って入り口を撮影するだけで、お店にぴったりなステップを提案します。
高さや横幅・奥行き、を計測してお店にあったステップを探す...
そんな面倒な作業を簡略化することで、もっと多くのお店がステップを整備してくれると信じています。

車椅子ユーザーが、もっとたくさんのお店を楽しめますように。

# 制作物
このプロジェクトを構成するために作成されるものは次のとおりです。

- PLATE DB
- MATCH PLATE API
- Webアプリ（情報表示）
- Webアプリ（AR測量）

# ドキュメント内での用語

|用語|定義|
|:-|:-|
|ステップ / step|段差そのもののことを指します|
|プレート / plate|段差を解消するために設置するもののことを指します|

# 各制作物の仕様

## PLATE DB
プレートの情報をWordPressのカスタム投稿タイプとして保存します。
保存する情報は次のとおりです。

|項目|ACFの型|ACFのslag|必須か|
|:-|:-|:-|:-|
|プレートの購入URL|URL|url|YES|
|プレートが室内用か外用か|RadioButton( inside / outside)|plate_is_use_for|YES|
|プレートの奥は何に接するか|RadioButton( ground / step)|plate_is_on|YES|
|プレートの横幅|数値(cm)|width|YES|
|プレートの高さ|数値(cm)|height|YES|
|プレートの奥行き|数値(cm) / -1|depth|YES|
|プレートの角度|数値(度) / -1|angle|YES|

奥行きが不明な場合は、代わりに角度を入力します。
どちらも情報がある場合は、奥行き情報が優先されます。

ACFを使っていますが、情報の登録は、[CSVファイル](Code/DB/plates.csv)上に記載し、これをWordPressにインポートする形で行います。<br>
こうすることで、以下のメリットがあります。

- 不慮の事故によりDBのデータが失われた場合でも、データを守ることができます。
- 将来的にCMSをWordPressからNuxt.jsなどに移動する際もデータを安全に移行できます。

CSVの書き方のルールについては、この[ドキュメント](Docs/DB/CSV_rule.md)に定義しています。

このサービスは、登録されるプレートの数が肝です。
一緒にプレートの登録に協力してくれる仲間を募集しています🎉

興味がある方は、[私のTwitterにDM](https://twitter.com/nlavp)をください。

ステップを登録する作業は、[plates.csv](Code/DB/plates.csv)に新しい行を追加してプッシュするだけです。

## MATCH PLATE API
ATCH PLATE APIは、以下の条件に沿ったPLATEをDBから探し出しだす検索APIです。

- 室内用か屋外用か
- 高さ
- 幅
- 設置場所の条件
- 奥行き情報

APIはJSONを返し、URLに次のパラメタをつけてリクエストします。

|パラメタ|許可される値|説明|必須か|
|:-|:-|:-|:-|
|?set_place|inside / outside|プレートが設置される場所を定義します|YES
|?height|数値(cm)|段差の高さを定義します|YES
|?width|数値(cm)|設置場所の横幅を定義します|YES
|?set_type|MIN / MAX / MINMAX / ABSOLUTE / FREE|設置場所の奥行きに関する条件を定義します。詳細については「Webアプリ（AR測量）」の欄に記載しています|YES
|?max_depth|数値(cm)|設置場所の許容される最大奥行を定義します|?depth_typeが**MIN**とMINMAXの時に必須|
|?min_depth|数値(cm)|設置場所の許容される最小奥行を定義します|?depth_typeが**MAX**とMINMAXの時に必須|
|?absolute_depth|数値(cm)|設置場所の絶対的な奥行サイズを定義します|?depth_typeが**ABSOLUTE**の時に必須|


これらを指定してMATCH PLATE APIに投げると、 条件にあったものをピックアップします。
さらにその情報は **傾斜が緩やかな順** となって返されます。

必要に応じて、各プレートの情報に購入先のOGP TITLEとOGP IMAGEを含めて返すこともできます。

APIの内部処理のプロセスは、[フローチャートドキュメント](https://drive.google.com/file/d/1W09Ghfw_q0mOiHjbBG68rleekI0MqNu4/view?usp=sharing)によって定義しています。

## Webアプリ（情報表示）
ユーザーは、このWebアプリに検索またはSNSによるシェア等によって本Webアプリに到達します。
このWebアプリは、PLATE DBに登録されたプレートを検索し表示することができます。

Webアプリは、以下のページと機能を有します。

### TOPページ
TOPページは、Webアプリの説明と検索機能のみに徹します。
最新のプレートの投稿などを表示するのは一般的ですが、プレートは設置場所の物理的条件に即したものがほしいわけで、最新のものが欲しいわけではありません。そのため、このWebアプリでは最新のプレートを表示するような機能を設ける必要はありません。

機能
- ページの概要説明
- 手動による検索ボックス
- ARによる測定機能へのリンクボタン
- 登録されているプレートの総数の表示

### 検索結果ページ
このページは、WordPressページ上ではArchivesではなく**固定ページ**として実装されます。
このページはTOPページの手動による検索ボックス及び、AR計測機能から発行された検索クエリをMATCH PLATE APIが受け取り、結果をJSON形式で返すことによって表示されます。
そのため、このページはWordPressの中ではありますが、検索結果はPHPによるHTMLではなくJSONを受け取った**Vue.jsがv-forを用いて生成**します。

MATCH PLATE APIの処理は、3秒以内には返ってこないことが予想されます。
そのため、このページは、結果が帰ってくるまでの間、**ステータスを表示する**ことでよりユーザーのストレスを抑えます。

検索結果は、傾斜の緩やかさの順に表示されます。
傾斜の緩やかなプレートは、多くの車椅子ユーザーの願いであり、これ以外の順序で表示することは今のところ考えていません。
必要に応じて、別の並び順に対応することもありえます。

機能

- 検索結果が表示されるまでのステータス表示
- 指定された検索条件の表示
- 条件にマッチしたプレートの一覧表示
- お気に入りに登録したプレートの表示

検索結果ページでは、１つ１つのプレートの次の情報を表示します

- OGP画像
- **傾斜**
- 奥行き
- 高さ
- 横幅
- **このプレートを何個購入すれば横幅を埋められるか**

### プレートの詳細ページ
このWebアプリは、全てのページが固有のURLを持ちます。
それはつまり、このサイトはWebアプリであると同時に情報サイトでもあるということを意味します。これはWordPressで構築する意義でもあります。
固有のURLを持つことで、気に入ったプレートをブックマークしたり仲間にシェアする事ができます。
また、SEOの面からも有利であり、このWebアプリに多くの人が訪れるようにする面で大きな意義です。

機能

- **プレートをARによって試しおきできる機能**（この機能は重要ではないので、余裕があれば実装します）
- **お気に入り保存機能**
- 奥行き
- 高さ
- 横幅
- 傾斜
- 商品購入ページへのボタン
- OGP情報による画像
- OGP情報による商品名
- OGP情報による製造会社名（これは取得が可能な場合のみ表示します）


## Webアプリ（AR測量）
高さなどを手入力するだけで、DBから条件にあったプレートが出てくるだけでも便利ですが、測量をARによって手軽に実現できればもっと便利です。
AR測量ではこれを実現します。

AR測量では、以下の情報を取得でき、MATCH PLATE APIが必要とするクエリーを生成します。

- 設置場所が屋内か屋外か
- 設置場所の段差の高さ(cm)
- 設置場所の段差の横幅(cm)
- 設置場所の条件（詳細は以下）
- 設置場所の許容する最大奥行き(cm)
- 設置場所の許容する最小奥行き(cm)
- 設置場所の絶対的な奥行き(cm)

奥行きは設置場所の条件によって、必要な情報量が変わってくるため条件に応じて次のように取得する情報を変えます。

| Type MIN      | Type MAX     | Type MINMAX   | Type ABSOLUTE | Type FREE |
|:-|:-|:-|:-|:-|
|![側溝画像](https://www.asahicom.jp/articles/images/AS20180418001383_comm.jpg)|![条例](https://ec.midori-anzen.com/img/event/3/a170/wide/1.jpg)|![側溝画像](https://www.asahicom.jp/articles/images/AS20180418001383_comm.jpg)| No Photo |![自由設置](https://www.city.shiki.lg.jp/images/content/86077/DSC06123.jpg)|
|岡山など側溝があるため、橋をかける必要がある場合|敷地外にプレートが侵入しないようにする必要がある場合|橋を架ける必要があり、かつ敷地外に出ないようにする必要がある場合|プレートを設置する場所の奥行きをぴったり合わせる必要がある場合|奥行に特に条件がない場合|
| 最小奥行を取得|最大奥行きを取得|最小奥行きと最大奥行きを取得|絶対的な奥行きを取得|取得しない|

### ARの構築に使用する技術

|ライブラリ|目的|
|:-|:-|
|[A-Frame](https://aframe.io/)|Web XRに必要な条件を整え、3Dの扱いを容易にする|
|[8th Wall Web](https://www.8thwall.com/)|A-FrameにARによる空間把握を提供するとともに、raycastを可能にする|
|Vue.js|A-Frameの3Dオブジェクトの管理や画面遷移を容易にする|
|[Anime.js](https://animejs.com/)|高度なCSSアニメーションを管理しやすい形で作成できる|