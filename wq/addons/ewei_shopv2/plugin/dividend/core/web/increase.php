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

require EWEI_SHOPV2_PLUGIN.'dividend/core/dividend_page_web.php';
class Increase_EweiShopV2Page extends DividendWebPage  {

	function main() {
		global $_W, $_GPC;


		$days = intval($_GPC['days']);
		if (empty($_GPC['search'])) {
			$days = 7;
		}
//年份
		$years = array();
		$current_year = date('Y');
		$year = $_GPC['year'];
		for ($i = $current_year - 10; $i <= $current_year; $i++) {
			$years[] = array('data' => $i, 'selected' => ($i == $year));
		}
//月份
		$months = array();
		$current_month = date('m');
		$month = $_GPC['month'];
		for ($i = 1; $i <= 12; $i++) {
			$months[] = array('data' => $i, 'selected' => ($i == $month));
		}
//时间字段
		$timefield = 'agenttime';

		$datas = array();
		$title = ''; //标题

		if (!empty($days)) {

			$charttitle = "最近{$days}天增长趋势图";

			for ($i = $days; $i >= 0; $i--) {
				$time = date("Y-m-d", strtotime("-" . $i . " day"));
				$condition = " and uniacid=:uniacid and {$timefield}>=:starttime and {$timefield}<=:endtime";
				$params = array(
					':uniacid' => $_W['uniacid'],
					':starttime' => strtotime("{$time} 00:00:00"),
					':endtime' => strtotime("{$time} 23:59:59")
				);
				$datas[] = array(
					'date' => $time,
					'acount' => pdo_fetchcolumn("select count(*) from " . tablename('ewei_shop_member') . " where isagent=1 and status=1  {$condition}", $params)
				);
			}
		} else if (!empty($year) && !empty($month)) {

			$charttitle = "{$year}年{$month}月增长趋势图";

			$lastday = get_last_day($year, $month);
			for ($d = 1; $d <= $lastday; $d++) {

				$condition = " and uniacid=:uniacid and {$timefield}>=:starttime and {$timefield}<=:endtime";
				$params = array(
					':uniacid' => $_W['uniacid'],
					':starttime' => strtotime("{$year}-{$month}-{$d} 00:00:00"),
					':endtime' => strtotime("{$year}-{$month}-{$d} 23:59:59")
				);
				$datas[] = array(
					'date' => "{$d}日",
					'acount' => pdo_fetchcolumn("select count(*) from " . tablename('ewei_shop_member') . " where isagent=1  {$condition}", $params)
				);
			}
		} else if (!empty($year)) {

			$charttitle = "{$year}年增长趋势图";

			foreach ($months as $m) {
				$lastday = get_last_day($year, $m['data']);
				$condition = " and uniacid=:uniacid and {$timefield}>=:starttime and {$timefield}<=:endtime";
				$params = array(
					':uniacid' => $_W['uniacid'],
					':starttime' => strtotime("{$year}-{$m['data']}-01 00:00:00"),
					':endtime' => strtotime("{$year}-{$m['data']}-{$lastday} 23:59:59")
				);
				$datas[] = array(
					'date' => $m['data'] . "月",
					'acount' => pdo_fetchcolumn("select count(*) from " . tablename('ewei_shop_member') . " where isagent=1  {$condition}", $params)
				);
			}
		}
		include $this->template();
	}

}
