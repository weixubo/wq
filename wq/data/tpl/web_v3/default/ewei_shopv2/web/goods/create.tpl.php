<?php defined('IN_IA') or exit('Access Denied');?><?php  $no_left =true;?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<style>
    .input-string-width{width:200px;}
    .region-goods{background: #f8f8f8;margin-bottom: 10px;padding:0 10px;}
    .region-goods-left{}
    .region-goods-right{border-left:3px solid #fff;padding:10px 10px;}
    .region-inner{text-align: center;font-weight:bold;color:#333;font-size:14px;padding:20px 0;}
</style>
<div class="page-header">
    当前位置：<span>首页</span><span class="fa fa-angle-double-right" style="margin: 0 5px"></span><span>商品管理</span><span class="fa fa-angle-double-right" style="margin: 0 5px"></span><span>发布商品</span>
</div>
<div class="page-content expandMode">
    <div class="row">
        <div class="col-md-12" style="margin-bottom: 50px;">
            <ul class="nav nav-tabs" id="crectgoods" style="width:100%;display: flex;">
                <li id="list_li" class="active" data-type="list" style="flex: 1; text-align: center"><a href="javascript:void(0);">编辑基本信息</a></li>
                <li id="basic_li" data-type="basic" style="flex: 1; text-align: center" class=""><a href="javascript:void(0);">规格/库存</a></li>
                <li id="sale_li" data-type="sale" style="flex: 1; text-align: center" class=""><a href="javascript:void(0);">编辑商品详情</a></li>
            </ul>
            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal form-validate">
                <div class="tab-content ">
                    <input type="hidden" name="type" id="type" value="0">
                    <input type="hidden" id="tab" value="list">

                    <div class="tab-pane active" id="list">
                        <div class="panel-body region-goods row">
                            <div class="col-md-2 region-goods-left">
                                <div class="region-inner">基本信息</div>
                            </div>
                            <div class="col-md-10 region-goods-right">
                                <div class="form-group row">
                                    <label class="col-sm control-label must">商品名称</label>

                                    <div class="col-md-10">
                                        <div class="col-sm-8"  style="padding:0;" >
                                            <input type="text" name="goodsname" id="goodsname" class="form-control" value="" data-rule-required="true" />
                                        </div>
                                        <div class="col-sm-2" style="padding-left:5px">
                                            <input type="text" name="unit" id="unit" class="form-control" value="" placeholder="单位, 如: 个/件/包"  />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm control-label">关键字</label>
                                    <div class="col-md-10">
                                        <input type="text" name="keywords" class="form-control input-string-width" value=""/>
                                        <div class="help-block">商品关键字,能准确搜到商品的,比如 : 海尔电视|电视 之类的</div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm control-label">商品类型</label>

                                    <div class="col-md-10">
                                        <label class="radio-inline"><input type="radio" name="type" value="1" checked="true" /> 实体商品</label>

                                        <?php  if(com('virtual') ) { ?>
                                        <label class="radio-inline"><input type="radio" name="type" value="2" onclick="type_change(2);" /> 虚拟商品</label>

                                        <label class="radio-inline"><input type="radio" name="type" value="3" onclick="type_change(3);" /> 虚拟物品(卡密)</label>
                                        <?php  } ?>

                                        <label class="radio-inline"><input type="radio" name="type" value="4" /> 批发商品</label>
                                        <label class="radio-inline"><input type="radio" name="type" value="5" <?php  if(!empty($item['id'])) { ?>disabled<?php  } ?>  <?php  if($item['type'] == 5) { ?>checked="true"<?php  } ?>  onclick="type_change(5);" /> 记次/时商品</label>
                                        <?php  if(p('mr')) { ?>
                                        <label class="radio-inline"><input type="radio" name="type" value="10" /> 话费流量充值</label>
                                        <?php  } ?>

                                        <span class="help-block">商品类型，商品保存后无法修改，请谨慎选择</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm control-label">商品分类</label>
                                    <div class="col-md-10">
                                        <select id="cates"  name='cates[]' class="form-control select2" style='width:605px;' multiple='' >
                                            <?php  if(is_array($category)) { foreach($category as $c) { ?>
                                            <option value="<?php  echo $c['id'];?>" ><?php  echo $c['name'];?></option>
                                            <?php  } } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm control-label must">商品图片</label>
                                    <div class="col-md-9 gimgs">
                                        <?php  echo tpl_form_field_multi_image2('thumbs',$piclist)?>
                                        <span class="help-block image-block">第一张为缩略图，建议为正方型图片，其他为详情页面图片，尺寸建议宽度为640，并保持图片大小一致</span>
                                        <span class="help-block">您可以拖动图片改变其显示顺序 </span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm control-label"></label>
                                    <div class="col-md-10">
                                        <label class="checkbox-inline"><input type="checkbox" name="thumb_first" value="1"  /> 详情显示首图</label>
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                                <?php  if(p('app')) { ?>
                                <div class="form-group">
                                    <label class="col-sm control-label">首图视频</label>
                                    <div class="col-md-9">
                                        <?php  echo tpl_form_field_video2('video', $item['video'], array('disabled'=>!cv('goods.edit'), 'network'=>true, 'placeholder'=>'请选择视频'))?>
                                        <div class='form-control-static'>设置后商品详情首图默认显示视频，目前仅支持小程序</div>
                                    </div>
                                </div>
                                <?php  } ?>
                                <div class="form-group row">
                                    <label class="col-sm control-label">商品属性</label>
                                    <div class="col-md-10">
                                        <label for="isrecommand" class="checkbox-inline">
                                            <input type="checkbox" name="isrecommand" value="1" id="isrecommand" /> 推荐
                                        </label>
                                        <label for="isnew" class="checkbox-inline">
                                            <input type="checkbox" name="isnew" value="1" id="isnew" /> 新品
                                        </label>
                                        <label for="ishot" class="checkbox-inline">
                                            <input type="checkbox" name="ishot" value="1" id="ishot" /> 热卖
                                        </label>

                                        <label for="issendfree" class="checkbox-inline">
                                            <input type="checkbox" name="issendfree" value="1" id="issendfree" /> 包邮
                                        </label>

                                        <label for="isnodiscount" class="checkbox-inline">
                                            <input type="checkbox" name="isnodiscount" value="1" id="isnodiscount" /> 不参与会员折扣
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body region-goods row">
                            <div class="col-md-2 region-goods-left">
                                <div class="region-inner">商品信息</div>
                            </div>
                            <div class="col-md-10 region-goods-right ">
                                <div class="form-group row goodsPrice">
                                    <label class="col-sm control-label must">商品价格</label>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-addon">售价</span>
                                            <input type="text" name="marketprice" id="marketprice" class="form-control" value="" data-rule-required="true" />
                                            <span class="input-group-addon">元 原价</span>
                                            <input type="text" name="productprice" id="productprice" class="form-control" value="" />
                                            <span class="input-group-addon">元 成本</span>
                                            <input type="text" name="costprice" id="costprice" class="form-control" value="" />
                                            <span class="input-group-addon">元</span>
                                        </div>
                                        <span class='help-block'>尽量填写完整，有助于于商品销售的数据分析</span>
                                    </div>
                                </div>
                                <?php  if(com('virtual')) { ?>
                                <div class="form-group" style="display: none;" id="type_virtual">
                                    <label class="col-sm control-label"></label>
                                    <div class="col-md-10">
                                        <select class="form-control select2" id="virtual" name="virtual">
                                            <option value="0">多规格虚拟物品</option>
                                            <?php  if(is_array($virtual_types)) { foreach($virtual_types as $virtual_type) { ?>
                                            <option value="<?php  echo $virtual_type['id'];?>"><?php  echo $virtual_type['usedata'];?>/<?php  echo $virtual_type['alldata'];?> | <?php  echo $virtual_type['title'];?></option>
                                            <?php  } } ?>
                                        </select>
                                        <span>提示：直接选中虚拟物品模板即可，选择多规格需在商品规格页面设置</span>
                                    </div>
                                </div>
                                <?php  } ?>
                                <div class="form-group row send-group" style="display: none;">
                                    <label class="col-sm control-label">自动发货</label>
                                    <div class="col-md-10">
                                        <?php if( ce('goods' ,$item) ) { ?>
                                        <label class="radio-inline"><input type="radio" name="virtualsend" value="0"  <?php  if(empty($item['virtualsend'])) { ?>checked="true"<?php  } ?>/> 否</label>
                                        <label class="radio-inline"><input type="radio" name="virtualsend" value="1" <?php  if($item['virtualsend'] == 1) { ?>checked="true"<?php  } ?>   /> 是</label>
                                        <span class="help-block">提示：发货后订单自动完成</span>
                                        <?php  } else { ?>
                                        <div class='form-control-static'><?php  if(empty($item['virtualsend'])) { ?>否<?php  } else { ?>是<?php  } ?></div>
                                        <?php  } ?>
                                    </div>
                                </div>

                                <div class="form-group row send-group" style="display: none;">
                                    <label class="col-sm control-label">自动发货内容</label>
                                    <div class="col-md-10">
                                        <textarea class="form-control" name="virtualsendcontent"><?php  echo $item['virtualsendcontent'];?></textarea>
                                    </div>
                                </div>

                                <div class="form-group interval" style="display: none">
                                    <label class="col-sm control-label" >批发价格</label>
                                    <div class="col-md-10 row">
                                        <div class="col-sm-2">
                                            <input type="hidden" id="intervalfloor" name="intervalfloor" value="">
                                            <a href="javascript:;" id='add-plus' onclick="setinterval('plus')" class="btn btn-default"  title="添加价格区间"><i class='fa fa-plus'></i> 添加价格区间</a>
                                        </div>
                                        <div class="col-sm-2">
                                            <a href="javascript:;" id='add-minus' onclick="setinterval('minus')" class="btn btn-default"  title="添加价格区间"><i class='fa fa-minus'></i> 移除价格区间</a>
                                        </div>
                                        <div class="col-sm-6">
                                            <p style="margin-top: 7px;">批发商品请至少设置一组价格区间，才能正常发布信息。</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group interval" style="display: none">
                                    <div class="col-sm control-label"></div>
                                    <div class="col-md-10">
                                        <div class="input-group"  <?php  if(!is_array($intervalprices['0'])) { ?> style="display: none"<?php  } ?>  id="interval1">
                                            <span class="input-group-addon">购买</span>
                                            <input type="text" name="intervalnum1" id="intervalnum1" class="form-control" value="" />
                                            <span class="input-group-addon">件及以上</span>
                                            <input type="text" name="intervalprice1" id="intervalprice1" class="form-control" value="" />
                                            <span class="input-group-addon">元/件</span>
                                        </div>
                                        <br />
                                        <div class="input-group"  <?php  if(!is_array($intervalprices['1'])) { ?> style="display: none"<?php  } ?> id="interval2">
                                            <span class="input-group-addon">购买</span>
                                            <input type="text" name="intervalnum2" id="intervalnum2" class="form-control" value="<?php  if(is_array($intervalprices['1'])) { ?><?php  echo $intervalprices[1]['intervalnum'];?><?php  } ?>" />
                                            <span class="input-group-addon">件及以上</span>
                                            <input type="text" name="intervalprice2" id="intervalprice2" class="form-control" value="<?php  if(is_array($intervalprices['1'])) { ?><?php  echo $intervalprices[1]['intervalprice'];?><?php  } ?>" />
                                            <span class="input-group-addon">元/件</span>
                                        </div>
                                        <br />
                                        <div class="input-group" <?php  if(!is_array($intervalprices['2'])) { ?> style="display: none"<?php  } ?> id="interval3">
                                            <span class="input-group-addon">购买</span>
                                            <input type="text" name="intervalnum3" id="intervalnum3" class="form-control" value="<?php  if(is_array($intervalprices['2'])) { ?><?php  echo $intervalprices[2]['intervalnum'];?><?php  } ?>" />
                                            <span class="input-group-addon">件及以上</span>
                                            <input type="text" name="intervalprice3" id="intervalprice3" class="form-control" value="<?php  if(is_array($intervalprices['2'])) { ?><?php  echo $intervalprices[2]['intervalprice'];?><?php  } ?>" />
                                            <span class="input-group-addon">元/件</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm control-label"></label>
                                    <div class="col-sm-10">
                                        <label class="checkbox-inline" <?php  if($item['isverify'] == 2 || $item['type'] == 2 || $item['type'] == 3) { ?>style="display:none;"<?php  } ?>>
                                        <input type="checkbox" name="cash" value="2" <?php  if($item['cash'] =='2') { ?>checked="true"<?php  } ?>  /> 支持货到付款
                                        </label>
                                        <label class="checkbox-inline">
                                            <input type="checkbox" name="cashier" value="1" <?php  if(!empty($item['cashier'])) { ?>checked="true"<?php  } ?>/> 支持收银台
                                        </label>
                                        <label class="checkbox-inline">
                                            <input type="checkbox" name="invoice" value="1" <?php  if(!empty($item['invoice'])) { ?>checked="true"<?php  } ?>/> 支持发票
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group dispatch_info" <?php  if(($item['type'] == 2 || $item['type'] == 3 || $item['type'] == 10)) { ?>style="display: none;"<?php  } ?>>
                                    <label class="col-sm control-label">运费设置</label>
                                    <div class="col-sm-3" style='padding-left:0'>
                                        <div class="input-group">
                                            <span class='input-group-addon' style='border:none;background: none;'><label class="radio-inline" style='margin-top:-7px;' ><input type="radio" name="dispatchtype" value="0" <?php  if(empty($item['dispatchtype'])) { ?>checked="true"<?php  } ?>   /> 运费模板</label></span>
                                            <select class="form-control tpl-category-parent select2" id="dispatchid" name="dispatchid">
                                                <option value="0">默认模板</option>
                                                <?php  if(is_array($dispatch_data)) { foreach($dispatch_data as $dispatch_item) { ?>
                                                <option value="<?php  echo $dispatch_item['id'];?>" <?php  if($item['dispatchid'] == $dispatch_item['id']) { ?>selected="true"<?php  } ?>><?php  echo $dispatch_item['dispatchname'];?></option>
                                                <?php  } } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group dispatch_info" <?php  if(($item['type'] == 2 || $item['type'] == 3 || $item['type'] == 10)) { ?>style="display: none;"<?php  } ?>>
                                    <label class="col-sm control-label"></label>
                                    <div class="col-sm-3" style='padding-left:0'>
                                        <div class="input-group">
                                            <span class='input-group-addon' style='border:none;background: none;'><label class="radio-inline"  style='margin-top:-7px;' ><input type="radio"name="dispatchtype" value="1" <?php  if($item['dispatchtype'] == 1) { ?>checked="true"<?php  } ?>  /> 统一邮费</label></span>
                                            <input type="text" name="dispatchprice" id="dispatchprice" class="form-control" value="<?php  echo $item['dispatchprice'];?>" />
                                            <span class="input-group-addon">元</span>
                                        </div>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm control-label">上架</label>
                                    <div class="col-sm-10">
                                        <label class="radio-inline"><input type="radio" name="status" value="0" checked="true" /> 否</label>
                                        <label class="radio-inline"><input type="radio" name="status" value="1" /> 上架</label>
                                        <label class="radio-inline"><input type="radio" name="status" value="2" /> 赠品上架</label>
                                        <span class="help-block">赠品上架之后，状态不可更改。</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm control-label">是否选择上架时间</label>
                                    <div class="col-sm-10">
                                        <label class="radio-inline"><input type="radio" name="isstatustime" value="0" checked="true" /> 否</label>
                                        <label class="radio-inline"><input type="radio" name="isstatustime" value="1" /> 是</label>
                                        <span class="help-block">商品在选择时间内自动上架，过期自动下架</span>
                                    </div>
                                </div>
                                <div id="shelves" class="form-group" <?php  if($item['isstatustime']!=1) { ?>style="display:none"<?php  } ?>>
                                    <label class="col-sm control-label">
                                        上架时间
                                    </label>
                                    <div class="col-sm-4 col-xs-6">
                                        <?php  echo tpl_form_field_daterange('statustime', array('starttime'=>date('Y-m-d H:i', $statustimestart),'endtime'=>date('Y-m-d H:i', $statustimeend)),true);?>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="basic">
                        <div class="panel-body region-goods">
                            <div class="col-md-2 region-goods-left">
                                <div class="region-inner">库存/规格</div>
                            </div>
                            <div class="col-md-10 region-goods-right">
                                <div class="form-group row">
                                    <label class="col-sm control-label">编码</label>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-addon">编码</span>
                                            <input type="text" name="goodssn" id="goodssn" class="form-control hasoption" value=""/>
                                            <span class="input-group-addon">条码</span>
                                            <input type="text" name="productsn" id="productsn" class="form-control hasoption" value="" />
                                            <span class="input-group-addon">重量</span>
                                            <input type="text" name="weight" id="weight" class="form-control hasoption" value="" />
                                            <span class="input-group-addon">克</span>
                                        </div>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm control-label">库存</label>
                                    <div class="col-md-10">
                                        <input type="text" name="total" id="total" class="form-control hasoption" value=""  style="width:150px;display: inline;margin-right: 20px;" />
                                        <label class="checkbox-inline">
                                            <input type="checkbox" id="showtotal" value="1" name="showtotal" />显示库存
                                        </label>
                                        &nbsp;
                                        <label for="totalcnf1" class="radio-inline"><input type="radio" name="totalcnf" value="0" id="totalcnf1" checked="true" /> 拍下减库存</label>
                                        <label for="totalcnf2" class="radio-inline"><input type="radio" name="totalcnf" value="1" id="totalcnf2"  /> 付款减库存</label>
                                        <label for="totalcnf3" class="radio-inline"><input type="radio" name="totalcnf" value="2" id="totalcnf3" /> 永不减库存</label>
                                        <span class="help-block">商品的剩余数量, 如启用多规格<?php  if(com('virtual')) { ?>或为虚拟卡密产品<?php  } ?>，则此处设置无效.</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm control-label"></label>
                                    <div class="col-md-10">
                                        <label class="checkbox-inline">
                                            <input type="checkbox" id="hasoption" value="1" name="hasoption" />启用商品规格
                                        </label>
                                        <span class="help-block">启用商品规格后，商品的价格及库存以商品规格为准,库存设置为0则会到”已售罄“中，手机也不会显示, -1为不限制</span>
                                    </div>
                                </div>
                                <div id='tboption' style="padding-left:15px;<?php  if($item['hasoption']!=1) { ?>display:none<?php  } ?>" >
                                    <div class="alert alert-primary">
                                        1. 拖动规格可调整规格显示顺序, 更改规格及规格项后请点击下方的【刷新规格项目表】来更新数据。<br/>
                                        2. 每一种规格代表不同型号，例如颜色为一种规格，尺寸为一种规格，如果设置多规格，手机用户必须每一种规格都选择一个规格项，才能添加购物车或购买。
                                    </div>
                                    <div id='specs'>
                                        <?php  if(is_array($allspecs)) { foreach($allspecs as $spec) { ?>
                                        <?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('goods/tpl/spec', TEMPLATE_INCLUDEPATH)) : (include template('goods/tpl/spec', TEMPLATE_INCLUDEPATH));?>
                                        <?php  } } ?>
                                    </div>
                                    <table class="table">
                                        <tr>
                                            <td>
                                                <h4><a href="javascript:;" class='btn btn-primary' id='add-spec' onclick="addSpec()" style="margin-top:10px;margin-bottom:10px;" title="添加规格"><i class='fa fa-plus'></i> 添加规格</a>
                                                    <a href="javascript:;" onclick="refreshOptions();" title="刷新规格项目表" class="btn btn-primary"><i class="fa fa-refresh"></i> 刷新规格项目表</a></h4>
                                            </td>
                                        </tr>
                                    </table>
                                    <div class="alert alert-info wholesalewarning"  style="display: none">
                                        1. 批发商品设置多规格时,无需设置价格参数(现价,原价,成本价,预售价),当商品保存时会自动获取第一级批发价作为不同规格商品的统一价格!
                                    </div>
                                    <div id="options" style="padding:0;"><?php  echo $html;?></div>
                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="tab-pane" id="sale">
                        <div class="panel-body region-goods">
                            <div class="col-md-2 region-goods-left">
                                <div class="region-inner">内容</div>
                            </div>
                            <div class="col-md-10 region-goods-right">
                                <div class="form-group row">
                                    <label class="col-sm control-label">商品副标题</label>
                                    <div class="col-md-10">
                                        <input type="text" name="subtitle" id="subtitle" class="form-control" value="" data-parent=".subtitle" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm control-label">商品短标题</label>
                                    <div class="col-md-10">
                                        <input type="text" name="shorttitle" class="form-control" value="" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm control-label">商品详情</label>
                                    <div class="col-md-10">
                                        <?php  echo tpl_ueditor('content',$item['content'],array('height'=>'300'))?>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="tab-footer col-md-12">
                        <a href="javascript:void(0);" class="btn btn-white btn-lg" id="prev" style="margin-right: 15px;display: none;">上一步</a>
                        <a href="javascript:void(0);" class="btn btn-primary btn-lg" id="next">下一步</a>
                        <input type="submit" value="保存商品" class="btn btn-primary btn-lg" style="display: none;"/>
                    </div>
                </div>
<input type="hidden" name="optionArray" value=''>
<input type="hidden" name="isdiscountDiscountsArray" value=''>
<input type="hidden" name="discountArray" value=''>
<input type="hidden" name="commissionArray" value=''>
            </form>
        </div>
    </div>

</div>
<script type="text/javascript">
    require(['jquery.ui'],function(){
        $('.multi-img-details').sortable({scroll:'false'});
    })
    $(function () {
        $('form').submit(function(){
            var check = true;

            window.type = $("input[name='type']:checked").val();
            window.virtual = $("#virtual").val();


            full = checkoption();
            if (!full) {
                $('form').attr('stop',1),tip.msgbox.err('请输入规格名称!');
                return false;
            }
            var spec_item_title = 1;
            $(".spec_item").each(function (i) {
                var _this = this;
                if($(_this).find(".spec_item_title").length == 0){
                    spec_item_title = 0;
                }
            });
            if(spec_item_title == 0){
                $('form').attr('stop',1),tip.msgbox.err('详细规格没有填写,请填写详细规格!');
                return false;
            }
            $('form').attr('stop',1);
            //处理规格
            optionArray();
            $('form').removeAttr('stop');
            return true;
        });

        function checkoption() {

            var full = true;
            var $spec_title = $(".spec_title");
            var $spec_item_title = $(".spec_item_title");
            if ($("#hasoption").get(0).checked) {
                if($spec_title.length==0){
                    $('#myTab a[href="#tab_option"]').tab('show');
                    full = false;
                }
                if($spec_item_title.length==0){
                    $('#myTab a[href="#tab_option"]').tab('show');
                    full = false;
                }
            }
            if (!full) {
                return false;
            }
            return full;
        }
        function optionArray() {
            var option_stock = new Array();
            $('.option_stock').each(function (index,item) {
                option_stock.push($(item).val());
            });

            var option_id = new Array();
            $('.option_id').each(function (index,item) {
                option_id.push($(item).val());
            });

            var option_ids = new Array();
            $('.option_ids').each(function (index,item) {
                option_ids.push($(item).val());
            });

            var option_title = new Array();
            $('.option_title').each(function (index,item) {
                option_title.push($(item).val());
            });

            var option_virtual = new Array();
            $('.option_virtual').each(function (index,item) {
                option_virtual.push($(item).val());
            });

            var option_marketprice = new Array();
            $('.option_marketprice').each(function (index,item) {
                option_marketprice.push($(item).val());
            });
            var option_presellprice = new Array();
            $('.option_presell').each(function (index,item) {
                option_presellprice.push($(item).val());
            });

            var option_productprice = new Array();
            $('.option_productprice').each(function (index,item) {
                option_productprice.push($(item).val());
            });

            var option_costprice = new Array();
            $('.option_costprice').each(function (index,item) {
                option_costprice.push($(item).val());
            });

            var option_goodssn = new Array();
            $('.option_goodssn').each(function (index,item) {
                option_goodssn.push($(item).val());
            });

            var option_productsn = new Array();
            $('.option_productsn').each(function (index,item) {
                option_productsn.push($(item).val());
            });

            var option_weight = new Array();
            $('.option_weight').each(function (index,item) {
                option_weight.push($(item).val());
            });

            var options = {
                option_stock : option_stock,
                option_id : option_id,
                option_ids : option_ids,
                option_title : option_title,
                option_presellprice : option_presellprice,
                option_marketprice : option_marketprice,
                option_productprice : option_productprice,
                option_costprice : option_costprice,
                option_goodssn : option_goodssn,
                option_productsn : option_productsn,
                option_weight : option_weight,
                option_virtual : option_virtual
            };
            console.log(options);
            $("input[name='optionArray']").val(JSON.stringify(options));
        }
        /*
        * 商品类型选择
        * */
        $("input[name=type]").off("click").on("click",function () {

            var goodstype = $(this).val();
            /*类型显示相关信息*/
            $(".send-group").hide();
            $("#type_virtual").hide();
            $(".interval").hide();
            $(".goodsPrice").show();
            if(goodstype==2){
                $(".send-group").show();
            }else if(goodstype==3){
                $("#type_virtual").show();
            }else if(goodstype==4){
                $(".goodsPrice").hide();
                $(".interval").show();
            }
        });
        /*
        * 商品自动上架
        * */
        $("input[name=isstatustime]").off('click').on('click',function () {
            if($(this).val()==1){
                $("#shelves").show()
            }else{
                $("#shelves").hide();
            }
        })
        /*
        * 标签tab切换
        * */
        $("#crectgoods li").off("click").on("click",function () {
            var tab = $("#tab").val();
            var type = $(this).attr("data-type");

            var goodsname = $("#goodsname").val();
            var thumb = $("input[name='thumbs[]']").val();
            var marketprice = parseFloat($("#marketprice").val()).toFixed(2);

            /*商品名称，售价必填*/
            if(goodsname==''){
                tip.msgbox.err("请填写商品名称");
                $("#goodsname").focus();
                return;
            }
            if(thumb==undefined){
                tip.msgbox.err("请填写上传图片");
                return;
            }
            var goodsType = $("input[name='type']:checked").val();
            if(goodsType!='4') {
                if (marketprice <= 0 || isNaN(marketprice)) {
                    tip.msgbox.err("请填写商品售价");
                    $("#marketprice").focus();
                    return;
                }
            }
            if(type=='list'){
                if($(this).hasClass("active")){
                    return false;
                }else{
                    $("#crectgoods li").removeClass("active");
                    $("div.tab-pane").removeClass("active");
                    $(this).addClass("active");
                    $("#"+type+"").addClass("active");
                    $("#tab").val(type);
                    $("#prev").hide();
                    $("#next").show();
                    $("input:submit").hide();
                }
            }else if(type=='basic'){
                if($(this).hasClass("active")){
                    return false;
                }else{
                    $("#crectgoods li").removeClass("active");
                    $("div.tab-pane").removeClass("active");
                    $(this).addClass("active");
                    $("#"+type+"").addClass("active");
                    $("#tab").val(type);
                    $("#prev").show();
                    $("#next").show();
                    $("input:submit").hide();
                }
            }else if(type=='sale'){
                if($(this).hasClass("active")){
                    return false;
                }else{
                    $("#crectgoods li").removeClass("active");
                    $("div.tab-pane").removeClass("active");
                    $(this).addClass("active");
                    $("#"+type+"").addClass("active");
                    $("#tab").val(type);
                    $("#prev").show();
                    $("#next").hide();
                    $("input:submit").show();
                }
            }
        });
        /*下一步操作*/
        $("#next").on("click",function () {
            var tab = $("#tab").val();
            var goodsname = $.trim($("#goodsname").val());
            var thumb = $("input[name='thumbs[]']").val();
            var marketprice = parseFloat($("#marketprice").val()).toFixed(2);
            /*商品名称，售价必填*/
            if(goodsname==''){
                tip.msgbox.err("请填写商品名称");
                $("#goodsname").focus();
                return;
            }
            if(thumb==undefined){
                tip.msgbox.err("请填写上传图片");
                return;
            }
            var goodsType = $("input[name='type']:checked").val();
            if(goodsType !=4) {
                if (marketprice <= 0 || isNaN(marketprice)) {
                    tip.msgbox.err("请填写商品售价");
                    $("#marketprice").focus();
                    return;
                }
            }
            if(tab=='list'){
                $("#crectgoods li").removeClass("active");
                $("div.tab-pane").removeClass("active");
                $("#basic_li").addClass("active");
                $("#basic").addClass("active");
                $("#tab").val('basic');
                $("#prev").show();
            }else if(tab=='basic'){
                $("#crectgoods li").removeClass("active");
                $("div.tab-pane").removeClass("active");
                $("#sale_li").addClass("active");
                $("#sale").addClass("active");
                $("#tab").val('sale');
                $("#prev").show();
                $("#next").hide();
                $("input:submit").show();
            }
        });
        /*上一步操作*/
        $("#prev").on("click",function () {
            var tab = $("#tab").val();
            if(tab=='sale'){
                $("#crectgoods li").removeClass("active");
                $("div.tab-pane").removeClass("active");
                $("#basic_li").addClass("active");
                $("#basic").addClass("active");
                $("#tab").val('basic');
                $("#prev").show();
                $("#next").show();
                $("input:submit").hide();
            }else if(tab=='basic'){
                $("#crectgoods li").removeClass("active");
                $("div.tab-pane").removeClass("active");
                $("#list_li").addClass("active");
                $("#list").addClass("active");
                $("#tab").val('list');
                $("#prev").hide();
                $("#next").show();
            }
        });
        /**/
        $(".spec_item_thumb").find('i').click(function(){
            var group  =$(this).parent();
            group.find('img').attr('src',"<?php echo EWEI_SHOPV2_LOCAL;?>static/images/nopic100.jpg");
            group.find(':hidden').val('');
            $(this).hide();
            group.find('img').popover('destroy');
        });

        require(['jquery.ui'],function(){
            $('#specs').sortable({
                stop: function(){
                    refreshOptions();
                }
            });
            $('.spec_item_items').sortable(
                {
                    handle:'.fa-arrows',
                    stop: function(){
                        refreshOptions();
                    }
                }
            );
        });
        $("#hasoption").click(function(){
            var obj = $(this);
            if (obj.get(0).checked){
                $('.hasoption').attr('readonly',true);
                $("#tboption").show();
                $("#tbdiscount").show();
                $("#isdiscount_discounts").show();
                $("#isdiscount_discounts_default").hide();
                $("#commission").show();
                $("#commission_default").hide();
                $("#discounts_type1").show().parent().show();
                refreshOptions();
            }else{
                $("#tboption").hide();
                refreshOptions();

                $("#isdiscount_discounts").hide();
                var isdiscount_discounts = $("#isdiscount_discounts").html();
                $("#isdiscount_discounts").html('');
                isdiscount_change();
                $("#isdiscount_discounts").html(isdiscount_discounts);



                $("#tbdiscount").hide();
                $("#isdiscount_discounts_default").show();

                $("#commission_default").show();
                $('.hasoption').removeAttr('readonly');

                $("#discounts_type1").hide().parent().hide();
                $("#discounts_type0").click();
            }
        });
    })
    function selectSpecItemImage(obj){
        util.image('',function(val){
            $(obj).attr('src',val.url).popover({
                trigger: 'hover',
                html: true,
                container: $(document.body),
                content: "<img src='" + val.url  + "' style='width:100px;height:100px;' />",
                placement: 'top'
            });

            var group  =$(obj).parent();

            group.find(':hidden').val(val.attachment), group.find('i').show().unbind('click').click(function(){
                $(obj).attr('src',"<?php echo EWEI_SHOPV2_LOCAL;?>static/images/nopic100.jpg");
                group.find(':hidden').val('');
                group.find('i').hide();
                $(obj).popover('destroy');
            });
        });
    }
    function addSpec(){
        var len = $(".spec_item").length;
        var type = $("input[name='type']:checked").val();
        var virtual = $("#virtual").val();
        if(type==3 && virtual==0 && len>=1){
            tip.msgbox.err('您的商品类型为：虚拟物品(卡密)的多规格形式，只能添加一种规格！');
            return;
        }

        if(type==4 && virtual==0 && len>=2){
            tip.msgbox.err('您的商品类型为：批发商品的多规格形式，只能添加两种规格！');
            return;
        }

        if(type==10 && len>=1){
            tip.msgbox.err('您的商品类型为：话费流量充值，只能添加一种规格！')
            return;
        }

        $("#add-spec").html("正在处理...").attr("disabled", "true").toggleClass("btn-primary");
        var url = "<?php  echo webUrl('goods/tpl',array('tpl'=>'spec'))?>";
        $.ajax({
            "url": url,
            success:function(data){
                $("#add-spec").html('<i class="fa fa-plus"></i> 添加规格').removeAttr("disabled").toggleClass("btn-primary"); ;
                $('#specs').append(data);
                var len = $(".add-specitem").length -1;
                $(".add-specitem:eq(" +len+ ")").focus();
                refreshOptions();
            }
        });
    }
    function removeSpec(specid){
        if (confirm('确认要删除此规格?')){
            $("#spec_" + specid).remove();
            refreshOptions();
        }
    }
    function addSpecItem(specid){
        $("#add-specitem-" + specid).html("正在处理...").attr("disabled", "true");
        var url = "<?php  echo webUrl('goods/tpl',array('tpl'=>'specitem'))?>" + "&specid=" + specid;
        $.ajax({
            "url": url,
            success:function(data){
                $("#add-specitem-" + specid).html('<i class="fa fa-plus"></i> 添加规格项').removeAttr("disabled");
                $('#spec_item_' + specid).append(data);
                var len = $("#spec_" + specid + " .spec_item_title").length -1;
                $("#spec_" + specid + " .spec_item_title:eq(" +len+ ")").focus();
                refreshOptions
                if(type==3 && virtual==0){
                    $(".choosetemp").show();
                }
            }
        });
    }
    function removeSpecItem(obj){
        $(obj).closest('.spec_item_item').remove();
        refreshOptions();
    }

    function refreshOptions(){
        var html = '<table class="table table-bordered table-condensed"><thead><tr class="active">';
        var specs = [];
        if($('.spec_item').length<=0){
            $("#options").html('');
            $("#discount").html('');
            $("#isdiscount_discounts").html('');
            $("#commission").html('');
            <?php  if(p('commission') && !empty($com_set['level'])) { ?>
            commission_change();
            <?php  } ?>
            isdiscount_change();
            return;
        }
        $(".spec_item").each(function(i){
            var _this = $(this);

            var spec = {
                id: _this.find(".spec_id").val(),
                title: _this.find(".spec_title").val()
            };

            var items = [];
            _this.find(".spec_item_item").each(function(){
                var __this = $(this);
                var item = {
                    id: __this.find(".spec_item_id").val(),
                    title: __this.find(".spec_item_title").val(),
                    virtual: __this.find(".spec_item_virtual").val(),
                    show:__this.find(".spec_item_show").get(0).checked?"1":"0"
                }
                items.push(item);
            });
            spec.items = items;
            specs.push(spec);
        });
        specs.sort(function(x,y){
            if (x.items.length > y.items.length){
                return 1;
            }
            if (x.items.length < y.items.length) {
                return -1;
            }
        });

        var len = specs.length;
        var newlen = 1;
        var h = new Array(len);
        var rowspans = new Array(len);
        for(var i=0;i<len;i++){
            html+="<th>" + specs[i].title + "</th>";
            var itemlen = specs[i].items.length;
            if(itemlen<=0) { itemlen = 1 };
            newlen*=itemlen;

            h[i] = new Array(newlen);
            for(var j=0;j<newlen;j++){
                h[i][j] = new Array();
            }
            var l = specs[i].items.length;
            rowspans[i] = 1;
            for(j=i+1;j<len;j++){
                rowspans[i]*= specs[j].items.length;
            }
        }

        html += '<th><div class=""><div style="padding-bottom:10px;text-align:center;">库存</div><div class="input-group"><input type="text" class="form-control  input-sm option_stock_all"VALUE=""/><span class="input-group-addon"><a href="javascript:;" class="fa fa-angle-double-down" title="批量设置" onclick="setCol(\'option_stock\');"></a></span></div></div></th>';
        html += '<th><div class=""><div style="padding-bottom:10px;text-align:center;">预售价</div><div class="input-group"><input type="text" class="form-control  input-sm option_presell_all"VALUE=""/><span class="input-group-addon"><a href="javascript:;" class="fa fa-angle-double-down" title="批量设置" onclick="setCol(\'option_presell\');"></a></span></div></div></th>';
        html += '<th><div class=""><div style="padding-bottom:10px;text-align:center;">现价</div><div class="input-group"><input type="text" class="form-control  input-sm option_marketprice_all"VALUE=""/><span class="input-group-addon"><a href="javascript:;" class="fa fa-angle-double-down" title="批量设置" onclick="setCol(\'option_marketprice\');"></a></span></div></div></th>';
        html+='<th><div class=""><div style="padding-bottom:10px;text-align:center;">原价</div><div class="input-group"><input type="text" class="form-control  input-sm option_productprice_all"VALUE=""/><span class="input-group-addon"><a href="javascript:;" class="fa fa-angle-double-down" title="批量设置" onclick="setCol(\'option_productprice\');"></a></span></div></div></th>';
        html+='<th><div class=""><div style="padding-bottom:10px;text-align:center;">成本价</div><div class="input-group"><input type="text" class="form-control  input-sm option_costprice_all"VALUE=""/><span class="input-group-addon"><a href="javascript:;" class="fa fa-angle-double-down" title="批量设置" onclick="setCol(\'option_costprice\');"></a></span></div></div></th>';
        html+='<th><div class=""><div style="padding-bottom:10px;text-align:center;">编码</div><div class="input-group"><input type="text" class="form-control  input-sm option_goodssn_all"VALUE=""/><span class="input-group-addon"><a href="javascript:;" class="fa fa-angle-double-down" title="批量设置" onclick="setCol(\'option_goodssn\');"></a></span></div></div></th>';
        html+='<th><div class=""><div style="padding-bottom:10px;text-align:center;">条码</div><div class="input-group"><input type="text" class="form-control  input-sm option_productsn_all"VALUE=""/><span class="input-group-addon"><a href="javascript:;" class="fa fa-angle-double-down" title="批量设置" onclick="setCol(\'option_productsn\');"></a></span></div></div></th>';
        html+='<th><div class=""><div style="padding-bottom:10px;text-align:center;">重量（克）</div><div class="input-group"><input type="text" class="form-control  input-sm option_weight_all"VALUE=""/><span class="input-group-addon"><a href="javascript:;" class="fa fa-angle-double-down" title="批量设置" onclick="setCol(\'option_weight\');"></a></span></div></div></th>';
        html+='</tr></thead>';

        for(var m=0;m<len;m++){
            var k = 0,kid = 0,n=0;
            for(var j=0;j<newlen;j++){
                var rowspan = rowspans[m];
                if( j % rowspan==0){
                    h[m][j]={title: specs[m].items[kid].title, virtual: specs[m].items[kid].virtual,html: "<td class='full' rowspan='" +rowspan + "'>"+ specs[m].items[kid].title+"</td>\r\n",id: specs[m].items[kid].id};
                }
                else{
                    h[m][j]={title:specs[m].items[kid].title,virtual: specs[m].items[kid].virtual, html: "",id: specs[m].items[kid].id};
                }
                n++;
                if(n==rowspan){
                    kid++; if(kid>specs[m].items.length-1) { kid=0; }
                    n=0;
                }
            }
        }

        var hh = "";
        for(var i=0;i<newlen;i++){
            hh+="<tr>";
            var ids = [];
            var titles = [];
            var virtuals = [];
            for(var j=0;j<len;j++){
                hh+=h[j][i].html;
                ids.push( h[j][i].id);
                titles.push( h[j][i].title);
                virtuals.push( h[j][i].virtual);
            }
            ids =ids.join('_');
            titles= titles.join('+');

            var val ={ id : "",title:titles, stock : "",presell : "",costprice : "",productprice : "",marketprice : "",weight:"",productsn:"",goodssn:"",virtual:virtuals };
            if( $(".option_id_" + ids).length>0){
                val ={
                    id : $(".option_id_" + ids+":eq(0)").val(),
                    title: titles,
                    stock : $(".option_stock_" + ids+":eq(0)").val(),
                    presell : $(".option_presell_" + ids+":eq(0)").val(),
                    costprice : $(".option_costprice_" + ids+":eq(0)").val(),
                    productprice : $(".option_productprice_" + ids+":eq(0)").val(),
                    marketprice : $(".option_marketprice_" + ids +":eq(0)").val(),
                    goodssn : $(".option_goodssn_" + ids +":eq(0)").val(),
                    productsn : $(".option_productsn_" + ids +":eq(0)").val(),
                    weight : $(".option_weight_" + ids+":eq(0)").val(),
                    virtual : virtuals
                }
            }

            hh += '<td>'
            hh += '<input data-name="option_stock_' + ids +'" type="text" class="form-control option_stock option_stock_' + ids +'" value="' +(val.stock=='undefined'?'':val.stock )+'"/></td>';
            hh += '<input data-name="option_id_' + ids+'" type="hidden" class="form-control option_id option_id_' + ids +'" value="' +(val.id=='undefined'?'':val.id )+'"/>';
            hh += '<input data-name="option_ids" type="hidden" class="form-control option_ids option_ids_' + ids +'" value="' + ids +'"/>';
            hh += '<input data-name="option_title_' + ids +'" type="hidden" class="form-control option_title option_title_' + ids +'" value="' +(val.title=='undefined'?'':val.title )+'"/></td>';
            hh += '<input data-name="option_virtual_' + ids +'" type="hidden" class="form-control option_virtual option_virtual_' + ids +'" value="' +(val.virtual=='undefined'?'':val.virtual )+'"/></td>';
            hh += '</td>';
            hh += '<td><input data-name="option_presell_' + ids+'" type="text" class="form-control option_presell option_presell_' + ids +'" value="' +(val.presell=='undefined'?'':val.presell )+'"/></td>';
            hh += '<td><input data-name="option_marketprice_' + ids+'" type="text" class="form-control option_marketprice option_marketprice_' + ids +'" value="' +(val.marketprice=='undefined'?'':val.marketprice )+'"/></td>';
            hh += '<td><input data-name="option_productprice_' + ids+'" type="text" class="form-control option_productprice option_productprice_' + ids +'" " value="' +(val.productprice=='undefined'?'':val.productprice )+'"/></td>';
            hh += '<td><input data-name="option_costprice_' +ids+'" type="text" class="form-control option_costprice option_costprice_' + ids +'" " value="' +(val.costprice=='undefined'?'':val.costprice )+'"/></td>';
            hh += '<td><input data-name="option_goodssn_' +ids+'" type="text" class="form-control option_goodssn option_goodssn_' + ids +'" " value="' +(val.goodssn=='undefined'?'':val.goodssn )+'"/></td>';
            hh += '<td><input data-name="option_productsn_' +ids+'" type="text" class="form-control option_productsn option_productsn_' + ids +'" " value="' +(val.productsn=='undefined'?'':val.productsn )+'"/></td>';
            hh += '<td><input data-name="option_weight_' + ids +'" type="text" class="form-control option_weight option_weight_' + ids +'" " value="' +(val.weight=='undefined'?'':val.weight )+'"/></td>';
            hh += "</tr>";
        }
        html+=hh;
        html+="</table>";
        $("#options").html(html);
        refreshDiscount();
        refreshIsDiscount();
        <?php  if(p('commission') && !empty($com_set['level'])) { ?>
        refreshCommission();
        commission_change();
        <?php  } ?>
        isdiscount_change();
    }

    function refreshDiscount() {
        var html = '<table class="table table-bordered table-condensed"><thead><tr class="active">';
        var specs = [];

        $(".spec_item").each(function (i) {
            var _this = $(this);

            var spec = {
                id: _this.find(".spec_id").val(),
                title: _this.find(".spec_title").val()
            };

            var items = [];
            _this.find(".spec_item_item").each(function () {
                var __this = $(this);
                var item = {
                    id: __this.find(".spec_item_id").val(),
                    title: __this.find(".spec_item_title").val(),
                    virtual: __this.find(".spec_item_virtual").val(),
                    show: __this.find(".spec_item_show").get(0).checked ? "1" : "0"
                }
                items.push(item);
            });
            spec.items = items;
            specs.push(spec);
        });
        specs.sort(function (x, y) {
            if (x.items.length > y.items.length) {
                return 1;
            }
            if (x.items.length < y.items.length) {
                return -1;
            }
        });

        var len = specs.length;
        var newlen = 1;
        var h = new Array(len);
        var rowspans = new Array(len);
        for (var i = 0; i < len; i++) {
            html += "<th>" + specs[i].title + "</th>";
            var itemlen = specs[i].items.length;
            if (itemlen <= 0) {
                itemlen = 1
            }
            ;
            newlen *= itemlen;

            h[i] = new Array(newlen);
            for (var j = 0; j < newlen; j++) {
                h[i][j] = new Array();
            }
            var l = specs[i].items.length;
            rowspans[i] = 1;
            for (j = i + 1; j < len; j++) {
                rowspans[i] *= specs[j].items.length;
            }
        }

        <?php  if(is_array($levels)) { foreach($levels as $level) { ?>
        <?php  if($level['key']=='default') { ?>
        html += '<th><div class=""><div style="padding-bottom:10px;text-align:center;"><?php  echo $level['levelname'];?></div><div class="input-group"><input type="text" class="form-control  input-sm discount_<?php  echo $level["key"];?>_all"VALUE=""/><span class="input-group-addon"><a href="javascript:;" class="fa fa-angle-double-down" title="批量设置" onclick="setCol(\'discount_<?php  echo $level["key"];?>\');"></a></span></div></div></th>';
        <?php  } else { ?>
        html += '<th><div class=""><div style="padding-bottom:10px;text-align:center;"><?php  echo $level['levelname'];?></div><div class="input-group"><input type="text" class="form-control  input-sm discount_level<?php  echo $level['id'];?>_all"VALUE=""/><span class="input-group-addon"><a href="javascript:;" class="fa fa-angle-double-down" title="批量设置" onclick="setCol(\'discount_level<?php  echo $level['id'];?>\');"></a></span></div></div></th>';
        <?php  } ?>
        <?php  } } ?>
        html += '</tr></thead>';

        for (var m = 0; m < len; m++) {
            var k = 0, kid = 0, n = 0;
            for (var j = 0; j < newlen; j++) {
                var rowspan = rowspans[m];
                if (j % rowspan == 0) {
                    h[m][j] = {
                        title: specs[m].items[kid].title,
                        virtual: specs[m].items[kid].virtual,
                        html: "<td class='full' rowspan='" + rowspan + "'>" + specs[m].items[kid].title + "</td>\r\n",
                        id: specs[m].items[kid].id
                    };
                }
                else {
                    h[m][j] = {
                        title: specs[m].items[kid].title,
                        virtual: specs[m].items[kid].virtual,
                        html: "",
                        id: specs[m].items[kid].id
                    };
                }
                n++;
                if (n == rowspan) {
                    kid++;
                    if (kid > specs[m].items.length - 1) {
                        kid = 0;
                    }
                    n = 0;
                }
            }
        }

        var hh = "";
        for (var i = 0; i < newlen; i++) {
            hh += "<tr>";
            var ids = [];
            var titles = [];
            var virtuals = [];
            for (var j = 0; j < len; j++) {
                hh += h[j][i].html;
                ids.push(h[j][i].id);
                titles.push(h[j][i].title);
                virtuals.push(h[j][i].virtual);
            }
            ids = ids.join('_');
            titles = titles.join('+');
            var val = {
                id: "",
                title: titles,
            <?php  if(is_array($levels)) { foreach($levels as $level) { ?>
            <?php  if($level['key']=='default') { ?>
            level<?php  echo $level['key'];?>: '',
            <?php  } else { ?>
            level<?php  echo $level['id'];?>: '',
            <?php  } ?>
            <?php  } } ?>
            costprice: "",
                    presell: "",
                    productprice: "",
                    marketprice: "",
                    weight: "",
                    productsn: "",
                    goodssn: "",
                    virtual: virtuals
        };

            var val ={ id : "",title:titles,<?php  if(is_array($levels)) { foreach($levels as $level) { ?><?php  if($level['key']=='default') { ?> level<?php  echo $level['key'];?>: '',<?php  } else { ?> level<?php  echo $level['id'];?>: '',<?php  } ?><?php  } } ?>costprice : "",productprice : "",marketprice : "",weight:"",productsn:"",goodssn:"",virtual:virtuals };
            if ($(".discount_id_" + ids).length > 0) {
                val = {
                    id: $(".discount_id_" + ids + ":eq(0)").val(),
                    title: titles,
                <?php  if(is_array($levels)) { foreach($levels as $level) { ?>
                <?php  if($level['key']=='default') { ?>
                level<?php  echo $level['key'];?>: $(".discount_<?php  echo $level['key'];?>_" + ids + ":eq(0)").val(),
                <?php  } else { ?>
                level<?php  echo $level['id'];?>: $(".discount_level<?php  echo $level['id'];?>_" + ids + ":eq(0)").val(),
                <?php  } ?>
                <?php  } } ?>
                costprice: $(".discount_costprice_" + ids + ":eq(0)").val(),
                        presell: $(".discount_presell_" + ids + ":eq(0)").val(),
                        productprice: $(".discount_productprice_" + ids + ":eq(0)").val(),
                        marketprice: $(".discount_marketprice_" + ids + ":eq(0)").val(),
                        presell: $(".discount_presell_" + ids + ":eq(0)").val(),
                        goodssn: $(".discount_goodssn_" + ids + ":eq(0)").val(),
                        productsn: $(".discount_productsn_" + ids + ":eq(0)").val(),
                        weight: $(".discount_weight_" + ids + ":eq(0)").val(),
                        virtual: virtuals
            }
            }

            <?php  if(is_array($levels)) { foreach($levels as $level) { ?>
            hh += '<td>'
            <?php  if($level['key']=='default') { ?>
            hh += '<input data-name="discount_level_<?php  echo $level['key'];?>_' + ids +'"type="text" class="form-control discount_<?php  echo $level['key'];?> discount_<?php  echo $level['key'];?>_' + ids +'" value="' +(val.level<?php  echo $level['key'];?>=='undefined'?'':val.level<?php  echo $level['key'];?> )+'"/>';
            <?php  } else { ?>
            hh += '<input data-name="discount_level_<?php  echo $level['id'];?>_' + ids +'"type="text" class="form-control discount_level<?php  echo $level['id'];?> discount_level<?php  echo $level['id'];?>_' + ids +'" value="' +(val.level<?php  echo $level['id'];?>=='undefined'?'':val.level<?php  echo $level['id'];?> )+'"/>';
            <?php  } ?>
            hh += '</td>';
            <?php  } } ?>
            hh += '<input data-name="discount_id_' + ids+'"type="hidden" class="form-control discount_id discount_id_' + ids +'" value="' +(val.id=='undefined'?'':val.id )+'"/>';
            hh += '<input data-name="discount_ids"type="hidden" class="form-control discount_ids discount_ids_' + ids +'" value="' + ids +'"/>';
            hh += '<input data-name="discount_title_' + ids +'"type="hidden" class="form-control discount_title discount_title_' + ids +'" value="' +(val.title=='undefined'?'':val.title )+'"/></td>';
            hh += '<input data-name="discount_virtual_' + ids +'"type="hidden" class="form-control discount_virtual discount_virtual_' + ids +'" value="' +(val.virtual=='undefined'?'':val.virtual )+'"/></td>';
            hh += "</tr>";
        }
        html += hh;
        html += "</table>";
        $("#discount").html(html);
    }

    function refreshIsDiscount() {
        var html = '<table class="table table-bordered table-condensed"><thead><tr class="active">';
        var specs = [];

        $(".spec_item").each(function (i) {
            var _this = $(this);

            var spec = {
                id: _this.find(".spec_id").val(),
                title: _this.find(".spec_title").val()
            };

            var items = [];
            _this.find(".spec_item_item").each(function () {
                var __this = $(this);
                var item = {
                    id: __this.find(".spec_item_id").val(),
                    title: __this.find(".spec_item_title").val(),
                    virtual: __this.find(".spec_item_virtual").val(),
                    show: __this.find(".spec_item_show").get(0).checked ? "1" : "0"
                }
                items.push(item);
            });
            spec.items = items;
            specs.push(spec);
        });
        specs.sort(function (x, y) {
            if (x.items.length > y.items.length) {
                return 1;
            }
            if (x.items.length < y.items.length) {
                return -1;
            }
        });

        var len = specs.length;
        var newlen = 1;
        var h = new Array(len);
        var rowspans = new Array(len);
        for (var i = 0; i < len; i++) {
            html += "<th>" + specs[i].title + "</th>";
            var itemlen = specs[i].items.length;
            if (itemlen <= 0) {
                itemlen = 1
            }
            ;
            newlen *= itemlen;

            h[i] = new Array(newlen);
            for (var j = 0; j < newlen; j++) {
                h[i][j] = new Array();
            }
            var l = specs[i].items.length;
            rowspans[i] = 1;
            for (j = i + 1; j < len; j++) {
                rowspans[i] *= specs[j].items.length;
            }
        }

        <?php  if(is_array($levels)) { foreach($levels as $level) { ?>
        <?php  if($level['key']=='default') { ?>
        html += '<th><div class=""><div style="padding-bottom:10px;text-align:center;"><?php  echo $level['levelname'];?></div><div class="input-group"><input type="text" class="form-control  input-sm isdiscount_discounts_<?php  echo $level['key'];?>_all"VALUE=""/><span class="input-group-addon"><a href="javascript:;" class="fa fa-angle-double-down" title="批量设置" onclick="setCol(\'isdiscount_discounts_<?php  echo $level['key'];?>\');"></a></span></div></div></th>';
        <?php  } else { ?>
        html += '<th><div class=""><div style="padding-bottom:10px;text-align:center;"><?php  echo $level['levelname'];?></div><div class="input-group"><input type="text" class="form-control  input-sm isdiscount_discounts_level<?php  echo $level['id'];?>_all"VALUE=""/><span class="input-group-addon"><a href="javascript:;" class="fa fa-angle-double-down" title="批量设置" onclick="setCol(\'isdiscount_discounts_level<?php  echo $level['id'];?>\');"></a></span></div></div></th>';
        <?php  } ?>
        <?php  } } ?>
        html += '</tr></thead>';

        for (var m = 0; m < len; m++) {
            var k = 0, kid = 0, n = 0;
            for (var j = 0; j < newlen; j++) {
                var rowspan = rowspans[m];
                if (j % rowspan == 0) {
                    h[m][j] = {
                        title: specs[m].items[kid].title,
                        virtual: specs[m].items[kid].virtual,
                        html: "<td class='full' rowspan='" + rowspan + "'>" + specs[m].items[kid].title + "</td>\r\n",
                        id: specs[m].items[kid].id
                    };
                }
                else {
                    h[m][j] = {
                        title: specs[m].items[kid].title,
                        virtual: specs[m].items[kid].virtual,
                        html: "",
                        id: specs[m].items[kid].id
                    };
                }
                n++;
                if (n == rowspan) {
                    kid++;
                    if (kid > specs[m].items.length - 1) {
                        kid = 0;
                    }
                    n = 0;
                }
            }
        }

        var hh = "";
        for (var i = 0; i < newlen; i++) {
            hh += "<tr>";
            var ids = [];
            var titles = [];
            var virtuals = [];
            for (var j = 0; j < len; j++) {
                hh += h[j][i].html;
                ids.push(h[j][i].id);
                titles.push(h[j][i].title);
                virtuals.push(h[j][i].virtual);
            }
            ids = ids.join('_');
            titles = titles.join('+');
            var val = {
                id: "",
                title: titles,
            <?php  if(is_array($levels)) { foreach($levels as $level) { ?>
            <?php  if($level['key']=='default') { ?>
            level<?php  echo $level['key'];?>: '',
            <?php  } else { ?>
            level<?php  echo $level['if'];?>: '',
            <?php  } ?>
            <?php  } } ?>
            costprice: "",
                    presell: "",
                    productprice: "",
                    marketprice: "",
                    weight: "",
                    productsn: "",
                    goodssn: "",
                    virtual: virtuals
        };

            var val ={ id : "",title:titles,<?php  if(is_array($levels)) { foreach($levels as $level) { ?><?php  if($level['key']=='default') { ?> level<?php  echo $level['key'];?>: '',<?php  } else { ?> level<?php  echo $level['id'];?>: '',<?php  } ?><?php  } } ?>costprice : "",productprice : "",marketprice : "",weight:"",productsn:"",goodssn:"",virtual:virtuals };
            if ($(".isdiscount_discounts_id_" + ids).length > 0) {
                val = {
                    id: $(".isdiscount_discounts_id_" + ids + ":eq(0)").val(),
                    title: titles,
                <?php  if(is_array($levels)) { foreach($levels as $level) { ?>
                <?php  if($level['key']=='default') { ?>
                level<?php  echo $level['key'];?>: $(".isdiscount_discounts_<?php  echo $level['key'];?>_" + ids + ":eq(0)").val(),
                <?php  } else { ?>
                level<?php  echo $level['id'];?>: $(".isdiscount_discounts_level<?php  echo $level['id'];?>_" + ids + ":eq(0)").val(),
                <?php  } ?>
                <?php  } } ?>
                costprice: $(".isdiscount_discounts_costprice_" + ids + ":eq(0)").val(),
                        productprice: $(".isdiscount_discounts_productprice_" + ids + ":eq(0)").val(),
                        marketprice: $(".isdiscount_discounts_marketprice_" + ids + ":eq(0)").val(),
                        presell: $(".isdiscount_discounts_presell_" + ids + ":eq(0)").val(),
                        goodssn: $(".isdiscount_discounts_goodssn_" + ids + ":eq(0)").val(),
                        productsn: $(".isdiscount_discounts_productsn_" + ids + ":eq(0)").val(),
                        weight: $(".isdiscount_discounts_weight_" + ids + ":eq(0)").val(),
                        virtual: virtuals
            }
            }

            <?php  if(is_array($levels)) { foreach($levels as $level) { ?>
            hh += '<td>'
            <?php  if($level['key']=='default') { ?>
            hh += '<input data-name="isdiscount_discounts_level_<?php  echo $level['key'];?>_' + ids +'"type="text" class="form-control isdiscount_discounts_<?php  echo $level['key'];?> isdiscount_discounts_<?php  echo $level['key'];?>_' + ids +'" value="' +(val.level<?php  echo $level['key'];?>=='undefined'?'':val.level<?php  echo $level['key'];?> )+'"/>';
            <?php  } else { ?>
            hh += '<input data-name="isdiscount_discounts_level_<?php  echo $level['id'];?>_' + ids +'"type="text" class="form-control isdiscount_discounts_level<?php  echo $level['id'];?> isdiscount_discounts_level<?php  echo $level['id'];?>_' + ids +'" value="' +(val.level<?php  echo $level['id'];?>=='undefined'?'':val.level<?php  echo $level['id'];?> )+'"/>';
            <?php  } ?>
            hh += '</td>';
            <?php  } } ?>
            hh += '<input data-name="isdiscount_discounts_id_' + ids+'"type="hidden" class="form-control isdiscount_discounts_id isdiscount_discounts_id_' + ids +'" value="' +(val.id=='undefined'?'':val.id )+'"/>';
            hh += '<input data-name="isdiscount_discounts_ids"type="hidden" class="form-control isdiscount_discounts_ids isdiscount_discounts_ids_' + ids +'" value="' + ids +'"/>';
            hh += '<input data-name="isdiscount_discounts_title_' + ids +'"type="hidden" class="form-control isdiscount_discounts_title isdiscount_discounts_title_' + ids +'" value="' +(val.title=='undefined'?'':val.title )+'"/></td>';
            hh += '<input data-name="isdiscount_discounts_virtual_' + ids +'"type="hidden" class="form-control isdiscount_discounts_virtual isdiscount_discounts_virtual_' + ids +'" value="' +(val.virtual=='undefined'?'':val.virtual )+'"/></td>';
            hh += "</tr>";
        }
        html += hh;
        html += "</table>";
        $("#isdiscount_discounts").html(html);
    }

    function refreshCommission() {
        var commission_level = <?php  echo json_encode($commission_level)?>;
        var html = '<table class="table table-bordered table-condensed"><thead><tr class="active">';
        var specs = [];

        $(".spec_item").each(function (i) {
            var _this = $(this);

            var spec = {
                id: _this.find(".spec_id").val(),
                title: _this.find(".spec_title").val()
            };

            var items = [];
            _this.find(".spec_item_item").each(function () {
                var __this = $(this);
                var item = {
                    id: __this.find(".spec_item_id").val(),
                    title: __this.find(".spec_item_title").val(),
                    virtual: __this.find(".spec_item_virtual").val(),
                    show: __this.find(".spec_item_show").get(0).checked ? "1" : "0"
                }
                items.push(item);
            });
            spec.items = items;
            specs.push(spec);
        });
        specs.sort(function (x, y) {
            if (x.items.length > y.items.length) {
                return 1;
            }
            if (x.items.length < y.items.length) {
                return -1;
            }
        });

        var len = specs.length;
        var newlen = 1;
        var h = new Array(len);
        var rowspans = new Array(len);
        for (var i = 0; i < len; i++) {
            html += "<th>" + specs[i].title + "</th>";
            var itemlen = specs[i].items.length;
            if (itemlen <= 0) {
                itemlen = 1
            }
            ;
            newlen *= itemlen;

            h[i] = new Array(newlen);
            for (var j = 0; j < newlen; j++) {
                h[i][j] = new Array();
            }
            var l = specs[i].items.length;
            rowspans[i] = 1;
            for (j = i + 1; j < len; j++) {
                rowspans[i] *= specs[j].items.length;
            }
        }

        $.each(commission_level,function (key,level) {
            html += '<th><div class=""><div style="padding-bottom:10px;text-align:center;">'+level.levelname+'</div></div></th>';
        })
        html += '</tr></thead>';

        for (var m = 0; m < len; m++) {
            var k = 0, kid = 0, n = 0;
            for (var j = 0; j < newlen; j++) {
                var rowspan = rowspans[m];
                if (j % rowspan == 0) {
                    h[m][j] = {
                        title: specs[m].items[kid].title,
                        virtual: specs[m].items[kid].virtual,
                        html: "<td class='full' rowspan='" + rowspan + "'>" + specs[m].items[kid].title + "</td>\r\n",
                        id: specs[m].items[kid].id
                    };
                }
                else {
                    h[m][j] = {
                        title: specs[m].items[kid].title,
                        virtual: specs[m].items[kid].virtual,
                        html: "",
                        id: specs[m].items[kid].id
                    };
                }
                n++;
                if (n == rowspan) {
                    kid++;
                    if (kid > specs[m].items.length - 1) {
                        kid = 0;
                    }
                    n = 0;
                }
            }
        }
        var hh = "";
        for (var i = 0; i < newlen; i++) {
            hh += "<tr>";
            var ids = [];
            var titles = [];
            var virtuals = [];
            for (var j = 0; j < len; j++) {
                hh += h[j][i].html;
                ids.push(h[j][i].id);
                titles.push(h[j][i].title);
                virtuals.push(h[j][i].virtual);
            }
            ids = ids.join('_');
            titles = titles.join('+');

            var val = {
                id: "",
                title: titles,
            <?php  if(is_array($commission_level)) { foreach($commission_level as $level) { ?>
            <?php  if($level["key"] == "default") { ?>
            level<?php  echo $level['key'];?>: '',
            <?php  } else { ?>
            level<?php  echo $level['id'];?>: '',
            <?php  } ?>
            <?php  } } ?>
            costprice: "",
                    presell: "",
                    productprice: "",
                    marketprice: "",
                    weight: "",
                    productsn: "",
                    goodssn: "",
                    virtual: virtuals
        };

            var val ={ id : "",title:titles,<?php  if(is_array($commission_level)) { foreach($commission_level as $level) { ?> <?php  if($level["key"] == "default") { ?>level<?php  echo $level['key'];?>: '',<?php  } else { ?>level<?php  echo $level['id'];?>: '',<?php  } ?><?php  } } ?>costprice : "",productprice : "",marketprice : "",weight:"",productsn:"",goodssn:"",virtual:virtuals };
            <?php  if(is_array($commission_level)) { foreach($commission_level as $level) { ?>
            <?php  if($level["key"] == "default") { ?>
            var level<?php  echo $level['key'];?> = new Array(3);
            $(".commission_<?php  echo $level['key'];?>_"+ ids).each(function(index,val){
                level<?php  echo $level['key'];?>[index] = val;
            })
            <?php  } else { ?>
            var level<?php  echo $level['id'];?> = new Array(3);
            $(".commission_level<?php  echo $level['id'];?>_"+ ids).each(function(index,val){
                level<?php  echo $level['id'];?>[index] = val;
            })
            <?php  } ?>
            <?php  } } ?>
            if ($(".commission_id_" + ids).length > 0) {
                val = {
                    id: $(".commission_id_" + ids + ":eq(0)").val(),
                    title: titles,
                    costprice: $(".commission_costprice_" + ids + ":eq(0)").val(),
                    presell: $(".commission_presell_" + ids + ":eq(0)").val(),
                    productprice: $(".commission_productprice_" + ids + ":eq(0)").val(),
                    marketprice: $(".commission_marketprice_" + ids + ":eq(0)").val(),
                    goodssn: $(".commission_goodssn_" + ids + ":eq(0)").val(),
                    productsn: $(".commission_productsn_" + ids + ":eq(0)").val(),
                    weight: $(".commission_weight_" + ids + ":eq(0)").val(),
                    virtual: virtuals
                }
            }
            <?php  if(is_array($commission_level)) { foreach($commission_level as $level) { ?>
            hh += '<td>';
            var level_temp = <?php  if($level['key'] == 'default') { ?>level<?php  echo $level['key'];?><?php  } else { ?>level<?php  echo $level['id'];?><?php  } ?>;
            if (len >= i && typeof (level_temp) != 'undefined')
            {
                if('<?php  echo $level['key'];?>' == 'default')
                {
                    for (var li = 0; li<<?php  echo $shopset_level;?>;li++)
                    {
                        if (typeof (level_temp[li])!= "undefined")
                        {
                            hh += '<input data-name="commission_level_<?php  echo $level['key'];?>_' +ids+ '"  type="text" class="form-control commission_<?php  echo $level['key'];?> commission_<?php  echo $level['key'];?>_' +ids+ '" value="' +$(level_temp[li]).val()+ '" style="display:inline;width: '+96/parseInt(<?php  echo $shopset_level;?>)+'%;"/> ';
                        }
                        else
                        {
                            hh += '<input data-name="commission_level_<?php  echo $level['key'];?>_' +ids+ '"  type="text" class="form-control commission_<?php  echo $level['key'];?> commission_<?php  echo $level['key'];?>_' +ids+ '" value="" style="display:inline;width: '+96/parseInt(<?php  echo $shopset_level;?>)+'%;"/> ';
                        }
                    }
                }
            else
                {
                    for (var li = 0; li<<?php  echo $shopset_level;?>;li++)
                    {
                        if (typeof (level_temp[li])!= "undefined")
                        {
                            hh += '<input data-name="commission_level_<?php  echo $level['id'];?>_' +ids+ '"  type="text" class="form-control commission_level<?php  echo $level['id'];?> commission_level<?php  echo $level['id'];?>_' +ids+ '" value="' +$(level_temp[li]).val()+ '" style="display:inline;width: '+96/parseInt(<?php  echo $shopset_level;?>)+'%;"/> ';
                        }
                        else
                        {
                            hh += '<input data-name="commission_level_<?php  echo $level['id'];?>_' +ids+ '"  type="text" class="form-control commission_level<?php  echo $level['id'];?> commission_level<?php  echo $level['id'];?>_' +ids+ '" value="" style="display:inline;width: '+96/parseInt(<?php  echo $shopset_level;?>)+'%;"/> ';
                        }
                    }
                }
            }
            else
            {
                if('<?php  echo $level['key'];?>' == 'default')
                {
                    for (var li = 0; li<<?php  echo $shopset_level;?>;li++)
                    {
                        if (typeof (level_temp[li])!= "undefined")
                        {
                            hh += '<input data-name="commission_level_<?php  echo $level['key'];?>_' +ids+ '"  type="text" class="form-control commission_<?php  echo $level['key'];?> commission_<?php  echo $level['key'];?>_' +ids+ '" value="' +$(level_temp[li]).val()+ '" style="display:inline;width: '+96/parseInt(<?php  echo $shopset_level;?>)+'%;"/> ';
                        }
                        else
                        {
                            hh += '<input data-name="commission_level_<?php  echo $level['key'];?>_' +ids+ '"  type="text" class="form-control commission_<?php  echo $level['key'];?> commission_<?php  echo $level['key'];?>_' +ids+ '" value="" style="display:inline;width: '+96/parseInt(<?php  echo $shopset_level;?>)+'%;"/> ';
                        }
                    }
                }
            else
                {
                    for (var li = 0; li<<?php  echo $shopset_level;?>;li++)
                    {
                        if (typeof (level_temp[li])!= "undefined")
                        {
                            hh += '<input data-name="commission_level_<?php  echo $level['id'];?>_' +ids+ '"  type="text" class="form-control commission_level<?php  echo $level['id'];?> commission_level<?php  echo $level['id'];?>_' +ids+ '" value="' +$(level_temp[li]).val()+ '" style="display:inline;width: '+96/parseInt(<?php  echo $shopset_level;?>)+'%;"/> ';
                        }
                        else
                        {
                            hh += '<input data-name="commission_level_<?php  echo $level['id'];?>_' +ids+ '"  type="text" class="form-control commission_level<?php  echo $level['id'];?> commission_level<?php  echo $level['id'];?>_' +ids+ '" value="" style="display:inline;width: '+96/parseInt(<?php  echo $shopset_level;?>)+'%;"/> ';
                        }
                    }
                }
            }
            hh += '</td>';
            <?php  } } ?>
            hh += '<input data-name="commission_id_' + ids+'"type="hidden" class="form-control commission_id commission_id_' + ids +'" value="' +(val.id=='undefined'?'':val.id )+'"/>';
            hh += '<input data-name="commission_ids"type="hidden" class="form-control commission_ids commission_ids_' + ids +'" value="' + ids +'"/>';
            hh += '<input data-name="commission_title_' + ids +'"type="hidden" class="form-control commission_title commission_title_' + ids +'" value="' +(val.title=='undefined'?'':val.title )+'"/></td>';
            hh += '<input data-name="commission_virtual_' + ids +'"type="hidden" class="form-control commission_virtual commission_virtual_' + ids +'" value="' +(val.virtual=='undefined'?'':val.virtual )+'"/></td>';
            hh += "</tr>";
        }
        html += hh;
        html += "</table>";
        $("#commission").html(html);
    }

    function setCol(cls){
        $("."+cls).val( $("."+cls+"_all").val());
    }
    function showItem(obj){
        var show = $(obj).get(0).checked?"1":"0";
        $(obj).parents('.spec_item_item').find('.spec_item_show:eq(0)').val(show);
    }
    function nofind(){
        var img=event.srcElement;
        img.src="./resource/image/module-nopic-small.jpg";
        img.onerror=null;
    }

    function choosetemp(id){
        $('#modal-module-chooestemp').modal();
        $('#modal-module-chooestemp').data("temp",id);
    }
    function addtemp(){
        var id = $('#modal-module-chooestemp').data("temp");
        var temp_id = $('#modal-module-chooestemp').find("select").val();
        var temp_name = $('#modal-module-chooestemp option[value='+temp_id+']').text();
        //alert(temp_id+":"+temp_name);
        $("#temp_name_"+id).val(temp_name);
        $("#temp_id_"+id).val(temp_id);
        $('#modal-module-chooestemp .close').click();
        refreshOptions()
    }

    function setinterval(type) {
        var intervalfloor =$('#intervalfloor').val();
        if(intervalfloor=="")
        {
            intervalfloor=0;
        }
        intervalfloor = parseInt(intervalfloor);

        if(type=='plus')
        {
            if(intervalfloor==3)
            {
                tip.msgbox.err("最多添加三个区间价格");
                return;
            }
            intervalfloor=intervalfloor+1;
        }
        else if(type=='minus')
        {
            if(intervalfloor==0)
            {
                tip.msgbox.err("请最少添加一个区间价格");
                return;
            }
            intervalfloor=intervalfloor-1;
        }else
        {
            return;
        }

        if(intervalfloor<1)
        {

            $('#interval1').hide();
            $('#intervalnum1').val("");
            $('#intervalprice1').val("");
        }else
        {
            $('#interval1').show();
        }

        if(intervalfloor<2)
        {

            $('#interval2').hide();
            $('#intervalnum2').val("");
            $('#intervalprice2').val("");
        }else
        {
            $('#interval2').show();
        }

        if(intervalfloor<3)
        {

            $('#interval3').hide();
            $('#intervalnum3').val("");
            $('#intervalprice3').val("");
        }else
        {
            $('#interval3').show();
        }


        $('#intervalfloor').val(intervalfloor);

    }


    /*$(document).ready(function() {
        var Discount = document.getElementById("isdiscount");
        showDiscount(Discount);
    });*/
    function showTime(obj) {
        if (obj.checked) {
            $('#timediv').show();
            $('#isdiscount_time').hide();
            $('input[name="isdiscount"]').removeAttr('checked');
            $('#isdiscount_true').hide();
        } else {
            $('#timediv').hide();
        }
    }
    function showDiscount(obj) {
        if (obj.checked) {
            $('input[name="istime"]').removeAttr('checked');
            $('#timediv').hide();
            $('#isdiscount_time').show();
            $('#isdiscount_true').show();
            $('#saletype').show();
        } else {
            $('#isdiscount_time').hide();
            $('#isdiscount_true').hide();
            $('#saletype').hide();
        }
    }

    function isdiscount_change() {
        var html = '<table class="table table-bordered table-condensed"><thead><tr class="active"><?php  if(is_array($levels)) { foreach($levels as $level) { ?><th><div class=""><div style="padding-bottom:10px;text-align:center;"><?php  echo $level["levelname"];?></div></div></th><?php  } } ?></tr></thead><tbody><tr><?php  if(is_array($levels)) { foreach($levels as $level) { ?><?php  if($level["key"]=="default") { ?><td><input name="isdiscount_discounts_level_<?php  echo $level["key"];?>_default" type="text" class="form-control isdiscount_discounts_<?php  echo $level["key"];?> isdiscount_discounts_<?php  echo $level["key"];?>_default" value="<?php echo is_array($isdiscount_discounts[$level["key"]]["option0"]) ? "" : $isdiscount_discounts[$level["key"]]["option0"];?>" placeholder="会员促销价格单位: 元"></td><?php  } else { ?><td><input name="isdiscount_discounts_level_<?php  echo $level["id"];?>_default" type="text" class="form-control isdiscount_discounts_level<?php  echo $level["id"];?> isdiscount_discounts_level<?php  echo $level["id"];?>_default" value="<?php echo is_array($isdiscount_discounts["level".$level["id"]]["option0"]) ? "" : $isdiscount_discounts["level".$level["id"]]["option0"];?>" placeholder="会员促销价格单位: 元"></td><?php  } ?><?php  } } ?></tr></tbody></table>';
        if ($("#isdiscount_discounts").html()=='')
        {
            $("#isdiscount_discounts_default").html(html);
        }
        else
        {
            $("#isdiscount_discounts_default").html('');
        }
    }

    function type_change(type) {

       if(type == 3) {
            $(".dispatch_info").hide();
        }
    }

    isdiscount_change();

</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
