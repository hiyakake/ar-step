<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>TEST2</title>

    <!-- We've included a slightly modified version of A-Frame, which fixes some polish concerns -->
    <script src="https://cdn.8thwall.com/web/aframe/8frame-0.8.2.min.js"></script>

    <!-- XR Extras - provides utilities like load screen, almost there, and error handling.
         See github.com/8thwall/web/xrextras -->
    <script defer src="https://cdn.8thwall.com/web/xrextras/xrextras.js"></script>

    <!-- 8thWall Web - Replace the app key here with your own app key -->
    <script async src="https://apps.8thwall.com/xrweb?appKey=uDTf8XBaSUdFebkZ5EVegGhaxTHxDX4KcEzM4Z1fIUddUfwuE7JRHuVFgK3kvaDUmz8cTO"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="arscan.js"></script>
    <link rel="stylesheet" href="page-arscan.min.css">
    <style>
      #ui_2d{
        z-index:100;
        position:fixed;
        width:100%;
        height:100%;
      }
    </style>
  </head>

  <body>
    <!-- We must add the tap-place component to the scene so it has an effect -->
    <a-scene id='ar_app'
      xrweb
      tap-place
      xrextras-almost-there
      xrextras-loading
      xrextras-runtime-error>
      <!--html elemnt-->
      <a-entity id='ui_2d' position='0 0 0'>
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
      </a-entity>

      <!--3Dアセット-->
      <a-assets>
          <a-asset-item id="pin-obj" src="ar/pin_model.obj"></a-asset-item>
      </a-assets>

      <!-- The raycaster will emit mouse events on scene objects specified with the cantap class -->
      <a-camera
        position="0 8 0"
        raycaster="objects: .cantap"
        cursor="
          fuse: false;
          rayOrigin: mouse;">
      </a-camera>
      <a-entity
        light="type: directional;
               intensity: 0.8;"
        position="1 4.3 2.5">
      </a-entity>
      <a-light type="ambient" intensity="1"></a-light>

      <!--ここから下がもともと作ってたやつ-->
      <a-entity
      id='step_pin_a'
      :position='set_position(B.pin_a_pos.x,B.pin_a_pos.y,B.pin_a_pos.z)'
      :rotation='set_rotation(0,P.camera_rig.rote.p,0)'
      scale='0.4 0.4 0.4'
      obj-model="obj: #pin-obj;"
      material='color:red;'></a-entity>
      <a-entity
      id='step_pin_b'
      :position='set_position(B.pin_b_pos.x,B.pin_b_pos.y,B.pin_b_pos.z)'
      :rotation='set_rotation(0,P.camera_rig.rote.p,0)'
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
    </a-scene>
  </body>
</html>