<?php
session_start();
?>
<?php 
$headerTitle = '投稿ページのタイトル';
?>
<?php
//ページに訪れたことがあるか
if(isset($_SESSION['fro'])){
    if($_SESSION['fro'] == 1){
        $is_from_google = false;
        //アプリの検索結果画面から来たユーザー
        $query = [
            'height' => isset($_GET['hei']) ? $_GET['hei'] : null,
            'width' => isset($_GET['wid']) ? $_GET['wid'] : null,
            'depth' => isset($_GET['dep']) ? $_GET['dep'] : null,
            'angle' => isset($_GET['ang']) ? $_GET['ang'] : null,
            'need' => isset($_GET['nee']) ? $_GET['nee'] : null
        ];
        //Googleから来た扱いにする
        //デバッグ用
        $is_from_google = $_GET['fro'] == 'google' ? true : false;
        //?fro=google&hei=3.2&wid=240&dep=10\/33.1&ang=4.2&nee=3
    }
}else{
    $is_from_google = true;
};
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
    <!--Googleから来た人にメッセージを出す-->
    <?php if($is_from_google):?>
    <div class="from_google_msg">
        <button class="close"><div class='close1'></div>
        <div class='close2'></div></button>
        <div class="center">
            <h2>
                段差を<br>
                なくそう
            </h2>
            <p>
                設置場所のサイズをARを使って簡単に計測し、サイズに合ったプレートを検索することができます。
            </p>
            <p class="use_ar"><a href="">ARで計測</a></p>
        </div>
    </div>
    <?php endif;?>

    <main>
        <div class='header'>
            <h2>詳細</h2>
            <p class="backToList">
                <?php if($is_from_google == false):?>
                <a href="<?php echo $_SERVER['HTTP_REFERER'];?>">
                    <img src="images/global/to-back.svg" alt="ステップの検索結果ページに戻る">
                </a>
                <?php else:?>
                <a href="<?php echo esc_url( home_url('/'));?>">
                    <img src="images/global/to-top.svg" alt="サイトのトップページヘ">
                </a>
                <?php endif;?>
            </p>
        </div>

        <article <?php post_class();?>>
        <?php if(have_posts()):
        while(have_posts()):
        the_post();

        //情報を格納
        $plate = [
            'url' => get_field('url'),
            'plate_is_use_for' => get_field('plate_is_use_for'),
            'plate_is_on' => get_field('plate_is_on'),
            'width' => get_field('width'),
            'height' => explode("/", get_field('height')),//高さにmin/maxがある場合に対応できるように処理
            'depth' => get_field('depth'),
            'angle' => get_field('angle'),
            'can_bind' => get_field('can_bind'),
            'image_url' => get_field('image_url')
        ];
        ?>
            <figure class='plateImage'>
                <img src="<?php echo esc_url($plate['image_url']);?>" alt="プレートの写真">
                <?php if($is_from_google == false):?>
                <figcaption>
                    <!--layout with Grid-->
                    <span class='kakeru'>✕</span>
                    <span class='kazu'><?php echo $query['need'];?></span>
                    <span class='ko'>個</span>
                    <span class='hituyou'>必要</span>
                </figcaption>
                <?php endif;?>
            </figure>
            <div class="actionBtns">
                <button class="try_with_ar" title='ARでプレビュするボタンです。この機能を使用するには、目の見える方に手伝って貰う必要があります。'>
                    ARで試す
                </button>
                <p class="buy">
                    <a href="<?php echo esc_url($plate['url']);?>" target='new'>購入ページへ</a>
                </p>
            </div>
            <div class="sizes">
                <dl>
                    <?php function displayNum($title,$key,$max_key = null){?>
                    <dt><?php echo ($title == '傾斜' && $plate['height'][1] != null ? '最小の' : '').$title;?></dt>
                    <dd>
                        <span class="num_int"><?php echo floor($key);?></span>
                        <?php if($key >= floor($key)+0.1):?>
                            <span class="num_floot">.<?php echo substr($key-floor($key),2);?></span>
                        <?php endif;?>
                        <?php if($max_key != null):?>
                            <span class="kara">〜</span>
                            <span class="num_int"><?php echo floor($max_key);?></span>
                            <?php if($max_key >= floor($max_key)+0.1):?>
                            .<span class="num_floot"><?php echo substr($max_key-floor($max_key),2);?></span>
                        <?php endif;?>
                        <?php endif;?>
                        <span class="tanni"><?php echo ($title == '傾斜' ? '度' : 'cm' );?></span>
                    </dd>
                    <?php };?>
                    <?php displayNum('奥行き',$plate['depth']);?>
                    <?php displayNum('横幅',$plate['width']);?>
                    <?php displayNum('高さ',$plate['height'][0],$plate['height'][1]);?>
                </dl>
            </div>

            <?php
            //アプリの検索結果ページから来た場合は、計測した高さを使う。Googleからの場合はDBにあった数値を使い、かつ高さが可変の場合は最大と最小の平均値を使う
            if($_SESSION['fro'] == 1 && $_GET['height'] != null){
                //アプリの検索結果ページから来た場合でかつGETがセットされている
                $height = $_GET['height'];
            }else if($plate['height'][1] != null){
                //最大と最小がある場合
                $height = ($plate['height'][0]+$plate['height'][1])/2;
            }else{
                //固定値の場合
                $height = $plate['height'][0];
            }
            //三角関数で角度を求める
            if($plate['plate_is_on'] == 'g'){
                //地面に接している
                $plate['angle'] = round(tan($height/$plate['depth'])*100,1);
            }else{
                //段差に接している
                $plate['angle'] = round(sin($height/$plate['depth'])*100,1);
            }
            //グラフィックとメッセージの決定
            if($plate['angle'] >= 0){
                $level = 'safe'; //画像のファイル名やクラス分けに使用
                $angle_msg = '車椅子にとって安全な高さです';
                $angle_explanatory = 'とてもいい角度です。しかし、雨の日の濡れたプレートは滑りやすく危険です。プレートにマットを敷くと、より良くなりますよ。';
            };
            if($plate['angle'] >= 15){
                $level = 'warning';
                $angle_msg = '注意が必要なプレートです';
                $angle_explanatory = '雨の日では、この角度のプレートは大変滑りやすくなります。設置する場合は、マットを一緒に敷くと安全になります。';
            };
            if($plate['angle'] >= 30){
                $level = 'danger';
                $angle_msg = '車椅子にとって危険な傾斜です';
                $angle_explanatory = '天候に関わらず、危険な角度です。このプレートを車椅子ユーザーや重い荷物を積んだベビーカーが使用しようとした場合、転倒する恐れがあります。可能であれば、緩やかなプレートを設置する努力が必要です。';
            };
            ?>
            <div class="angle <?php echo $level;?>">
                <dl>
                    <?php displayNum('傾斜',$plate['angle']);?>
                </dl>
                <img src='images/single/angle-info-<?php echo $level;?>.svg"' alt="<?php echo $angle_msg;?>">
                <p class="msg"><?php echo $angle_msg;?></p>
                <p class="explanatory">
                    <?php echo $angle_explanatory;?>
                </p>
            </div>

            <aside class="noti">
                <p>
                    <span>値段など詳細は、購入ページにアクセスして確認してください。</span>
                </p>
            </aside>
        <?php endwhile;
        endif;?>
        </article>
    </main>

<?php get_footer();?>

<?php
$_SESSION['fro'] = 1;
?>