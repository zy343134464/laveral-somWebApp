<?php

use Illuminate\Support\Facades\Cookie;
function pw($password)
{
	return password_hash($password, PASSWORD_DEFAULT);
}

function checkpw($password,$hash)
{
	return password_verify($password, $hash);
}
function no404()
{
	return '<img src="https://gss3.bdstatic.com/-Po3dSag_xI4khGkpoWK1HF6hhy/baike/c0%3Dbaike80%2C5%2C5%2C80%2C26/sign=3593f3d9d8b44aed4d43b6b6d275ec64/2fdda3cc7cd98d10b262fca2233fb80e7aec90eb.jpg" alt="404" title="unknow 404" >';
}
function organ_info($ip,$str)
{
	$res = DB::table('organs')->where('host',$ip)->first();
	if(count($res)) {
		return $res->$str;
	} else {
		return no404();
	}
	
}
function set_user_id_cookie($uid,$min)
{
	Cookie::queue('user_id',$uid,$min);
}

function logout()
{
	cookie::forget('user_id');
}
?>