<?php
/**
 * Windwork
 * 
 * 一个用于快速开发高并发Web应用的轻量级PHP框架
 * 
 * @copyright Copyright (c) 2008-2017 Windwork Team. (http://www.windwork.org)
 * @license   http://opensource.org/licenses/MIT
 */
namespace wf\logger;

/**
 * 日志读写
 * 
 * @package     wf.logger
 * @author      cm <cmpan@qq.com>
 * @link        http://docs.windwork.org/manual/wf.logger.html
 * @since       0.1.0
 */ 
abstract class LoggerAbstract implements LoggerInterface
{
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
     * 检查是否启用该级别日志
     * @param string $level
     * @return bool
     */
    protected function checkLevel($level) 
    {        
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
    
    public function __construct(array $cfg) 
    {
        $this->logLevel = $cfg['level'];
        $this->setLogDir($cfg['dir']);
    }
        
    /**
     * 设置日志目录，支持wrapper
     * 
     * @param string $dir
     */
    public function setLogDir($dir)
    {
        $dir = str_replace("\\", "/", $dir);
        $dir = rtrim($dir, '/');
        
        $this->logDir = $dir;
    }

    /**
     * {@inheritDoc}
     * @see \wf\logger\LoggerInterface::emergency()
     */
    public function emergency($message, array $context = [])
    {
        $this->log('emergency', $message, $context);
    }
    
    /**
     * {@inheritDoc}
     * @see \wf\logger\LoggerInterface::alert()
     */
    public function alert($message, array $context = [])
    {
        $this->log('alert', $message, $context);
    }
    
    /**
     * {@inheritDoc}
     * @see \wf\logger\LoggerInterface::critical()
     */
    public function critical($message, array $context = [])
    {
        $this->log('critical', $message, $context);
    }
    
    /**
     * {@inheritDoc}
     * @see \wf\logger\LoggerInterface::error()
     */
    public function error($message, array $context = [])
    {
        $this->log('error', $message, $context);
    }
    
    /**
     * {@inheritDoc}
     * @see \wf\logger\LoggerInterface::warning()
     */
    public function warning($message, array $context = [])
    {
        $this->log('warning', $message, $context);
    }
    
    /**
     * {@inheritDoc}
     * @see \wf\logger\LoggerInterface::notice()
     */
    public function notice($message, array $context = [])
    {
        $this->log('notice', $message, $context);
    }
    
    /**
     * {@inheritDoc}
     * @see \wf\logger\LoggerInterface::info()
     */
    public function info($message, array $context = [])
    {
        $this->log('info', $message, $context);
    }
    
    /**
     * {@inheritDoc}
     * @see \wf\logger\LoggerInterface::debug()
     */
    public function debug($message, array $context = [])
    {
        $this->log('debug', $message, $context);
    }
}

