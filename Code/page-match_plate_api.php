<?php
/*
Template Name:MATCHI STEP API
*/
session_start();

/*******定数定義*************/
$SAFETY_MIN_WIDTH = 110; //車椅子がプレートの上を走ることを想定した時の最小限必要な横幅
$SAFETY_MAX_SPACE_CM = 30; //プレートを設置した時の左右の最大の隙間の大きさ(CM)


/*全てのパラメタがセットされていることを確認した上で、無毒化*/
if(isset($_GET['width'])){
    $_GET['width'] = htmlspecialchars($_GET['width']);
    //var_dump($_GET['width']);
    $status[0] = 1;
}else{
    $status[0] = 0;
};
if(isset($_GET['height'])){
    $_GET['height'] = htmlspecialchars($_GET['height']);
    //var_dump($_GET['height']);
    $status[1] = 1;
}else{
    $status[1] = 0;
};
if(isset($_GET['min_depth'])){
    $_GET['min_depth'] = htmlspecialchars($_GET['min_depth']);
    //var_dump($_GET['min_depth']);
    $status[2] = 1;
}else{
    $status[2] = 0;
};
if(isset($_GET['max_depth'])){
    $_GET['max_depth'] = htmlspecialchars($_GET['max_depth']);
    //var_dump($_GET['max_depth']);
    $status[3] = 1;
}else{
    $status[3] = 0;
};

/*全てのパラメタが正常だったら実行*/
if($status[0] == 1 && $status[1] == 1 && $status[2] == 1 && $status[3] == 1){
    include('mpa_parts/store_in_QUERY.php'); //GETの不足部分を補完し、QUERYに保管
    include('mpa_parts/get_data_by_height.php'); //高さを条件としてWP_QUERYを発行し、高さがマッチするプレートをPLATESに格納
    if(count($PLATES) != 0) include('mpa_parts/matching_depth.php'); //段差の形状毎に、奥行き条件と照らし合わせ抽出
    if(count($PLATES) != 0) include('mpa_parts/matching_width.php'); //横幅の条件と照らし合わせて抽出
    if(count($PLATES) != 0) include('mpa_parts/sort_by_angle.php'); //配列を角度の緩やかな順に並び替え
}


if($_GET['dev'] == 1) echo '<br>-------------最終出力-------------';
if($_GET['dev'] == 1) echo '<br><br>';
echo json_encode($PLATES);