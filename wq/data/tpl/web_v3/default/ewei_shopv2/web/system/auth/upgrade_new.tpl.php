<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<style>
    [v-clock]{
        display: none;
    }
    .stystem_upgrade  .control-label{
        margin-right: 10px;
    }
    .log .upgradelog{
        line-height: 80px;
        font-size:18px;
        color: #333;
    }
    .log .upgradelog i{
        font-weight: bold;
        color: #00aeff;
        margin-right: 7px;
        font-size:20px;
    }
    .log .panel{
        padding: 0 25px;
        margin-bottom: 20px;
        border:1px solid #efefef;
    }
    .log .panel p{
        display: -webkit-box;
        display: -moz-box;
        display: -ms-flexbox;
        display: -webkit-flex;
        display: flex;
    }
    .log .panel p i{
        margin-top: 5px;
        margin-right: 5px;
    }
    .log .panel-heading{
        padding: 0;
        height:58px;
        line-height: 58px;
        font-size:14px;
        border-bottom:1px solid #efefef !important;
    }
    .log .panel-body{
        font-size: 13px;
        color: #333;
        line-height: 30px;
        padding: 14px 0 35px;
    }
    .log .panel-body p i{
        font-size:16px;
    }
    .shopedtion{
        line-height: 50px;
        margin-bottom: 30px;
    }
    .shopedtion .shopedtion_info{
        display: flex;
        align-items: center;
        font-size:14px;
        color: #333;
        line-height: 30px;
        padding: 15px 30px;
        background: #eef9ff;
        border: 1px solid #c4e3f3;
    }
    .shopedtion .model{
        border: 1px solid #efefef;
        line-height: 30px;
        height: 200px;
        overflow: auto;
        padding: 15px 30px;
    }
    .shopedtion .shopedtion_info p{
        font-size:14px;
    }
    .shopedtion_info>div{
        flex:1;
        align-items: center;
    }
    .shopedtion .control-label,.new_edtion .control-label{
        padding-top: 0;
    }
    .popover{
        width:249px;
        height:80px;
        color: #666;
        line-height: 20px;
    }
    .popover.bottom>.arrow {
        top: -11px;
        left: 50%;
        margin-left: -11px;
        border-top-width: 0;
        border-bottom-color: rgba(0,0,0,0);
    }
    .btn-group-pull input{
        margin: 5px 0;
    }
</style>
<div class="page-header">
    <span class='pull-right'>
        <?php  if(!empty($result['status'])) { ?>
            <span class='label label-primary'>更新服务到期时间:  <?php  echo $result['result']['auth_date_end'];?></span>
        <?php  } ?>
    </span>
    当前位置：<span class="text-primary">系统更新</span>
</div>
<div class="page-content stystem_upgrade" id="update" v-clock>

    <form action="" method="post" class="form-horizontal form" enctype="multipart/form-data" >
        <div class="form-group shopedtion">
            <label class="col-lg control-label">当前版本</label>
            <div class="col-sm-9 col-xs-12 shopedtion_info">
               <div>
                   <span class=""><?php  echo $version;?></span> RELEASE <?php  echo $release;?>
                   <span  v-if="status==1 && show && files.length <= 0 && database.length<=0 && upgrades.length<=0" style="margin-left: 30px">您当前版本为最新版本，<span class="text-danger">无需更新</span></span>
               </div>
                <a  rel="pop" data-content="如果您的系统未正常检测到最新版本，或者您需要强制更新，您可以降低版本后重新尝试更新。"  class='btn btn-default pull-right' href="<?php  echo webUrl('system/auth/upgrade_new/checkversion')?>" >降级版本更新 <i class="icow icow-shibai text-warning" style="font-size: 14px;
    vertical-align: baseline;"></i></a>
            </div>
        </div>
        <div class=" upgrade" v-show="!show"  style="margin-left: -15px">
            <label class="col-lg control-label">最新版本</label>
            <div class="col-sm-9 col-xs-12">
                <div class="form-control-static"  id="check">等待检测...</div>
            </div>
        </div>

        <div v-if="status==1 && show">
            <div class=" upgrade shopedtion" v-if="files.length <= 0 && database.length<=0 && upgrades.length<=0"  style="margin-left: -15px">
                <label class="col-lg control-label">最新版本</label>
                <div class="col-sm-9 col-xs-12 shopedtion_info">
                    <div class="">{{version}} RELEASE {{release}}</div>
                </div>
            </div>
            <div class="form-group shopedtion" v-else>
                <label class="col-lg control-label">最新版本</label>
                <div class="col-sm-9 col-xs-12 shopedtion_info">
                    <div>
                        <p><span class="text-danger">{{version}}</span> RELEASE {{release}}</p>
                        <p>共检测到 <span class="text-danger">{{files.length}}</span>个文件</p>
                        <p>更新之前请注意数据备份</p>
                        <p v-if="database.length>0 || upgrades.length>0"> 此次有数据变动</p>
                    </div>
                    <p class="btn-group-pull">
                        <input type="button" id="upgradebtn" :value="btn_name" @click="upgradebtn" class="btn btn-primary" /><br/>
                        <a v-if="hasfile" href="<?php  echo webUrl('system/auth/upgrade_new/filechange')?>" target="_blank" class="btn btn-default">变动数据<i class="icow icow-shibai text-warning" style="font-size: 14px; vertical-align: baseline;"></i></a>
                    </p>
            </div>
            </div>

            <div class="form-group" v-if="result.new_log != '' && (files.length > 0 || database.length>0 || upgrades.length>0)">
                <label class="col-lg control-label">更新日志</label>
                <div class="log col-sm-9 col-xs-12" style="padding: 0">
                    <div class="panel" v-for="item in result.new_log">
                        <div class="panel-heading">
                            {{item.release}}
                            <span class="pull-right" style="font-size: 12px;"> {{item.time}}</span>
                        </div>
                        <div class="panel-body">
                            <p v-for="index in item.log_data">
                                <i v-if="index.type==0" class="icow icow-icon32208 text-primary" ></i>
                                <i v-else-if="index.type==1" class="icow icow-icon32208 text-success" ></i>
                                <i v-else-if="index.type==2" class="icow icow-sanjiaoxing text-warning" ></i>
                                <i v-else-if="index.type==3" class="icow icow-icon32208 text-primary" ></i>
                                <i v-else-if="index.type==4" class="icow icow-sanjiaoxing text-danger" ></i>
                                <span v-html="index.value"></span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group upgrade" v-else v-show="show" style="margin-left: -15px">
            <label class="col-lg control-label">最新版本</label>
            <div class="col-sm-9 col-xs-12">
                <div class="form-control-static" v-html="result.message"></div>
            </div>
        </div>
    </form>
</div>


<script language='javascript'>
    myrequire(['dist/vue/vue.min','tpl'],function (Vue,tpl) {
        var app = new Vue({
            el: '#update',
            data: {
                message: 'update',
                upgrade: '',
                version: '<?php  echo $version;?>',
                release: '<?php  echo $release;?>',
                result: {},
                status: 0,
                files: [],
                database: [],
                upgrades: [],
                show: false,
                updating: 0,
                update_files:0,
                update_database:0,
                update_upgrades:0,
                update_title:'',
                hasfile:0
            },
            mounted: function () {
                this.check();
            },
            computed: {
                btn_name:function () {
                    var title = this.updating===0?'立即更新':'正在更新中...';
                    if (this.update_title !== ''){
                        title = this.update_title;
                    }
                    return title;
                }
            },
            methods: {
                check: function () {
                    var $this=this;
                    $.ajax({
                        url: "<?php  echo webUrl('system/auth/upgrade_new/check')?>",
                        type: 'post',
                        data: {check:1},
                        dataType: 'json',
                        success: function (ret) {
                            $this.show = true;
                            $this.result = ret.result;
                            $this.files = $this.result.files || [];
                            $this.database = $this.result.database || [];
                            $this.upgrades = $this.result.upgrades || [];
                            $this.version = $this.result.version;
                            $this.release = $this.result.release;
                            $this.hasfile = $this.result.hasfile || 0;
                            $this.status = ret.status;

                            if ($this.files.length===0 && $this.database.length===0 && $this.upgrades.length===0){
                                $this.process('upgrades',[{upgrade:'success_noload'}],0);
                            }
                        }
                    });
                },
                upgradebtn:function () {
                    var $this = this;
                    if ($this.updating===1)
                    {
                        return;
                    }
                    $this.updating = 1;
                    tip.confirm('确认已备份，并进行更新吗?', function () {
                        if ($this.database.length>0){
                            $this.process('database',$this.database,0);
                        }else if ($this.files.length>0){
                            $this.process('files',$this.files,0);
                        }else if ($this.upgrades.length>0){
                            $this.process('upgrades',$this.upgrades,0);
                        }else{

                        }
                    });
                },
                process:function (action,content,index) {
                    var $this = this,postdata = content[index];
                    postdata= action==='upgrades' ? postdata.upgrade : postdata;
                    $.ajax({
                        url: "<?php  echo webUrl('system/auth/upgrade_new/process')?>",
                        data: {type: action,content:postdata,version:$this.version,release:$this.release},
                        type: 'post',
                        async: true,
                        dataType: 'json',
                        success: function (ret) {
                            var status = ret.status;
                            if (status==3) {
                                return;
                            }
                            if (status==2) {
                                $this.success();
                                return;
                            }
                            switch (action)
                            {
                                case 'database':
                                    $this.update_database++;
                                    if ($this.update_database >= $this.database.length){
                                        $this.update_title = "已成功更新 " + $this.update_database + " 条数据库结构变动";
                                        if ($this.files.length>0){
                                            $this.process('files',$this.files,0);
                                        }else if ($this.upgrades.length>0){
                                            $this.process('upgrades',$this.upgrades,0);
                                        }else {
                                            $this.process('upgrades',['success'],0);
                                            return;
                                        }

                                        return;
                                    }
                                    $this.update_title = "已更新 " + $this.update_database + " 条数据库结构变动 / 共 " + $this.database.length + " 条";
                                    $this.process('database',$this.database,$this.update_database);
                                    break;
                                case 'files':
                                    $this.update_files++;

                                    if ($this.update_files >= $this.files.length){
                                        $this.update_title = "已成功更新 " + $this.update_files + " 个文件";
                                        if ($this.upgrades.length>0) {
                                            $this.process('upgrades', $this.upgrades, 0);
                                        }else {
                                            $this.process('upgrades',['success'],0);
                                            return;
                                        }
                                        return;
                                    }
                                    $this.update_title = "已更新 " + $this.update_files + " 个文件 / 共 " + $this.files.length + " 个文件";
                                    $this.process('files',$this.files,$this.update_files);
                                    break;
                                case 'upgrades':
                                    $this.update_upgrades++;
                                    if ($this.update_upgrades>=$this.upgrades.length){
                                        $this.process('upgrades',['success'],0);
                                    }
                                    $this.update_title = "已更新 " + $this.update_upgrades + " 个补丁 / 共 " + $this.upgrades.length + " 个补丁";
                                    $this.process('upgrades',$this.upgrades,$this.update_upgrades);
                                    break;
                            }
                        }
                    });
                },
                success:function () {
                    this.updating = 0;
                    this.update_title = "更新完成";
                    tip.alert('更新完成', function () {
                        window.location.reload();
                    });
                }
            },
            watch: {}
        });

        require(['bootstrap'], function () {
            $("[rel=pop]").popover({
                trigger: 'manual',
                placement: 'bottom',
                title: $(this).data('title'),
                html: 'true',
                content: $(this).data('content'),
                animation: false
            }).on("mouseenter", function () {
                var _this = this;
                $(this).popover("show");
                $(this).siblings(".popover").on("mouseleave", function () {
                    $(_this).popover('hide');
                });
            }).on("mouseleave", function () {
                var _this = this;
                setTimeout(function () {
                    if (!$(".popover:hover").length) {
                        $(_this).popover("hide")
                    }
                }, 100);
            });
        });

    });

</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>