# plates.csvについて

PLATE_DBはACFを使っていますが、情報の登録は、[CSVファイル](/Code/PLATE_DB/plates.csv)上に記載し、これを[プラグイン](http://www.wpallimport.com/)を使ってWordPressにインポートする形で行います。<br>
こうすることで、以下のメリットがあります。

- 不慮の事故によりDBのデータが失われた場合でも、データを守ることができます。
- 将来的にCMSをWordPressからNuxt.jsなどに移動する際もデータを安全に移行できます。

また、これは重要なことですが<br>
不慮の事故を防ぐためこのCSVを編集するときは必ず **「Register CSV ブランチ」** に切り替えて作業をします。<br>
こうすることで、CSVファイル以外を含めてコミットした時に、そのコミットをリベースする時にCSVを影響から外すことができる他、共同編集が容易になります。

# CSVファイルの書き方とACFとの対応

次の情報を表の順番と同じようにして1行づつ定義します。
プレートが室内でも屋外でも使えるという場合は、**別のプレートとして扱って**登録をします。

|記載すること|CSVに記載する値|必須か|ACFと対応するslag|ACF上での型|
|:-|:-|:-|:-|:-|
|プレートが室内用か外用か| `i` / `o`|YES|plate_is_use_for|RadioButton( inside / outside)|
|プレートの奥は何に接するか| `g` / `s` |YES|plate_is_on|RadioButton( ground / step)|
|プレートの横幅|`数値(cm)`|YES|width|数値(cm)|
|プレートの高さが固定の場合|`数値(cm)`|YES|height|文字列|
|プレートの高さが可変の場合|`min数値/max数値(cm)`<br>スラッシュを含める|YES|height|文字列|
|プレートの奥行き|`数値(cm)` / `-1`|YES|depth|数値(cm)|
|プレートの角度|`数値(度)` / `-1`|YES|angle|数値(度)|
|プレートの購入URL|`エンコーディング済みのURL`|YES|url|URL|

奥行きが不明な場合は、-1を記入し、代わりに角度を入力します。
どちらも情報がある場合は、奥行き情報が優先されます。

プレートの設置面がgの場合は底辺を入力し、sの場合は斜辺を入力します。

プレートの高さは、高さが[固定ではなく可変となるプレートもあり](https://www.monotaro.com/g/01144824/)<br>
その最大値と最小値を格納する際は、値をmin/maxのようにスラッシュで区切ります。<br>
そのため、ACFの型は文字列となります。

## 記述例

今回のデータでは「"」を含まないため、省きます。

>i,g,55,4,10,-1,https://amazon.com/hoge

>i,s,55,4,-1,5.1,https://amazon.com/hoge

CSVなのでExcelやNumbersで編集しても良いですが、書き出し時に「”」が出力されないように注意してください。

# ACFにCSVを読み込む方法

この記事を参考にする

https://ahalog.tdesignworks.net/cms/wordpress/how-to-use-wp-all-import/

この記事によると[WP All Importプラグイン](http://www.wpallimport.com/)と同プラグインのアドオンを用いることで、ACFのフィールドとCSVをバインドすることが可能とのこと。