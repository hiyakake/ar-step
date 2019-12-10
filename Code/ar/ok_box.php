<section class="ok card"
v-if='S.show_ui == "ok"'>
    <p class="phase">
        <span class="now">{{ S.timeline_cnt+1 }}</span>
        <span class="total">{{ S.timeline.length }}</span>
    </p>
    <div class='icon'>
        <img
        src="images/arscan/ok.svg"
        :alt="S.timeline[S.timeline_cnt].ok_box.icon_msg">
        <p class="icon_msg">{{ S.timeline[S.timeline_cnt].ok_box.icon_msg }}</p>
    </div>
    <p class="msg"
    :style='{ textAlign : S.timeline[S.timeline_cnt].ok_box.text_msg.align }'
    v-html='S.timeline[S.timeline_cnt].ok_box.text_msg.text'></p>
    <button
    v-if='S.timeline_cnt != S.timeline.length-1'
    @click='[
        S.timeline_cnt++,
        S.show_ui = "info"
    ]'>{{ S.timeline[S.timeline_cnt].ok_box.btn }}</button>
    <a
    v-else
    :href="set_query()">{{ S.timeline[S.timeline_cnt].ok_box.btn }}</a>
</section>