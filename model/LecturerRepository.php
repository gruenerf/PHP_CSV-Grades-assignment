<?php

use CourseModel as Course;
use LecturerModel as Lecturer;
use ErrorModel as Error;

/**
 * Class LecturerRepository
 */
class LecturerRepository extends BaseRepository implements LecturerRepositoryInterface
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

	public function create($title, $name, $surname, $birthday)
	{
		return new Lecturer($title, $name, $surname, $birthday);
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

		if (file_exists(ROOT_PATH . "/data/lecturer.txt")) {
			$fh = fopen(ROOT_PATH . "/data/lecturer.txt", "r") or die ('Failed!');
		} else {
			new Error("lecturer.txt does not exist");
			return $objectArray;
		}

		while (!feof($fh)) {
			$a = fgetcsv($fh);

			if ($a[0] !== '' && $a[0] !== 'id' && $a[0] !== null) {
				array_push($objectArray, new Lecturer($a[1], $a[2], $a[3], $a[4], $a[5], $a[0], false));
			}
		};

		fclose($fh);

		return $objectArray;
	}

	public function getAllCourseByLecturer(Lecturer $lecturer)
	{
		$objectArray = array();

		if (file_exists(ROOT_PATH . "/data/lecturer_course")) {
			$fh = fopen(ROOT_PATH . "/data/lecturer_course.txt", "r");
		} else {
			new ErrorModel("lecturer_course.txt does not exist");
			return $objectArray;
		}


		while (!feof($fh)) {
			$a = fgetcsv($fh);

			if ($a[0] !== '' && $a[0] !== 'id' && $a[0] !== null && $a[0] == $lecturer->getId()) {
				array_push($objectArray, CourseRepository::getInstance()->getById($a[1]));
			}
		};

		fclose($fh);

		return $objectArray;
	}


	public function addCourse(Lecturer $lecturer, Course $course)
	{
		if (file_exists(ROOT_PATH . "/data/lecturer_course.txt")) {
			$fh = fopen(ROOT_PATH . "/data/lecturer_course.txt", 'a') or die ('Failed!');
		} else {
			$fh = fopen(ROOT_PATH . "/data/lecturer_course.txt", 'w') or die ('Failed!');
			fputcsv($fh, array('lecturer_id', 'course_id'));
		}

		fputcsv($fh, array($lecturer->getId(), $course->getId()));
		fclose($fh);
	}


	public function getPreviousCourse(Lecturer $lecturer)
	{
		$array = LecturerRepository::getInstance()->getAllCourseByLecturer($lecturer);
		$array_buffer = array();

		foreach ($array as $course) {
			if ($course->getSemester() !== self::getCurrentSemester()) {
				array_push($array_buffer, $course);
			}
		}

		return $array_buffer;
	}


	public function getCurrentCourse(Lecturer $lecturer)
	{
		$array = LecturerRepository::getInstance()->getAllCourseByLecturer($lecturer);
		$array_buffer = array();

		foreach ($array as $course) {
			if ($course->getSemester() == self::getCurrentSemester()) {
				array_push($array_buffer, $course);
			}
		}

		return $array_buffer;
	}


	public function getWorkload(Lecturer $lecturer)
	{
		$workload = 0;

		$array = LecturerRepository::getInstance()->getAllCourseByLecturer($lecturer);
		$array_buffer = array();

		foreach ($array as $course) {
			if ($course->getSemester() == self::getCurrentSemester()) {
				array_push($array_buffer, $course);
			}
		}

		foreach ($array_buffer as $course) {
			$workload += $course->getEcts();
		}

		$result = $workload * 5;

		// Update Database
		$lecturer->setWorkload($result);
		$lecturer->update();

		return $result;
	}
} 