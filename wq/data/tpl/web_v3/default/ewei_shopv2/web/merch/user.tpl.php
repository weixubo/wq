<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>

<div class="page-header">
    当前位置：<span class="text-primary"> 多商户管理 </span>
</div>
<div class="page-content">
<form action="./index.php" method="get" class="form-horizontal" role="form" id="form1">
    <input type="hidden" name="c" value="site" />
    <input type="hidden" name="a" value="entry" />
    <input type="hidden" name="m" value="ewei_shopv2" />
    <input type="hidden" name="do" value="web" />
    <input type="hidden" name="r" value="merch.user" />

    <div class="page-toolbar m-b-sm m-t-sm">
        <div class="col-sm-3">
             <span class='pull-left'>
                    <a class='btn btn-primary btn-sm' href="<?php  echo webUrl('merch/user/add',array('status'=>$_GPC['status']))?>">
                        <i class="fa fa-plus"></i> 添加多商户</a>
                </span>
        </div>

        <div class="col-sm-8 pull-right">
            <div class="input-group">
                <div class="input-group-select">
                    <select name='groupid' class='form-control  input-sm select-md' style="width:100px;"  >
                        <option value=''>分组</option>
                        <?php  if(is_array($groups)) { foreach($groups as $g) { ?>
                        <option value="<?php  echo $g['id'];?>" <?php  if($_GPC['groupid']==$g['id']) { ?>selected<?php  } ?>><?php  echo $g['groupname'];?></option>
                        <?php  } } ?>
                    </select>
                </div>
                <div class="input-group-select">
                    <select name='status' class='form-control  input-sm select-md' style="width:100px;"  >
                        <option value=''>状态</option>
                        <option value='0' <?php  if($_GPC['status']=='0') { ?>selected<?php  } ?>>禁用</option>
                        <option value='1' <?php  if($_GPC['status']=='1') { ?>selected<?php  } ?>>启用</option>
                    </select>
                </div>
                <div class="input-group-select">
                    <select name='checked' class='form-control  input-sm select-md' style="width:100px;"  >
                        <option value=''>审核</option>
                        <option value='0' <?php  if($_GPC['status']=='0') { ?>selected<?php  } ?>>未审核</option>
                        <option value='1' <?php  if($_GPC['status']=='1') { ?>selected<?php  } ?>>已审核</option>
                        <option value='-1' <?php  if($_GPC['status']=='-1') { ?>selected<?php  } ?>>审核未通过</option>
                    </select>
                </div>
                <input type="text" class="form-control input-sm"  name="keyword" value="<?php  echo $_GPC['keyword'];?>" placeholder="商户名称/联系人/手机号"/>
				 <span class="input-group-btn">

                                        <button class="btn btn-primary" type="submit"> 搜索</button>
				</span>
            </div>

        </div>
    </div>
</form>
<?php  if(count($list)>0) { ?>
<div class="page-table-header">
    <input type="checkbox">
    <div class="btn-group">
        <?php if(cv('merch.user.edit')) { ?>
        <a class='btn btn-default btn-sm btn-operation'  data-toggle='batch' data-href="<?php  echo webUrl('merch/user/status',array('status'=>1))?>"  data-confirm='确认要启用账户吗?'>
            <i class="icow icow-qiyong"></i>启用
        </a>
        <a class='btn btn-default btn-sm btn-operation'  data-toggle='batch' data-href="<?php  echo webUrl('merch/user/status',array('status'=>0))?>" data-confirm='确认要禁用账户吗?'>
            <i class="icow icow-jinyong"></i>禁用
        </a>
        <?php  } ?>
        <?php if(cv('merch.user.delete')) { ?>
        <a class="btn btn-default btn-sm btn-operation" type="button" data-toggle='batch-remove' data-confirm="确认要删除?" data-href="<?php  echo webUrl('merch/user/delete')?>">
            <i class='icow icow-shanchu1'></i> 删除
        </a>
        <?php  } ?>
    </div>
</div>
<table class="table table-hover table-responsive">
    <thead class="navbar-inner" >
    <tr>
        <th style="width:25px;"></th>
        <th >商户名称</th>
        <th>主营项目</th>
        <th>联系人</th>
        <th>入驻时间</th>
        <th>到期时间</th>
        <th>状态</th>
        <th style='width:65px;'>操作</th>
    </tr>
    </thead>
    <tbody>
    <?php  if(is_array($list)) { foreach($list as $row) { ?>
    <tr rel="pop" data-title="ID: <?php  echo $row['id'];?>" data-id="<?php  echo $row['id'];?>" >
        <td>
            <input type='checkbox'   value="<?php  echo $row['id'];?>"/>
        </td>
        <td>
            <?php  echo $row['merchname'];?><br/>
            <?php  if($row['status']>0) { ?>
            <label class="label label-primary"><?php  if(empty($row['groupname'])) { ?>无分组<?php  } else { ?><?php  echo $row['groupname'];?><?php  } ?></label><br/>
            <?php  } ?>
        </td>
        <td><?php  echo $row['salecate'];?></td>
        <td><?php  echo $row['realname'];?><br/><?php  echo $row['mobile'];?></td>
        <td><?php  if(empty($row['jointime'])) { ?>-<?php  } else { ?><?php  echo date('Y-m-d',$row['jointime'])?><br/><?php  echo date('H:i',$row['jointime'])?><?php  } ?></td>
        <td><?php  if(empty($row['accounttime'])) { ?>-<?php  } else { ?><?php  echo date('Y-m-d',$row['accounttime'])?><?php  } ?></td>
        <td>
            <?php  if($row['status']==1) { ?>
            <label class="label label-primary">已入驻</label>
            <?php  } else if($row['status']==0) { ?>
            <label class="label label-default">待入驻</label>
            <?php  } else if($row['status']==2) { ?>
            <label class="label label-danger">暂停中</label>
            <?php  } ?>
        </td>
        <td  style="overflow:visible;">
            <?php if(cv('merch.user.view|merch.user.edit')) { ?>
            <a href="<?php  echo webUrl('merch/user/edit', array('id' => $row['id'],'status'=>$_GPC['status']))?>" class="btn btn-default btn-sm btn-op btn-operation" >
                  <span data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php if(cv('merch.user.edit')) { ?>修改<?php  } else { ?>查看<?php  } ?>">
                        <i class='icow icow-bianji2'></i>
                   </span>
            </a>
            <?php  } ?>
            <?php if(cv('merch.user.delete')) { ?>
            <a data-toggle='ajaxRemove' href="<?php  echo webUrl('merch/user/delete', array('id' => $row['id']))?>"class="btn btn-default btn-sm btn-op btn-operation" data-confirm='确认要删除此商户吗?'>
                <span data-toggle="tooltip" data-placement="top" title="" data-original-title="删除">
                     <i class='icow icow-shanchu1'></i>
                </span>
            </a>
            <?php  } ?>
        </td>
    </tr>
    <?php  } } ?>
    </tbody>
    <tfoot>
        <tr>
            <td><input type="checkbox"></td>
            <td colspan="2">
                <div class="btn-group">
                    <?php if(cv('merch.user.edit')) { ?>
                    <a class='btn btn-default btn-sm btn-operation'  data-toggle='batch' data-href="<?php  echo webUrl('merch/user/status',array('status'=>1))?>"  data-confirm='确认要启用账户吗?'>
                        <i class="icow icow-qiyong"></i>启用
                    </a>
                    <a class='btn btn-default btn-sm btn-operation'  data-toggle='batch' data-href="<?php  echo webUrl('merch/user/status',array('status'=>0))?>" data-confirm='确认要禁用账户吗?'>
                        <i class="icow icow-jinyong"></i> 禁用
                    </a>
                    <?php  } ?>
                    <?php if(cv('merch.user.delete')) { ?>
                    <a class="btn btn-default btn-sm btn-operation" type="button" data-toggle='batch-remove' data-confirm="确认要删除?" data-href="<?php  echo webUrl('merch/user/delete')?>">
                        <i class='icow icow-shanchu1'></i> 删除
                    </a>
                    <?php  } ?>
                </div>
            </td>
            <td colspan="5" class="text-right">
                <?php  echo $pager;?>
            </td>
        </tr>
    </tfoot>
</table>

<?php  } else { ?>
<div class='panel panel-default'>
    <div class='panel-body' style='text-align: center;padding:30px;'>
        暂时没有任何商户!
    </div>
</div>
<?php  } ?>
    </div>
<script language="javascript">
    require(['bootstrap'], function () {
        $("[rel=pop]").popover({
            trigger: 'manual',
            placement: 'top',
            title: $(this).data('title'),
            html: 'true',
            content:  function() {
                var contents="正在加载中...";
                $.ajax({type: "GET",
                    url: "<?php  echo webUrl('merch/user/get_show_money')?>",
                    dataType:"json",
                    data:{id:$(this).data('id')},
                    async:false,
                    success: function(data){
                        var result = data.result;
                        contents="可提现金额："+result['status0']+" </br>已结算金额："+result['status3'];
                    }
                });
                return contents;
            },
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

</script>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>