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

class Index_EweiShopV2Page extends PluginWebPage {

	function main(){
		if (cv('qa.question')) {
			header('location: ' . webUrl('qa/question'));
		} else if (cv('qa.category')) {
			header('location: ' . webUrl('qa/category'));
		} else if (cv('qa.set')) {
			header('location: ' . webUrl('qa/set'));
		}else {
			header('location: ' . webUrl());
		}
		exit;
	}

}