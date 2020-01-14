const from_google_msg = new Vue({
    el:'.from_google_msg',
    data:{
        view:true
    }
});

const toste = new Vue({
    el:'.actionBtns',
    data:{
        toste:false
    },
    watch:{
        toste:function(){
            setTimeout(() => {
                this.toste = false;
            }, 5000);
        }
    }
})