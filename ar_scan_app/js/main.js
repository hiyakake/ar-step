//Vue.js
function run_vue(){
    const ar_app = new Vue({
        el:'#ar_app',
        data:{
            //ベースとなる入力値
            B:{
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
                senen_width:null, //千円を計測した時の3D空間上での大きさ
                width:null,
                height:1,
                height_offset:-1,
                min_depth:2,
                max_depth:3
            },
            //各パーツの状態管理
            P:{
                preview_pin:{
                    opacity:1,
                    color:'gray',
                    pos:{
                        x:0,
                        y:0,
                        z:0
                    }
                },
                pins:[
                    {
                        opacity:1,
                        color:'yellow',
                        seted:false
                    },
                    {
                        opacity:1,
                        color:'blue',
                        seted:false
                    },
                    {
                        opacity:1,
                        color:'red',
                        seted:false
                    },
                    {
                        opacity:1,
                        color:'green',
                        seted:false
                    }
                ],
                senen_line:{
                    opacity:1,
                    color:'blue',
                    pos:{x:0,y:0,z:0},
                    rote:{h:0,p:0,b:0}
                },
                width_line:{
                    opacity:1,
                    color:'blue',
                    pos:{x:0,y:0,z:0},
                    rote:{h:0,p:0,b:0}
                },
                height_surface:{
                    opacity:0.5,
                    color:'#55bdb4'
                },
                depth_offset_line:{
                    opacity:1,
                    color:'red'
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
                                end:15
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
                                end:4.5
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
                            bg_color:'#FFFFFF'
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
                        info_box:{
                            video:{
                                start:0,
                                end:4.5
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
                            bg_color:'#FFFFFF'
                        },
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
                                start:5,
                                end:10
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
                            bg_color:'#e5e2e3'
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
                        info_box:{
                            video:{
                                start:5,
                                end:10
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
                            bg_color:'#e5e2e3'
                        },
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
                                start:10,
                                end:12
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
                            bg_color:'#e6e4e6'
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
                                start:12,
                                end:13
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
                                start:13,
                                end:16
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
                            bg_color:'#e6e4e6'
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
                                start:16,
                                end:18
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
                            bg_color:'#e3e2e3'
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
                                start:5,
                                end:20
                            },
                            msgs:[
                                {
                                    align:'center',
                                    text:'お疲れさまです！<br>寸法がわかりましたよ！'
                                },
                                {
                                    align:'justify',
                                    text:'次のページで、段差の寸法にあった'
                                },
                                {
                                    align:'justify',
                                    text:'プレートをご確認いただけます。'
                                }
                            ],
                            btn:'見に行く',
                            bg_color:'#e3e2e3'
                        },
                        //ARのUI表示を設定
                        ar_ui:null
                    }
                ]
            }
        },
        watch:{
            'B.pins':{
                handler:function(){
                    /*--横幅ピン--*/
                    let     x1 = this.B.pins[2].x,
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

                    /*--千円ピン--*/ 
                    x1 = this.B.pins[0].x;
                    x2 = this.B.pins[1].x;
                    z1 = this.B.pins[0].z;
                    z2 = this.B.pins[1].z;
                    //２点のピンから横幅の長さを返す
                    this.B.senen_width = Math.sqrt((x1-x2)**2+(z1-z2)**2);
                    //横幅線の位置を求める
                    this.P.senen_line.pos.x = (x1+x2)/2;
                    this.P.senen_line.pos.z = (z1+z2)/2;
                    //角度を求める
                    angle = Math.atan2(x2 - x1,z2 - z1)*(180 / Math.PI);
                    //セット
                    this.P.senen_line.rote.p = angle-90;
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
                this.get_depth_guide_surface_paras('min');
            },
            'B.max_depth':function(val){
                if(val < this.B.min_depth) this.B.max_depth = this.B.min_depth;
                this.get_depth_guide_surface_paras('max');
            },
            //display:none中にtimeupdateが発生してエラーが出てしまうのを防ぐために、ar表示中は再生を停止する
            'S.show_ui':function(val){
                if(val == 'ar') this.$el.querySelector('#info_video').pause();
                if(val == 'info') this.$el.querySelector('#info_video').play();
            },
            //timeline_cntによる画面遷移及び機能変更
            'S.timeline_cnt':function(val){
                //3Dオブジェクトの表示非表示
                const changeShowHide = (preview_pin,pin0,pin1,pin2,pin3,senen_line,width_line,height_surface,depth_offset_line,min_depth_line,min_depth_guide_surface,max_depth_line,max_depth_guide_surface)=>{
                    const keyToOpacity = (key)=>{
                        if(key == 'H') return 0.0; //Hide
                        if(key == 'S') return 1.0; //Show
                        if(key == 'A') return 0.5; //Alpha
                    };
                    this.P.preview_pin.opacity = keyToOpacity(preview_pin);
                    this.P.pins[0].opacity = keyToOpacity(pin0);
                    this.P.pins[1].opacity = keyToOpacity(pin1);
                    this.P.pins[2].opacity = keyToOpacity(pin2);
                    this.P.pins[3].opacity = keyToOpacity(pin3);
                    this.P.senen_line.opacity = keyToOpacity(senen_line);
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
                        changeShowHide('H','H','H','H','H','H','H','H','H','H','H','H','H');
                    break;
                    //千円1
                    case 1:
                        this.S.show_ui = 'info';
                        this.S.now_active_pin = 0;
                        changeShowHide('S','S','H','H','H','H','H','H','H','H','H','H','H')
                    ;break;
                    //千円2
                    case 2:
                        this.S.show_ui = 'ar';
                        this.S.now_active_pin = 1;
                        changeShowHide('S','S','S','H','H','S','H','H','H','H','H','H','H');
                    break;
                    //横幅1
                    case 3:
                        this.S.show_ui = 'info';
                        this.S.now_active_pin = 2;
                        changeShowHide('S','H','H','S','H','H','H','H','H','H','H','H','H');
                    break;
                    //横幅2
                    case 4:
                        this.S.show_ui = 'ar';
                        this.S.now_active_pin = 3;
                        changeShowHide('S','H','H','S','S','H','S','H','H','H','H','H','H');
                    break;
                    //高さ計測
                    case 5:
                        this.S.show_ui = 'info';
                        changeShowHide('H','H','H','S','S','H','S','A','H','H','H','H','H');
                    break;
                    //高さオフセット
                    case 6:
                        this.S.show_ui = 'info';
                        changeShowHide('H','H','H','S','S','H','S','A','S','H','H','H','H');
                    break;
                    //最短奥行き
                    case 7:
                        this.S.show_ui = 'info';
                        this.get_depth_guide_surface_paras('min');
                        changeShowHide('H','H','H','S','S','H','S','H','S','S','A','H','H');
                    break;
                    //最長奥行き
                    case 8:
                        this.S.show_ui = 'info';
                        this.get_depth_guide_surface_paras('max');
                        changeShowHide('H','H','H','S','S','H','S','H','S','S','A','S','A');
                    break;
                    //プレビュー
                    case 9:
                        this.S.show_ui = 'info';
                        this.set_query();
                        changeShowHide('H','H','H','S','S','H','S','A','S','S','A','S','A');
                    break;
                };
            }
        },
        mounted:function(){
            //各パーツの初期化を行う
            this.S.timeline_cnt = 0;

            //レイキャストのループ
            setTimeout(()=>{
                setInterval(()=>{
                    if(this.S.timeline_cnt < 5){
                        this.set_pin_by_camera_ray();
                    }else{
                        this.P.preview_pin.pos.y = 1000;
                    }
                },50);
            },6000);

            //テキストが2秒毎に丁寧丁寧丁寧に切り替わるように
            setInterval(()=>{
                let length = 0,current = 0;
                //infobox内
                if(this.S.timeline[this.S.timeline_cnt].info_box != null){
                    length = this.S.timeline[this.S.timeline_cnt].info_box.msgs.length;
                    current = this.S.info_box_msgs_cnt;
                    if(current < length-1) this.S.info_box_msgs_cnt++;
                    else this.S.info_box_msgs_cnt = 0;
                }
                //ar_ui内
                if(this.S.timeline[this.S.timeline_cnt].ar_ui != null){
                    length = this.S.timeline[this.S.timeline_cnt].ar_ui.guide_msg.length;
                    current = this.S.ar_ui_guide_msg_cnt;
                    if(current < length-1) this.S.ar_ui_guide_msg_cnt++;
                    else this.S.ar_ui_guide_msg_cnt = 0;
                }
            },2000);
        },
        //計算をしないと求めらない数値
        computed:{
            
        },
        //セットを行う
        methods:{
            //最短斜辺面の位置、角度、大きさを決める
            get_depth_guide_surface_paras:function(minmax){
                //変数格納
                const depth = this.B[minmax+'_depth'];
                const height = this.B.height;
                const depth_offset = this.B.height_offset;
    
                //設置位置を求める
                const setY = height / 2;
                const Z_chuten = ((depth + Math.sqrt(depth_offset**2)) / 2);
                const setZ = Z_chuten + depth_offset;
                
                //角度を求める
                const setH = (Math.atan(Z_chuten / setY)*(180 / Math.PI))*-1+180;
    
                //長さを求める
                const length = Math.sqrt(height**2 + (Z_chuten*2)**2);
    
                //セットする
                this.P[minmax+'_depth_guide_surface'].pos.y = setY;
                this.P[minmax+'_depth_guide_surface'].pos.z = setZ;
                this.P[minmax+'_depth_guide_surface'].rote.h = setH;
                this.P[minmax+'_depth_guide_surface'].height = length;
            },
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
                return `color:${color};opacity:${opacity};side:${side};blending:${blend}`;
            },
            //数値を千円札を基準に実寸に直す
            covert_to_actual_size:function(target){
                /*
                千円札をスキャンした時の3D空間上のサイズ(m) = SS(senen_width)
                千円札の実際の大きさ（15cm） = 15
                対象物の3D上のサイズ(m) = VS(target)
                現実世界でのサイズ(cm) = RS(Anser)
    
                「SS:15 = VS:RS」の比率関係を利用
                */
               //console.log(((15 * target*100) / (this.B.senen_width*100)));
                return ((15 * target*100) / (this.B.senen_width*100));
            },
            //検索クエリにしてセット
            set_query:function(){
                //四捨五入あり
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
                            if(vector == 1) this.B[target]+= 0.1;
                            else this.B[target]-= 0.1;
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
                //reyposの取得
                const ray_pos = window.XR8.XrController.hitTest.apply(window,[0.5,0.5,['FEATURE_POINT']])[0].position;
                const ray_rote = window.XR8.XrController.hitTest.apply(window,[0.5,0.5,['FEATURE_POINT']])[0].rotetion;
                //既にピンされているか
                if(this.P.pins[this.S.now_active_pin].seted  == false){//いいえ
                    //active_pinへセット
                    this.B.pins[this.S.now_active_pin].x = ray_pos.x;
                    this.B.pins[this.S.now_active_pin].y = ray_pos.y;
                    this.B.pins[this.S.now_active_pin].z = ray_pos.z;
                    //プレビューピンへセット
                    this.P.preview_pin.pos.x = 0;
                    this.P.preview_pin.pos.y = 1000;
                    this.P.preview_pin.pos.z = 0;
                }else{//はい
                    //再セットrequestを持っているか
                    if(this.P.pins[this.S.now_active_pin].seted == 'resetrequest'){//はい
                        //active_pinへの再セット
                        this.B.pins[this.S.now_active_pin].x = ray_pos.x;
                        this.B.pins[this.S.now_active_pin].y = ray_pos.y;
                        this.B.pins[this.S.now_active_pin].z = ray_pos.z;
                        this.P.pins[this.S.now_active_pin].seted = true;
                    }
                    //プレビューピンへセット
                    this.P.preview_pin.pos.x = ray_pos.x;
                    this.P.preview_pin.pos.y = ray_pos.y;
                    this.P.preview_pin.pos.z = ray_pos.z;
                }
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

