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
interface LoggerInterface 
{
    /**
     * 保存日志
     * @param int $level
     * @param string $message
     * @param array $context
     */
    public function log($level, $message, array $context = []);
    
    /**
     * 系统不可用
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public function emergency($message, array $context = []);
    
    /**
     * 功能必须马上修复
     *
     * @param string $message
     * @param array $context
     * @return null
    */
    public function alert($message, array $context = []);
    
    /**
     * 危险的环境.
     *
     * Example: 应用组件不可用, 不可预知的异常.
     *
     * @param string $message
     * @param array $context
     * @return null
    */
    public function critical($message, array $context = []);
    
    /**
     * 不需要立即处理的运行时错误，但通常应该被记录和监测。
     *
     * @param string $message
     * @param array $context
     * @return null
    */
    public function error($message, array $context = []);
    
    /**
     * 运行时警告 (非致命错误)。仅给出提示信息，但是脚本不会终止运行。
     *
     * Example: 使用不赞成的接口, 不好的东西但不一定是错误
     *
     * @param string $message
     * @param array $context
     * @return null
    */
    public function warning($message, array $context = []);
    
    /**
     * 运行时通知。
     * 
     * 表示脚本遇到可能会表现为错误的情况，但是在可以正常运行的脚本里面也可能会有类似的通知。
     *
     * @param string $message
     * @param array $context
     * @return null
    */
    public function notice($message, array $context = []);
    
    /**
     * 有意义的事件
     *
     * Example: 用户登录，sql日志等
     *
     * @param string $message
     * @param array $context
     * @return null
    */
    public function info($message, array $context = []);
    
    /**
     * 详细的调试信息
     *
     * @param string $message
     * @param array $context
     * @return null
    */
    public function debug($message, array $context = []);
}

