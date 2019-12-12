<?php

//HTML5を有効化
add_theme_support('html5');

function add_files(){
    //現在のページのスラッグを取得
    $page = get_post( get_the_ID() ); 
    $slug = $page->post_name; 

    //グローバルに読み込むもの
    wp_enqueue_style(
        'global-style',
        get_template_directory_uri().'/style/global.min.css',
        ['reset-style','google-fonts-style'],
        date('U')
    );
    wp_enqueue_style(
        'reset-style',
        get_template_directory_uri().'/style/reset.min.css',
        [],
        date('U')
    );
    wp_enqueue_style(
        'google-fonts-style',
        'https://fonts.googleapis.com/css?family=Noto+Sans+JP:400,500,700,900&display=swap&subset=japanese',
        []
    );
    wp_enqueue_script(
        'vue',
        'https://cdn.jsdelivr.net/npm/vue/dist/vue.js',
        [],
        false,
        true
    );
    //platesの場合に適用するもの
    if(get_post_type() == 'plates'){
        wp_enqueue_script(
            'plate-single-script',
            get_template_directory_uri().'/js/singel-plates.js',
            ['vue'],
            date('U'),
            true
        );
        wp_enqueue_style(
            'plate-single-style',
            get_template_directory_uri().'/style/single-plates.min.css',
            ['global-style'],
            date('U')
        );
    };
    //TOPページに適用するもの
    if($slug == 'home'){
        wp_enqueue_style(
            'home-style',
            get_template_directory_uri().'/style/home.min.css',
            ['global-style'],
            date('U')
        );
        wp_enqueue_script(
            'home-script',
            get_template_directory_uri().'/js/home.js',
            ['vue'],
            false,
            true
        );
    };
    //検索ページに適用するもの
    if($slug == 'search'){
        wp_enqueue_style(
            'search-style',
            get_template_directory_uri().'/style/page-search.min.css',
            ['global-style'],
            date('U')
        );
    };
    //AR SCANに適用するもの
    if($slug == 'ar'){
        wp_enqueue_style(
            'ar-style',
            get_template_directory_uri().'/style/page-arscan.min.css',
            ['global-style'],
            date('U')
        );
        wp_enqueue_script(
            'aframe',
            'https://cdn.8thwall.com/web/aframe/8frame-0.8.2.min.js',
            [],
            false,
            false
        );
        $_8th_wall_api_key = 'uDTf8XBaSUdFebkZ5EVegGhaxTHxDX4KcEzM4Z1fIUddUfwuE7JRHuVFgK3kvaDUmz8cTO';
        wp_enqueue_script(
            '_8th_wall',
            'https://apps.8thwall.com/xrweb?appKey='.$_8th_wall_api_key,
            [],
            false,
            false
        );
        wp_enqueue_script(
            'arscan_script',
            get_template_directory_uri().'/js/arscan.js',
            ['vue','aframe'],
            date('U'),
            true
        );
    }
};
add_action('wp_enqueue_scripts','add_files');

//asyncを追加
function addasync_enqueue_script( $tag, $handle ) {
    if ( '_8th_wall' !== $handle ) {
    return $tag;
    }
    return str_replace( ' src', ' async="async" src', $tag );
   }
   add_filter( 'script_loader_tag', 'addasync_enqueue_script', 10, 2);