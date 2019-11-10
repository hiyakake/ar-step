<?php

function add_files(){
    wp_enqueue_style(
        'global-style',
        get_template_directory_uri().'/style/global.min.css',
        ['reset-style'],
        date('U')
    );
    wp_enqueue_style(
        'plate-single-style',
        get_template_directory_uri().'/style/single-plates.min.css',
        ['global-style'],
        date('U')
    );
    wp_enqueue_style(
        'reset-style',
        get_template_directory_uri().'/style/reset.min.css',
        [],
        date('U')
    );
};
add_action('wp_enqueue_scripts','add_files');