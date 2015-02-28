<?php

/**
 * Class StudentModel
 */
class StudentModel
{
	/**
	 * @var int
	 */
	private static $counter = 0;

	/**
	 * @param Student $o
	 */
	public static function saveStudent(Student $o)
	{
		if (file_exists(ROOT_PATH . "/data/student.txt")) {
			$fh = fopen(ROOT_PATH . "/data/student.txt", 'a') or die ('Failed!');
		} else {
			$fh = fopen(ROOT_PATH . "/data/student.txt", 'w') or die ('Failed!');
			fputcsv($fh, array('id', 'surname', 'name', 'birthday'));
		}

		fputcsv($fh, self::toArray($o));

		fclose($fh);

		self::$counter++;
	}

	/**
	 * @param $id
	 * @return null
	 */
	public static function getStudentById($id)
	{
		$studentArray = self::getAllStudent();

		foreach ($studentArray as $student) {
			if (intval($student->getId()) === $id) {
				return $student;
			}
		}

		return null;
	}

	/**
	 * @param Student $student
	 */
	public static function updateStudent(Student $student)
	{
		$studentArray = self::getAllstudent();

		for ($i = 0; $i < count($studentArray); $i++) {
			if ($studentArray[$i]->getId() === $student->getId()) {
				$studentArray[$i] = $student;
				break;
			}
		}

		$fh = fopen(ROOT_PATH . "/data/student.txt", 'w') or die ('Failed!');
		fputcsv($fh, array('id', 'surname', 'name', 'birthday'));

		foreach ($studentArray as $student) {
			fputcsv($fh, self::toArray($student));
		}

		fclose($fh);
	}

	/**
	 * @return array
	 */
	public static function getAllStudent()
	{
		$fh = fopen(ROOT_PATH . "/data/student.txt", "r");
		$studentArray = array();

		while (!feof($fh)) {
			$a = fgetcsv($fh);

			if ($a[0] !== '' && $a[0] !== 'id' && $a[0] !== null) {
				array_push($studentArray, new Student($a[1], $a[2], $a[3], $a[0], false));
			}
		};

		fclose($fh);

		return $studentArray;
	}

	/**
	 * @param Course $c
	 * @param Student $s
	 */
	public static function addRegisteredCourse(Student $s, Course $c)
	{
		$fh = fopen(ROOT_PATH . "/data/student_course_registered.txt", 'a') or die ('Failed!');

		fwrite($fh, $s->getId() . "," . $c->getId() . "\n");

		fclose($fh);
	}

	/**
	 * @param Student $s
	 * @return array
	 */
	public static function getAllGradeByStudent(Student $s)
	{

		$fh = fopen(ROOT_PATH . "/data/grade.txt", "r");
		$gradeArray = array();

		while (!feof($fh)) {
			$a = fgetcsv($fh);

			if ($a[0] !== '' && $a[0] !== 'id' && $a[0] !== null && $a[1] == $s->getId()) {
				array_push($gradeArray, GradeModel::getGradeById($a[0]));
			}
		};

		fclose($fh);

		return $gradeArray;
	}


	/**
	 * @param Student $o
	 * @return string
	 */
	private static function toArray(Student $o)
	{
		if ($o->getId() === null) {
			$id = self::$counter;
		} else {
			$id = $o->getId();
		}


	}

} 