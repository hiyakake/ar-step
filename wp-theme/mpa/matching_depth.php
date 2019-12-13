<?php

if($_GET['dev'] == 1) echo '<br>-------------奥行きの処理-------------';
/*
連想配列PLATESから条件にマッチしない配列を安全に削除するアプローチ
1. PLATESの中身をコピーしてPLATES_TMPとして保持
2. PLATESの数だけループを行い、その中で条件に合わないものがある場合はPLATES_TMPから削除
3. 全ループが終了後に、PLATES_TMPをPLATESにコピー
*/

$plate_tmp = $PLATES;

if($_GET['dev'] == 1) echo '<br><br><br>PLATESの要素数は'.count($PLATES).'<br>';
if($_GET['dev'] == 1) echo 'plates_tmpの要素数は'.count($plate_tmp).'<br>';

for($i = 0;$i < count($PLATES);$i++){
    if($_GET['dev'] == 1) echo '<br><br>'.$i.'回目';
    //判定に必要な値を求める
    if($QUERY['STEP_TYPE'] == 'single'){
        //1段型
        if($PLATES[$i]['PLATE_IS_ON'] == 's'){
            if($_GET['dev'] == 1) echo 'single-s';
            //ステップ設置型
            $depth_tmp = sqrt($PLATES[$i]['DEPTH']^2+$QUERY['HEIGHT']^2);
        }else{
            if($_GET['dev'] == 1) echo 'single-g';
            //地面設置型
            $depth_tmp = $PLATES[$i]['DEPTH'];
        }
    }else{
        //多段型
        if($PLATES[$i]['PLATE_IS_ON'] == 's'){
            if($_GET['dev'] == 1) echo 'multi-s';
            //ステップ設置型
            $depth_tmp = sqrt($PLATES[$i]['DEPTH']^2+$QUERY['HEIGHT']^2);
        }else{
            if($_GET['dev'] == 1) echo 'multi-g';
            //地面設置型
            unset($plate_tmp[$i]);
        }
    }

    if($_GET['dev'] == 1) echo '<br>query min '.$QUERY['MIN_DEPTH'];
    if($_GET['dev'] == 1) echo '<br>this min '.$depth_tmp;
    if($_GET['dev'] == 1) echo '<br>query max '.$QUERY['MAX_DEPTH'];

    //判定と除去
    //最短奥行きの判定
    if($QUERY['MIN_DEPTH'] <= $depth_tmp && $depth_tmp <= $QUERY['MAX_DEPTH']){
            if($_GET['dev'] == 1) echo '<br>奥行き OK';
    }else{
        if($_GET['dev'] == 1) echo '<br>奥行き BAD';
        unset($plate_tmp[$i]);
    }

    if($_GET['dev'] == 1) echo '<br>plate_tmpの要素数 '.count($plate_tmp);
}

$PLATES = array_values($plate_tmp);
unset($plate_tmp);

if($_GET['dev'] == 1) echo '<br><br>';
if($_GET['dev'] == 1) echo json_encode($PLATES);