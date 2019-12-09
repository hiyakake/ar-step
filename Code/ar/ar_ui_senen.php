<div class="ar_ui">
    <button class="show_info_btn">？</button>
    <button class="back_scene">
        <img src="images/arscan/back_scene.svg" alt="前に戻る">
        <p>前に戻る</p>
    </button>
    <button class="diside"
    @click='S.show_ok = true'>
        <img src="images/arscan/diside.svg" alt="確定">
        <p>確定</p>
    </button>
    <div class="controller_container">
        <p class="guide_msg">切り替わるメッセージ</p>
        <div class="shutter">
            <button></button>
        </div>
        <div class="volume">
            <button>+</button>
            <button>-</button>
        </div>
    </div>
</div>