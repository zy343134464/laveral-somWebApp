<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;

class MailController extends Controller
{
    public function send()
    {
        $flag = Mail::send('email.test', [], function ($message) {
            $to = '283606834@qq.com';
            $message ->to($to)->subject('欢迎注册我们的网站，请激活您的账号！');
        });

        dd($flag);
        if ($flag) {
            echo '发送邮件成功，请查收！';
        } else {
            echo '发送邮件失败，请重试！';
        }
    }
}
