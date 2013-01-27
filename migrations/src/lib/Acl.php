<?php
/**
 * Generate a dump of the set of tables that are involved in the ACL system
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 */
class Acl extends Helper implements Task
{
	/**
	 * Contains the Zend_Application used to retrieve options and bootstrap the application
	 * @var Zend_Config
	 */
	private $config;

	/**
	 *
	 * The way a migration is being run
	 * @var const
	 */
	private $mode;

	/**
	 * Set the configuration option
	 * @param Zend_Application $config
	 */
	public function setConfig(Zend_Config $config)
	{
		$this->config = $config;
	}

	/**
	 * Retrieve the application config
	 * @return Zend_Config
	 */
	public function getConfig()
	{
		return $this->config;
	}

	/**
	 *
	 * Setter for mode
	 * @param unknown_type $mode
	 */
	public function setMode($mode)
	{
		$this->mode = $mode;
	}

	/**
	 *
	 * Getter for mode
	 */
	public function getMode()
	{
		return $this->mode ;
	}

	/* (non-PHPdoc)
	 * @see utils/migrations/src/lib/Task::task()
	 */
	public function task()
	{
		//	This is the mysqldump command for dumping the acl tables
		$cmd = $this->config->migrations->mysqldump->unix.' --user='.$this->config->resources->db->params->username.' --password='.$this->config->resources->db->params->password.' -h'.$this->config->resources->db->params->host.' '.$this->config->migrations->mysqldump->flags.' '.$this->config->resources->db->params->dbname.' '.$this->config->migrations->acltables;
		$dump = $this->popenWrapper($cmd.'|grep -v "/\*"');

		if( $this->mode == Task::DOWN )
		{
			$cast = file_get_contents($this->config->migrations->template->down,'r');
			$newdump = preg_replace("/\[%s\]/", $dump, $cast);
			if ( file_put_contents($this->config->migrations->template->deploy.'aclDown.sql', $newdump) === false )
			{
				throw new Exception("Migtool was unable to write the dump");
			}
			return true;
		}

		if( $this->mode == Task::UP )
		{
			$cast = file_get_contents($this->config->migrations->template->up,'r');
			$newdump = preg_replace("/\[%s\]/", $dump, $cast);
			if ( file_put_contents($this->config->migrations->template->deploy.'aclUp.sql', $newdump) === false )
			{
				throw new Exception("Migtool was unable to write the dump");
			}
			return true;
		}
	}
}