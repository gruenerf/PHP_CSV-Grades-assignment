<?php

/**
 * Class CourseModel
 */
class CourseModel
{

	/**
	 * @param $id
	 * @return null
	 */
	public static function getCourseById($id)
	{
		$courseArray = self::getAllCourse();

		foreach ($courseArray as $course) {
			if (intval($course->getId()) === $id) {
				return $course;
			}
		}

		return null;
	}

	/**
	 * @param Course $course
	 */
	public static function updateCourse(Course $course)
	{
		$courseArray = self::getAllCourse();

		for ($i = 0; $i < count($courseArray); $i++) {
			if ($courseArray[$i]->getId() === $course->getId()) {
				$courseArray[$i] = $course;
				break;
			}
		}

		$fh = fopen(ROOT_PATH . "/data/course.txt", "w");
		fputcsv($fh, array('id', 'name', 'ects', 'group', 'semester'));
		foreach ($courseArray as $course) {
			fputcsv($fh, self::toArray($course));
		}

		fclose($fh);
	}

	/**
	 * @return array
	 */
	public static function getAllCourse()
	{
		$courseArray = array();

		if (file_exists(ROOT_PATH . "/data/course.txt")) {
			$fh = fopen(ROOT_PATH . "/data/course.txt", "r");
		} else {
			new Error("course file does not exist");
			return $courseArray;
		}

		while (!feof($fh)) {
			$a = fgetcsv($fh);

			if ($a[0] !== '' && $a[0] !== 'id' && $a[0] !== null) {
				array_push($courseArray, new Course($a[1], $a[2], $a[3], $a[4], $a[0], false));
			}
		};

		fclose($fh);

		return $courseArray;
	}

	/**
	 * @param Student $s
	 * @return array
	 */
	public static function getAllRegisteredCourseByStudent(Student $s)
	{
		$courseArray = array();

		if (file_exists(ROOT_PATH . "/data/student_course_registered.txt")) {
			$fh = fopen(ROOT_PATH . "/data/student_course_registered.txt", "r");
		} else {
			new Error("student_course_registered file does not exist");
			return $courseArray;
		}

		while (!feof($fh)) {
			$a = fgetcsv($fh);

			if ($a[0] !== '' && $a[0] !== 'id' && $a[0] !== null && $a[0] == $s->getId()) {
				array_push($courseArray, CourseModel::getCourseById($a[1]));
			}
		};

		fclose($fh);

		return $courseArray;
	}

	/**
	 * @param Lecturer $l
	 * @return array
	 */
	public static function getAllCurrentCourseByLecturer(Lecturer $l)
	{
		$courseArray = array();

		if (file_exists(ROOT_PATH . "/data/lecturer_course_current.txt")) {
			$fh = fopen(ROOT_PATH . "/data/lecturer_course_current.txt", "r");
		} else {
			new Error("lecturer_course_current file does not exist");
			return $courseArray;
		}

		while (!feof($fh)) {
			$a = fgetcsv($fh);

			if ($a[0] !== '' && $a[0] !== 'id' && $a[0] !== null && $a[0] == $l->getId()) {
				array_push($courseArray, CourseModel::getCourseById($a[1]));
			}
		};

		fclose($fh);

		return $courseArray;
	}

	/**
	 * @param Lecturer $l
	 * @return array
	 */
	public static function getAllPreviousCourseByLecturer(Lecturer $l)
	{
		$courseArray = array();

		if (file_exists(ROOT_PATH . "/data/lecturer_course_previous.txt")) {
			$fh = fopen(ROOT_PATH . "/data/lecturer_course_previous.txt", "r");
		} else {
			new Error("lecturer_course_previous file does not exist");
			return $courseArray;
		}

		while (!feof($fh)) {
			$a = fgetcsv($fh);

			if ($a[0] !== '' && $a[0] !== 'id' && $a[0] !== null && $a[0] == $l->getId()) {
				array_push($courseArray, CourseModel::getCourseById($a[1]));
			}
		};

		fclose($fh);

		return $courseArray;
	}

	/**
	 * @param Course $o
	 * @return string
	 */
	private static function toArray(Course $o)
	{
		if ($o->getId() === null) {
			$id = self::$counter;
		} else {
			$id = $o->getId();
		}

		return array($id, $o->getName(), $o->getEcts(), $o->getGroup(), $o->getSemester());
	}

} 