const ar_app = new Vue({
    el:'#ar_app',
    data:{
        //ベースとなる入力値
        B:{
            pin_a_pos:{
                x:-5,
                y:0,
                z:0
            },
            pin_b_pos:{
                x:5,
                y:0,
                z:0
            },
            width:null,
            height:20,
            height_offset:-10,
            min_depth:30,
            max_depth:50
        },
        //各パーツの状態管理
        P:{
            width_line:{
                pos:{x:0,y:0,z:0},
                rote:{h:0,p:0,b:0}
            }
        }
    },
    //各パーツの初期化を行う
    mounted:function(){

    },
    //計算をしないと求めらない数値
    computed:{
        //２点のピンから横幅の長さを返す
        get_width_length:function(){
            const   x1 = this.B.pin_a_pos.x,
                    x2 = this.B.pin_b_pos.x,
                    z1 = this.B.pin_a_pos.z,
                    z2 = this.B.pin_b_pos.z;
            this.B.width = Math.sqrt((x1-x2)**2+(z1-z2)**2);
        },
        //横幅線の位置を求める
        get_width_line_pos:function(){
            const   x1 = this.B.pin_a_pos.x,
                    x2 = this.B.pin_b_pos.x,
                    z1 = this.B.pin_a_pos.z,
                    z2 = this.B.pin_b_pos.z;
            this.P.width_line.pos.x = (x1+x2)/2;
            this.P.width_line.pos.z = (z1+z2)/2;
        },
        //横幅線の角度を決める
        get_width_line_rote:function(){
            const   a = this.P.width_line.pos.x,
                    b = this.P.width_line.pos.z;
            this.P.width_line.rote.p = (Math.atan(a/b)*(180 / Math.PI));
        }
    },
    //セットを行う
    methods:{
        set_box_geometry:function(width,depth,height){
            return `primitive: box;width: ${width};depth: ${depth};height: ${height}`;
        },
        set_plane_geometry:function(width,height){
            return `primitive: plane;width: ${width};height: ${height}`;
        },
        set_position:function(x,y,z){
            return `${x} ${y} ${z}`;
        },
        set_rotation:function(h,p,b){
            return `${h} ${p} ${b}`;
        }
    }
});