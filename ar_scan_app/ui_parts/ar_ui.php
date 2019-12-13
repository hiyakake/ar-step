<div class="ar_ui"
v-if='S.show_ui == "ar"'>
    <button class="show_info_btn"
    @click='S.show_ui = "info"'>INFO</button>
    <button class="back_scene"
    @click='[
        S.timeline_cnt--,
        S.show_ui = "info"
    ]'>
        <img src="assets/back_scene.svg" alt="前に戻る">
        <p><!--前に戻る--></p>
    </button>
    <button class="diside"
    @click='S.show_ui = "ok"'>
        <img src="assets/diside.svg" alt="確定">
        <p><!--確定--></p>
    </button>

    <!--コントローラー-->
    <div class="controller_container">

        <p
        v-show='S.timeline[S.timeline_cnt].ar_ui.guide_msg.length != 0'
        class="guide_msg"><span>{{ S.timeline[S.timeline_cnt].ar_ui.guide_msg[S.ar_ui_guide_msg_cnt] }}</span></p>


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
            @mousedown='hold_up_down("height",1,"start")'
            @mouseleave='hold_up_down("height",1,"end")'
            @mouseup='hold_up_down("height",1,"end")'
            @touchstart='hold_up_down("height",1,"start")'
            @touchend='hold_up_down("height",1,"end")'
            @touchcancel='hold_up_down("height",1,"end")'
            ></button>
            <button class='minus'
            @mousedown='hold_up_down("height",0,"start")'
            @mouseleave='hold_up_down("height",0,"end")'
            @mouseup='hold_up_down("height",0,"end")'
            @touchstart='hold_up_down("height",0,"start")'
            @touchend='hold_up_down("height",0,"end")'
            @touchcancel='hold_up_down("height",0,"end")'
            ></button>
        </div>
        <!--高さオフセット-->
        <div class="volume"
        v-if='S.timeline_cnt == 4'>
        <button class='plus'
            @mousedown='hold_up_down("height_offset",0,"start")'
            @mouseleave='hold_up_down("height_offset",0,"end")'
            @mouseup='hold_up_down("height_offset",0,"end")'
            @touchstart='hold_up_down("height_offset",0,"start")'
            @touchend='hold_up_down("height_offset",0,"end")'
            @touchcancel='hold_up_down("height_offset",0,"end")'
            ></button>
            <button class='minus'
            @mousedown='hold_up_down("height_offset",1,"start")'
            @mouseleave='hold_up_down("height_offset",1,"end")'
            @mouseup='hold_up_down("height_offset",1,"end")'
            @touchstart='hold_up_down("height_offset",1,"start")'
            @touchend='hold_up_down("height_offset",1,"end")'
            @touchcancel='hold_up_down("height_offset",1,"end")'
            ></button>
        </div>
        <!--最短奥行き-->
        <div class="volume"
        v-if='S.timeline_cnt == 5'>
        <button class='plus'
            @mousedown='hold_up_down("min_depth",1,"start")'
            @mouseleave='hold_up_down("min_depth",1,"end")'
            @mouseup='hold_up_down("min_depth",1,"end")'
            @touchstart='hold_up_down("min_depth",1,"start")'
            @touchend='hold_up_down("min_depth",1,"end")'
            @touchcancel='hold_up_down("min_depth",1,"end")'
            ></button>
            <button class='minus'
            @mousedown='hold_up_down("min_depth",0,"start")'
            @mouseleave='hold_up_down("min_depth",0,"end")'
            @mouseup='hold_up_down("min_depth",0,"end")'
            @touchstart='hold_up_down("min_depth",0,"start")'
            @touchend='hold_up_down("min_depth",0,"end")'
            @touchcancel='hold_up_down("min_depth",0,"end")'
            ></button>
        </div>
        <!--最長奥行き-->
        <div class="volume"
        v-if='S.timeline_cnt == 6'>
            <button class='plus'
            @mousedown='hold_up_down("max_depth",1,"start")'
            @mouseleave='hold_up_down("max_depth",1,"end")'
            @mouseup='hold_up_down("max_depth",1,"end")'
            @touchstart='hold_up_down("max_depth",1,"start")'
            @touchend='hold_up_down("max_depth",1,"end")'
            @touchcancel='hold_up_down("max_depth",1,"end")'
            ></button>
            <button class='minus'
            @mousedown='hold_up_down("max_depth",0,"start")'
            @mouseleave='hold_up_down("max_depth",0,"end")'
            @mouseup='hold_up_down("max_depth",0,"end")'
            @touchstart='hold_up_down("max_depth",0,"start")'
            @touchend='hold_up_down("max_depth",0,"end")'
            @touchcancel='hold_up_down("max_depth",0,"end")'
            ></button>
        </div>
    </div>
</div>