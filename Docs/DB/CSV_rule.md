# plates.csvについて

PLATEはWordPressのカスタム投稿タイプに保存され、ACFによりブラウザ上から登録できるように整備しています。

しかしACFは、フィールドの設定を変更するときの不慮の事故によりデータを失うことがあります。

それを防ぐため、サービスが安定するまではブラウザ用での登録は行わず、[CSVファイル](/Code/DB/plates.csv)に情報を記載し、それを[プラグイン](http://www.wpallimport.com/)を使って一斉登録する手法を取ります。

また、これは重要なことですが<br>
不慮の事故を防ぐためこのCSVを編集するときは必ず **「Register CSV ブランチ」** に切り替えて作業をします。<br>
こうすることで、CSVファイル以外を含めてコミットした時に、そのコミットをリベースする時にCSVを影響から外すことができる他、共同編集が容易になります。

# CSVファイルの書き方とACFとの対応

次の情報を表の順番と同じようにして1行づつ定義します。
プレートが室内でも屋外でも使えるという場合は、**別のプレートとして扱って**登録をします。

|記載すること|CSVに記載する値|必須か|ACFと対応するslag|ACF上での型|
|:-|:-|:-|:-|:-|
|プレートが室内用か外用か| i / o|YES|plate_is_use_for|RadioButton( inside / outside)|
|プレートの奥は何に接するか| g / s |YES|plate_is_on|RadioButton( ground / step)|
|プレートの横幅|数値(cm)|YES|width|数値(cm)|
|プレートの高さ|数値(cm)|YES|height|数値(cm)|
|プレートの奥行き|数値(cm) / -1|YES|depth|数値(cm)|
|プレートの角度|数値(度) / -1|YES|angle|数値(度)|
|プレートの購入URL|エンコーディング済みのURL|YES|url|URL|

奥行きが不明な場合は、-1を記入し、代わりに角度を入力します。
どちらも情報がある場合は、奥行き情報が優先されます。

## 記述例

今回のデータでは「"」を含まないため、省きます。

i,g,55,4,10,-1,https://amazon.com/hoge

i,s,55,4,-1,5.1,https://amazon.com/hoge

# ACFにCSVを読み込む方法

この記事を参考にする

https://ahalog.tdesignworks.net/cms/wordpress/how-to-use-wp-all-import/

この記事によると[WP All Importプラグイン](http://www.wpallimport.com/)と同プラグインのアドオンを用いることで、ACFのフィールドとCSVをバインドすることが可能とのこと。