const ar_app = new Vue({
    el:'#ar_app',
    data:{
        //ベースとなる入力値
        B:{
            pin_a_pos:{
                x:-10,
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
                show:true,
                pos:{x:0,y:0,z:0},
                rote:{h:0,p:0,b:0}
            },
            height_surface:{
                show:true
            },
            depth_offset_line:{
                show:true
            },
            min_depth_line:{
                show:true
            },
            max_depth_line:{
                show:true
            },
            min_depth_guide_surface:{
                show:true,
                pos:{x:0,y:0,z:0},
                rote:{h:0,p:0,b:0},
                height:30
            },
            max_depth_guide_surface:{
                show:true,
                pos:{x:0,y:0,z:0},
                rote:{h:0,p:0,b:0},
                height:30
            }
        }
    },
    //各パーツの初期化を行う
    mounted:function(){
        this.get_width_length;
        this.get_width_line_pos;
        this.get_width_line_rote;
        this.get_min_depth_guide_surface_paras;
        this.get_max_depth_guide_surface_paras;
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
        },
        //最短斜辺面の位置、角度、大きさを決める
        get_min_depth_guide_surface_paras:function(){
            //変数格納
            const min_max_depth = this.B.min_depth;
            const height = this.B.height;
            const depth_offset = this.B.height_offset;

            //設置位置を求める
            const setY = height / 2;
            const Z_chuten = ((min_max_depth + Math.sqrt(depth_offset**2)) / 2);
            const setZ = Z_chuten + depth_offset;
            
            //角度を求める
            const setH = (Math.atan(Z_chuten / setY)*(180 / Math.PI))*-1;

            //長さを求める
            const length = Math.sqrt(height**2 + (Z_chuten*2)**2);

            //セットする
            this.P.min_depth_guide_surface.pos.y = setY;
            this.P.min_depth_guide_surface.pos.z = setZ;
            this.P.min_depth_guide_surface.rote.h = setH;
            this.P.min_depth_guide_surface.height = length;
        },
        //最長斜辺面の位置、角度、大きさを決める
        get_max_depth_guide_surface_paras:function(){
            //変数格納
            const min_max_depth = this.B.max_depth;
            const height = this.B.height;
            const depth_offset = this.B.height_offset;

            //設置位置を求める
            const setY = height / 2;
            const Z_chuten = ((min_max_depth + Math.sqrt(depth_offset**2)) / 2);
            const setZ = Z_chuten + depth_offset;
            
            //角度を求める
            const setH = (Math.atan(Z_chuten / setY)*(180 / Math.PI))*-1;

            //長さを求める
            const length = Math.sqrt(height**2 + (Z_chuten*2)**2);

            //セットする
            this.P.max_depth_guide_surface.pos.y = setY;
            this.P.max_depth_guide_surface.pos.z = setZ;
            this.P.max_depth_guide_surface.rote.h = setH;
            this.P.max_depth_guide_surface.height = length;
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