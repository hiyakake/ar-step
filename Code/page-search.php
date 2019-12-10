<?php
/*
Template Name:プレート検索結果ページ
*/
session_start();
$_SESSION['have_seen'] = true;

include('mpa/match_plate_api.php');

?>

<?php get_header();?>

<main>
    <div class='header'>
        <h2>おすすめのステップ</h2>
        <p class="backToList">
            <?php if($_GET['from'] != 'ar'):?>
            <!--手入力検索から来た場合はトップへ-->
            <a href="<?php echo esc_url( home_url('/'));?>">
                <img src="images/global/to-top.svg" alt="サイトのトップページヘ">
            </a>
            <?php else:?>
            <!--ARから着た人はARのトップへ-->
            <a href="<?php echo esc_url( home_url('/')).'/ar';?>">
                <img src="images/global/to-ar.svg" alt="ARスキャンに戻る">
            </a>
            <?php endif;?>
        </p>
    </div>

    <div class="sizes">
        <div class='sticky'>
            <h2>
                <?php echo ($_GET['from'] == 'ar') ? '計測した段差の寸法' : '入力した段差の寸法';?>
            </h2>
            <dl>
                <?php function displayNum($title,$key,$max_key = -1){?>
                <dt>
                    <?php echo ($title == '傾斜' && $plate['max_height'] != -1 ? '平均' : '').$title;?>
                </dt>
                <dd>
                    <span class="num_int"><?php echo floor($key);?></span>
                    <?php if($key >= floor($key)+0.1):?>
                        <span class="num_floot">.<?php echo substr($key-floor($key),2);?></span>
                    <?php endif;?>
                    <?php if($max_key != -1):?>
                        <span class="kara">〜</span>
                        <span class="num_int"><?php echo floor($max_key);?></span>
                        <?php if($max_key >= floor($max_key)+0.1):?>
                        .<span class="num_floot"><?php echo substr($max_key-floor($max_key),2);?></span>
                    <?php endif;?>
                    <?php endif;?>
                    <span class="tanni"><?php echo ($title == '傾斜' ? '度' : 'cm' );?></span>
                </dd>
                <?php };?>
                <?php displayNum('高さ',$QUERY['HEIGHT']);?>
                <?php displayNum('横幅',$QUERY['WIDTH']);?>
                <?php displayNum('奥行き',$QUERY['MIN_DEPTH'],$QUERY['MAX_DEPTH']);?>
            </dl>
        </div>
    </div>
    
    <?php if(count($PLATES) == 0):?>
    <section class="list unmatch" <?php post_class();?>>
        <p>マッチするプレートが<br>見つかりません</p>
    </section>
    <?php else:?>
    <section class="list matched" <?php post_class();?>>
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