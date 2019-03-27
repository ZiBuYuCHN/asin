<?php

/**
 * 此文件为 api 唯一入口文件
 */

// 加载核心库
require_once 'source/class/class_core.php';

// 预设置返回内容
$res = array();

// 获取响应内容
$param = getgpc('param');

if (getgpc('qq','param',0) == 1063614727) {
	$cache = getData('test2.txt');
	$cache = $cache ? (int)$cache : 0;
	$cache++;
	setData('test2.txt',$cache);
}

// 初始化db链接
$db = new DBConn($_config['dbhost']['ip'], $_config['dbhost']['user'], $_config['dbhost']['pwd'], $_config['dbhost']['base'],$_config['dbhost']['port']);

if (getgpc('qq','param',0) == 1063614727) {
	$cache = getData('test3.txt');
	$cache = $cache ? (int)$cache : 0;
	$cache++;
	setData('test3.txt',$cache);
}

Log::Info('param===>'.$param);

if (empty($param)) {
	// 如果没有响应内容，则返回错误信息
	$res['errCode'] = -1;
	$res['errMsg'] = '没有参数';
} else {

	$param = json_decode($param,true);

	// 获取响应模组
	$mod = getgpc('mod','PARAM');

	if (empty($mod)) {
		// 如果没有响应模组或者请求模组中未携带_，则返回错误信息
		$res['errCode'] = -2;
		$res['errMsg'] = '没有请求模组';
	} else {
		$modArr = explode('_',$mod);
		$mod = implode('/',$modArr);
		$modPath = libfile($mod,'module');
		if (file_exists($modPath)) {
			// 如果有该文件则加载
			// 获取响应行动
			$action = getgpc('action','PARAM');
			require_once $modPath;
		} else {
			// 如果没有该文件，则返回错误信息
			$res['errCode'] = -3;
			$res['errMsg'] = '没有该模组';
		}
	}
}

// 返回信息
echo json_encode($res);