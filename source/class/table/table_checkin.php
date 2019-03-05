<?php

/**
 * 签到相关数据库操作
 */
class table_checkin extends Table
{
	
	public function __construct() {

		$this->_table = 'asin_checkin';
		$this->_pk    = 'qq';

		parent::__construct();
	}

	/**
	 * 根据日期获取签到信息
	 * @param  [type] $day 需要获取签到信息的日期
	 * @param  [type] $db  [description]
	 * @return [type]      [description]
	 */
	public function getCheckinByDay($day=null,$db=null) {
		if (!$db) global $db;
		if (!$day) $day = getTime('Y-m-d');
		return $db->fetch($this->_table,array('lday'=>$day));
	}

	/**
	 * 新建用户签到信息
	 * @param  [type] $pk    [description]
	 * @param  array  $datas [description]
	 * @param  [type] $db    [description]
	 * @return [type]        [description]
	 */
	protected function newData($pk,array $datas,$db) {
		$num = 10000000000;
		$day = getTime('Y-m-d');
		$datas['count'] = 1;
		$datas['countrank'] = $datas['count']*$num+($num-time());
		$datas['lday'] = $day;
		return parent::newData($pk,$datas,$db);
	}

	/**
	 * 更新用户签到信息
	 * @param  [type] $pk    [description]
	 * @param  array  $datas [description]
	 * @param  [type] $db    [description]
	 * @return [type]        [description]
	 */
	protected function updateData($pk,array $datas,$db) {
		$data = $this->getData($qq,$db);
		$yday = getTime('Y-m-d',time()-86400);
		$day = getTime('Y-m-d');
		$count = ($data['lday'] == $yday) ? (int)$data['count'] : 0;
		$count++;
		$num = 10000000000;
		$datas['count'] = $count;
		$datas['countrank'] = $datas['count']*$num+($num-time());
		$datas['lday'] = $day;
		return parent::updateData($pk,$datas,$db);
	}

	/**
	 * 检测今天是否已签到
	 * @param  [type]  $pk [description]
	 * @param  [type]  $db [description]
	 * @return [type]      [description]
	 */
	public function isCheckin($pk,$db=null) {
		if (!$db) global $db;
		if (!$pk) return false;
		$data = $this->getData($pk,$db);
		if (!$data) return false;
		return ($data['lday'] == getTime('Y-m-d'));
	}

	/**
	 * 获取排行榜列表
	 * @param  integer $limit 获取数量
	 * @param  [type]  $db    [description]
	 * @return [type]         [description]
	 */
	public function getRankList($limit=0,$db=null) {
		if (!$db) global $db;
		if ($limit) return $db->fetch($this->_table,null,null,'countrank DESC',0,$limit);
		return $db->fetch($this->_table,null,null,'countrank DESC');
	}

}