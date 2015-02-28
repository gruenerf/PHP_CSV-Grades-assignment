<?php

/**
 * Class GradeModel
 */
class GradeModel
{
	/**
	 * @var int
	 */
	private static $counter = 0;

	/**
	 * @param Grade $o
	 */
	public static function saveGrade(Grade $o)
	{

		if (file_exists(ROOT_PATH . "/data/grade.txt")) {
			$fh = fopen(ROOT_PATH . "/data/grade.txt", 'a') or die ('Failed!');
		} else {
			$fh = fopen(ROOT_PATH . "/data/grade.txt", 'w') or die ('Failed!');
			fputcsv($fh, array('id', 'studentId', 'courseId', 'grade', 'year'));
		}

		fputcsv($fh, self::toArray($o));

		fclose($fh);

		self::$counter++;
	}


	/**
	 * @param $id
	 * @return null
	 */
	public static function getGradeById($id)
	{
		$gradeArray = self::getAllGrade();

		foreach ($gradeArray as $grade) {
			if (intval($grade->getId()) === $id) {
				return $grade;
			}
		}

		return null;
	}

	/**
	 * @param Grade $grade
	 */
	public static function updateCourse(Grade $grade)
	{
		$gradeArray = self::getAllGrade();

		for ($i = 0; $i < count($gradeArray); $i++) {
			if ($gradeArray[$i]->getId() === $grade->getId()) {
				$gradeArray[$i] = $grade;
				break;
			}
		}

		$fh = fopen(ROOT_PATH . "/data/grade.txt", "w");

		fputcsv($fh, array('id', 'studentId', 'courseId', 'grade', 'year'));

		foreach ($gradeArray as $grade) {
			fputcsv($fh, self::toArray($grade));
		}

		fclose($fh);
	}

	/**
	 * @return array
	 */
	public static function getAllGrade()
	{
		$gradeArray = array();

		if (file_exists(ROOT_PATH . "/data/grade.txt")) {
			$fh = fopen(ROOT_PATH . "/data/grade.txt", "w");
		} else {
			new Error("grade file does not exist");
			return $gradeArray;
		}

		while (!feof($fh)) {
			$a = fgetcsv($fh);

			if ($a[0] !== '' && $a[0] !== 'id' && $a[0] !== null) {
				array_push($gradeArray, new Grade($a[1], $a[2], $a[3], $a[4], $a[0], false));
			}
		};

		fclose($fh);

		return $gradeArray;
	}

	/**
	 * @param Student $s
	 * @return array
	 */
	public static function getAllGradeByStudent(Student $s)
	{
		$gradeArray = array();

		if (file_exists(ROOT_PATH . "/data/grade.txt")) {
			$fh = fopen(ROOT_PATH . "/data/grade.txt", "w");
		} else {
			new Error("grade file does not exist");
			return $gradeArray;
		}

		while (!feof($fh)) {
			$a = fgetcsv($fh);

			if ($a[0] !== '' && $a[0] !== 'id' && $a[0] !== null && $a[1] == $s->getId()) {
				array_push($gradeArray, new Grade($a[1], $a[2], $a[3], $a[0], false));
			}
		};

		fclose($fh);

		return $gradeArray;
	}

	/**
	 * @param Grade $o
	 * @return string
	 */
	private static function toArray(Grade $o)
	{
		if ($o->getId() === null) {
			$id = self::$counter;
		} else {
			$id = $o->getId();
		}

		return array($id, $o->getStudentId(), $o->getCourseId(), $o->getGrade(), $o->getYear());
	}
}