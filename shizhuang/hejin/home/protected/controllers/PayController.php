<?php
/*
 * autor: Mr.xu
 *
 */
error_reporting(0);
class PayController extends Controller{
	private $menus;
    public function init(){
        parent::init();
        $this->layout = false;
        $this->title = '充值中心';
        $this->keyword = '充值中心';
        $this->desc = '充值中心';
        $this->menu = array(
        		1=>array('money'=>'6','desc'=>'60钻石','gift'=>''),
        		2=>array('money'=>'18','desc'=>'180钻石','gift'=>''),
        		3=>array('money'=>'68','desc'=>'680钻石','gift'=>''),
        		4=>array('money'=>'128','desc'=>'1280钻石','gift'=>''),
        		5=>array('money'=>'328','desc'=>'3280钻石','gift'=>''),
        		6=>array('money'=>'628','desc'=>'6280钻石','gift'=>''),
        		//6=>array('money'=>'25','desc'=>'月卡','gift'=>'领取120钻石/天'),
        		//7=>array('money'=>'98','desc'=>'狩猎月卡','gift'=>'领取5张狩猎券/天'),
        		//8=>array('money'=>'0.01','desc'=>'测试1分钱','gift'=>''),
        		//9=>array('money'=>'1','desc'=>'测试1元钱','gift'=>''),
        );

    }
    public function actionIndex(){

    	if(!isset($_GET['player_id']) || !isset($_GET['acc_id']))
    		exit('参数错误');
    	$serverid = isset($_GET['serverid'])?$_GET['serverid']:0;
    	$result = $this->checkPlayer($_GET['player_id'],$_GET['acc_id'],$serverid);
    	$result = json_decode($result,true);
    	if($result['status'] == 1){
    		exit($result['msg']);
    	}
    	$player_name = $result['data']['name'];
        $this->render('index', array(
            'title'=>'充值中心','player_name'=>$player_name,'menu'=>$this->menu
           // 'gameServer' => $this->getServer(),
        ));
    }
    public function actionInfo(){
    	$userinfo = Yii::app()->session['userinfo'];
    	if(!$userinfo){
    		exit('参数错误');
    	}
    	if(isset($_GET['pay']) && $_GET['pay'] == 'ali'){
    		$tinfo = Yii::app()->session['tinfo'];
    		if(!$tinfo){
    			exit('没有这个档次的充值金额');
    		}
    		$playerId = $userinfo['player_id'];
    		$serverid = $userinfo['serverid'];
    		$accountId = $userinfo['account_id'];
    		$out_trade_no = $this->getOrderId($serverid.'_'.$playerId.'_'.$accountId.'_');
    		//订单名称，必填
    		//付款金额，必填
    		$total_amount = intval($tinfo['money']);
    		//$total_amount = 0.01;
    		//超时时间
    		//$url = "http://pokeweb.u591776.com:84/interface/alipay/alipayapi.php";
    		$url = "http://fhweb.u776.com:84/interface/aliwappay/alipayapi.php";
    		$data = array(
    				'WIDout_trade_no' =>$out_trade_no,
    				'WIDsubject'    =>'官网wap充值',
    				'WIDtotal_fee'  =>$total_amount,
    				'WIDbody'       =>'',
    		);
    		$rs =$this->https_post($url, $data);
    		echo $rs;
    		return ;
    	}

    	 $t = $_GET['t'];
    	 $tinfo = $this->menu[$t];
    	 if(!$tinfo){
    	 	exit('没有这个档次的充值金额');
    	 }
    	 Yii::app()->session['tinfo'] = $tinfo;
    	 $this->render('info', array(
    	 		'title'=>'充值中心','player_name'=>$userinfo['player_name'],'tinfo'=>$tinfo
    	 		// 'gameServer' => $this->getServer(),
    	 ));
    }



    public function checkPlayer($player_id,$account_id,$serverid){
    	if(!isset($player_id) || !isset($account_id))
    		exit(array('status'=>1,'msg'=>'参数错误'));
        $url = "http://fhweb.u776.com:86/interface/website/checkUser.php";
        $array = array();
        $array['serverid'] = $serverid;
        $array['account_id'] = $account_id;
        $array['player_id'] = $player_id;
        $mySign = $this->httpBuidQuery($array, $this->appKey);
        $array['sign'] = $mySign;
        $result = $this->https_post($url, $array);
        $myresult = json_decode($result,true);
        if(isset($myresult['status'] ) && $myresult['status'] == 0){
        	Yii::app()->session['userinfo']=array('account_id'=>$myresult['data']['accountId'],'player_name'=>$myresult['data']['name'],'player_id'=>$player_id,'serverid'=>$serverid);
        }
        return $result;
        
    }

    private function getOrderId($pre = ''){
        return $pre.date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
    }

}