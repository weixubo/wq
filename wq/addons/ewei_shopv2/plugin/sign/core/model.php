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

class SignModel extends PluginModel
{

    public function getSet() {
        global $_W;

        $set = pdo_fetch("select *  from " . tablename('ewei_shop_sign_set') . " where uniacid=:uniacid limit 1 ", array(':uniacid'=>$_W['uniacid']));

        if(empty($set)){
            return '';
        }

        if(empty($set['textsign'])){
            $set['textsign'] = "签到";
        }
        if(empty($set['textsigned'])){
            $set['textsigned'] = "已签";
        }
        if(empty($set['textsignold'])){
            $set['textsignold'] = "补签";
        }
        if(empty($set['textsignforget'])){
            $set['textsignforget'] = "漏签";
        }
        if(empty($_W['shopset']['trade']['credittext'])){
            $set['textcredit'] = "积分";
        }else{
            $set['textcredit'] = $_W['shopset']['trade']['credittext'];
        }
        if(empty($_W['shopset']['trade']['credittext'])){
            $set['textmoney'] = "余额";
        }else{
            $set['textmoney'] = $_W['shopset']['trade']['moneytext'];
        }

        return $set;
    }

    public function setShare($set=null){
        global $_W;
        session_start();
        if(!empty($_SESSION['sign_xcx_openid'])){
            $_W['openid'] = $_SESSION['sign_xcx_openid'];
        }
        if(empty($set)){
            $set = $this->getSet();
        }
        if(!empty($set['share'])){
            // 定义分享数据
            $_W['shopshare'] = array(
                'title' => $set['title'],
                'imgUrl' => tomedia($set['thumb']),
                'desc' => $set['desc'],
                'link' => mobileUrl('sign', null, true)
            );
            if (p('commission')) {
                $set = p('commission')->getSet();
                if (!empty($set['level'])) {
                    $member = m('member')->getMember($_W['openid']);
                    if (!empty($member) && $member['status'] == 1 && $member['isagent'] == 1) {
                        $_W['shopshare']['link'] = mobileUrl('sign', array('mid' => $member['id']), true);
                    } else if (!empty($_GPC['mid'])) {
                        $_W['shopshare']['link'] = mobileUrl('sign', array('mid' => $_GPC['mid']), true);
                    }
                }
            }
        }
    }

    public function getDate($date = array())
    {
        global $_W;

        if (empty($date)) {
            $date = array(
                'year' => date('y', time()),
                'month' => date('m', time()),
                'day' => date('d', time())
            );
        }


        $lasttime = strtotime($date['year']."-".($date['month']+1)."-1") - 1;
        if($date['month']==12){
            $lasttime_year = $date['year']+1;
            $lasttime = strtotime($lasttime_year."-1-1") - 1;
        }

        $days = date('t', strtotime($date['year'] . "-" . $date['month']));
        $result = array(
            'firstday' => 1,
            'lastday' => $days,
            'firsttime'=>strtotime($date['year']."-".$date['month']."-1"),
            'lasttime'=>$lasttime,
            'year' => $date['year'],
            'thisyear' => date('Y', time()),
            'month' => $date['month'],
            'thismonth'=>date('m', time()),
            'day' => $date['day'],
            'doday' => date('d', time()),
            'days' => $days
        );

        return $result;
    }

    public function getMonth()
    {
        $month = array();
        $start_year = '2016';
        $start_month = '8';
        $this_year = date('Y', time());
        $this_month = date('m', time());

        for($i=$start_year; $i<=$this_year; $i++){
            if($this_year-$i>0){
                $ii_month = 12;
            }else{
                $ii_month = $this_month;
            }
            if($i>$start_year){
                $start_month = 1;
            }
            for ($ii=$start_month; $ii<=$ii_month; $ii++){

                $month[] = array(
                    'year'=>$i,
                    'month'=>$ii<10 ? '0'.$ii : $ii,
                );
            }
        }
        return $month;

    }

    public function getCalendar($year=null, $month=null, $week=true)
    {
        global $_W;
        session_start();
        if(!empty($_SESSION['sign_xcx_openid'])){
            $_W['openid'] = $_SESSION['sign_xcx_openid'];
        }
        if(empty($year)){
            $year = date('Y', time());
        }
        if(empty($month)){
            $month = date('m', time());
        }

        $set = $this->getSet();

        $date = $this->getDate(array('year'=>$year, 'month'=>$month));

        //  1. 创建日历数组
        $array = array();
        $maxday = 28;
        if($date['days']>28){
            $maxday = 35;
        }
        for ($i=1; $i<=$maxday; $i++){
            $day = 0;
            if($i<=$date['days']){
                $day = $i;
            }
            //  today 判断是否当前月的day
            $today = 0;
            if($date['thisyear']==$year && $date['thismonth']==$month && $date['doday']==$i){
                $today = 1;
            }
            $array[$i] = array('year'=>$date['year'], 'month'=>$date['month'], 'day'=>$day, 'date'=>$date['year'].'-'.$date['month'].'-'.$day, 'signed'=>0, 'signold'=>1, 'title'=>'', 'today'=>$today);
        }

        //echo date('Y-m-d H:i:s', '1480521600');

        //  2. 查出 签到记录并 合并
        $records = pdo_fetchall("select *  from " . tablename('ewei_shop_sign_records') . " where openid=:openid and `type`=0 and `time` between :starttime and :endtime and uniacid=:uniacid ", array(':uniacid'=>$_W['uniacid'], ':openid'=>$_W['openid'], ':starttime'=>$date['firsttime'], ':endtime'=>$date['lasttime']));

        if(!empty($records)){
            foreach ($records as $item){
                $sign_date = array(
                    'year'=>date('Y', $item['time']),
                    'month'=>date('m', $item['time']),
                    'day'=>date('d', $item['time'])
                );
                foreach ($array as $day=>&$row){
                    if($day==$sign_date['day']){
                        $row['signed'] = 1;
                    }
                }
                unset($row);
            }
        }

        //  3. 查出 特殊日期 并合并
        $reword_special = iunserializer($set['reword_special']);
        if(!empty($reword_special)){
            foreach ($reword_special as $item){
                $sign_date = array(
                    'year'=>date('Y', $item['date']),
                    'month'=>date('m', $item['date']),
                    'day'=>date('d', $item['date'])
                );
                foreach ($array as $day=>&$row){
                    if($row['day']==$sign_date['day'] && $row['month']==$sign_date['month'] && $row['year']==$sign_date['year']){
                        $row['title'] = $item['title'];
                        $row['color'] = $item['color'];
                    }
                }
                unset($row);
            }
        }

        //  4. 判断是否需要拆分成周
        if($week){
            //  将数组 每七天拆分
            $calendar = array();
            foreach ($array as $index=>$row){
                if($index>=1 && $index<=7){
                    $cindex = 0;
                }
                elseif ($index>=8 && $index<=14){
                    $cindex = 1;
                }
                elseif ($index>=15 && $index<=21){
                    $cindex = 2;
                }
                elseif ($index>=22 && $index<=28){
                    $cindex = 3;
                }
                elseif ($index>=29 && $index<=35){
                    $cindex = 4;
                }
                $calendar[$cindex][] = $row;
            }
        }else{
            $calendar = $array;
        }

        return $calendar;
    }

    //  获取签到信息
    public function getSign($date=null)
    {
        global $_W;
        session_start();
        if(!empty($_SESSION['sign_xcx_openid'])){
            $_W['openid'] = $_SESSION['sign_xcx_openid'];
        }
        $set = $this->getSet();

        $condition = "";

        if(!empty($set['cycle'])){
            $month_start=mktime(0,0,0,date('m'),1,date('Y'));
            $month_end=mktime(23,59,59,date('m'),date('t'),date('Y'));
            $condition .= " and `time` between {$month_start} and {$month_end} ";
        }

        //  根据系统设置 指定时间段查询
        $records = pdo_fetchall("select * from " . tablename('ewei_shop_sign_records') . ' where openid=:openid and `type`=0 and uniacid=:uniacid '. $condition . ' order by `time` desc ', array(':uniacid'=>$_W['uniacid'], ':openid'=>$_W['openid']));

        // 今天是否签到
        $signed = 0;
        $orderindex = 0;
        //  最高连续签到
        $order = array();
        //  连续签到
        $orderday = 0;

        if(!empty($records)){
            foreach ($records as $key=>$item){

                $day = date('Y-m-d', $item['time']);
                $today = date('Y-m-d', time());

                // 处理今日是否签到
                if(empty($date) && $day==$today){
                    $signed = 1;
                }
                if(!empty($date) && $day==$date){
                    $signed = 1;
                }

                if(count($records)>1 && $key==0){
                    if (date('Y-m-d',$records[$key+1]['time']) == date('Y-m-d',strtotime('-1 day'))){
                        $order[$orderindex]++;
                    }
                }

                //  处理最高连续签到
                $dday = date('d', $item['time']);
                $pday = date('d', isset($records[$key+1]['time']) ? $records[$key+1]['time'] : 0);

                if($dday-$pday==1){
                    $order[$orderindex]++;
                }else{
                    if ($dday == 1 && date('d', isset($records[$key+1]['time']) ? $records[$key+1]['time'] : 0) == date('t',strtotime('-1 month',$item['time']))){
                        $order[$orderindex]++;
                    }else{
                        $orderindex++;
                        $order[$orderindex]++;
                    }
                }

                // 处理连续签到
                if($this->dateplus($day, $orderday)==$this->dateminus($today, 1)){
                    $orderday++;
                }
            }
        }

        $data = array(
            'order'=>empty($order)?0:max($order),
            'orderday'=>empty($signed) ? $orderday : $orderday+1,
            'sum'=>count($records),
            'signed'=>$signed
        );

        return $data;
    }

    public function dateplus($date, $day){
        $time = strtotime($date);
        $time = $time + (3600 * 24 * $day);
        $date = date("Y-m-d", $time);
        return$date;
    }

    public function dateminus($date, $day){
        $time = strtotime($date);
        $time = $time - (3600 * 24 * $day);
        $date = date("Y-m-d", $time);
        return$date;
    }

    // 获取高级奖励信息

    public function getAdvAward()
    {
        global $_W;

        $set = $this->getSet();

        $date = $this->getDate();

        $signinfo = $this->getSign();

        $reword_sum = iunserializer($set['reword_sum']);
        $reword_order = iunserializer($set['reword_order']);

        $condition = "";
        if(!empty($set['cycle'])){
            $month_start=mktime(0,0,0,date('m'),1,date('Y'));
            $month_end=mktime(23,59,59,date('m'),date('t'),date('Y'));
            $condition .= " and `time` between {$month_start} and {$month_end} ";
        }

        //  根据系统设置 指定时间段查询
        $records = pdo_fetchall("select * from " . tablename('ewei_shop_sign_records') . ' where openid=:openid and uniacid=:uniacid '. $condition . ' order by `time` asc ', array(':uniacid'=>$_W['uniacid'], ':openid'=>$_W['openid']));
        if(!empty($records)){
            foreach ($records as $item){
                if(!empty($reword_order)){
                    foreach ($reword_order as $i=>&$order){
                        if(!empty($set['cycle']) && $order['day']>$date['days']){
                            unset($reword_order[$i]);
                        }
                        if($item['day']==$order['day'] && $item['type']==1){
                            $order['drawed'] = 1;
                        }
                        elseif($signinfo['order']>=$order['day']){
                            $order['candraw'] = 1;
                        }
                    }
                    unset($order);
                }
                if(!empty($reword_sum)){
                    foreach ($reword_sum as $i=>&$sum){
                        if(!empty($set['cycle']) && $sum['day']>$date['days']){
                            unset($reword_sum[$i]);
                        }
                        if($item['day']==$sum['day'] && $item['type']==2){
                            $sum['drawed'] = 1;
                        }
                        elseif($signinfo['sum']>=$sum['day']){
                            $sum['candraw'] = 1;
                        }
                    }
                    unset($sum);
                }
            }
        }
        $data = array(
            'order'=>$reword_order,
            'sum'=>$reword_sum
        );
        return $data;
    }

    public function updateSign($signinfo){
        global $_W;
        session_start();
        if(!empty($_SESSION['sign_xcx_openid'])){
            $_W['openid'] = $_SESSION['sign_xcx_openid'];
        }
        if(empty($signinfo)) {
            $signinfo = $this->getSign();
        }
        $info = pdo_fetch("select id  from " . tablename('ewei_shop_sign_user') . " where openid=:openid and uniacid=:uniacid limit 1 ", array(':openid'=>$_W['openid'], ':uniacid'=>$_W['uniacid']));
        $data = array(
            'openid'=>$_W['openid'],
            'order'=>$signinfo['order'],
            'orderday'=>$signinfo['orderday'],
            'sum'=>$signinfo['sum'],
            'signdate'=>date('Y-m')
        );

        if($_SESSION['sign_xcx_isminiprogram']){
            $data['isminiprogram'] = 1;
        }

        if(empty($info)){
            $data['uniacid'] = $_W['uniacid'];
            pdo_insert('ewei_shop_sign_user', $data);
        }else{
            pdo_update('ewei_shop_sign_user', $data, array('id'=>$info['id']));
        }
    }
}
