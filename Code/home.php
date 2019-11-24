<?php
/*
Template Name:トップページ
*/
session_start();
$_SESSION['have_seen'] = true;
?>

<?php get_header();?>

<header>
    <div class="text">
        <h2 class='big'>段差を<br>なくそう</h2>
        <p class='regular'>このサイトは、一つでも多くの場所に段差を解消するプレートを設置してもらうことを目指しています。</p>
    </div>
    <img src="" alt="" class="visual">
    <div class="scrollToBottom"><!--CSSで描く--></div>
</header>

<!--サイト紹介エリア-->
<section class='PR'>
    <div class="arde">
        <div class="text">
            <p class='big'>ARで簡単に<br>段差を<br>計測できます</p>
            <p class='small'><small>※手入力もできます</small></p>
        </div>
        <img src="" alt="" class="visual">
    </div>
    <div class="keisokusita">
        <div class="text">
            <p>
                <span>計測した寸法に</span>
                <span>マッチする</span>
                <span>段差を提案します</span>
            </p>
        </div>
        <img src="" alt="" class="visual sp">
        <img src="" alt="" class="visual pc">
    </div>
</section>

<section class="search">
    <!--AR SCANの導線エリア-->
    <section class="ar_scan sp">
        <h2 class='big'>段差を<br>なくしましょう</h2>
        <p class="button">
            <a href="">
                <div class="main">
                    <!--アイコンはCSSで-->
                    ARで計測する
                </div>
                <div class="hukidashi">
                    簡単に計測できます
                </div>
            </a>
        </p>
    </section>
    <section class="ar_scan pc">
        <div class="main">
            <!--スマホアイコンはCSSで-->
            <img src="" alt="URL" class="qr">
            <p>ARで<br>段差の大きさを<br>計測しましょう。</p>
        </div>
    </section>
    <!--手入力検索のエリア-->
    <section class="hand_scan">
        <h2>
            <!--アイコンはCSSで-->
            手入力でも<br>検索できます
        </h2>
        <form action="" method="get">
            <?php
            //タイトルコンポーネント
            $i = 1;
            function title_component($slag,$title){?>
                <label class='ques_title' for="<?php echo $slag?>">
                    <span class="num"><?php echo $i;?></span>
                    <span class="text"><?php echo $title;?></span>
                </label>
            <?php
            $i++;
            };
            ?>
            <!--1.段差の形状はどちらですか？-->
            <div class="ques1">
                <?php title_component('step_type','段差の形状は<br>どちらですか？');?>

            </div>
        </form>
    </section>
</section>

<!--ギャラリー-->
<section class="gallery">
    <h2>
        <span>ギャラリー</span>
        <span>#進めバリアフリー</span>
    </h2>
    <ol>
        <?php 
        //ギャラリー動画コンポーネント
        $i = 1;
        function gallery_component($title,$youtubeID){?>
        <li>
            <h3><?php echo $i.'.'.$title;?></h3>
            <div class="youtube">
                <iframe src="" frameborder="0"></iframe>
            </div>
            <p class="twitter">
                <a href="">
                    <img src="" alt="<?php echo $title.'をTwitterでつぶやく';?>">
                </a>
            </p>
        </li>
        <?php
        $i++;
        };?>
        <?php
        gallery_component('ほにゃにゃら編','youtubeID');
        gallery_component('ほにゃにゃら編','youtubeID');
        ?>
    </ol>
</section>


<?php
get_footer();
?>