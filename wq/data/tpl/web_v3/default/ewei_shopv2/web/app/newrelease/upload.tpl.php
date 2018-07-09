<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>

<link href="../addons/ewei_shopv2/plugin/app/static/css/page.css?v=20170922" rel="stylesheet" type="text/css"/>

<style type="text/css">
    .jconfirm.jconfirm-white .jconfirm-box .buttons button {font-size: 12px; font-weight: normal;}
    .page-content.step ul{
        height: 160px;
        padding: 46px 60px 50px;
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        -webkit-justify-content: space-between;
        justify-content: space-between;
    }

    .page-content.step ul li.step-1,.page-content.step ul li.step-2{
         text-align: center;
         -webkit-box-flex: 1;
         -webkit-flex: 1;
         -ms-flex: 1;
         flex: 1;
         position: relative;
        text-align: left;
     }
    .page-content.step ul li.step-3{
        width:300px;
    }
    .page-content.step ul li.step-3 :after{
        display: none;
    }
    .item-step .line{
        display: inline-block;
        width: 271px;
        background: #fff;
        z-index: 88;
        position: relative;
        text-align: left;
    }
    .page-content.step ul li:after{
        content: "";
        position: absolute;
        border-top: 2px solid #f3f3f3;
        top: 22px;
        left: 200px;
       right:50px;
        z-index: 2;
    }
    .page-content.step ul li:last-child:after{
        display: none;
    }
    .page-content.step ul li.active:after{
        content: "";
        position: absolute;
        border-top: 2px solid #44abf7;
        top: 22px;
        left: 200px;
        right:50px;
        z-index: 2;
    }
    .page-content.step ul li:last-child{
        text-align: left;
        width: 210px;
    }
    .item-step .title{
        font-size: 14px;
        color: #333;
        margin-top: 7px;
    }
    .item-step .explain {
        padding-left: 46px;
        font-size: 12px;
        color: #999;
    }
    .item-step.active .title .spans{
        display:inline-block;
    }
    .item-step .title .spans{
        display: none;
        background:#44abf7;
        color: #fff;
    }
    .item-step.active .title .num{
        display: none;
    }
    .item-step .title span{
        display: inline-block;
        width: 27px;
        height: 27px;
        border: 1px solid #e5e5e5;
        color: #999;
        font-size: 14px;
        text-align: center;
        line-height: 26px;
        border-radius: 50%;
        margin-right: 14px;
    }
    .item-step .title span.active{
        background: #44abf7;
        border: 1px solid #44abf7;
        color: #fff;
    }

    /*第一步*/
    .step-three{
        display: none;
    }
    .page-content.step-one{
        height: 446px;
        text-align: center;
        font-size: 14px;
        color: #000;
    }
    .code-img{
        width: 150px;
        height: 150px;
        margin-top: 57px;
        margin-bottom: 50px;
    }

    /*第二步*/
    .step-one{
        display: block;
    }
    .page-content.step-two .inner{
        width: 574px;
        margin: 0 auto;
    }
    .page-content.step-two .inner .title{
        width: 572px;
        font-size: 14px;
        color: #999;
        text-align: left;
        line-height: 48px;
        padding-left: 3px;
    }
    .page-content.step-two .inner .content .import{
        width: 572px;
        border: 1px solid #efefef;
        padding: 5px 10px;
        font-size: 12px;
        color: #000;
     }
    .page-content.step-two .inner .content input.import{
        height: 30px;
    }
    .page-content.step-two .inner .content textarea.import{
        height: 158px;
        color: #000;
    }
    .page-content.step-two .inner .content textarea.import:focus{
        color: #000;
    }
    .page-content.step-two.step-two-b{
        display: none;
        text-align: center;
        padding-top: 70px;
        color: #000;
    }
    .step-two-b .progressbar{
        width: 350px;
        position: relative;
        border-top: 1px solid #f0f0f0;
        display: inline-block;
        margin-top: 50px;
    }
    .step-two-b .progressbar .line{
        width: 0%;
        height: 7px;
        background: #ffc730;
        border-radius: 4px;
        position: relative;
        left: 0;
        top: -4px;
        z-index: 9;
        transition: width 1s linear;
    }
    .step-two-b .progressbar .line.finish{
        width: 100%;
    }

    /*第三步*/
    .step-two{
        display: none;
    }
    .page-content.step-three{
        text-align: center;
        padding: 90px 0 112px;
    }
    .step-three .hint{
        font-size: 14px;
        color: #000;
        margin-top: 36px;
    }
    .step-three .reminder{
        color: #ffc730;
        font-size: 14px;
        margin-top: 16px;
        margin-bottom: 26px;
    }
    .uploadsuccess{
        width: 100px;
        height: 100px;
        background: #f7f8fa;
        border-radius: 50%;
        display: inline-block;
        position: relative;
    }
    .uploadsuccess .check{
        width:100px;
        height:50px;
        position:absolute;
        left:50%;
        top:50%;
        margin:-30px 0 0 -48px;
        -webkit-transform:rotate(-45deg);
        transform:rotate(-45deg) scale(0.5);
        overflow:hidden;
    }
    .uploadsuccess .check:before,.uploadsuccess .check:after{
        content:"";
        position:absolute;
        background:#02c12c;
        border-radius:8px
    }
    .uploadsuccess .check:before{
        width:16px;
        height:50px;
        left:0;
        -webkit-animation:dgLeft 0.2s linear 1s 1 both;
        animation:dgLeft 0.2s linear 1s 1 both
    }
    .uploadsuccess .check:after{
        width:100px;
        height:16px;
        bottom:0;
        -webkit-animation:dgRight 0.2s linear 1.2s 1 both;
        animation:dgRight 0.2s linear 1.2s 1 both
    }
    @-webkit-keyframes dgLeft{0%{top:-100%}100%{top:0%}}
    @-webkit-keyframes dgLeft{0%{top:-100%}100%{top:0%}}
    @-webkit-keyframes dgRight{0%{left:-100%}100%{left:0%}}
    @-webkit-keyframes dgRight{0%{left:-100%}100%{left:0%}}
</style>

<div class="page-header">
    当前位置：
    <span class="text-primary">发布与审核</span>
</div>
<div class="page-content step">
    <ul>
        <li class="item-step step-1">
            <div class="title">
                <span class="num active">1</span>
                <span class="spans "></span>
                扫码上传
            </div>
            <div class="explain">
                扫描二维码登录小程序后台
            </div>
        </li>
        <li class="item-step step-2 ">
            <div class="title">
                <span class=" num">2</span>
                <span class="spans "></span>
                填写版本信息
            </div>
            <div class="explain">
                填写小程序版本信息，上传代码
            </div>
        </li>
        <li class="item-step step-3">
            <div class="title">
                <span class="num">3</span>
                <span class="spans "></span>
                提交微信审核
            </div>
            <div class="explain">
                跳转微信页面提交审核
            </div>
        </li>
    </ul>
</div>

<!--第一步-->
<div class="page-content code step-one" style="margin-top: 20px;">
    <img class="code-img" src="<?php  echo $qrcode;?>">
    <div>请先扫描以上二维码,成功后再填写版本信息</div>
</div>
<!--第二步 01-->
<div class="page-content step-two step-two-a" style="margin-top: 20px;">
    <div class="inner">
        <div class="title">版本号<span style="font-size: 12px;color: #666;margin-left: 10px;">(当前版本号：<?php echo empty($last_log['version'])?'未提交':$last_log['version']?>)</span></div>
        <div class="content">
            <input class="import" type="text" id="version" value="<?php echo empty($last_log['version'])?'':$last_log['version']?>"/>
        </div>
        <div class="title">版本描述</div>
        <div class="content">
            <textarea class="import" id="describe"><?php echo empty($last_log['describe'])?'':$last_log['describe']?></textarea>
        </div>
        <div class="button" style="padding: 36px 0 36px 200px;">
            <input type="submit" value="上传代码" class="btn btn-primary upload"/>
        </div>
    </div>
</div>
<!--第二步 02-->
<div class="page-content step-two step-two-b" style="margin-top: 20px;">
    <div class="inner">
        <img src="../addons/ewei_shopv2/plugin/app/static/images/upload.png"  id="showimgurl" style="width: 100px;height: 100px;"></br>
        <div class="progressbar"><div class="line"></div></div>
        <div style="margin: 40px 0 120px">您的代码正在上传，请等待...</div>
    </div>
</div>

<!--第三步-->
<div class="page-content step-three" style="margin-top: 20px;">
    <div class="inner">
        <div class="uploadsuccess"><div class="check"></div></div>
        <div class="hint">上传代码成功，请到微信开发平台小程序后台预览，提交审核后应用。</div>
        <div class="reminder"> <i class="icow icow-zhuyi" style="margin-right: 10px"></i><a style="color: #ffc730;" href="<?php  echo webUrl('app/newrelease/wechatset')?>" target="_blank">如何在微信开发平台提交审核</a></div>
        <input type="submit" value="前往微信设置" class="btn btn-primary WeChat"/>
    </div>
</div>

<script type="text/javascript">
    // step
    $('.spans').html('<i class="icow icow-wancheng"></i>');
    $(document).ready(function(){
        var need_scan=<?php  echo $need_scan;?>;
        //存在令牌的情况
        if(need_scan==0){
            //head
            $(".item-step.step-1").addClass("active");
            $(".item-step.step-2 .title .num").addClass("active");
            //body
            $('.step-one').css('display','none');
            $('.step-two-a').css('display','block');
        }else{
            var uuid='<?php  echo $uuid;?>';
            if(uuid=='' || uuid==undefined){
                alert('请刷新后重试！');
            }else{
                var settime = setInterval(function () {
                    $.ajax({
                        url: "<?php  echo webUrl('app/newrelease/getstatus')?>",
                        data: {uuid: uuid},
                        type: 'post',
                        async: true,
                        dataType: 'json',
                        success: function (ret) {
                            if(ret.result.wx_errcode==405){
                                clearInterval(settime);
                                $.ajax({
                                    url: "<?php  echo webUrl('app/newrelease/getticket')?>",
                                    data: {code: ret.result.wx_code},
                                    type: 'post',
                                    async: true,
                                    dataType: 'json',
                                    success: function (re) {
                                        if(re.result.new_ticket!=null){
                                            //head
                                            $(".item-step.step-1").addClass("active");
                                            $(".item-step.step-2 .title .num").addClass("active");
                                            //body
                                            $('.step-one').css('display','none');
                                            $('.step-two-a').css('display','block');
                                        }
                                    }
                                });
                            }
                        }
                    });
                }, 1000);
            }
        }
    });

    // 第二步 上传
    $(".upload").click(function () {
       $(this).attr("disabled","disabled");
        var version=$('#version').val();
        var describe=$('#describe').val();
        $.ajax({
            url: "<?php  echo webUrl('app/newrelease/submit')?>",
            data: {version: version,describe:describe},
            type: 'post',
            async: true,
            dataType: 'json',
            success: function (ret) {
                var result = ret.result;
                if (ret.status != 1) {
                    tip.msgbox.err(result.message);
                    setTimeout(function () {
                        location.reload();
                    },3000);
                    return;
                }else{
                    $('.step-two-b').css('display','block');
                    $('.step-two-a').css('display','none');
                    var i=0;
                    var settime=setInterval(function () {
                        i=i+10;
                        $('.step-two-b .progressbar .line').css('width',i+'%');
                        if(i==180){
                            clearInterval(settime);
                            //head
                            $(".item-step.step-2").addClass("active");
                            $(".item-step.step-3 .title .num").addClass("active");
                            //body
                            $('.step-two-b').css('display','none');
                            $('.step-three').css('display','block');
                        }
                    },100);
                }
            }
        });
    });


    $(".WeChat").click(function () {
        window.open("http://mp.weixin.qq.com");
        tip.impower('已在微信完成审核？',
            function (){
//                //head
//                $(".item-step.step-2").removeClass("active");
//                $(".item-step.step-3 .title .num").removeClass("active");
//                //body
//                $('.step-two-a').css('display','block');
//                $('.step-two-b').css('display','none');
//                $('.step-three').css('display','none');
//                $('.step-two-b .progressbar .line').css('width','0%');
                location.reload();
            },
            function(){
                window.location.href="<?php  echo webUrl('app/newrelease')?>";
            }
        )
    });
</script>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>