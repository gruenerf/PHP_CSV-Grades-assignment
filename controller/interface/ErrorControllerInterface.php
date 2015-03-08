<?php

/**
 * Interface ErrorControllerInterface
 */
interface ErrorControllerInterface
{
	/**
	 * @param $errormessage
	 * @return mixed
	 */
	public function create($errormessage);
} 