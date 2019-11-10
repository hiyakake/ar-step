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
|プレートの最小高さ|`数値(cm)`|YES|min_height|文字列|
|プレートの最大高さ|`数値(cm)`<br>プレートの高さが固定の場合は`-1`|YES|max_height|文字列|
|プレートの奥行き|`数値(cm)`|YES|depth|数値(cm)|
|複数つなげて使用できるか|`y` / `n`|YES|canBind|RadioButton(yes / no)|
|プレートの購入URL|`エンコーディング済みのURL`|YES|url|URL|
|画像のURL|`エンコーディング済みのURL`|YES|image_url|URL|

プレートの設置面がgの場合は底辺を入力し、sの場合は斜辺を入力します。

プレートの高さは、高さが[固定ではなく可変となるプレートもあります](https://www.monotaro.com/g/01144824/)

## 記述例

今回のデータでは「"」を含まないため、省きます。

>i,g,55,4,20,10,-1,https://amazon.com/hoge,imageURL

>i,s,55,4,-1,-1,5.1,https://amazon.com/hoge,imageURL

CSVなのでExcelやNumbersで編集しても良いですが、書き出し時に「”」が出力されないように注意してください。

# ACFにCSVを読み込む方法

この記事を参考にする

https://ahalog.tdesignworks.net/cms/wordpress/how-to-use-wp-all-import/

この記事によると[WP All Importプラグイン](http://www.wpallimport.com/)と同プラグインのアドオンを用いることで、ACFのフィールドとCSVをバインドすることが可能とのこと。