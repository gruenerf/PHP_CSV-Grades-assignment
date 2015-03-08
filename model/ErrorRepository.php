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

	/**
	 * Creates one error object
	 * @param $errormessage
	 * @return ErrorModel|mixed
	 */
	public function create($errormessage)
	{
		return new Error($errormessage);
	}

	/**
	 * Returns the highest id of the csv file
	 * @return int
	 */
	public function getHighestId()
	{
		if (file_exists(ROOT_PATH . "/data/error.txt")) {
			$rows = file(ROOT_PATH . "/data/error.txt");
		} else {
			new Error("error.txt does not exist");
			return 0;
		}

		$last_row = array_pop($rows);
		$data = str_getcsv($last_row);

		if ($data[0] == 'id') {
			return 0;
		}

		return $data[0];
	}

	/**
	 * Returns Errorobject with certain id
	 * @param $id
	 * @return mixed|null
	 */
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

	/**
	 * Returns all Errorobjects
	 * @return array|mixed
	 */
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