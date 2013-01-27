<?php
/**
 * Shell utils used for I/O operations against the disc.
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * @package library.shell
 */
class Shell_Wrapper
{
	protected $log;

	public function __construct()
	{
		$this->log = new ZFObserver_Forensic();
		$this->log->attach(new ZFObserver_Observers_Text);
		$this->log->setStatus(ZFObserver_ILogeable::INFO);
		$this->log->notify("Shell_Wrapper","Shell utils called");
	}

	/**
	 * Execute a command. Many of the functions weren't working, and we aren't using safe_mode
	 * @param string $cmd Contains a command to execute
	 * @return string
	 */
	public function execute($cmd)
	{
		$this->log->notify("Shell Wrapper","Execute called.Received $cmd");
		$handle = popen($cmd." 2>&1", 'r');
		$output = "";
		while( !feof($handle) )
		{
			$output .=fread($handle,4096);
		}
		return $output;
	}
}