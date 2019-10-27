# AR_SCAN（AR測量）
高さなどを手入力するだけで、DBから条件にあったプレートが出てくるだけでも便利ですが、測量をARによって手軽に実現できればもっと便利です。
AR測量ではこれを実現します。

AR測量では、以下の情報を取得でき、MATCH_PLATE_APIが必要とするクエリーを生成します。

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

## ARの構築に使用する技術

|ライブラリ|目的|
|:-|:-|
|[A-Frame](https://aframe.io/)|Web XRに必要な条件を整え、3Dの扱いを容易にする|
|[8th Wall Web](https://www.8thwall.com/)|A-FrameにARによる空間把握を提供するとともに、raycastを可能にする|
|Vue.js|A-Frameの3Dオブジェクトの管理や画面遷移を容易にする|
|[Anime.js](https://animejs.com/)|高度なCSSアニメーションを管理しやすい形で作成できる|