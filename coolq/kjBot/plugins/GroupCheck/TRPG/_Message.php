<?php
namespace kjBotPlugin\GroupCheck\TRPG;

use kjBot\Framework\Plugin;
use kjBot\Framework\Message;
use kjBot\Framework\Event\GroupMessageEvent;
use kjBot\SDK\CQCode;
use kjBot\Framework\DataStorage;
use \Log;

class _Message extends Plugin {
    public $handleDepth = 3; //捕获到最底层的事件
    public $handleQueue = true; //声明是否要捕获消息队列

    public function beforePostMessage(&$queue){} //若声明不需要捕获消息队列可不实现本方法
    //此处以正常群聊消息举例
    public function message_group_normal($event) {
        global $Modules;
        if (isBan($event)) return NULL;
        if (checkGroup($event,'trpg')) {
            $Modules['你好'] = \kjBotModule\TRPG\Hello::class;
            $Modules['.coc'] = \kjBotModule\TRPG\COC::class;
            $Modules['.st'] = \kjBotModule\TRPG\ST::class;
            $Modules['.show'] = \kjBotModule\TRPG\Show::class;
            $Modules['.help'] = \kjBotModule\TRPG\Help::class;
            $Modules['.ro'] = \kjBotModule\TRPG\Roll\RO::class;
            $Modules['.rd'] = \kjBotModule\TRPG\Roll\RD::class;
            $Modules['.re'] = \kjBotModule\TRPG\Roll\RE::class;
            $Modules['.sc'] = \kjBotModule\TRPG\Roll\SC::class;
            $Modules['.ha'] = \kjBotModule\TRPG\Roll\HA::class;
            $Modules['.hs'] = \kjBotModule\TRPG\Roll\HS::class;
        }
        $closeMods = DataStorage::GetData('CloseMods.json');
        $closeMods = $closeMods ? json_decode($closeMods, true) : array();
        foreach ($Modules as $key => $value) {
            if (in_array($key, $closeMods)) $Modules[$key] = \kjBotModule\Common\Manager\CloseModMsg::class;
        }

    }

}