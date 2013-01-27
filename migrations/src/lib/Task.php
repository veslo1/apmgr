<?php
/**
 * Interface that defines the general behavior of the tasks that the application executes
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 * @package utils.migrations.src.lib
 */
interface Task {
	/**
	 *
	 * Concrete implementation of your code for your particular task
	 */
	public function task();

	/**
	 *
	 * The direction a migration is going
	 * @var const
	 */
	const UP=1;

	/**
	 *
	 * The direction a migration is going
	 * @var const
	 */
	const DOWN=2;
}