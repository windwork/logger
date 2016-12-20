<?php
/**
 * Windwork
 * 
 * 一个开源的PHP轻量级高效Web开发框架
 * 
 * @copyright   Copyright (c) 2008-2016 Windwork Team. (http://www.windwork.org)
 * @license     http://opensource.org/licenses/MIT	MIT License
 */
namespace wf\logger;

/**
 * 静态创建日志操作类实例工厂类
 * 
 * @package     wf.logger
 * @author      erzh <cmpan@qq.com>
 * @link        http://www.windwork.org/manual/wf.logger.html
 * @since       0.1.0
 */
final class LoggerFactory {
	/**
	 * 
	 * @var array
	 */
	private static $instance = array();
		
	/**
	 * 创建日志组件实例
	 * 
	 * @param array $cfg array(
	 *   'log_adapter' => 'File',     // 日志处理（\wf\logger\adapter\中）实现的类
	 *   'log_dir'     => 'data/log', // 日志保存路径，支持wrapper，如新浪公有云可使用  saekv://data/log或saemc://data/cache
	 *   'log_level'   => 7,          // 启用日志级别，可为0-7，记录小于或等于该级别的日志。日志等级：0)emergency，1)alert，2)critical，3)error，4)warning，5)notice，6)info，7)debug
	 * );
	 * @return \wf\logger\ALogger
	 */
	public static function create(array $cfg) {
		empty($cfg["log_adapter"]) && $cfg["log_adapter"] = 'File';

		// 获取带命名空间的类名
		$class = "\\wf\\logger\\adapter\\{$cfg["log_adapter"]}";

		$scope = md5(serialize($cfg));
		
		// 如果该类实例未初始化则创建
		if(empty(static::$instance[$scope])) {
			static::$instance[$scope] = new $class($cfg);
		}
		
		return static::$instance[$scope];
	}
}


