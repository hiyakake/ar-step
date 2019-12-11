<?php
/*
Template Name:AR SCAN
*/
get_header();
?>
<main id="ar_app">
    <div id="ui_2d">
        <!--box-->
        <div class="bg_gradient"
        :class='{ bg_gradient_active : S.show_ui != "ar" }'>
            <!--info box-->
            <?php include('ar/info_box.php');?>
            <!--ok box-->
            <?php include('ar/ok_box.php');?>
        </div>
        <!--ar_ui-->
        <?php include('ar/ar_ui.php');?>
        <!--デバッグ表示-->
        <div class="debug_ui">
            <h2>Base</h2>
            <p>height: {{B.height}}</p>
            <p>width: {{B.width}}</p>
            <p>min_depth: {{B.min_depth}}</p>
            <p>max_depth: {{B.max_depth}}</p>
            <p>height_offset: {{B.height_offset}}</p>
            <h2>min_depth_surface</h2>
            <p>length: {{P.min_depth_guide_surface.height}}</p>
            <p>posY: {{P.min_depth_guide_surface.pos.y}}</p>
            <p>posZ: {{P.min_depth_guide_surface.pos.z}}</p>
            <p>roteH: {{P.min_depth_guide_surface.rote.h}}</p>
        </div>
    </div>
    <div id="stage">
        <!--3Dアセット-->
        <a-assets>
            <a-asset-item id="pin-obj" src="ar/pin_model.obj"></a-asset-item>
        </a-assets>
        <!--キャンバス-->
        <a-scene> 
            <!--Step Senen pointer-->
            <!--Step width pointer-->
            <a-entity
            id='step_pin_a'
            :position='set_position(B.pin_a_pos.x,B.pin_a_pos.y,B.pin_a_pos.z)'
            scale='0.4 0.4 0.4'
            obj-model="obj: #pin-obj;"
            material='color:red;'></a-entity>
            <a-entity
            id='step_pin_b'
            :position='set_position(B.pin_b_pos.x,B.pin_b_pos.y,B.pin_b_pos.z)'
            scale='0.4 0.4 0.4'
            obj-model="obj: #pin-obj;"
            material='color:green;'></a-entity>
            <!--Tool Base-->
            <a-entity
            id='width_line'
            :geometry='set_box_geometry(B.width,0.5,0.5)'
            :position='set_position(P.width_line.pos.x,P.width_line.pos.y,P.width_line.pos.z)'
            :rotation='set_rotation(0,P.width_line.rote.p,0)'
            :material='set_material(P.width_line.color,P.width_line.opacity)'>
                <!--高さ-->
                <a-entity
                id='height_surface'
                :geometry='set_plane_geometry(B.width,40)'
                :position='set_position(0,B.height,0)'
                :rotation='set_rotation(90,0,0)'
                :material='set_material(P.height_surface.color,P.height_surface.opacity)'>
                    <a-entity
                    id='depth_offset_line'
                    :geometry='set_box_geometry(B.width,0.5,0.5)'
                    :position='set_position(0,B.height_offset,0)'
                    :rotation='set_rotation(0,0,0)'
                    :material='set_material(P.depth_offset_line.color,P.depth_offset_line.opacity)'></a-entity>
                </a-entity>
                <!--最短底辺-->
                <a-entity
                id='min_depth_line'
                :geometry='set_box_geometry(B.width,0.5,0.5)'
                :position='set_position(0,0,B.min_depth)'
                :rotation='set_rotation(0,0,0)'
                :material='set_material(P.min_depth_line.color,P.min_depth_line.opacity)'></a-entity>
                <a-entity
                id='min_depth_guide_surface'
                :geometry='set_plane_geometry(B.width,P.min_depth_guide_surface.height)'
                :position='set_position(0,P.min_depth_guide_surface.pos.y,P.min_depth_guide_surface.pos.z)'
                :rotation='set_rotation(P.min_depth_guide_surface.rote.h,0,0)'
                :material='set_material(P.min_depth_guide_surface.color,P.min_depth_guide_surface.opacity)'></a-entity>
                <!--最長底辺-->
                <a-entity
                id='max_depth_line'
                :geometry='set_box_geometry(B.width,0.5,0.5)'
                :position='set_position(0,0,B.max_depth)'
                :rotation='set_rotation(0,0,0)'
                :material='set_material(P.max_depth_line.color,P.max_depth_line.opacity)'></a-entity>
                <a-entity
                id='max_depth_guide_surface'
                :geometry='set_plane_geometry(B.width,P.max_depth_guide_surface.height)'
                :position='set_position(0,P.max_depth_guide_surface.pos.y,P.max_depth_guide_surface.pos.z)'
                :rotation='set_rotation(P.max_depth_guide_surface.rote.h,0,0)'
                :material='set_material(P.max_depth_guide_surface.color,P.max_depth_guide_surface.opacity)'></a-entity>
            </a-entity>
    
            
            <a-camera
            position='0 30 100'
            rotation='0 30 0'></a-camera>
        </a-scene>
    </div>
</main>
<?php wp_footer();?>
</body>
</html>