<?php
/*高さを条件としてWP_QUERYを発行し、高さがマッチするプレートをPLATESに格納*/

if($QUERY['STEP_TYPE'] == 'single'){
    if($_GET['dev'] == 1) echo '<br><br>work single';
    //1段型
    $arg = array(
        'posts_per_page'=>'-1',
        'post_type'		=> 'plates',
        'meta_query'	=> array(
            'relation'  => 'AND',
            array(
                'key'       => 'plate_is_on',
                'compare'   => '=',
                'value'     => 's'
            ),
            array(
                'key'       => 'min_height',
                'compare'   => '<=',
                'value'     => $QUERY['HEIGHT'],
                'type' => 'NUMERIC'
            ),
            array(
                'key'       => 'max_height',
                'compare'   => '>=',
                'value'     => $QUERY['HEIGHT'],
                'type' => 'NUMERIC'
            )
        )
    );
    $arg2 = array(
        'posts_per_page'=>'-1',
        'post_type'		=> 'plates',
        'meta_query'	=> array(
            'relation' => 'AND',
            array(
                'key'       => 'plate_is_on',
                'compare'   => '=',
                'value'     => 'g'
            ),
            array(
                'key' => 'min_height',
                'compare' => '<=',
                'value' => $QUERY['HEIGHT']+1,
                'type' => 'NUMERIC'
            ),
            array(
                'key' => 'min_height',
                'compare' => '>=',
                'value' => $QUERY['HEIGHT'],
                'type' => 'NUMERIC'
            )
        )
    );
}else{
    if($_GET['dev'] == 1) echo '<br><br>work multiple';
    //多段型
    $arg = array(
        'posts_per_page'=>'-1',
        'post_type'		=> 'plates',
        'meta_query'	=> array(
            'relation'  => 'AND',
            array(
                'key'       => 'plate_is_on',
                'compare'   => '=',
                'value'     => 's'
            ),
            array(
                'key'       => 'min_height',
                'compare'   => '<=',
                'value'     => $QUERY['HEIGHT'],
                'type' => 'NUMERIC'
            ),
            array(
                'key'       => 'max_height',
                'compare'   => '>=',
                'value'     => $QUERY['HEIGHT'],
                'type' => 'NUMERIC'
            )
        )
    );
}

$PLATES = [];
$i = 0;
$the_query = new WP_Query( $arg );
if( $the_query->have_posts() ){
    while( $the_query->have_posts() ){
        $the_query->the_post();
        //PLATES[]に格納
        $PLATES[$i]['POST_ID'] = get_the_ID();
        $PLATES[$i]['MIN_HEIGHT'] = get_field('min_height');
        $PLATES[$i]['MAX_HEIGHT'] = get_field('max_height');
        $PLATES[$i]['WIDTH'] = get_field('width');
        $PLATES[$i]['DEPTH'] = get_field('depth');
        $PLATES[$i]['PLATE_IS_ON'] = get_field('plate_is_on');
        $PLATES[$i]['URL'] = get_field('url');
        $PLATES[$i]['IMAGE_URL'] = get_field('image_url');
        $PLATES[$i]['CAN_BIND'] = get_field('can_bind');
        if($_GET['dev'] == 1) echo '<br>'.$i.'回目のループ';
        $i++;
    }
}
wp_reset_query();

if($QUERY['STEP_TYPE'] == 'single'){
    $PLATES_TMP = [];
    $i = 0;
    $the_query = new WP_Query( $arg2 );
    if( $the_query->have_posts() ){
        while( $the_query->have_posts() ){
            $the_query->the_post();
            //PLATES[]に格納
            $PLATES_TMP[$i]['POST_ID'] = get_the_ID();
            $PLATES_TMP[$i]['MIN_HEIGHT'] = get_field('min_height');
            $PLATES_TMP[$i]['MAX_HEIGHT'] = get_field('max_height');
            $PLATES_TMP[$i]['WIDTH'] = get_field('width');
            $PLATES_TMP[$i]['DEPTH'] = get_field('depth');
            $PLATES_TMP[$i]['PLATE_IS_ON'] = get_field('plate_is_on');
            $PLATES_TMP[$i]['URL'] = get_field('url');
            $PLATES_TMP[$i]['IMAGE_URL'] = get_field('image_url');
            $PLATES_TMP[$i]['CAN_BIND'] = get_field('can_bind');
            if($_GET['dev'] == 1) echo '<br>'.$i.'回目のループB';
            $i++;
        }
    }
    wp_reset_query();

    //PLATESとPLATES_TMPと重複なしで統合
    $PLATES = array_merge($PLATES, $PLATES_TMP);
}

if($_GET['dev'] == 1) echo '<br><br>';
if($_GET['dev'] == 1) echo json_encode($PLATES);