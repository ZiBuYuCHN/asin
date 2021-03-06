<?php

namespace kjBotModule\Asin\Forum;

use kjBot\Framework\Module;
use kjBot\Framework\Event\GroupMessageEvent;
use kjBot\SDK\CQCode;
use \Log;

/**
 * 查看用户信息
 */
class Search extends Module
{
	
	public function process(array $args, $event){
        if (!isset($args[1])) q('请输入搜索值');
        $searchText = $args[1];
        $findPost = isset($args[2]) ? '0' : '1';
        $searchText .= '-'.$findPost;
        $url = "https://567.pohun.com/?search-".$searchText.".htm?ajax=1";
        $forumCache = param_post($url,array('qq'=>$event->getId()));
        $forumList = $forumCache['message'];
        if (count($forumList) <= 0) return $event->sendBack('没有相关消息');
        $forumArr = array();
        for ($i=0; $i < min(count($forumList),5); $i++) { 
            $_forum = strip_tags($forumList[$i]['subject']);
            $_forum .= "\nhttps://567.pohun.com/?thread-".$forumList[$i]['tid'].'.htm';
            array_push($forumArr,$_forum);
        }
        $msg = implode("\n\n",$forumArr);
        return $event->sendBack($msg);
    }
}