<div class="ar_ui"
v-if='S.show_ui == "ar"'>
    <button class="show_info_btn"
    @click='S.show_ui = "info"'>INFO</button>
    <button class="back_scene">
        <img src="images/arscan/back_scene.svg" alt="前に戻る">
        <p>前に戻る</p>
    </button>
    <button class="diside"
    @click='S.show_ui = "ok"'>
        <img src="images/arscan/diside.svg" alt="確定">
        <p>確定</p>
    </button>
    <div class="controller_container">
        <p class="guide_msg"><span>切り替わるメッセージ</span></p>
        <div class="shutter">
            <button><span></span></button>
        </div>
        <div class="volume">
            <button class='plus'
            @click='B.height = B.height + 1'>+</button>
            <button class='minus'
            @click='B.height = B.height - 1'>-</button>
        </div>
    </div>
</div>