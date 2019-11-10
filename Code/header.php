<!DOCTYPE html>
<html <?php language_attributes();?>>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <?php wp_head();?>
    <base href="<?php echo get_template_directory_uri();?>/">
</head>
<body <?php body_class();?>>
    <?php wp_body_open();?>