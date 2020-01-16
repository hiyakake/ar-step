<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>MATCH STEP | ARで段差の寸法をかんたん計測・ピッタリ合うステップを提案</title>

    <script async src="js/main.js"></script>

    <!-- We've included a slightly modified version of A-Frame, which fixes some polish concerns -->
    <script src="https://cdn.8thwall.com/web/aframe/8frame-0.8.2.min.js"></script>

    <!-- XR Extras - provides utilities like load screen, almost there, and error handling.
         See github.com/8thwall/web/xrextras -->
    <script defer src="https://cdn.8thwall.com/web/xrextras/xrextras.js"></script>

    <!-- 8thWall Web - Replace the app key here with your own app key -->
    <script async src="https://apps.8thwall.com/xrweb?appKey=uDTf8XBaSUdFebkZ5EVegGhaxTHxDX4KcEzM4Z1fIUddUfwuE7JRHuVFgK3kvaDUmz8cTO"></script>
    
    <link rel="stylesheet" href="style/main.css">
    <meta name="theme-color" content="#409FB5">

    <script async src="https://cdn.jsdelivr.net/npm/vue/dist/vue.min.js"></script>
    
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Noto+Sans+JP:400,500,700,900&display=swap&subset=japanese">
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-153180197-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-153180197-1');
    </script>
  </head>

  <body>
    <a-scene id='ar_app'
      xrweb
      tap-place
      xrextras-almost-there
      xrextras-loading
      xrextras-runtime-error>
      <!--html elemnt-->
      <a-entity id='ui_2d'
      position='0 0 0'
      style='display:none;'
      :style='{ display : S.show_2d_ui }'>
        <!--box-->
        <div class="bg_gradient"
        :class='{ bg_gradient_active : S.show_ui != "ar" }'>
            <!--info box-->
            <?php include('ui_parts/info_box.php');?>
            <!--ok box-->
            <?php include('ui_parts/ok_box.php');?>
        </div>
        <!--ar_ui-->
        <?php include('ui_parts/ar_ui.php');?>
        <!--デバッグ表示-->
        <div class="debug_ui">
            <h2>Base</h2>
            <p>height: {{B.height}}</p>
            <p>width: {{B.width}}</p>
            <p>min_depth: {{B.min_depth}}</p>
            <p>max_depth: {{B.max_depth}}</p>
            <p>height_offset: {{B.height_offset}}</p>
            <h2>DEBUG</h2>
            <p>timeline_cnt:{{S.timeline_cnt}}</p>
            <p>now_active_pin:{{S.now_active_pin}}</p>
        </div>
      </a-entity>

      <!--3Dアセット-->
      <a-assets>
          <a-asset-item id="pin-obj" src="assets/pin_model.obj"></a-asset-item>
      </a-assets>

      <!-- The raycaster will emit mouse events on scene objects specified with the cantap class -->
      <a-camera
        position="0 8 0"
        camera look-controls wasd-controls raycaster>
      </a-camera>
      <!--ライト-->
      <a-entity
        light="type: directional;
               intensity: 0.8;"
        position="1 4.3 2.5">
      </a-entity>
      <a-light type="ambient" intensity="1"></a-light>

      <!--地面を制作-->
      <a-entity 
        id="ground"
        class="cantap"
        geometry="primitive: box; width: 1000; height: 0.2; depth: 1000"
        material="color: #ffffff; transparent: true; opacity: 0"
        position='0 0 0'>
      </a-entity>

      <!--プレビュー用-->
      <a-entity
      id='preview_pin'
      :position='set_position(P.preview_pin.pos.x,P.preview_pin.pos.y,P.preview_pin.pos.z)'
      :rotation='set_rotation(0,0,0)'
      scale='0.07 0.07 0.07'
      obj-model="obj: #pin-obj;"
      :material='set_material(P.preview_pin.color,P.preview_pin.opacity)'></a-entity>
      <!--千円ピン-->
      <a-entity
      id='senen_pin_a'
      :position='set_position(B.pins[0].x,B.pins[0].y,B.pins[0].z)'
      :rotation='set_rotation(0,0,0)'
      scale='0.07 0.07 0.07'
      obj-model="obj: #pin-obj;"
      :material='set_material(P.pins[0].color,P.pins[0].opacity)'>
        <a-entity
        text="value: A;"
        position='0 0 0'
        scale='0.5 0.5 0.5'
        align='center'
        color='white'></a-entity>
      </a-entity>
      <a-entity
      id='senen_pin_b'
      :position='set_position(B.pins[1].x,B.pins[1].y,B.pins[1].z)'
      :rotation='set_rotation(0,0,0)'
      scale='0.07 0.07 0.07'
      obj-model="obj: #pin-obj;"
      :material='set_material(P.pins[1].color,P.pins[1].opacity)'></a-entity>
      <!--横幅ピン-->
      <a-entity
      id='step_pin_a'
      :position='set_position(B.pins[2].x,B.pins[2].y,B.pins[2].z)'
      :rotation='set_rotation(0,0,0)'
      scale='0.07 0.07 0.07'
      obj-model="obj: #pin-obj;"
      :material='set_material(P.pins[2].color,P.pins[2].opacity)'></a-entity>
      <a-entity
      id='step_pin_b'
      :position='set_position(B.pins[3].x,B.pins[3].y,B.pins[3].z)'
      :rotation='set_rotation(0,0,0)'
      scale='0.07 0.07 0.07'
      obj-model="obj: #pin-obj;"
      :material='set_material(P.pins[3].color,P.pins[3].opacity)'></a-entity>
      <!--Tool Base-->
      <a-entity
      id='width_line'
      :geometry='set_box_geometry(B.width,0.05,0.05)'
      :position='set_position(P.width_line.pos.x,P.width_line.pos.y,P.width_line.pos.z)'
      :rotation='set_rotation(0,P.width_line.rote.p,0)'
      :material='set_material(P.width_line.color,P.width_line.opacity)'>
          <!--最短底辺-->
          <a-entity
          id='min_depth_line'
          :geometry='set_box_geometry(B.width,0.05,0.05)'
          :position='set_position(0,0,B.min_depth)'
          :rotation='set_rotation(0,0,0)'
          :material='set_material(P.min_depth_line.color,P.min_depth_line.opacity)'></a-entity>
          <a-entity
          id='min_depth_guide_surface'
          :geometry='set_plane_geometry(B.width,P.min_depth_guide_surface.height)'
          :position='set_position(0,P.min_depth_guide_surface.pos.y,P.min_depth_guide_surface.pos.z)'
          :rotation='set_rotation(P.min_depth_guide_surface.rote.h,0,0)'
          :material='set_material(P.min_depth_guide_surface.color,P.min_depth_guide_surface.opacity,"src:assets/solid_tex.png;repeat:100 100;")'></a-entity>
          <!--最長底辺-->
          <a-entity
          id='max_depth_line'
          :geometry='set_box_geometry(B.width,0.05,0.05)'
          :position='set_position(0,0,B.max_depth)'
          :rotation='set_rotation(0,0,0)'
          :material='set_material(P.max_depth_line.color,P.max_depth_line.opacity)'></a-entity>
          <a-entity
          id='max_depth_guide_surface'
          :geometry='set_plane_geometry(B.width,P.max_depth_guide_surface.height)'
          :position='set_position(0,P.max_depth_guide_surface.pos.y,P.max_depth_guide_surface.pos.z)'
          :rotation='set_rotation(P.max_depth_guide_surface.rote.h,0,0)'
          :material='set_material(P.max_depth_guide_surface.color,P.max_depth_guide_surface.opacity,"src:assets/solid_tex.png;repeat:100 100;")'></a-entity>
          <!--高さ-->
          <a-entity
          id='height_surface'
          :geometry='set_plane_geometry(B.width,40)'
          :position='set_position(0,B.height,0)'
          :rotation='set_rotation(90,0,0)'
          :material='set_material(P.height_surface.color,P.height_surface.opacity,"src:assets/solid_tex.png;repeat:100 100;")'>
              <a-entity
              id='depth_offset_line'
              :geometry='set_box_geometry(B.width,0.05,0.05)'
              :position='set_position(0,B.height_offset,0)'
              :rotation='set_rotation(0,0,0)'
              :material='set_material(P.depth_offset_line.color,P.depth_offset_line.opacity)'></a-entity>
          </a-entity>
      </a-entity>
      <a-entity
      id='senen_line'
      :geometry='set_box_geometry(B.senen_width,0.05,0.05)'
      :position='set_position(P.senen_line.pos.x,P.senen_line.pos.y,P.senen_line.pos.z)'
      :rotation='set_rotation(0,P.senen_line.rote.p,0)'
      :material='set_material(P.senen_line.color,P.senen_line.opacity)'></a-antity>
    </a-scene>
  </body>
</html>