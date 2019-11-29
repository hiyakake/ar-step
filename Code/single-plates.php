<?php
session_start();
?>
<?php 
$headerTitle = '投稿ページのタイトル';
?>
<?php
    //GETの無毒化
    $_GET['need_count'] = htmlspecialchars($_GET['ndde_count']);
    $_GET['angle_when_used'] = htmlspecialchars($_GET['angle_when_used']);
    $_GET['from'] = htmlspecialchars($_GET['form']);
?>
<?php
//ページに訪れたことがあるか
if(isset($_SESSION['have_seen'])){
    $is_from_google = false;
    $_SESSION['have_seen'] = true;
    if($_GET['from'] == 'google'){
        $is_from_google = true;
    }
}else{
    $is_from_google = true;
};
?>

<?php get_header();?>

    <!--Googleから来た人にメッセージを出す-->
    <?php if($is_from_google):?>
    <div class="from_google_msg" v-show='view'>
        <button class="close" @click='view = false'><div class='close1'></div>
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

        //通常の情報を格納
        $plate = [
            'url'               => get_field('url'),
            'plate_is_use_for'  => get_field('plate_is_use_for'),
            'plate_is_on'       => get_field('plate_is_on'),
            'width'             => get_field('width'),
            'min_height'        => get_field('min_height'),
            'max_height'        => get_field('max_height'),
            'depth'             => get_field('depth'),
            'image_url'         => get_field('image_url')
        ];
        //検索結果から来たユーザー向け情報の格納
        if($is_from_google == false){
            $plate['need_count']        = $_GET['need_count'];
            $plate['angle_when_used']   = round($_GET['angle_when_used'],1);
        }
        //検索から来た場合、設置高さを平均値で仮定し高さを算出
        if($is_from_google == true){
            //三角関数で角度を求める
            if($plate['plate_is_on'] == 'g'){
                //地面に接している
                $plate['angle_when_used'] = round(rad2deg(atan($plate['min_height']/$plate['depth'])),1);
            }else{
                //段差に接している
                $plate['angle_when_used'] = round(rad2deg(asin((($plate['min_height']+$plate['max_height'])/2)/$plate['depth'])),1);
            }
        }
        ?>
            <figure class='plateImage'>
                <img src="<?php echo esc_url($plate['image_url']);?>" alt="プレートの写真">
                <?php if($is_from_google == false):?>
                <figcaption>
                    <!--layout with Grid-->
                    <span class='kakeru'>✕</span>
                    <span class='kazu'><?php echo $plate['need_count'];?></span>
                    <span class='ko'>枚</span>
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
                    <?php displayNum('奥行き',$plate['depth']);?>
                    <?php displayNum('横幅',$plate['width']);?>
                    <?php displayNum('高さ',$plate['min_height'],$plate['max_height']);?>
                </dl>
            </div>

            <?php
            //グラフィックとメッセージの決定
            if($plate['angle_when_used'] >= 0){
                $level = 'safe'; //画像のファイル名やクラス分けに使用
                $angle_msg = '車椅子にとって安全な高さです';
                $angle_explanatory = 'とてもいい角度です。しかし、雨の日の濡れたプレートは滑りやすく危険です。プレートにマットを敷くと、より良くなりますよ。';
            };
            if($plate['angle_when_used'] >= 4){
                $level = 'warning';
                $angle_msg = '注意が必要なプレートです';
                $angle_explanatory = '雨の日では、この角度のプレートは大変滑りやすくなります。設置する場合は、マットを一緒に敷くと安全になります。';
            };
            if($plate['angle_when_used'] >= 13){
                $level = 'danger';
                $angle_msg = '車椅子にとって危険な傾斜です';
                $angle_explanatory = '天候に関わらず、危険な角度です。このプレートを車椅子ユーザーや重い荷物を積んだベビーカーが使用しようとした場合、転倒する恐れがあります。可能であれば、緩やかなプレートを設置する努力が必要です。';
            };
            ?>
            <div class="angle <?php echo $level;?>">
                <dl>
                    <?php displayNum('傾斜',$plate['angle_when_used']);?>
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