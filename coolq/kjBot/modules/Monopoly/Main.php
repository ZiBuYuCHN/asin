<?php

/** 大富翁入口文件 */

namespace kjBotModule\Monopoly;

use kjBot\Framework\Module;
use kjBot\Framework\Message;
use kjBot\Framework\Event\GroupMessageEvent;
use kjBot\SDK\CQCode;
use kjBotModule\Monopoly\Data;
use kjBotModule\Monopoly\Action;

/**
 * 帮助文档
 */
class Main extends Module {

	public function process(array $args, $event) {
        if (!isset($args[1])) q('请输入指令');
        $class = new Action();
        $actions = [
            '坐庄' => 'init',
            '开始' => 'start',
            '参加' => 'join',
            '要' => 'need',
            '过' => 'pass',
            '帮助' => 'help',
        ];
        if (!isset($actions[$args[1]]) && method_exists($class, $actions[$args[1]])) q('指令不正确');
        $action = $actions[$args[1]];
        return $class->$action($event);
    }

}