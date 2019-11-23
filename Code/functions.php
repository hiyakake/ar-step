<?php

function add_files(){
    //現在のページのスラッグを取得
    $page = get_post( get_the_ID() ); 
    $slug = $page->post_name; 

    //グローバルに読み込むもの
    wp_enqueue_style(
        'global-style',
        get_template_directory_uri().'/style/global.min.css',
        ['reset-style'],
        date('U')
    );
    wp_enqueue_style(
        'reset-style',
        get_template_directory_uri().'/style/reset.min.css',
        [],
        date('U')
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
};
add_action('wp_enqueue_scripts','add_files');