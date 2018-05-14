<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Wechat;

class WechatController extends Controller
{
    public function openid($code)
    {
    	$wechat = new Wechat;
    	$res = $wechat->access_token($code);
    	if($res) {
    		return $res['openid'];
    	}
    	return '';
    }
}
