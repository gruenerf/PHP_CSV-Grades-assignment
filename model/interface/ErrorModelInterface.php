<?php

/**
 * Interface ErrorModelInterface
 */
interface ErrorModelInterface extends ModelInterface
{
	/**
	 * @return mixed
	 */
	public function getDate();

	/**
	 * @param $date
	 * @return mixed
	 */
	public function setDate($date);

	/**
	 * @return mixed
	 */
	public function getErrormessage();

	/**
	 * @param $errormassage
	 * @return mixed
	 */
	public function setErrormessage($errormassage);
}