<?php
/*
Template Name:プレート検索結果ページ
*/

//クエリーを保存
$query = [
    'height' => $_GET['hei'],
    'width' => $_GET['wid'],
    'depth_min' => $_GET['dep_min'],
    'depth_max' => $_GET['dep_max'],
    'angle' => $_GET['ang'],
    'need' => $_GET['nee']
];

?>

<?php get_header();?>

<header>
    <div class="titles">
        <h1><a href='<?php echo esc_url( home_url('/'));?>'><img src="" alt="LOGO"></a></h1>
        <span>/</span>
        <h2><?php echo $headerTitle;?></h2>
    </div>
    <nav>
        <p>プレートを探す</p>
    </nav>
</header>

<main>
    <div class='header'>
        <h1>おすすめのステップ</h1>
        <p class="backToList">
            <?php if($is_from_google == false):?>
            <a href="<?php echo $_SERVER['HTTP_REFERER'];?>">
                <img src="" alt="ステップの検索結果ページに戻る">
                <span>一覧へ</span>
            </a>
            <?php else:?>
            <a href="<?php echo $_SERVER['HTTP_REFERER'];?>">
                <img src="<?php echo esc_url( home_url('/'));?>" alt="サイトのトップページヘ">
                <span>TOPへ</span>
            </a>
            <?php endif;?>
        </p>
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
            <?php displayNum('横幅',$query['width']);?>
            <?php displayNum('高さ',$query['height']);?>
            <?php displayNum('高さ',$query['depth_min'],$query['depth_max']);?>
        </dl>
    </section>

    <section class="wait_api" v-show='is_wait_api == true'>
        <h2>あなたにぴったりにステップを探しています。</h2>
        <div class="bar">
            <div :style='{ width : loading_progress+"%" }'><!--これのwidthを変化させる--></div>
        </div>
        <p class="bar_percentage">{{loading_progress}}％</p>
    </section>

    <section class="list" v-show='is_wait_api == false' <?php post_class();?>>
        <h2>傾斜が緩やかな順</h2>
        <ol>
            <li v-for='plate in plates'>
                <figure>
                    <img :src="plate.image_url" alt="プレートの写真です">
                    <dl>
                        <dt>傾斜</dt>
                        <dd>{{plate.angle}}度</dd>
                        <dt>必要数</dt>
                        <dd>{{plate.need}}枚</dd>
                    </dl>
                </figure>
            </li>
        </ol>
    </section>
</main>

<?php get_footer();?>