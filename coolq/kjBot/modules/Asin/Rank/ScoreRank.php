<?php

namespace kjBotModule\Asin\Rank;

use kjBot\Framework\Module;
use kjBot\Framework\Event\GroupMessageEvent;
use kjBot\SDK\CQCode;

/**
 * 
 */
class CheckinRank extends Module
{
	
	public function process(array $args, $event){
		$msg = "刺客排行榜";
		$data = param_post('http://asin.ygame.cc/api.php',array('mod'=>'rank_score','action'=>'getRankList'));
		$rankList = $data['data'];
		for ($i=0; $i < min(10,count($rankList)); $i++) {
			$msg .= "\n".$rankList[$i]['rank']."\t".$rankList[$i]['nickname']."\t".$rankList[$i]['score'];
		}
		return $event->sendBack($msg);
	}
}