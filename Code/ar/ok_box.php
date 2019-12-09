<section class="ok card"
v-if='S.show_ok'>
    <p class="phase">
        <span class="now">{{ S.timeline_cnt+1 }}</span>
        <span class="total">{{ S.timeline.length }}</span>
    </p>
    <img
    src="images/arscan/ok.svg"
    :alt="S.timeline[S.timeline_cnt].ok_box.icon_msg">
    <p class="icon_msg">{{ S.timeline[S.timeline_cnt].ok_box.icon_msg }}</p>
    <p class="msg"
    :style='{ textAlign : S.timeline[S.timeline_cnt].ok_box.text_msg.align }'
    v-html='S.timeline[S.timeline_cnt].ok_box.text_msg.text'></p>
    <button>{{ S.timeline[S.timeline_cnt].ok_box.btn }}</button>
</section>