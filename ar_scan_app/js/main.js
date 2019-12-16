//Vue.js
function run_vue(){
    const ar_app = new Vue({
        el:'#ar_app',
        data:{
            //ベースとなる入力値
            B:{
                senens_scanned_size_at_3d_world:23.456, //千円を計測した時の3D空間上での大きさ
                pins:[
                    //千円ピンA
                    {x:-4,y:0,z:100},
                    //千円ピンB
                    {x:5,y:0,z:100},
                    //横幅ピンA
                    {x:-4,y:0,z:100},
                    //横幅ピンB
                    {x:5,y:0,z:100}
                ],
                width:null,
                height:1,
                height_offset:-4,
                min_depth:4,
                max_depth:5
            },
            //各パーツの状態管理
            P:{
                senen_pin_a:{
                    opacity:1,
                    color:'yellow'
                },
                senen_pin_b:{
                    opacity:1,
                    color:'blue'
                },
                step_pin_a:{
                    opacity:1,
                    color:'red'
                },
                step_pin_b:{
                    opacity:1,
                    color:'green'
                },
                width_line:{
                    opacity:1,
                    color:'blue',
                    pos:{x:0,y:0,z:0},
                    rote:{h:0,p:0,b:0}
                },
                height_surface:{
                    opacity:0.5,
                    color:'red'
                },
                depth_offset_line:{
                    opacity:1,
                    color:'blue'
                },
                min_depth_line:{
                    opacity:1,
                    color:'yellow'
                },
                max_depth_line:{
                    opacity:1,
                    color:'green'
                },
                min_depth_guide_surface:{
                    opacity:0.5,
                    color:'green',
                    pos:{x:0,y:0,z:0},
                    rote:{h:0,p:0,b:0},
                    height:15
                },
                max_depth_guide_surface:{
                    opacity:0.5,
                    color:'blue',
                    pos:{x:0,y:0,z:0},
                    rote:{h:0,p:0,b:0},
                    height:17
                }
            },
            //画面遷移の管理
            S:{
                show_2d_ui:"block",
                info_box_msgs_cnt:0,
                ar_ui_guide_msg_cnt:0,
                show_ui:'info',
                contenu_interval:false,
                timeline_cnt:0, //全体の進捗を管理
                now_active_pin:0, //4種類のピンのうち現在はどれか
                timeline:[
                    //ようこそ画面
                    {
                        //説明ボックス
                        info_box:{
                            video:{
                                start:5,
                                end:5
                            },
                            msgs:[
                                {
                                    align:'justify',
                                    text:'段差の寸法を計測して、良いプレートを探しましょう'
                                }
                            ],
                            btn:'はじめる',
                            bg_color:'#F3F3F3'
                        },
                        //ARのUI表示を設定
                        ar_ui:null
                    },
                    //千円計測1
                    {
                        //説明ボックス
                        info_box:{
                            video:{
                                start:0,
                                end:3
                            },
                            msgs:[
                                {
                                    align:'justify',
                                    text:'まずはじめに、千円札の大きさを計測します。'
                                },
                                {
                                    align:'justify',
                                    text:'この作業は、ARアプリがカメラに映る段差が'
                                },
                                {
                                    align:'justify',
                                    text:'何cmなのかを正確に把握するために必要です。'
                                },
                                {
                                    align:'justify',
                                    text:'机の上に千円札を置き、上の辺をピンしましょう'
                                }
                            ],
                            btn:'OK',
                            bg_color:'#F3F3F3'
                        },
                        //ARのUI表示を設定
                        ar_ui:{
                            guide_msg:[
                                'お札を軽く手で抑えて',
                                '千円の左上からピン'
                            ]
                        }
                    },
                    //千円計測2
                    {
                        //説明ボックス
                        info_box:null,
                        //ARのUI表示を設定
                        ar_ui:{
                            guide_msg:[
                                '千円の右上にピン'
                            ]
                        }
                    },
                    //横幅計測1
                    {
                        //説明ボックス
                        info_box:{
                            video:{
                                start:3,
                                end:6
                            },
                            msgs:[
                                {
                                    align:'justify',
                                    text:'それでは、段差の横幅を計測していきます。'
                                },
                                {
                                    align:'justify',
                                    text:'千円札を計測したときと同じ要領で行いましょう。'
                                },
                                {
                                    align:'justify',
                                    text:'横幅は、すべての基準になりますのでご慎重に。'
                                },
                                {
                                    align:'justify',
                                    text:'図のように、段差の横幅の両端2点をピンしましょう'
                                }
                            ],
                            btn:'OK',
                            bg_color:'#F3F3F3'
                        },
                        //ARのUI表示を設定
                        ar_ui:{
                            guide_msg:[
                                '左手前の角にピン'
                            ]
                        }
                    },
                    //横幅計測2
                    {
                        //説明ボックス
                        info_box:null,
                        //ARのUI表示を設定
                        ar_ui:{
                            guide_msg:[
                                '次に右手前の角にピン'
                            ]
                        }
                    },
                    //高さ計測フェーズ
                    {
                        //説明ボックス
                        info_box:{
                            video:{
                                start:6,
                                end:10
                            },
                            msgs:[
                                {
                                    align:'justify',
                                    text:'段差の高さを調べます。<br>表示される縞模様の面を'
                                },
                                {
                                    align:'justify',
                                    text:'段差の最上面に合わせましょう。'
                                },
                                {
                                    align:'justify',
                                    text:'横から覗くようにするのがコツです。'
                                }
                            ],
                            btn:'OK',
                            bg_color:'#EDEBEA'
                        },
                        //ARのUI表示を設定
                        ar_ui:{
                            guide_msg:[
                                '段差の上に面を合わせる'
                            ]
                        }
                    },
                    //奥行きオフセット計測フェーズ
                    {
                        //説明ボックス
                        info_box:{
                            video:{
                                start:10,
                                end:11
                            },
                            msgs:[
                                {
                                    align:'justify',
                                    text:'次に、段差の奥行きを調べます。'
                                },
                                {
                                    align:'justify',
                                    text:'赤い線を、段差の一番上の面の角に合わせましょう'
                                }
                            ],
                            btn:'OK',
                            bg_color:'#E1DFE0'
                        },
                        //ARのUI表示を設定
                        ar_ui:{
                            guide_msg:[
                                '赤線を上の角に合わせる'
                            ]
                        }
                    },
                    //最短奥行き計測フェーズ
                    {
                        //説明ボックス
                        info_box:{
                            video:{
                                start:11,
                                end:12
                            },
                            msgs:[
                                {
                                    align:'justify',
                                    text:'どんな長さのプレートがいいか試し置きしてみましょう'
                                },
                                {
                                    align:'justify',
                                    text:'可能な範囲で横から面を覗いて、階段の角に面がぶつからないようにします'
                                }
                            ],
                            btn:'OK',
                            bg_color:'#F3F3F3'
                        },
                        //ARのUI表示を設定
                        ar_ui:{
                            guide_msg:[
                                '面が段差の角にぶつからない'
                            ]
                        }
                    },
                    //最長奥行き計測フェーズ
                    {
                        //説明ボックス
                        info_box:{
                            video:{
                                start:12,
                                end:13
                            },
                            msgs:[
                                {
                                    align:'justify',
                                    text:'できるだけプレートは緩やかにしたいものです。'
                                },
                                {
                                    align:'justify',
                                    text:'最も長くて、どこまでプレートを設置することができるか'
                                },
                                {
                                    align:'justify',
                                    text:'試し置きしながら、設定してください。'
                                }
                            ],
                            btn:'OK',
                            bg_color:'#E9E6E8'
                        },
                        //ARのUI表示を設定
                        ar_ui:{
                            guide_msg:[
                                'どこまで伸ばせますか？'
                            ]
                        }
                    },
                    //プレビュー計測フェーズ
                    {
                        //説明ボックス
                        info_box:{
                            video:{
                                start:13,
                                end:14
                            },
                            msgs:[
                                {
                                    align:'center',
                                    text:'お疲れさまです！<br>寸法がわかりましたよ！'
                                },
                                {
                                    align:'justify',
                                    text:'試し置きしながら、ズレがないか確認しましょう。'
                                },
                                {
                                    align:'center',
                                    text:'ズレがある場合は<br>もう一度やり直せます。'
                                }
                            ],
                            btn:'OK',
                            bg_color:'#E9E6E8'
                        },
                        //ARのUI表示を設定
                        ar_ui:{
                            guide_msg:null
                        }
                    }
                ]
            }
        },
        watch:{
            'B.pins':{
                handler:function(){
                    const   x1 = this.B.pins[2].x,
                            x2 = this.B.pins[3].x,
                            z1 = this.B.pins[2].z,
                            z2 = this.B.pins[3].z;
                    //２点のピンから横幅の長さを返す
                    this.B.width = Math.sqrt((x1-x2)**2+(z1-z2)**2);
                    //横幅線の位置を求める
                    this.P.width_line.pos.x = (x1+x2)/2;
                    this.P.width_line.pos.z = (z1+z2)/2;
                    //角度を求める
                    let angle = Math.atan2(x2 - x1,z2 - z1)*(180 / Math.PI);
                    //セット
                    this.P.width_line.rote.p = angle-90;


                    //千円の3D空間上での大きさをセット
                    this.senens_scanned_size_at_3d_world = Math.sqrt((this.B.pins[0].x-this.B.pins[1].x)**2+(this.B.pins[0].y-this.B.pins[1].y)**2+(this.B.pins[0].z-this.B.pins[1].z)**2);
                },
                deep: true
            },
            //Bの各値が許可された範囲内を動くように
            'B.height':function(val){
                if(val < 0) this.B.height = 0;
            },
            'B.height_offset':function(val){
                if(val > 0) this.B.height_offset = 0;
            },
            'B.min_depth':function(val){
                if(val < 0) this.B.min_depth = 0;
            },
            'B.max_depth':function(val){
                if(val < this.B.min_depth) this.B.max_depth = this.B.min_depth;
            },
            //timeline_cntによる画面遷移及び機能変更
            'S.timeline_cnt':function(val){
                //3Dオブジェクトの表示非表示
                const changeShowHide = (pin0,pin1,pin2,pin3,width_line,height_surface,depth_offset_line,min_depth_line,min_depth_guide_surface,max_depth_line,max_depth_guide_surface)=>{
                    const keyToOpacity = (key)=>{
                        if(key == 'H') return 0.0; //Hide
                        if(key == 'S') return 1.0; //Show
                        if(key == 'A') return 0.5; //Alpha
                    };
                    this.P.senen_pin_a.opacity = keyToOpacity(pin0);
                    this.P.senen_pin_b.opacity = keyToOpacity(pin1);
                    this.P.step_pin_a.opacity = keyToOpacity(pin2);
                    this.P.step_pin_b.opacity = keyToOpacity(pin3);
                    this.P.width_line.opacity = keyToOpacity(width_line);
                    this.P.height_surface.opacity = keyToOpacity(height_surface);
                    this.P.depth_offset_line.opacity = keyToOpacity(depth_offset_line);
                    this.P.min_depth_line.opacity = keyToOpacity(min_depth_line);
                    this.P.min_depth_guide_surface.opacity = keyToOpacity(min_depth_guide_surface);
                    this.P.max_depth_line.opacity = keyToOpacity(max_depth_line);
                    this.P.max_depth_guide_surface.opacity = keyToOpacity(max_depth_guide_surface);
                };
                //切り替え実行
                switch(val){
                    //ようこそ
                    case 0:
                        this.S.show_ui = 'info';
                        changeShowHide('H','H','H','H','H','H','H','H','H','H','H');
                    break;
                    //千円1
                    case 1:
                        this.S.show_ui = 'info';
                        this.S.now_active_pin = 0;
                        changeShowHide('S','H','H','H','H','H','H','H','H','H','H')
                    ;break;
                    //千円2
                    case 2:
                        this.S.show_ui = 'ar';
                        this.S.now_active_pin = 1;
                        changeShowHide('S','S','H','H','H','H','H','H','H','H','H');
                    break;
                    //横幅1
                    case 3:
                        this.S.show_ui = 'info';
                        this.S.now_active_pin = 2;
                        changeShowHide('H','H','S','H','S','H','H','H','H','H','H');
                    break;
                    //横幅2
                    case 4:
                        this.S.show_ui = 'ar';
                        this.S.now_active_pin = 3;
                        changeShowHide('H','H','S','S','S','H','H','H','H','H','H');
                    break;
                    //高さ計測
                    case 5:
                        this.S.show_ui = 'info';
                        changeShowHide('H','H','S','S','S','A','H','H','H','H','H');
                    break;
                    //高さオフセット
                    case 6:
                        this.S.show_ui = 'info';
                        changeShowHide('H','H','S','S','S','A','S','H','H','H','H');
                    break;
                    //最短奥行き
                    case 7:
                        this.S.show_ui = 'info';
                        changeShowHide('H','H','S','S','S','H','S','S','A','H','H');
                    break;
                    //最長奥行き
                    case 8:
                        this.S.show_ui = 'info';
                        changeShowHide('H','H','S','S','S','H','S','S','A','S','A');
                    break;
                    //プレビュー
                    case 9:
                        this.S.show_ui = 'info';
                        changeShowHide('H','H','S','S','S','A','S','S','A','S','A');
                    break;
                };
            }
        },
        //各パーツの初期化を行う
        mounted:function(){
            this.S.timeline_cnt = 0;

            this.get_min_depth_guide_surface_paras;
            this.get_max_depth_guide_surface_paras;


            //レイキャストの開始
            setTimeout(()=>{
                setInterval(()=>{
                    this.set_pin_by_camera_ray();
                },50);
            },6000);

            //テキストが2秒毎に丁寧丁寧丁寧に切り替わるように
            setInterval(()=>{
                //infobox内
                let length = this.S.timeline[this.S.timeline_cnt].info_box.msgs.length;
                //debugger;
                let current = this.S.info_box_msgs_cnt;
                if(current < length-1) this.S.info_box_msgs_cnt++;
                else this.S.info_box_msgs_cnt = 0;
                //ar_ui内
                length = this.S.timeline[this.S.timeline_cnt].ar_ui.guide_msg.length;
                current = this.S.ar_ui_guide_msg_cnt;
                if(current < length-1) this.S.ar_ui_guide_msg_cnt++;
                else this.S.ar_ui_guide_msg_cnt = 0;
            },2000);
        },
        //計算をしないと求めらない数値
        computed:{
            //最短斜辺面の位置、角度、大きさを決める
            get_min_depth_guide_surface_paras:function(){
                //console.log('計算しました');
                //変数格納
                const min_max_depth = this.B.min_depth;
                const height = this.B.height;
                const depth_offset = this.B.height_offset;
    
                //設置位置を求める
                const setY = height / 2;
                const Z_chuten = ((min_max_depth + Math.sqrt(depth_offset**2)) / 2);
                const setZ = Z_chuten + depth_offset;
                
                //角度を求める
                const setH = (Math.atan(Z_chuten / setY)*(180 / Math.PI))*-1+180;
    
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
                const setH = (Math.atan(Z_chuten / setY)*(180 / Math.PI))*-1+180;
    
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
            //A-Frameの形式にフォーマットして返す
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
            },
            set_material:function(color,opacity,blend = 'normal',side = 'double'){
                console.log(`color:${color};opacity:${opacity};side:${side};`);
                if(opacity == 0){
                    return `color:${color};opacity:${opacity};side:${side};blending:${blend};shader:flat`;
                }else{
                    return `color:${color};opacity:${opacity}:${side};blending:${blend};shader:flat`;
                }
                
            },
            //数値を千円札を基準に実寸に直す
            covert_to_actual_size:function(target){
                /*
                千円札をスキャンした時の3D空間上のサイズ = SS(senens_scanned_size_at_3d_world)
                千円札の実際の大きさ（15cm） = 15
                対象物の3D上のサイズ = VS(target)
                現実世界でのサイズ = RS(Anser)
    
                「SS:15 = VS:RS」の比率関係を利用
                */
                return (15 * target) / this.B.senens_scanned_size_at_3d_world;
            },
            //検索クエリにしてセット
            set_query:function(){
                const   height = Math.round(this.covert_to_actual_size(this.B.height),2),
                        width = Math.round(this.covert_to_actual_size(this.B.width),2),
                        min_depth = Math.round(this.covert_to_actual_size(this.B.min_depth),2),
                        max_depth = Math.round(this.covert_to_actual_size(this.B.max_depth),2);
                return `/search/?height=${height}&width=${width}&min_depth=${min_depth}&max_depth=${max_depth}&from=ar`;
                //TODO:四捨五入が正しくなるように、後で実装し直す。
            },
            //volumeControllerが押している間増減するように
            hold_up_down:function(target,vector,mode){
                /*
                vector 0 as Decrement
                vector 1 as Increment
                mode start is start hold function
                mode end is end hold function
                */
               //debugger;
               if(mode == 'start'){
                    if(!this.S.contenu_interval){
                        this.S.contenu_interval = setInterval(() => {
                            if(vector == 1) this.B[target]++;
                            else this.B[target]--;
                            this.get_min_depth_guide_surface_paras;
                            this.get_max_depth_guide_surface_paras;
                        }, 80);
                    }
               }else{
                    clearInterval(this.S.contenu_interval)
                    this.S.contenu_interval = false;
               }
               
            },
            //動画のコントロール
            video_cnt:function(event){
                const start = this.S.timeline[this.S.timeline_cnt].info_box.video.start;
                const end = this.S.timeline[this.S.timeline_cnt].info_box.video.end;
                if(!(start <= event.target.currentTime && event.target.currentTime <= end)){ 
                    event.target.currentTime = start;
                }
            },
            //ピンのraycast
            set_pin_by_camera_ray:function(){
                const ray_pos = window.XR8.XrController.hitTest.apply(window,[0.5,0.5,['FEATURE_POINT']])[0].position;
                this.B.pins[this.S.now_active_pin].x = ray_pos.x;
                this.B.pins[this.S.now_active_pin].y = ray_pos.y;
                this.B.pins[this.S.now_active_pin].z = ray_pos.z;
            }
        }
    });
    
    
};

window.addEventListener('load',(event)=>{
    //bodyの監視
    const target = document.body;
    let _8th_wall_is_show = false; //一度登場したらtrueに
    const observer = new MutationObserver(records => {
        console.log('実行');
        //要素が登場した
        if(_8th_wall_is_show == false && document.getElementById("loadingContainer") != null){
            _8th_wall_is_show = true;
            console.log('登場');
        }else{
            console.log('未登場');
        }
        //要素が消滅した
        if(_8th_wall_is_show == true && document.getElementById("loadingContainer") == null){
            console.log('消滅');
            observer.disconnect();//bodyの監視を終了
            run_vue(); //Vueを実行
        }else{
            console.log('登場中');
        }
    });
    observer.observe(target, {
        childList: true
    });
});

