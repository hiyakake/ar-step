<?php
/*
Template Name:AR SCAN
*/
get_header();
?>
<div id="stage">
    <a-scene> 
        <!--Tool Base-->
        <a-entity
        id='width_line'
        geometry='
        primitive: box;
        width: 50;
        depth: 0.5;
        height: 0.5'
        position='0 0 0'
        rotation='0 0 0'
        material='color: blue;'>
            <!--高さ-->
            <a-entity
            id='height_surface'
            geometry='
            primitive: plane;
            width: 50;
            height: 40'
            position='0 10 0'
            rotation='90 0 0'
            material='
            side: double;
            color: red'>
                <a-entity
                id='depth_offset_line'
                geometry='
                primitive: box;
                width: 50;
                depth: 0.5;
                height: 0.5'
                position='0 -10 0'
                rotation='0 0 0'
                material='color: blue'></a-entity>
            </a-entity>
            <!--最短底辺-->
            <a-entity
            id='min_depth_line'
            geometry='
            primitive: box;
            width: 50;
            depth: 0.5;
            height: 0.5'
            position='0 0 30'
            rotation='0 0 0'
            material='color: yellow'></a-entity>
            <a-entity
            id='min_depth_guide_surface'
            geometry='
            primitive: plane;
            width: 50;
            height: 40'
            position='0 4.78 10.45'
            rotation='-77 0 0'
            material='
            side: double;
            color: gray'></a-entity>
            <!--最長底辺-->
            <a-entity
            id='max_depth_line'
            geometry='
            primitive: box;
            width: 50;
            depth: 0.5;
            height: 0.5'
            position='0 0 70'
            rotation='0 0 0'
            material='color: green'></a-entity>
            <a-entity
            id='max_depth_guide_surface'
            geometry='
            primitive: plane;
            width: 50;
            height: 82'
            position='0 5.246 28.96'
            rotation='-84 0 0'
            material='
            side: double;
            color: gray'></a-entity>
        </a-entity>

        
        <a-camera
        position='0 100 50'
        rotation='-30 0 0'></a-camera>
    </a-scene>
</div>






<?php wp_footer();?>
</body>
</html>