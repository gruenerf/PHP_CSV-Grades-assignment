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

	public function getCurrentCourses()
	{
		$array = $this->getAll();

		$array_buffer = array();

		foreach ($array as $course) {
			if ($course->getSemester() == self::getCurrentSemester()) {
				array_push($array_buffer, $course);
			}
		}

		return $array_buffer;
	}

	public function getCurrentCoursesGroupsAndPreviously()
	{
		$array = $this->getAll();
		$arrayBuffer = array();

		foreach ($array as $course) {
			if (!array_key_exists($course->getName(), $arrayBuffer)) {
				$tempArray = array();
				$tempArray['name'] = $course->getName();
				$tempArray['ects'] = $course->getEcts();
				$tempArray['groups'] = $this->getNumberOfCurrentGroups($course);
				$tempArray['previously'] = $this->getNumberPreviouslyTaught($course);

				$arrayBuffer[$course->getName()] = $tempArray;
			}
		}

		return $arrayBuffer;
	}

	public function getNumberOfCurrentGroups(Course $course)
	{
		$array = $this->getCurrentCourses();

		$counter = 0;
		foreach ($array as $course2) {
			if ($course->getName() == $course2->getName() && $course2->getSemester() == self::getCurrentSemester()) {
				$counter++;
			}
		}

		return $counter;
	}

	public function getNumberPreviouslyTaught(Course $course)
	{
		$array = $this->getAll();
		$counter = 0;
		foreach ($array as $course2) {
			if ($course->getName() == $course2->getName()) {
				$counter++;
			}
		}

		return $counter - $this->getNumberOfCurrentGroups($course);
	}


}