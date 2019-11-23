<?php
/*
Template Name:プレート検索結果ページ
*/

include('page-match_plate_api.php');

?>

<?php get_header();?>

<main>
    <div class='header'>
        <h2>詳細</h2>
    </div>

    <section class="set_place">
        <h2>設置場所の寸法</h2>
        <?php function displayNum($title,$key,$max_key = null){?>
        <dt><?php echo $title;?></dt>
        <dd>
            <span class="num_int"><?php echo floor($key);?></span>
            <?php if($key >= floor($key)+0.1):?>
                .<span class="num_floot"><?php echo substr($key-floor($key),2);?></span>
            <?php endif;?>

            <?php if($max_key != null):?>
                <span class="kara">〜</span>
                <span class="num_int"><?php echo floor($max_key);?></span>
                <?php if($max_key >= floor($max_key)+0.1):?>
                .<span class="num_floot"><?php echo substr($max_key-floor($max_key),2);?></span>
            <?php endif;?>
            <?php endif;?>
            <span class="tanni">cm</span>
        </dd>
        <?php };?>
        <dl>
            <?php displayNum('横幅',$QUERY['WIDTH']);?>
            <?php displayNum('高さ',$QUERY['HEIGHT']);?>
            <?php displayNum('高さ',$QUERY['MIN_DEPTH'],$QUERY['MAX_DEPTH']);?>
        </dl>
    </section>
    
    <?php if(count($PLATES) == 0):?>
    <section class="list" <?php post_class();?>>
        <p>マッチするプレートが見つかりませんでした</p>
    </section>
    <?php else:?>
    <section class="list" <?php post_class();?>>
        <h2>傾斜が緩やかな順</h2>
        <ol>
            <?php for($i = 0;$i < count($PLATES);$i++):?>
            <li>
                <a href="<?php echo $PLATES[$i]['POST_URL'].'?angle_when_used='.$PLATES[$i]['angle_when_used'].'&need_count='.$PLATES[$i]['need_count'];?>">
                    <figure>
                        <img src="<?php echo $PLATES[$i]['IMAGE_URL'];?>" alt="プレートの写真です">
                    </figure>
                    <dl>
                        <dt><img src="images/search/angle-icon.svg" alt="傾斜"></dt>
                        <dd>傾斜<?php echo round($PLATES[$i]['angle_when_used'],1);?>°</dd>
                        <dt><img src="images/search/stack-icon.svg" alt="必要枚数"></dt>
                        <dd><?php echo $PLATES[$i]['need_count'];?>枚必要</dd>
                    </dl>
                </a>
            </li>
        <?php endfor;?>
        </ol>
    </section>
    <?php endif;?>
</main>

<?php get_footer();?>