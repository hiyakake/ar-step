<!DOCTYPE html>
<html <?php language_attributes();?>>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <?php wp_head();?>
</head>
<body <?php body_class();?>>
    <?php wp_body_open();?>

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