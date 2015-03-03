<?php

use ErrorModel as Error;

class ErrorRepository extends BaseRepository implements ErrorRepositoryInterface
{
	/**
	 * static instance
	 */
	private static $errorRepository = null;


	/**
	 * Empty constructor for singleton
	 */
	public function __construct()
	{
	}

	/**
	 *  Singleton returns the one instance
	 */
	public static function getInstance()
	{
		if (self::$errorRepository == null) {
			self::$errorRepository = new ErrorRepository();
		}

		return self::$errorRepository;
	}

	public function create($errormessage)
	{
		return new Error($errormessage);
	}

	public function getById($id)
	{
		$array = $this->getAll();

		foreach ($array as $object) {
			if (intval($object->getId()) === intval($id)) {
				return $object;
			}
		}

		return null;
	}

	public function getAll()
	{
		$objectArray = array();

		if (file_exists(ROOT_PATH . "/data/errorlog.txt")) {
			$fh = fopen(ROOT_PATH . "/data/errorlog.txt", "r") or die ('Failed!');
		} else {
			new Error("errorlog.txt does not exist");
			return $objectArray;
		}

		while (!feof($fh)) {
			$a = fgetcsv($fh);

			if ($a[0] !== '' && $a[0] !== 'id' && $a[0] !== null) {
				array_push($objectArray, new Error($a[1], $a[2], $a[0], false));
			}
		};

		fclose($fh);

		return $objectArray;
	}
}