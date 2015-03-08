<?php

class ErrorModel implements ErrorModelInterface
{

	/**
	 * Private variables
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
	 * @param null $date
	 * @param int $id
	 * @param bool $save
	 */
	function __construct($errormessage, $date = NULL, $id = 0, $save = true)
	{
		if (isset($date)) {
			$this->date = $date;
		} else {
			$this->date = new DateTime();
		}
		$this->errormessage = $errormessage;

		if ($save) {
			$this->id = $this->save();
		} else {
			$this->id = $id;
		}
	}

	/**
	 * Saves the Object
	 */
	public function save()
	{
		if (file_exists(ROOT_PATH . "/data/errorlog.txt")) {
			$fh = fopen(ROOT_PATH . "/data/errorlog.txt", 'a') or die ('Failed!');
		} else {
			$fh = fopen(ROOT_PATH . "/data/errorlog.txt", 'w') or die ('Failed!');
			fputcsv($fh, array('id', 'date', 'message'));
		}

		// Only raise counter if $counterCheck = NULL that means the object is saved the first time
		// Prevents problems with update function
		$counterCheck = $this->getId();

		fputcsv($fh, $this->toArray());

		fclose($fh);

		if (!$counterCheck) {
			return $_SESSION['errorId'];
		}
	}

	// Not needed for Errors because its just a log
	public function update()
	{

	}

	/**
	 * Returns Array representation of Class
	 *
	 * @return array
	 */
	public function toArray()
	{
		if ($this->getId() === null) {
			if (isset($_SESSION['errorId'])) {
				$id = ++$_SESSION['errorId'];
			} else {
				$_SESSION['errorId'] = ErrorRepository::getInstance()->getHighestId();
				$id = ++$_SESSION['errorId'];
			}
		} else {
			$id = $this->getId();
		}

		return array($id, $this->getDate()->format('Y-m-d H:i:s'), $this->getErrorMessage());
	}
}