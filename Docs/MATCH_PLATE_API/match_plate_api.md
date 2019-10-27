# MATCH_PLATE_API
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
|?set_type|MIN / MAX / MINMAX / ABSOLUTE / FREE|設置場所の奥行きに関する条件を定義します。詳細については[AR_SCAN（AR測量）](/Docs/AR_SCAN/ar_scan.md)に記載しています|YES
|?max_depth|数値(cm)|設置場所の許容される最大奥行を定義します|?depth_typeが**MIN**とMINMAXの時に必須|
|?min_depth|数値(cm)|設置場所の許容される最小奥行を定義します|?depth_typeが**MAX**とMINMAXの時に必須|
|?absolute_depth|数値(cm)|設置場所の絶対的な奥行サイズを定義します|?depth_typeが**ABSOLUTE**の時に必須|


これらを指定してMATCH_PLATE_APIに投げると、 条件にあったものをピックアップします。
さらにその情報は **傾斜が緩やかな順** となって返されます。

必要に応じて、各プレートの情報に購入先のOGP TITLEとOGP IMAGEを含めて返すこともできます。

APIの内部処理のプロセスは、[フローチャートドキュメント](/Docs/MATCH_PLATE_API/flow.pdf)によって定義しています。

## APIファイルの実態
このAPIファイルは、WordPressの固定ページとして存在します。<br>
そのため、WordPressテーマからみるとこのフォルダは次のとおりです。
>/page-match_plate_api.php

WordPressの内部に入れ込むことで、PLATEの情報をWP_Queryによって取得することができます。

これにより、場合によっては豊富なWordPressプラグインの恩恵を受けることができます。