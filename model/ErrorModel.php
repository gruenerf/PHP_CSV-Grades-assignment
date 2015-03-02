<?php

class ErrorModel {

	/**
	 * Private variables
	 * @var DateTime
	 */
	private $id, $date, $errormessage;

	/**
	 * Getter / Setter
	 */

	public function getId()
	{
		return $this->id;
	}

	public function setId($id)
	{
		$this->id = $id;
	}

	public function getDate()
	{
		return $this->date;
	}

	public function setDate($date)
	{
		$this->date = $date;
	}

	public function getErrormessage()
	{
		return $this->errormessage;
	}

	public function setErrormessage($errormessage)
	{
		$this->errormessage = $errormessage;
	}

	/**
	 * Constructor
	 * @param $errormessage
	 */
	function __construct($errormessage)
	{
		$this->date = new DateTime();
		$this->errormessage = $errormessage;

		Database::getInstance()->save($this);
	}

} 