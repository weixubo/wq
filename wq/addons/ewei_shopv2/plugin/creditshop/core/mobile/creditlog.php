<?php
/*
 * 人人商城
 *
 * 青岛易联互动网络科技有限公司
 * http://www.we7shop.cn
 * TEL: 4000097827/18661772381/15865546761
 */
if (!defined('IN_IA')) {
	exit('Access Denied');
}
class Creditlog_EweiShopV2Page extends PluginMobileLoginPage {

	
	function main(){
		global $_W, $_GPC;
		
		$openid = $_W['openid'];
		$uniacid = $_W['uniacid'];
		$credit = intval( m('member')->getCredit($openid, 'credit1') );
		$member = m('member')->getMember($openid);
		//多商户
		$merch_plugin = p('merch');
		$merch_data = m('common')->getPluginset('merch');
		if ($merch_plugin && $merch_data['is_openmerch']) {
			$is_openmerch = 1;
		} else {
			$is_openmerch = 0;
		}
		
		/* 分享 *************/
		$_W['shopshare'] =array(
		    'title' => $this->set['share_title'],
		    'imgUrl' => tomedia($this->set['share_icon']),
		    'link' => mobileUrl('creditshop', array(), true),
		    'desc' => $this->set['share_desc']
		);
		$com = p('commission');
		if ($com) {
		    $cset = $com->getSet();
		    if (!empty($cset)) {
		        if ($member['isagent'] == 1 && $member['status'] == 1) {
		            $_W['shopshare']['link'] = mobileUrl('creditshop', array('mid' => $member['id']), true);
		            if(empty($cset['become_reg']) && ( empty($member['realname']) || empty($member['mobile']))){
		                  $trigger = true;
		            }
		        } else if (!empty($_GPC['mid'])) {
		            $_W['shopshare']['link'] = mobileUrl('creditshop/detail', array('mid' => $_GPC['mid']), true);
		        }
		    }
		}
		include $this->template();
	}	
	
	function getlist(){
		global $_W, $_GPC;
		
		$openid = $_W['openid'];
		$uniacid = $_W['uniacid'];
		$credit = intval( m('member')->getCredit($openid, 'credit1') );
		$merchid = intval($_GPC['merchid']);

		$pindex = max(1, intval($_GPC['page']));
        $psize = 10;
        $condition = ' and log.openid=:openid and log.uniacid = :uniacid';
		if($merchid>0){
			$condition .= " and log.merchid = ".$merchid." ";
		}
        $params = array(':uniacid' => $_W['uniacid'], ':openid' => $openid);
        $sql = 'SELECT COUNT(*) FROM ' . tablename('ewei_shop_creditshop_log') . " log where 1 {$condition}";
        $total = pdo_fetchcolumn($sql, $params);
        $list = array();
        if (!empty($total)) {
            $sql = 'SELECT log.id,log.goodsid,g.title,g.thumb,g.credit,g.type,g.money,log.createtime, log.status, g.thumb FROM ' . tablename('ewei_shop_creditshop_log') . ' log '
                    . ' left join ' . tablename('ewei_shop_creditshop_goods') . ' g on log.goodsid = g.id '
                    . ' where 1 ' . $condition . ' ORDER BY log.createtime DESC LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
            $list = pdo_fetchall($sql, $params);
            $list = set_medias($list, 'thumb');
          foreach ($list as &$row) {
                if ($row['credit'] > 0 & $row['money'] > 0) {
                    $row['acttype'] = 0; //积分+钱
                } else if ($row['credit'] > 0) {
                    $row['acttype'] = 1; //积分
                } else if ($row['money'] > 0) {
                    $row['acttype'] = 2; //钱
                }
                $row['createtime'] = date('Y-m-d H:i:s',$row['createtime']);
            }
            unset($row);
        }
        show_json(1, array('total' => $total, 'list' => $list, 'pagesize' => $psize));
	}
	
}
