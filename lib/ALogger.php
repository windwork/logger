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
 * 日志读写
 * 
 * @package     wf.logger
 * @author      erzh <cmpan@qq.com>
 * @link        http://www.windwork.org/manual/wf.logger.html
 * @since       0.1.0
 */ 
abstract class ALogger {
	/**
	 * 日志保存目录
	 * @var string
	 */
	protected $logDir;

	/**
	 * 系统不可用
	 * @var int
	 */
	const LEVEL_EMERGENCY = 0;

	/**
	 * 必须立刻采取行动
	 * @var int
	 */
	const LEVEL_ALTER = 1;

	/**
	 * 紧急情况
	 * @var int
	 */
	const LEVEL_CRITICAL = 2;

	/**
	 * 运行时出现的错误，不需要立刻采取行动，但必须记录下来以备检测。
	 * @var int
	 */
	const LEVEL_ERROR = 3;

	/**
	 * 出现非错误性的异常（Exception等）。 例如：使用了被弃用的API、错误地使用了API或者非预想的不必要错误。
	 * @var int
	 */
	const LEVEL_WARNING = 4;

	/**
	 * 一般性重要的事件。
	 * @var int
	 */
	const LEVEL_NOTICE = 5;

	/**
	 * 重要事件，例如：用户登录和SQL记录。
	 * @var int
	 */
	const LEVEL_INFO = 6;
	
	/**
	 * 调试信息
	 * @var int
	 */
	const LEVEL_DEBUG = 7;
	
	/**
	 * 日志记录级别
	 * 
	 * 日志级别设置可为0-7，记录小于或等于该级别的日志。
	 * 0)emergency，1)alert，2)critical，3)error，4)warning，5)notice，6)info，7)debug
	 * 
	 * @var string
	 */
	protected $logLevel = 7;

    /**
	 * 写入日志
	 * 
	 * @param string $level 日志级别  emergency|alert|critical|error|warning|notice|info|debug
	 * @param string $message  日志内容
     * @param array $context
     * @throws \wf\logger\Exception
     * @return null
     */
    abstract public function log($level, $message, array $context = array());
    
    /**
     * 检查是否启用该级别日志
     * @param string $level
     * @return bool
     */
    protected function checkLevel($level) {    	
    	switch ($this->logLevel) {
    		case self::LEVEL_EMERGENCY:
    			if ($level != 'emergency') {
    				return false;
    			}
    			break;
    			
    		case self::LEVEL_ALTER:
    			if (false === stripos('emergency|alert', $level)) {
    				return false;
    			}
    			break;

    		case self::LEVEL_CRITICAL:
    			if (false === stripos('emergency|alert|critical', $level)) {
    				return false;
    			}
    			break;

    	    case self::LEVEL_ERROR:
    			if (false === stripos('emergency|alert|critical|error', $level)) {
    				return false;
    			}
    			break;

    	    case self::LEVEL_WARNING:
    			if (false === stripos('emergency|alert|critical|error|warning', $level)) {
    				return false;
    			}
    			break;

    	    case self::LEVEL_NOTICE:
    			if (false === stripos('emergency|alert|critical|error|notice', $level)) {
    				return false;
    			}
    			break;

    	    case self::LEVEL_INFO:
    			if (false === stripos('emergency|alert|critical|error|notice|info', $level)) {
    				return false;
    			}
    			break;
    	    case self::LEVEL_DEBUG:
    	    	// logging all
    	    	break;
    	}
    	
    	return true;
    }
	
	public function __construct(array $cfg) {
		$this->logLevel = $cfg['log_level'];
		$this->setLogDir($cfg['log_dir']);
	}
		
	/**
	 * 设置日志目录，支持wrapper
	 * 
	 * @param string $dir
	 */
	public function setLogDir($dir) {
		$dir = str_replace("\\", "/", $dir);
		$dir = rtrim($dir, '/');
		
		$this->logDir = $dir;
	}

	/**
	 * 系统不可用
	 *
	 * @param string $message
	 * @param array $context
	 * @return null
	 */
	public function emergency($message, array $context = array()) {
		$this->log('emergency', $message, $context);
	}
	
	/**
	 * 功能必须马上修复
	 *
	 * @param string $message
	 * @param array $context
	 * @return null
	*/
	public function alert($message, array $context = array()){
		$this->log('alert', $message, $context);
	}
	
	/**
	 * 危险的环境.
	 *
	 * Example: 应用组件不可用, 不可预知的异常.
	 *
	 * @param string $message
	 * @param array $context
	 * @return null
	*/
	public function critical($message, array $context = array()){
		$this->log('critical', $message, $context);
	}
	
	/**
	 * 不需要立即处理的运行时错误，但通常应该被记录和监测。
	 *
	 * @param string $message
	 * @param array $context
	 * @return null
	*/
	public function error($message, array $context = array()){
		$this->log('error', $message, $context);
	}
	
	/**
	 * 运行时警告 (非致命错误)。仅给出提示信息，但是脚本不会终止运行。
	 *
	 * Example: 使用不赞成的接口, 不好的东西但不一定是错误
	 *
	 * @param string $message
	 * @param array $context
	 * @return null
	*/
	public function warning($message, array $context = array()){
		$this->log('warning', $message, $context);
	}
	
	/**
	 * 运行时通知。表示脚本遇到可能会表现为错误的情况，但是在可以正常运行的脚本里面也可能会有类似的通知。
	 *
	 * @param string $message
	 * @param array $context
	 * @return null
	*/
	public function notice($message, array $context = array()){
		$this->log('notice', $message, $context);
	}
	
	/**
	 * 有意义的事件
	 *
	 * Example: 用户登录，sql日志等
	 *
	 * @param string $message
	 * @param array $context
	 * @return null
	*/
	public function info($message, array $context = array()){
		$this->log('info', $message, $context);
	}
	
	/**
	 * 详细的调试信息
	 *
	 * @param string $message
	 * @param array $context
	 * @return null
	*/
	public function debug($message, array $context = array()){
		$this->log('debug', $message, $context);
	}
}

