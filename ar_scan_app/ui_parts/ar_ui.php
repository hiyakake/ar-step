<div class="ar_ui"
v-if='S.show_ui == "ar"'>
    <!--INFO再表示-->
    <button class="show_info_btn"
    @click='S.show_ui = "info"'>説明</button>
    <!--バックボタン-->
    <button class="back_scene"
    v-if='S.timeline_cnt != 0'
    @click='S.timeline_cnt--'>
        <img src="assets/back_scene.svg" alt="前に戻る">
        <p><!--前に戻る--></p>
    </button>
    <!--決定ボタン-->
    <button class="diside"
    :class='{ disable : P.pins[S.now_active_pin].seted == false }'
    @click='S.timeline_cnt++'>
        <img src="assets/diside.svg" alt="確定">
        <p><!--確定--></p>
    </button>

    <!--コントローラー-->
    <div class="controller_container">

        <p
        v-show='S.timeline[S.timeline_cnt].ar_ui.guide_msg != null'
        class="guide_msg"><span>{{ S.timeline[S.timeline_cnt].ar_ui.guide_msg[S.ar_ui_guide_msg_cnt] }}</span></p>


        <!--ピンシャッターボタン　未ピン-->
        <div class="shutter"
        v-if='S.timeline_cnt >= 1 && S.timeline_cnt <= 4 && P.pins[S.now_active_pin].seted == false'
        @click='[
            P.pins[S.now_active_pin].seted = true
        ]'>
            <button><span></span></button>
        </div>
        <!--ピンシャッターボタン　ピン済み上書き用-->
        <div class="shutter"
        v-if='S.timeline_cnt >= 1 && S.timeline_cnt <= 4 && P.pins[S.now_active_pin].seted == true'
        @click='[
            P.pins[S.now_active_pin].seted = "resetrequest"
        ]'>
            <button><span></span></button>
        </div>
        <!--高さ計測-->
        <div class="volume"
        v-if='S.timeline_cnt == 5'>
        <button class='plus'
            @click='B.height+=0.5'
            @mousedown='hold_up_down("height",1,"start")'
            @mouseleave='hold_up_down("height",1,"end")'
            @mouseup='hold_up_down("height",1,"end")'
            @touchstart='hold_up_down("height",1,"start")'
            @touchend='hold_up_down("height",1,"end")'
            @touchcancel='hold_up_down("height",1,"end")'
            ></button>
            <button class='minus'
            @click='B.height-=0.5'
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
        v-if='S.timeline_cnt == 6'>
        <button class='plus'
            @click='B.height_offset-=0.5'
            @mousedown='hold_up_down("height_offset",0,"start")'
            @mouseleave='hold_up_down("height_offset",0,"end")'
            @mouseup='hold_up_down("height_offset",0,"end")'
            @touchstart='hold_up_down("height_offset",0,"start")'
            @touchend='hold_up_down("height_offset",0,"end")'
            @touchcancel='hold_up_down("height_offset",0,"end")'
            ></button>
            <button class='minus'
            @click='B.height_offset+=0.5'
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
        v-if='S.timeline_cnt == 7'>
        <button class='plus'
            @click='B.min_depth+=0.5'
            @mousedown='hold_up_down("min_depth",1,"start")'
            @mouseleave='hold_up_down("min_depth",1,"end")'
            @mouseup='hold_up_down("min_depth",1,"end")'
            @touchstart='hold_up_down("min_depth",1,"start")'
            @touchend='hold_up_down("min_depth",1,"end")'
            @touchcancel='hold_up_down("min_depth",1,"end")'
            ></button>
            <button class='minus'
            @click='B.min_depth-=0.5'
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
        v-if='S.timeline_cnt == 8'>
            <button class='plus'
            @click='B.max_depth+=0.5'
            @mousedown='hold_up_down("max_depth",1,"start")'
            @mouseleave='hold_up_down("max_depth",1,"end")'
            @mouseup='hold_up_down("max_depth",1,"end")'
            @touchstart='hold_up_down("max_depth",1,"start")'
            @touchend='hold_up_down("max_depth",1,"end")'
            @touchcancel='hold_up_down("max_depth",1,"end")'
            ></button>
            <button class='minus'
            @click='B.max_depth-=0.5'
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