<?php

namespace kjBotModule\Asin\Home;

use kjBot\Framework\Module;
use kjBot\Framework\Event\GroupMessageEvent;
use kjBot\SDK\CQCode;

/** 洗点 */
class ResetAttr extends Module
{
	
	public function process(array $args, $event){
        $msg = '';
        $isConfirm = isset($args[1]) && $args[1] === '确认';
        if (isset($args[2])) checkAuth($event);
		$atqq = isset($args[2]) ? parseQQ($args[2]) : null;
		$User_id = $event->getId();
		$qq = $atqq ? $atqq : $User_id;
		if($event instanceof GroupMessageEvent){
			$msg .= CQCode::At($User_id)."\n";
        }
        if (!$isConfirm) return $event->sendBack($msg.'洗点需要消耗 2000 暗币，确认洗点请输入`洗点 确认`（中间带空格）');
        $dAttr = new \Domain\UserAttr();
        $resetAttr = $dAttr->resetAttr($qq);
        if ($resetAttr === -1) {
            $msg .= '洗点失败：您没有加入刺客组织';
        } elseif (!$resetAttr) {
            $msg .= '洗点失败';
        } elseif ($resetAttr === -2) {
            $msg .= '洗点失败：您的暗币不足 2000';
        } else {
            $userAttr = $dAttr->getUserAttrWithFight($qq);
            $msg .= "洗点成功，当前属性点为：\n";
            $msg .= '力量：'.$userAttr['str']."\n";
            $msg .= '敏捷：'.$userAttr['dex']."\n";
            $msg .= '体质：'.$userAttr['con']."\n";
            $msg .= '智力：'.$userAttr['ine']."\n";
            $msg .= '感知：'.$userAttr['wis']."\n";
            $msg .= '魅力：'.$userAttr['cha']."\n";
            $msg .= '自由属性点：'.$userAttr['free']."\n\n";
            $msg .= '血量上限（大乱斗）：'.$userAttr['maxBld']."\n";
            $msg .= '攻击力（大乱斗）：'.$userAttr['atk']."\n";
            $msg .= '暴击率（大乱斗）：'.$userAttr['crit']." %";
        }
        return $event->sendBack($msg);
    }
}