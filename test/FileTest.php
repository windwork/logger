<?php
require_once '../lib/ALogger.php';
require_once '../lib/Exception.php';
require_once '../lib/strategy/File.php';

use \wf\logger\strategy\File;

function cfg() {
    $cfg = [
        'strategy' => 'File',
        'dir'     => __DIR__.'/log',
        'level'   => 7,
    ];
    
    if (!is_dir($cfg['dir'])) {
        mkdir($cfg['dir'], 0755, true);
    }
    
    return $cfg;
}

function logging($level, $message) {
    $logger = new \wf\logger\strategy\File(cfg('log'));
    return $logger->log($level, $message);
}

/**
 * File test case.
 */
class FileTest extends PHPUnit_Framework_TestCase {
    
    /**
     *
     * @var File
     */
    private $file;
    
    /**
     * Prepares the environment before running a test.
     */
    protected function setUp() {
        parent::setUp ();

        
        $this->file = new \wf\logger\strategy\File(cfg('log'));
    }
    
    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown() {
        $this->file = null;
        
        parent::tearDown ();
    }
    
    /**
     * Tests File->log()
     */
    public function testLog() {        
        // 测试实现类
        $this->file->log('error', 'err message');
        
        // 函数保存
        logging('debug', 'dbg message');
        
        // 日志组件接口
        $logger = new \wf\logger\strategy\File(cfg('log'));
        
        $logger->emergency('emergency info');
        $logger->info('info message');
        $logger->critical('critical message');
    }
}

