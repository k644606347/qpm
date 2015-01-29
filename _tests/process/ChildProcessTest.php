<?php
namespace qpm\_tests\process;
require_once 'qpm/process/Process.php';
require_once 'qpm/_tests/BaseTestCaseWithLogFile.php';
use qpm\process\Process;
use qpm\process\ChildProcess;
class ChildProcessTest extends \qpm\_tests\BaseTestCaseWithLogFile {
	public function testProcessFork() {
		$child = Process::current()->forkByCallable(function() {exit;});
		$this->assertTrue($child instanceof ChildProcess);
		$st = 0;
		$cpid = pcntl_wait($st);
		$this->assertEquals($cpid, $child->getPid());
	}
	
	public function testGetStatus() {
		$child = Process::current()->forkByCallable(function() {usleep(100*1000);exit;});
		$status = $child->getStatus();
		$this->assertTrue($status instanceof \qpm\process\status\ForkedChildStatus);
		$this->assertTrue($status instanceof \qpm\process\status\NotExitStatus);
		$this->assertNull($status->getExitCode());
	}
}
