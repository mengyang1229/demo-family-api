<?php

namespace App\Listeners;

use App\Models\WechatUser;

class WechatUserEventSubscriber
{
    /**
     * 处理获取用户列表。
     */
    public function onUserList($event) {
        foreach($event->openids as $openid){
            $wechatUser = WechatUser::firstOrCreate([
                'app_type' => $event->wechatApp->config->app_type, // config/wechat.php 文件里每个账户里要单独配置 app_type，否则根据环境变量取值
                'app_id'   => $event->wechatApp->config->app_id,
                'openid'   => $openid,
            ]);
        }
    }

    /**
     * 为订阅者注册监听器
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'App\Events\Wechat\UserList',
            'App\Listeners\WechatUserEventSubscriber@onUserList'
        );
    }
}