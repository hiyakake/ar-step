<?php
/*
Template Name:MATCHI STEP API
*/
session_start();

/*必要なコンポーネントの読み込み*/


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
    include('mpa_parts/request_wp_query.php'); //高さを条件としてWP_QUERYを発行し、高さがマッチするプレートをPLATESに格納
    include('mpa_parts/matching_depth.php'); //段差の形状毎に、奥行き条件と照らし合わせ抽出
}