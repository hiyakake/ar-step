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
    <img src="images/home/home_hero.jpg" alt="" class="visual">
    <div class="scrollToBottom"><!--CSSで描く--></div>
</header>

<!--サイト紹介エリア-->
<section class='PR'>
    <div class="arde">
        <div class="text">
            <p class='big'>ARで簡単に<br>段差を<br>計測できます</p>
            <p class='small'><small>※手入力もできます</small></p>
        </div>
        <img src="images/home/home_arde.jpg" alt="" class="visual">
    </div>
    <div class="keisokusita">
        <div class="text">
            <p>
                <span>
                    <span>計</span><span>測</span><span>し</span><span>た</span><span>寸</span><span>法</span><span>に</span>
                </span>
                <span>
                    <span>マ</span><span>ッ</span><span>チ</span><span>す</span><span>る</span>
                </span>
                <span>
                    <span>ス</span><span>テ</span><span>ッ</span><span>プ</span><span>を</span><span>提</span><span>案</span><span>し</span><span>ま</span><span>す</span>
                </span>
            </p>
        </div>
        <img src="images/home/home_keisoku_sp.jpg" alt="" class="visual sp">
        <img src="images/home/home_keisoku_pc.jpg" alt="" class="visual pc">
    </div>
</section>

<section class="search">
    <!--AR SCANの導線エリア-->
    <section class="ar_scan sp">
        <h2 class='big'>段差を<br>なくしましょう</h2>
        <p class="button">
            <a href="/ar">
                <span class="main">
                    ARで計測する
                </span>
                <span class="hukidashi">
                    簡単に計測できます
                </span>
            </a>
        </p>
    </section>
    <section class="ar_scan pc">
        <div class="main">
            <!--スマホアイコンはCSSで-->
            <img src="images/home/QR.svg" alt="URL" class="qr">
            <p>ARで<br>段差の大きさを<br>計測しましょう。</p>
        </div>
    </section>
    <!--手入力検索のエリア-->
    <section class="hand_scan">
        <h2>
            <!--アイコンはCSSで-->
            手入力でも<br>検索できます
        </h2>
        <form action="/search" method="get">
            <!--1.段差の形状はどちらですか？-->
            <fieldset class="ques1">
                <legend>
                    <span class="num">1</span>
                    <span class='title'>段差の形状は<br>どちらですか？</span>
                </legend>
                <div class='contents'>
                    <div :class='{ active : step_type == "single" }'>
                        <label for="step_type_single">
                            <img class='unselect' src="images/home/段差選択_1段.jpg" alt="1段型段差の例を紹介した画像です" v-show='step_type != "single"'>
                            <img class='selected' src="images/home/段差選択_1段_hover.jpg" alt="1段型段差の例を紹介した画像です" v-show='step_type == "single"'>
                            <p>
                                <span class="title">1段型</span>
                                <span class='text'>段差が１段だけのシンプルな段差です</span>
                            </p>
                        </label>
                        <input require='require' type="radio" name="step_type" id="step_type_single" value='single' v-model='step_type' autofocus>
                    </div>
                    <p class="or">OR</p>
                    <div :class='{ active : step_type == "multipul" }'>
                        <label for="step_type_multipul">
                            <img class='unselect' src="images/home/段差選択_階段.jpg" alt="多段型段差の例を紹介した画像です" v-show='step_type != "multipul"'>
                            <img class='selected' src="images/home/段差選択_階段_hover.jpg" alt="多段型段差の例を紹介した画像です" v-show='step_type == "multipul"'>
                            <p>
                                <span class="title">多段型</span>
                                <span class='text'>階段状の段差や、岡山でよく見られる側溝をまたぐ段差などです</span>
                            </p>
                        </label>
                        <input require='require' type="radio" name="step_type" id="step_type_multipul" value='multipul' v-model='step_type'>
                    </div>
                </div>
            </fieldset>
            <!--2.段差の横幅と高さを教えて下さい-->
            <fieldset class='ques2'>
                <legend>
                    <span class="num">2</span>
                    <span class='title'>段差の横幅と高さを<br>教えてください</span>
                </legend>
                <video src="images/home/how_to_width_and_height.mp4" playsinline controls repeat preload='metadata'>
                    <p>
                        横幅を測るときは、段差の一番手前の横幅を測ります。
                        測るのは、必要な長さだけで構いません。
                        高さを測るときは、身長を測るときのように板を用意して計測するとうまくいきます。
                        水平と垂直を意識して計測作業を行いましょう。
                    </p>
                </video>
                <div class='num_input'>
                    <p class="error_msg"><!--insert with Vue.js--></p>
                    <label for="width">横幅</label>
                    <input require='require' type="number" pattern="[0-9]*" name="width" id="width" placeholder='入力'>
                    <span class="cm">cm</span>
                </div>
                <div class='num_input'>
                    <p class="error_msg"><!--insert with Vue.js--></p>
                    <label for="height">高さ</label>
                    <input require='require' type="number" pattern="[0-9]*" name="height" id="height" placeholder='入力'>
                    <span class="cm">cm</span>
                </div>
            </fieldset>
            <!--3.段差の奥行きについて教えてください 多段型選択時-->
            <fieldset class='ques3' v-show='step_type == "multipul"'>
                <legend>
                    <span class="num">3</span>
                    <span class='title'>段差の奥行きについて<br>教えてください</span>
                </legend>
                <video src="images/home/how_to_width_and_height.mp4" playsinline controls repeat preload='metadata'>
                    <p>
                        奥行きを測るときは「最短」と「最長」を考えます。
                        プレートが階段の角にぶつからないようにするには、段差の奥行きよりも少し伸ばす必要があります。
                        伸ばす距離は、階段の最も奥行きがある段の長さです。
                        これが、最短の奥行きとなります。
                        次に、設置場所の環境でプレートを設置できる最大の奥行きを指定します。
                        こすうることにより、車いすでも安全に登れる坂の角度を求めることができます。
                    </p>
                </video>
                <div class='num_input'>
                    <p class="error_msg"><!--insert with Vue.js--></p>
                    <label for="min_depth">最短の奥行き</label>
                    <input require='require' type="number" pattern="[0-9]*" name="min_depth" id="min_depth" placeholder='入力'>
                    <span class="cm">cm</span>
                </div>
                <div class='num_input'>
                    <p class="error_msg"><!--insert with Vue.js--></p>
                    <label for="max_depth">最長の奥行き</label>
                    <input require='require' type="number" pattern="[0-9]*" name="max_depth" id="max_depth" placeholder='入力'>
                    <span class="cm">cm</span>
                </div>
            </fieldset>
            <!--3.プレートを設置する場所で設置できる最大の奥行きを教えて下さい １段型選択時-->
            <fieldset class='ques3' v-show='step_type == "single"'>
                <legend>
                    <span class="num">3</span>
                    <span class='title'>プレートを設置する場所で<br>設置できる最大の奥行きを<br>教えて下さい</span>
                </legend>
                <div class='num_input'>
                    <input type="hidden" name="min_depth" id="min_depth" value='0' v-bind:disabled='step_type != "single"'>
                </div>
                <div class='num_input'>
                    <p class="error_msg"><!--insert with Vue.js--></p>
                    <label for="max_depth">最大の奥行き</label>
                    <input require='require' type="number" pattern="[0-9]*" name="max_depth" id="max_depth" placeholder='入力' v-bind:disabled='step_type != "single"'>
                    <span class="cm">cm</span>
                </div>
            </fieldset>
            <!--submitボタンとメッセージ-->
            <div class='submit'>
                <input type="submit" value="ぴったりプレートを表示" v-show='step_type != null'>
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
        function gallery_component($title,$youtubeID){?>
        <li>
            <h3><?php echo '# '.$title;?></h3>
            <div class="youtube">
                <iframe width="560" height="315" src="https://www.youtube.com/embed/<?php echo $youtubeID;?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
            <p class="twitter">
                <a href="">
                    <img src="images/global/icon-twitter.svg" alt="<?php echo $title.'をTwitterでつぶやく';?>">
                </a>
            </p>
        </li>
        <?php };?>
        <?php
        gallery_component('なおっちゃさん','h8tB5BCWMQY');
        ?>
    </ol>
</section>


<?php
get_footer();
?>