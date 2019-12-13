<?php
/*GETの不足部分を補完し、QUERYに保管*/
$QUERY['HEIGHT'] = $_GET['height'];
$QUERY['WIDTH'] = $_GET['width'];
$QUERY['MIN_DEPTH'] = $_GET['min_depth'];
$QUERY['MAX_DEPTH'] = $_GET['max_depth'];
//角度を求めて格納
if($QUERY['MIN_DEPTH'] != '0') $QUERY['MIN_ANGLE'] = rad2deg(atan($QUERY['HEIGHT']/$QUERY['MIN_DEPTH']));
else $QUERY['MIN_ANGLE'] = 0;
if($QUERY['MAX_ANGLE'] != '0') $QUERY['MIN_ANGLE'] = rad2deg(atan($QUERY['HEIGHT']/$QUERY['MAX_DEPTH']));
else $QUERY['MAX_ANGLE'] = 0;
//段差の形状を判断して格納
if($QUERY['MIN_DEPTH'] == 0) $QUERY['STEP_TYPE'] = 'single';
else $QUERY['STEP_TYPE'] = 'multiple';

if($_GET['dev'] == 1){
    print('<br>HEIGHT '.$QUERY['HEIGHT']);
    print('<br>WIDTH '.$QUERY['WIDTH']);
    print('<br>MIN_DEPTH '.$QUERY['MIN_DEPTH']);
    print('<br>MAX_DEPTH '.$QUERY['MAX_DEPTH']);
    print('<br>MIN_ANGLE '.$QUERY['MIN_ANGLE']);
    print('<br>MAX_ANGLE '.$QUERY['MAX_ANGLE']);
    print('<br>STEP_TYPE '.$QUERY['STEP_TYPE']);
}