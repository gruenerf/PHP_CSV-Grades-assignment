<?php

use CourseModel as Course;
use ErrorModel as Error;

class CourseRepository extends BaseRepository implements CourseRepositoryInterface
{

	/**
	 * static instance
	 */
	private static $courseRepository = null;


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
		if (self::$courseRepository == null) {
			self::$courseRepository = new CourseRepository();
		}

		return self::$courseRepository;
	}

	public function create($name, $ects, $group, $semester)
	{
		if ($semester instanceof DateTime) {
			$semesterBuffer = self::dateToSemester($semester);
			$currentSemester = self::getCurrentSemester();

			// The current semester is the latest semester courses can be asigned to. Courses in the future are set back to current semester.
			// Courses in the past are set as usual.
			if (self::compareSemesterDate($semesterBuffer, $currentSemester)) {
				$semester = $semesterBuffer;
			} else {
				$semester = $currentSemester;
			}
		}

		return new Course($name, $ects, $group, $semester);
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

		if (file_exists(ROOT_PATH . "/data/course.txt")) {
			$fh = fopen(ROOT_PATH . "/data/course.txt", "r") or die ('Failed!');
		} else {
			new Error("course.txt does not exist");
			return $objectArray;
		}

		while (!feof($fh)) {
			$a = fgetcsv($fh);

			if ($a[0] !== '' && $a[0] !== 'id' && $a[0] !== null) {
				array_push($objectArray, new Course($a[1], $a[2], $a[3], $a[4], $a[0], false));
			}
		};

		fclose($fh);

		return $objectArray;
	}
} 