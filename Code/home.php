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
        <form action="/search" method="get" require>
            <!--1.段差の形状はどちらですか？-->
            <fieldset class="ques1">
                <legend>
                    <span class="num">1</span>
                    <span class='title'>段差の形状は<br>どちらですか？</span>
                </legend>
                <div>
                    <label for="step_type_single">
                        <img class='unselect' src="" alt="1段型段差の例を紹介した画像です">
                        <img class='selected' src="" alt="1段型段差の例を紹介した画像です">
                        <p>
                            <span class="title">1段型</span>
                            <span class='text'>段差が１段だけのシンプルな段差です</span>
                        </p>
                    </label>
                    <input type="radio" name="step_type" id="step_type_single" value='single' autofocus>
                </div>
                <div>
                    <label for="step_type_multipul">
                        <img class='unselect' src="" alt="多段型段差の例を紹介した画像です">
                        <img class='selected' src="" alt="多段型段差の例を紹介した画像です">
                        <p>
                            <span class="title">多段型</span>
                            <span class='text'>階段状の段差や、岡山でよく見られる側溝をまたぐ段差などです</span>
                        </p>
                    </label>
                    <input type="radio" name="step_type" id="step_type_multipul" value='multipul'>
                </div>
            </fieldset>
            <!--2.段差の横幅と高さを教えて下さい-->
            <fieldset class='ques2'>
                <legend>
                    <span class="num">2</span>
                    <span class='title'>段差の横幅と高さを<br>教えてください</span>
                </legend>
                <video src="">
                    横幅を測るときは、段差の一番手前の横幅を測ります。
                    測るのは、必要な長さだけで構いません。
                    高さを測るときは、身長を測るときのように板を用意して計測するとうまくいきます。
                    水平と垂直を意識して計測作業を行いましょう。
                </video>
                <div>
                    <input type="number" name="width" id="width" autocomplete='off' placeholder='横幅を入力'>
                    <span class="cm">cm</span>
                    <div class="check_icons">
                        <img class='ok' src="" alt="入力された値は正常です">
                        <img class='bad' src="" alt="入力された値に誤りがあります">
                    </div>
                    <p class="error_msg">{{insert with Vue.js}}</p>
                </div>
                <div>
                    <input type="number" name="height" id="height" autocomplete='off' placeholder='高さを入力'>
                    <span class="cm">cm</span>
                    <div class="check_icons">
                        <img class='ok' src="" alt="入力された値は正常です">
                        <img class='bad' src="" alt="入力された値に誤りがあります">
                    </div>
                    <p class="error_msg">{{insert with Vue.js}}</p>
                </div>
            </fieldset>
            <!--3.段差の奥行きについて教えてください 多段型選択時-->
            <fieldset class='ques3'>
                <legend>
                    <span class="num">3</span>
                    <span class='title'>段差の奥行きについて<br>教えてください</span>
                </legend>
                <video src="">
                    奥行きを測るときは「最短」と「最長」を考えます。
                    プレートが階段の角にぶつからないようにするには、段差の奥行きよりも少し伸ばす必要があります。
                    伸ばす距離は、階段の最も奥行きがある段の長さです。
                    これが、最短の奥行きとなります。
                    次に、設置場所の環境でプレートを設置できる最大の奥行きを指定します。
                    こすうることにより、車いすでも安全に登れる坂の角度を求めることができます。
                </video>
                <div>
                    <input type="number" name="min_depth" id="min_depth" autocomplete='off' placeholder='最短の奥行きを入力'>
                    <span class="cm">cm</span>
                    <div class="check_icons">
                        <img class='ok' src="" alt="入力された値は正常です">
                        <img class='bad' src="" alt="入力された値に誤りがあります">
                    </div>
                    <p class="error_msg">{{insert with Vue.js}}</p>
                </div>
                <div>
                    <input type="number" name="max_depth" id="max_depth" autocomplete='off' placeholder='最長の奥行きを入力'>
                    <span class="cm">cm</span>
                    <div class="check_icons">
                        <img class='ok' src="" alt="入力された値は正常です">
                        <img class='bad' src="" alt="入力された値に誤りがあります">
                    </div>
                    <p class="error_msg">{{insert with Vue.js}}</p>
                </div>
            </fieldset>
            <!--3.プレートを設置する場所で設置できる最大の奥行きを教えて下さい １段型選択時-->
            <fieldset class='ques3'>
                <legend>
                    <span class="num">3</span>
                    <span class='title'>プレートを設置する場所で<br>設置できる最大の奥行きを教えて下さい</span>
                </legend>
                <div>
                    <input type="hidden" name="min_depth" id="min_depth" autocomplete='off' value='0'>
                </div>
                <div>
                    <input type="number" name="max_depth" id="max_depth" autocomplete='off' placeholder='最大の奥行きを入力'>
                    <span class="cm">cm</span>
                    <div class="check_icons">
                        <img class='ok' src="" alt="入力された値は正常です">
                        <img class='bad' src="" alt="入力された値に誤りがあります">
                    </div>
                    <p class="error_msg">{{insert with Vue.js}}</p>
                </div>
            </fieldset>
            <!--submitボタンとメッセージ-->
            <div>
                <button type="submit">検索する</button>
                <p class="require">全項目入力する必要があります</p>
                <p class="error_msg"></p>
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