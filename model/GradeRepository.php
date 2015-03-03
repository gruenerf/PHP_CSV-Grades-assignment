<?php

use GradeModel as Grade;
use ErrorModel as Error;

class GradeRepository extends BaseRepository implements GradeRepositoryInterface
{

	/**
	 * static instance
	 */
	private static $lecturerRepository = null;


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
		if (self::$lecturerRepository == null) {
			self::$lecturerRepository = new LecturerRepository();
		}

		return self::$lecturerRepository;
	}

	public function create($studentId, $courseId, $grade)
	{
		return new Grade($studentId, $courseId, $grade);
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

		if (file_exists(ROOT_PATH . "/data/grade.txt")) {
			$fh = fopen(ROOT_PATH . "/data/grade.txt", "r") or die ('Failed!');
		} else {
			new Error("grade.txt does not exist");
			return $objectArray;
		}

		while (!feof($fh)) {
			$a = fgetcsv($fh);

			if ($a[0] !== '' && $a[0] !== 'id' && $a[0] !== null) {
				array_push($objectArray, new Grade($a[1], $a[2], $a[3], $a[0], false));
			}
		};

		fclose($fh);

		return $objectArray;
	}

}