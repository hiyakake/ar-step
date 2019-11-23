<?php
/*横幅の条件と照らし合わせて抽出*/
if($_GET['dev'] == 1) echo '<br>-------------横幅の処理-------------';


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
    if($_GET['dev'] == 1) echo '<br>プレートの横幅 '.$PLATES[$i]['WIDTH'];
    
    //複数繋げて使用可能なプレートなのか判断
    if($PLATES[$i]['CAN_BIND'] == 'y'){
        //CAN BIND - 複数枚使用アプローチ
        if($_GET['dev'] == 1) echo '<br>複数枚繋げて使用可能なプレート';

        //初期化
        $PLATES[$i]['need_count'] = 0;
        $loop_contenu = true;

        //n枚繋げた横幅の合計が設置場所の横幅を超えるギリギリまでループ
        while($loop_contenu == true){
            if($PLATES[$i]['WIDTH'] * ($PLATES[$i]['need_count']+1) <= $QUERY['WIDTH']){
                $PLATES[$i]['need_count']++;
            }else{
                $loop_contenu = false;
            }
        }
        if($_GET['dev'] == 1) echo '<br>試算利用可能枚数 '.$PLATES[$i]['need_count'];
    }else{
        //CANT BIND - 1枚のみ使用アプローチ
        if($_GET['dev'] == 1) echo '<br>1枚のみでの利用のプレート';
        
        //プレートの1枚の長さが、QUERYの横幅未満である
        if($PLATES[$i]['WIDTH'] < $QUERY['WIDTH']){
            $PLATES[$i]['need_count'] = 1;
        }else{
            $PLATES[$i]['need_count'] = 0;
        }
        if($_GET['dev'] == 1) echo '<br>試算利用可能枚数 '.$PLATES[$i]['need_count'];
    }


    //その枚数で使用した場合に条件を満たすかをチェック

    //need_countの数が0である場合は除外してループスキップ
    if($PLATES[$i]['need_count'] == 0){
        if($_GET['dev'] == 1) echo '<br>条件を満たさない BAD';
        unset($plate_tmp[$i]);
        continue;
    }

    //つなぎ合わせて使用したときのプレートの長さが120cm以上である

    if($_GET['dev'] == 1) echo '<br>つなぎ合わせて使用した時の長さ'.($PLATES[$i]['WIDTH'] * $PLATES[$i]['need_count']).'cm';
    if($SAFETY_MIN_WIDTH <= ($PLATES[$i]['WIDTH'] * $PLATES[$i]['need_count'])){
        if($_GET['dev'] == 1) echo '<br>長さ'.$SAFETY_MIN_WIDTH.'cm以上 OK';
        //余白が10cm以内である
        $space = $QUERY['WIDTH'] - ( $PLATES[$i]['WIDTH'] * $PLATES[$i]['need_count'] );
        if($_GET['dev'] == 1) echo '<br>余白の長さ'.$space;
        if($space <= $SAFETY_MAX_SPACE_CM){
            if($_GET['dev'] == 1) echo '<br>余白'.$SAFETY_MAX_SPACE_CM.'cm以内 OK';
        }else{
            if($_GET['dev'] == 1) echo '<br>余白'.$SAFETY_MAX_SPACE_CM.'cm以内 BAD';
            unset($plate_tmp[$i]);
        }
    }else{
        if($_GET['dev'] == 1) echo '<br>長さ'.$SAFETY_MIN_WIDTH.'cm以上 BAD';
        unset($plate_tmp[$i]);
    }



    if($_GET['dev'] == 1) echo '<br>plate_tmpの要素数 '.count($plate_tmp);
}

$PLATES = array_values($plate_tmp);
unset($plate_tmp);

if($_GET['dev'] == 1) echo '<br><br>';
if($_GET['dev'] == 1) echo json_encode($PLATES);