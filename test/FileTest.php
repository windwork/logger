<?php
require_once '../ALogger.php';
require_once '../LoggerFactory.php';
require_once '../Exception.php';
require_once '../adapter/File.php';

use \wf\logger\adapter\File;
use \wf\logger\LoggerFactory;

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

		$cfg = array(
			'log_adapter' => 'File',
	        'log_dir'     => __DIR__.'/log',
	        'log_level'   => 7,
		);
		if (!is_dir($cfg['log_dir'])) {
			mkdir($cfg['log_dir'], 0755, true);
		}
		\wf\logger\LoggerFactory::init($cfg);
		
		$this->file = new File($cfg);
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
		$logger = \wf\logger\LoggerFactory::create();
		$logger->emergency('emergency info');
		$logger->info('info message');
		$logger->critical('critical message');
	}
}

