<?php
/*
Template Name:トップページ
*/
session_start();
?>

<?php get_header();?>

<header>
    <div class="none">
        <h1>サイト名</h1>
        <p>サイトの説明文</p>
    </div>
    <div class="hero_msg">
        <h2>
            段差を<br>
            なくそう
        </h2>
        <p>
            このサイトは、一つでも多くの場所に段差を解消するプレートを設置してもらうことを目指しています。
        </p>
    </div>
    <div class="hero_image">
        <img src="" alt="ヒーロー画像">
    </div>
    <div class="developnow">
        <a href="https://github.com/LavP/ar-step" target='new'>
            <img src="images/home/seisakutyuu.svg" alt="GitHub上で、鋭意製作中">
        </a>
    </div>
    <button class="scroll_btn">
        <img src="images/home/scrollDown.svg" alt="▼">
    </button>
</header>

<main <?php post_class();?>>
    <h3>CM<br>ギャラリー</h3>
    <div class="videos">
        <div class="video">
            <video src="" alt='この動画に字幕は用意されていません。'></video>
            <div class="play_button">
                <img src="images/home/play.svg" alt="動画を再生する">
            </div>
        </div>
        <div class="video">
            <video src="" alt='この動画に字幕は用意されていません。'></video>
            <div class="play_button">
                <img src="images/home/play.svg" alt="動画を再生する">
            </div>
        </div>
    </div>
</main>

<?php
get_footer();

$_SESSION['fro'] = 1;
?>