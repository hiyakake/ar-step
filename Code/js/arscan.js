const ar_app = new Vue({
    el:'#ar_app',
    data:{
        //ベースとなる入力値
        B:{
            senen:{
                senens_scanned_size_at_3d_world:23.456, //千円を計測した時の3D空間上での大きさ
                first_point:{x:0,y:0,z:0},
                last_point:{x:0,y:0,z:0}
            },
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
        },
        //画面遷移の管理
        S:{
            info_box_msgs_cnt:0,
            show_ui:'ar',
            timeline_cnt:3, //全体の進捗を管理
            timeline:[
                //ようこそ画面
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
                                text:'段差の寸法を計測して、良いプレートを探しましょう'
                            }
                        ],
                        btn:'はじめる',
                        bg_color:'#F3F3F3'
                    },
                    //ARのUI表示を設定
                    ar_ui:{
                        guide_msg:[]
                    },
                    //OK BOXの設定
                    ok_box:{
                        icon_msg:'',
                        text_msg:{
                            align:'',
                            text:''
                        },
                        btn:''
                    }
                },
                //千円計測フェーズ
                {
                    //説明ボックス
                    info_box:{
                        video:{
                            start:34,
                            end:72
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
                            '千円の左上からピン',
                            '次に千円の右上にピン'
                        ]
                    },
                    //OK BOXの設定
                    ok_box:{
                        icon_msg:'OK',
                        text_msg:{
                            align:'center',
                            text:'すばらしい!<br>この要領で進めましょう'
                        },
                        btn:'NEXT'
                    }
                },
                //横幅計測フェーズ
                {
                    //説明ボックス
                    info_box:{
                        video:{
                            start:72,
                            end:102
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
                            '左手前の角にピン',
                            '次に右手前の角にピン'
                        ]
                    },
                    //OK BOXの設定
                    ok_box:{
                        icon_msg:'OK',
                        text_msg:{
                            align:'center',
                            text:'いいですね！<br>その調子で進めましょう'
                        },
                        btn:'NEXT'
                    }
                },
                //高さ計測フェーズ
                {
                    //説明ボックス
                    info_box:{
                        video:{
                            start:102,
                            end:140
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
                    },
                    //OK BOXの設定
                    ok_box:{
                        icon_msg:'OK',
                        text_msg:{
                            align:'justify',
                            text:'いいですね！段差の高さがわかりましたよ！'
                        },
                        btn:'NEXT'
                    }
                },
                //奥行きオフセット計測フェーズ
                {
                    //説明ボックス
                    info_box:{
                        video:{
                            start:140,
                            end:178
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
                    },
                    //OK BOXの設定
                    ok_box:{
                        icon_msg:'OK',
                        text_msg:{
                            align:'justify',
                            text:'この段差の奥行きがわかってきましたよ！'
                        },
                        btn:'NEXT'
                    }
                },
                //最短奥行き計測フェーズ
                {
                    //説明ボックス
                    info_box:{
                        video:{
                            start:140,
                            end:178
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
                    },
                    //OK BOXの設定
                    ok_box:{
                        icon_msg:'OK',
                        text_msg:{
                            align:'center',
                            text:'いいですね！'
                        },
                        btn:'NEXT'
                    }
                },
                //最長奥行き計測フェーズ
                {
                    //説明ボックス
                    info_box:{
                        video:{
                            start:140,
                            end:178
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
                    },
                    //OK BOXの設定
                    ok_box:{
                        icon_msg:'OK',
                        text_msg:{
                            align:'center',
                            text:'段差の寸法が<br>よくわかりました！'
                        },
                        btn:'NEXT'
                    }
                },
                //プレビュー計測フェーズ
                {
                    //説明ボックス
                    info_box:{
                        video:{
                            start:140,
                            end:178
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
                        guide_msg:[]
                    },
                    //OK BOXの設定
                    ok_box:{
                        icon_msg:'Complete!',
                        text_msg:{
                            align:'justify',
                            text:'次のページで、あなたの設置場所にぴったりなプレートをご覧いただけます。'
                        },
                        btn:'見に行く'
                    }
                }
            ]
        }
    },
    //各パーツの初期化を行う
    mounted:function(){
        this.get_width_length;
        this.get_width_line_pos;
        this.get_width_line_rote;
        this.get_min_depth_guide_surface_paras;
        this.get_max_depth_guide_surface_paras;

        this.set_display_text_in_order;
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
        //数値を千円札を基準に実寸に直す
        covert_to_actual_size:function(target){
            /*
            千円札をスキャンした時の3D空間上のサイズ = SS(senens_scanned_size_at_3d_world)
            千円札の実際の大きさ（15cm） = 15
            対象物の3D上のサイズ = VS(target)
            現実世界でのサイズ = RS(Anser)

            「SS:15 = VS:RS」の比率関係を利用
            */
            return (15 * target) / this.B.senen.senens_scanned_size_at_3d_world;
        },
        //再生範囲をセット
        set_info_video:function(start,end){
            return `images/arscan/info.mp4#t=${start},${end}`;
        },
        //テキストを順に表示していく
        set_display_text_in_order:function(){
            //infobox内
            debugger;
            const length = this.S.timeline[this.S.timeline_cnt].info_box.msgs.length;
            const change = function(){
                if(length <= this.S.timeline_cnt) this.S.timeline_cnt = 0;
                else this.S.timeline_cnt++;
            }
            window.setInterval(change,2000);
        }
    }
});