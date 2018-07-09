<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>

<link rel="stylesheet" type="text/css" href="../addons/ewei_shopv2/template/mobile/default/static/css/coupon-new.css?v=2017030310125">

<script src="../addons/ewei_shopv2/static/js/app/biz/sale/coupon/circle-progress.js"></script>
<link rel="stylesheet" type="text/css" href="../addons/ewei_shopv2/template/mobile/default/static/css/coupon.css?v=2.0.0">
<div class='fui-page fui-page-current'>
	<div class="fui-header">
		<div class="fui-header-left">
			<a class="back"></a>
		</div>
		<div class="title">优惠券领取中心</div>
		<div class="fui-header-right">
			<a href="<?php  echo mobileUrl('sale/coupon/my')?>" class="external">
				<i class="icon icon-person2"></i>
			</a>
		</div>
	</div>
	<div class='fui-content coupon-index-bg'>

		<?php  if(!empty($advs)) { ?>
			<div class='fui-swipe' data-transition="500" data-gap="1"> 
			    <div class='fui-swipe-wrapper'>
					<?php  if(is_array($advs)) { foreach($advs as $adv) { ?>
						<a class='fui-swipe-item' href="<?php  if(!empty($adv['url'])) { ?><?php  echo $adv['url'];?><?php  } else { ?>javascript:;<?php  } ?>"><img src="<?php  echo tomedia($adv['img'])?>" /></a>
					<?php  } } ?>
			    </div>
			    <div class='fui-swipe-page'></div>
			</div>
		<?php  } ?>

		<div class="fui-tab-scroll">
			<div class='container'>
				<span class='item on' data-cateid="">全部优惠券</span>
					<?php  if(is_array($category)) { foreach($category as $item) { ?>
						<span class='item' data-cateid="<?php  echo $item['id'];?>"><?php  echo $item['name'];?></span>
					<?php  } } ?>
			</div>
		</div>
		
		<div class="fui-message fui-message-popup in content-empty" style="display: none; margin-top: 0; padding-top: 0; position: relative; height: auto; background: none;">
				<div class="icon ">
					<i class="icon icon-information"></i>
				</div>
				<div class="content">还没有发布优惠券~</div>
		</div>
		<!--内容加载-->
		<div id='container' class="coupon-container coupon-index-list">
		</div>

		<div class='infinite-loading' style="text-align: center; color: #666;">
	    	<span class='fui-preloader'></span>
	    	<span class='text'> 正在加载...</span>
	    </div>
		<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_copyright', TEMPLATE_INCLUDEPATH)) : (include template('_copyright', TEMPLATE_INCLUDEPATH));?>
	</div>
	<script id='tpl_list_coupon' type='text/html'>
		<%each list as coupon index%>
			<% if coupon.isdisa =='1'%>
				<a class="coupon-item gray"  href="javascript:;" >
			<%else%>
				<% if coupon.contype =='1'%>
					<a  href="javascript:;" onclick="addCard('<%=coupon.card_id%>')" class="coupon-item <%coupon.color%>">
				<% else coupon.contype =='2'%>
					<a href="<?php  echo mobileUrl('sale/coupon/detail')?>&id=<%coupon.id%>" class="coupon-item <%coupon.color%>">
				<% /if %>
			<%/if%>
				<div class="coupon-dots">
					<i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i>
				</div>
				<div class="coupon-type" <% if coupon.settitlecolor ==1 %>style="background:<%coupon.titlecolor%>"<%/if%>><%coupon.tagtitle%></div>
				<div class="coupon-left">
					<div class="title"><%=coupon.title3%></div>
					<div class="subtitle"><%=coupon.title2%></div>
				</div>
				<div class="coupon-right">
					<div class="title"><%coupon.couponname%></div>
					<div class="subtitle"><%=coupon.title5%></div>
					<div class="subtitle light"><%if coupon.t>0%>剩余<%coupon.t%>/<%coupon.last%>张<%/if%></div>
					<div class="usetime">
						<div class="text"><%=coupon.title4%></div>
						<div class="usebtn"><% if coupon.isdisa =='1'%>已发完<%else%>立即领取<%/if%></div>
					</div>
				</div>
			</a>
		<%/each%>
	</script>
	<script  language='javascript'>
		require(['biz/sale/coupon/common'], function (modal) {modal.init();});


		function addCard(card_id) {

			var data = {'openid': '<?php  echo $openid;?>', 'card_id': card_id};
			$.ajax({
				url: "<?php  echo mobileUrl('sale/coupon/getsignature')?>",
				data: data,
				cache: false
			}).done(function (result) {
				var data = jQuery.parseJSON(result);
				if (data.status == 1) {
					wx.addCard({
						cardList: [
							{
								cardId: card_id,
								cardExt: data.result.cardExt
							}
						],
						success: function (res) {
							$.ajax({
								url: "<?php  echo mobileUrl('sale/coupon/updateQuantity')?>",
								data: res,
								cache: false
							}).done(function (result) {

							});
							//alert('已添加卡券：' + JSON.stringify(res.cardList));
						},
						cancel: function (res) {
							//alert(JSON.stringify(res))
						}
					});
				} else {
					alert("微信接口繁忙,请稍后再试!");
					alert(data.result.message);
				}
			});
		}

	</script>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>