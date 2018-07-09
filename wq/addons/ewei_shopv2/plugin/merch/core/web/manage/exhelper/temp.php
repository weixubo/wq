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

require EWEI_SHOPV2_PLUGIN . 'merch/core/inc/page_merch.php';
class Temp_EweiShopV2Page extends MerchWebPage {
    function main() {
        header('location: '.merchUrl('exhelper/index'));
    }

    protected function tempData($type){
        global $_W, $_GPC;

        $merchid = $_W['merchid'];

        $pindex = max(1, intval($_GPC['page']));
        $psize = 20;
        $condition = ' uniacid = :uniacid and type=:type and merchid=:merchid';
        $params = array(':uniacid' => $_W['uniacid'], ':type'=>$type, ':merchid'=>$merchid);

        if (!empty($_GPC['keyword'])) {
            $_GPC['keyword'] = trim($_GPC['keyword']);
            $condition .= ' AND expressname LIKE :expressname';
            $params[':expressname'] = '%' . trim($_GPC['keyword']) . '%';
        }

        $sql = 'SELECT id,expressname,expresscom,isdefault FROM ' . tablename('ewei_shop_exhelper_express') . " where  1 and {$condition} ORDER BY isdefault desc, id DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize;
        $list = pdo_fetchall($sql, $params);
        $total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('ewei_shop_exhelper_express') . " where 1 and {$condition}", $params);
        $pager = pagination($total, $pindex, $psize);

        return array(
            'list' => $list,
            'total' => $total,
            'pager' => $pager,
            'type' => $type
        );
    }

    function invoice(){
        global $_W, $_GPC;

        $data = $this->tempData(1);
        extract($data);

        include $this->template('exhelper/temp/index');
    }
    function express(){
        global $_W, $_GPC;

        $data = $this->tempData(2);
        extract($data);

        include $this->template('exhelper/temp/index');
    }

    function add1(){
        $this->post();
    }

    function add2(){
        $this->post();
    }

    function edit1(){
        $this->post();
    }

    function edit2(){
        $this->post();
    }

    function post(){
        global $_W, $_GPC;

        $merchid = $_W['merchid'];

        $id = intval($_GPC['id']);
        $type = trim($_GPC['type']);
        if($type=='temp.invoice'){
            $type = 1;
        }
        elseif($type=='temp.express'){
            $type = 2;
        }

//		if(empty($type) || $type>2){
//			header('location: '.merchUrl('exhelper/index'));
//		}

        if(!empty($id)){
            $item = pdo_fetch("select * from " . tablename('ewei_shop_exhelper_express') . " where id=:id and type=:type and uniacid=:uniacid and merchid=:merchid limit 1", array(":id" => $id, ':type'=>$type ,":uniacid" => $_W['uniacid'], ':merchid'=>$merchid));
        }

        include $this->template('exhelper/temp/post');
    }

    function delete(){

    }

    function setdefault(){
        global $_W, $_GPC;

        $merchid = $_W['merchid'];

        $type = intval($_GPC['type']);
        $id = intval($_GPC['id']);

        if(!empty($type) && !empty($id)){
            $item = pdo_fetch("SELECT id,expressname,type FROM " . tablename('ewei_shop_exhelper_express') . " WHERE id=:id and type=:type AND uniacid=:uniacid and merchid=:merchid" ,array(":id"=>$id, ':type'=>$type,":uniacid"=>$_W['uniacid'], ':merchid'=>$merchid));
            if (!empty($item)) {
                pdo_update('ewei_shop_exhelper_express', array('isdefault'=>0), array('type'=>$type,'uniacid'=>$_W['uniacid'], 'merchid'=>$merchid));
                pdo_update('ewei_shop_exhelper_express',array('isdefault'=>1),array('id'=>$id));
                //plog('merch.exhelper.express.delete',"设置快递单默认信息 ID: {$id} 快递单: {$item['expressname']} ");
            }
        }
        show_json(1);
    }

}