<?php 
$headerTitle = '投稿ページのタイトル';
?>
<?php
//検索から人にメッセージウィンドウを出す
//つまり何もパラメタを持っていない
if(isset($_GET['fro'])){
    $is_from_google = false;
    //アプリの検索結果画面から来たユーザー
    $query = [
        'height' => $_GET['hei'],
        'width' => $_GET['wid'],
        'depth' => $_GET['dep'],
        'angle' => $_GET['ang'],
        'need' => $_GET['nee']
    ];
    //?fro=s&hei=3.2&wid=240&dep=10\/33.1&ang=4.2&nee=3
}else{
    
    $is_from_google = true;
}
?>

<?php get_header();?>

    <!--Googleから来た人にメッセージを出す-->
    <?php if($is_from_google):?>
    <div class="from_google_msg">
        <button class="close"><div></div>
        <div></div></button>
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

        <article <?php post_class();?>>
        <?php if(have_posts()):
        while(have_posts()):
        the_post();?>
            <figure class='plateImage'>
                <img src="<?php echo esc_url(get_field('image_url'));?>" alt="プレートの写真">
                <?php if($is_from_google == false):?>
                <figcaption>
                    <!--layout with Grid-->
                    <span>✕</span>
                    <span><?php echo $query['need'];?></span>
                    <span>個</span>
                    <span>必要</span>
                </figcaption>
                <?php endif;?>
            </figure>
            <div class="actionBtns">
                <p class="buy">
                    <a href="<?php echo esc_url(get_field('url'));?>" target='new'>購入ページへ</a>
                </p>
            </div>
            <div class="sizes">
                <dl>
                    <?php function displayNum($title,$key){?>
                        <dt><?php echo $title;?></dt>
                        <dd>
                            <span class="num_int"><?php echo floor($key);?></span>
                            <?php if($key >= floor($key)+0.1):?>
                                .<span class="num_floot"><?php echo substr($key-floor($key),2);?></span>
                            <?php endif;?>
                            <span class="tanni">cm</span>
                        </dd>
                    <?php };?>
                    <?php displayNum('奥行き',get_field('depth'));?>
                    <?php displayNum('高さ',get_field('height'));?>
                    <?php displayNum('横幅',get_field('width'));?>
                </dl>
                <div class="view_ar">
                    <button>
                        <img src="" alt="ARでプレビュするボタンです。この機能を使用するには、目の見える方に手伝って貰う必要があります。">
                        <p>ARで試す</p>
                    </button>
                </div>
            </div>

            <?php
            //三角関数で角度を求める

            $angle = 10.1;
            //グラフィックとメッセージの決定
            if($angle > 5){
                $level = 'safe'; //画像のファイル名やクラス分けに使用
                $angle_msg = '車椅子にとって安全な高さです';
                $angle_explanatory = '天候に関わらず、危険な角度です。このプレートを車椅子ユーザーや重い荷物を積んだベビーカーが使用しようとした場合、転倒する恐れがあります。可能であれば、緩やかなプレートを設置する努力が必要です。';
            };
            ?>
            <div class="angle <?php echo $level;?>">
                <dl>
                    <?php displayNum('傾斜',$angle);?>
                </dl>
                <img src='"images/plates/plate_"+$level+".svg"' alt="<?php echo $angle_msg;?>">
                <p class="explanatory">
                    <?php echo $angle_explanatory;?>
                </p>
                
                <p class="note">
                    値段など詳細は、購入ページにアクセスして確認してください。
                </p>
            </div>
        <?php endwhile;
        endif;?>
        </article>
    </main>

<?php get_footer();?>