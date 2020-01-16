<section class="info card"
:style='{ backgroundColor : S.timeline[S.timeline_cnt].info_box.bg_color }'
v-show='S.show_ui == "info"'>
    <p class="phase">
        <span class="now">{{ S.timeline_cnt+1 }}</span>
        <span class="total">{{ S.timeline.length }}</span>
    </p>
    <video id='info_video'
    src='assets/info.mp4?ver=2'
    @timeupdate='video_cnt'
    muted loop preload='metadata' playsinline></video>
    <div>
        <p
        class="msgs"
        :style='{ textAlign : S.timeline[S.timeline_cnt].info_box.msgs[S.info_box_msgs_cnt].align }'
        v-html='S.timeline[S.timeline_cnt].info_box.msgs[S.info_box_msgs_cnt].text'></p>
        <button
        v-if='S.timeline[S.timeline_cnt].ar_ui != null && S.timeline_cnt != 9'
        @click='[
        S.show_ui = "ar"
        ]'
        >{{ S.timeline[S.timeline_cnt].info_box.btn }}</button>
        <button
        v-if='S.timeline[S.timeline_cnt].ar_ui == null && S.timeline_cnt != 9'
        @click='[
            S.timeline_cnt++
        ]'
        >{{ S.timeline[S.timeline_cnt].info_box.btn }}</button>
        <a
        v-if='S.timeline_cnt == 9'
        :href='set_query()'
        >{{ S.timeline[S.timeline_cnt].info_box.btn }}</a>
    </div>
</section>