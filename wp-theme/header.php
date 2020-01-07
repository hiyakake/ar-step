<!DOCTYPE html>
<html <?php language_attributes();?>>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="theme-color" content="#409FB5">
    <title>Document</title>
    <?php wp_head();?>
    <base href="<?php echo get_template_directory_uri();?>/">
    <script async src="https://cdn.ampproject.org/v0.js"></script>
    <script async custom-element="amp-fx-collection" src="https://cdn.ampproject.org/v0/amp-fx-collection-0.1.js"></script>

</head>
<body <?php body_class();?>>
    <?php wp_body_open();?>