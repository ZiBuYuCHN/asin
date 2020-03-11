<?php

namespace kjBotModule\TRPG\Roll;

use kjBotModule\TRPG\Common;
use kjBot\Framework\Event\GroupMessageEvent;
use kjBot\SDK\CQCode;
use \Log;

/**
 * 
 */
class RO extends Common
{
	
	public function process(array $args, $event){
        if(!($event instanceof GroupMessageEvent)) q('只有群聊才能使用本命令');
        if (!isset($args[1])) q('请输入属性');
        $User_id = $event->getId();
        $msg = CQCode::At($User_id)."\n";
        $num = mt_rand(1, 100);
        // 获取属性
        $attr = $this->getAttr(implode(DIRECTORY_SEPARATOR, array('trpg', $event->groupId, $User_id.'.json')), $args[1]);
        $msg .= '普通检定：1d100：'. $num . '，检测 '.$args[1]. '('. $attr .') ';
        if ($num <= 5) {
            $msg .= '大成功！！！';
        } else {
            if ($num >= 96 && $num > $attr) {
                $msg .= '大失败！！！';
            } elseif ($num <= $attr) {
                $msg .= '成功';
            } else {
                $msg .= '失败';
            }
        }
		return $event->sendBack($msg);
	}
}