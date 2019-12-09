<div class="ar_ui"
v-if='S.show_ui == "ar"'>
    <button class="show_info_btn"
    @click='S.show_ui = "info"'>INFO</button>
    <button class="back_scene"
    @click='[
        S.timeline_cnt--,
        S.show_ui = "info"
    ]'>
        <img src="images/arscan/back_scene.svg" alt="前に戻る">
        <p>前に戻る</p>
    </button>
    <button class="diside"
    @click='S.show_ui = "ok"'>
        <img src="images/arscan/diside.svg" alt="確定">
        <p>確定</p>
    </button>

    <!--コントローラー-->
    <div class="controller_container">
        <p class="guide_msg"><span>{{ S.timeline[S.timeline_cnt].ar_ui.guide_msg[0] }}</span></p>
        <!--お札計測 1-->
        <div class="shutter"
        v-if='S.timeline_cnt == 1 && B.senen.first_point.x == 0'>
            <button><span></span></button>
        </div>
        <!--お札計測 2-->
        <div class="shutter"
        v-if='S.timeline_cnt == 1 && B.senen.last_point.x == 0'>
            <button><span></span></button>
        </div>
        <!--横幅計測 1-->
        <div class="shutter"
        v-if='S.timeline_cnt == 2 && B.pin_a_pos.y == 0'>
            <button><span></span></button>
        </div>
        <!--横幅計測 2-->
        <div class="shutter"
        v-if='S.timeline_cnt == 2 && B.pin_b_pos.y == 0'>
            <button><span></span></button>
        </div>
        <!--高さ計測-->
        <div class="volume"
        v-if='S.timeline_cnt == 3'>
            <button class='plus'
            @click='[
                B.height++,
                get_min_depth_guide_surface_paras,
                get_max_depth_guide_surface_paras
            ]'>+</button>
            <button class='minus'
            @click='[
                B.height--,
                get_min_depth_guide_surface_paras,
                get_max_depth_guide_surface_paras
            ]'>-</button>
        </div>
        <!--高さオフセット-->
        <div class="volume"
        v-if='S.timeline_cnt == 4'>
            <button class='plus'
            @click='[
                B.height_offset--,
                get_min_depth_guide_surface_paras,
                get_max_depth_guide_surface_paras
            ]'>+</button>
            <button class='minus'
            @click='[
                B.height_offset++,
                get_min_depth_guide_surface_paras,
                get_max_depth_guide_surface_paras
            ]'>-</button>
        </div>
        <!--最短奥行き-->
        <div class="volume"
        v-if='S.timeline_cnt == 5'>
            <button class='plus'
            @click='[
                B.min_depth++,
                get_min_depth_guide_surface_paras,
                get_max_depth_guide_surface_paras
            ]'>+</button>
            <button class='minus'
            @click='[
                B.min_depth--,
                get_min_depth_guide_surface_paras,
                get_max_depth_guide_surface_paras
            ]'>-</button>
        </div>
        <!--最長奥行き-->
        <div class="volume"
        v-if='S.timeline_cnt == 6'>
            <button class='plus'
            @click='[
                B.max_depth++,
                get_min_depth_guide_surface_paras,
                get_max_depth_guide_surface_paras
            ]'>+</button>
            <button class='minus'
            @click='[
                B.max_depth--,
                get_min_depth_guide_surface_paras,
                get_max_depth_guide_surface_paras
            ]'>-</button>
        </div>
    </div>
</div>