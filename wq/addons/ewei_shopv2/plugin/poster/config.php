
<?php
/*
 * 人人商城
 *
 * 青岛易联互动网络科技有限公司
 * http://www.we7shop.cn
 * TEL: 4000097827/18661772381/15865546761
 */
if(!defined('IN_IA')) {
     exit('Access Denied');
}

return array(
    'version'=>'1.0',
    'id'=>'poster',
    'name'=>'超级海报',
    'v3'=>true,
    'menu'=>array(
        'title'=>'页面',
        'plugincom'=>1,
        'icon'=>'page',
        'items'=>array(
            array(
                'title'=>'海报管理',
                'route'=>'',
                'extends'=>array(
                    'poster.scan'
                )
            )
        )
    )
);