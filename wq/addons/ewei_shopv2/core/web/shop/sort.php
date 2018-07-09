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

class Sort_EweiShopV2Page extends WebPage
{

    /**
     *
     */
    function main()
    {

        global $_W, $_GPC;
        $defaults = array(
            'adv' => array('text' => '幻灯片', 'visible' => 1),
            'search' => array('text' => '搜索栏', 'visible' => 1),
            'nav' => array('text' => '导航栏', 'visible' => 1),
            'notice' => array('text' => '公告栏', 'visible' => 1),
            'seckill' => array('text' => '秒杀栏', 'visible' => 1),
            'cube' => array('text' => '魔方栏', 'visible' => 1),
            'banner' => array('text' => '广告栏', 'visible' => 1),
            'goods' => array('text' => '推荐栏', 'visible' => 1)
        );

        if ($_W['ispost']) {

            $datas = json_decode(html_entity_decode($_GPC['datas']), true);

            if (!is_array($datas)) {
                show_json(0, '数据出错');
            }

            $indexsort = array();

            foreach ($datas as $v) {
                $indexsort[$v['id']] = array("text" => $defaults[$v['id']]['text'], "visible" => intval($_GPC['visible'][$v['id']]));
            }

            $shop = $_W['shopset']['shop'];
            $shop['indexsort'] = $indexsort;
            m('common')->updateSysset(array('shop' => $shop));
            plog('shop.sort', '修改首页排版');
            show_json(1);
        }

        $oldsorts = !empty($_W['shopset']['shop']['indexsort']) ? $_W['shopset']['shop']['indexsort'] : $defaults;

        $sorts = array();

        foreach ($oldsorts as $key => $old) {
            $sorts[$key] = $old;
            if ($key == 'notice' && !isset($oldsorts['seckill'])) {
                $sorts['seckill'] = array('text' => '秒杀栏', 'visible' => 0);
            }
        }

        include $this->template();
    }

}
