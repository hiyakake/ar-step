<?php
/*
Template Name:AR SCAN
*/
get_header();
?>
<main id="ar_app">
    <div class="ui_2d">
    
    </div>
    <div id="stage">
        <a-scene> 
            <!--Tool Base-->
            <a-entity
            id='width_line'
            :geometry='set_box_geometry(B.width,0.5,0.5)'
            :position='set_position(P.width_line.pos.x,P.width_line.pos.y,P.width_line.pos.z)'
            :rotation='set_rotation(0,P.width_line.rote.p,0)'
            material='color: blue;'>
                <!--高さ-->
                <a-entity
                id='height_surface'
                :geometry='set_plane_geometry(B.width,40)'
                :position='set_position(0,B.height,0)'
                :rotation='set_rotation(90,0,0)'
                material='
                side: double;
                color: red'>
                    <a-entity
                    id='depth_offset_line'
                    :geometry='set_box_geometry(B.width,0.5,0.5)'
                    :position='set_position(0,B.height_offset,0)'
                    :rotation='set_rotation(0,0,0)'
                    material='color: blue'></a-entity>
                </a-entity>
                <!--最短底辺-->
                <a-entity
                id='min_depth_line'
                :geometry='set_box_geometry(B.width,0.5,0.5)'
                :position='set_position(0,0,B.min_depth)'
                :rotation='set_rotation(0,0,0)'
                material='color: yellow'></a-entity>
                <a-entity
                id='min_depth_guide_surface'
                :geometry='set_plane_geometry(B.width,P.min_depth_guide_surface.height)'
                :position='set_position(0,P.min_depth_guide_surface.pos.y,P.min_depth_guide_surface.pos.z)'
                :rotation='set_rotation(P.min_depth_guide_surface.rote.h,0,0)'
                material='
                side: double;
                color: gray'></a-entity>
                <!--最長底辺-->
                <a-entity
                id='max_depth_line'
                :geometry='set_box_geometry(B.width,0.5,0.5)'
                :position='set_position(0,0,B.max_depth)'
                :rotation='set_rotation(0,0,0)'
                material='color: green'></a-entity>
                <a-entity
                id='max_depth_guide_surface'
                :geometry='set_plane_geometry(B.width,P.max_depth_guide_surface.height)'
                :position='set_position(0,P.max_depth_guide_surface.pos.y,P.max_depth_guide_surface.pos.z)'
                :rotation='set_rotation(P.max_depth_guide_surface.rote.h,0,0)'
                material='
                side: double;
                color: gray'></a-entity>
            </a-entity>
    
            
            <a-camera
            position='0 100 50'
            rotation='-30 0 0'></a-camera>
        </a-scene>
    </div>
</main>






<?php wp_footer();?>
</body>
</html>