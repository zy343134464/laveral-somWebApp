<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SendController extends Controller
{
	private $appid;
	private $appkey;
	private $sign_type;

	function __construct()
	{
		$this->appid = env('SUBMAIL_APPID','16116');
		$this->appkey = env('SUBMAIL_APPKEY','ab7c0ebb6d915b9bd4e18da867e02ab8');
		$this->sign_type = env('SUBMAIL_TYPE','normal');
	}
    public function send_message($phone = '15899967504',$code = '1234')
    {
    	$message_configs['appid'] = $this->appid;
        $message_configs['appkey'] = $this->appkey;
        $message_configs['sign_type']=$this->sign_type;
        
        $submail = new \MESSAGEsend($message_configs);
        $submail->setTo($phone);
        $submail->SetContent('【大师工坊】您的短信验证码：'.$code.'，请在2小时内输入。');
        $res = $submail->send();
        return $res;
    }
}
