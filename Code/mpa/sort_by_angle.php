<?php
/*角度の緩やかな順に並び替え*/
if($_GET['dev'] == 1) echo '<br>-------------角度による並び替えの処理-------------';


//設置時の角度を算出
for($i = 0;$i < count($PLATES);$i++){
    if($PLATES[$i]['PLATE_IS_ON'] == 's'){
        //プレートがステップ設置型の場合
        $PLATES[$i]['angle_when_used'] = rad2deg(asin($QUERY['HEIGHT']/$PLATES[$i]['DEPTH']));
    }else{
        //プレートが地面設置型の場合
        $PLATES[$i]['angle_when_used'] = rad2deg(atan($QUERY['HEIGHT']/$PLATES[$i]['DEPTH']));
    }
    if($_GET['dev'] == 1) echo '<br>'.$i.'件目の設置時の角度'.$PLATES[$i]['angle_when_used'];
}

//緩やかな順に並び替え
foreach ((array) $PLATES as $key => $value) {
    $sort[$key] = $value['angle_when_used'];
}
array_multisort($sort, SORT_ASC, $PLATES);

if($_GET['dev'] == 1) echo '<br><br>';
if($_GET['dev'] == 1) echo json_encode($PLATES);