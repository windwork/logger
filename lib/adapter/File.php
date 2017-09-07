<?php
/**
 * Windwork
 * 
 * 一个用于快速开发高并发Web应用的轻量级PHP框架
 * 
 * @copyright Copyright (c) 2008-2017 Windwork Team. (http://www.windwork.org)
 * @license   http://opensource.org/licenses/MIT
 */
namespace wf\logger\adapter;

/**
 * 日志读写，使用文件存贮
 * 
 * @package     wf.logger.adapter
 * @author      cm <cmpan@qq.com>
 * @link        http://docs.windwork.org/manual/wf.logger.html
 * @since       0.1.0
 */
class File extends \wf\logger\LoggerAbstract
{
    /**
     * 每个日志文件的大小
     * @var int
     */
    const LOG_SIZE = 4096000;

    /**
     * {@inheritDoc}
     * @see \wf\logger\LoggerAbstract::log()
     */
    public function log($level, $message, array $context = array()) 
    {
        if (!$this->checkLevel($level)) {
            return;
        }

        if (!is_scalar($message)) {
            $message = var_export($message, 1);
        }
        
        $time = time();
        $yearMonth = date('Y-m', $time);
        $logFile = $this->logDir . "/log.{$level}.php";
    
        // 日志文件超过限定大小将分文件保存
        if(@is_file($logFile) && filesize($logFile) > self::LOG_SIZE) {
            $archiveTime = date('YmdHis', $time);
            $logFileArchive = $this->logDir . "/log.{$level}-{$archiveTime}.php";
            // 文件是否正在保存，如果正在保存，其他请求就不再保存
            if(!is_file($logFileArchive)) {
                @rename($logFile, $logFileArchive);
            }
        }
    
        // 新添加的文件前添加浏览保护信息
        $pre = "<?php exit?>";
        $pre .= date('Y-m-d H:i:s');
        $message = trim($message);
        
        if(!file_put_contents($logFile, "{$pre} {$level} {$message}\n", FILE_APPEND)) {
            throw new \wf\logger\Exception($logFile. ' can\'t write.');
        }
    }
    
}

