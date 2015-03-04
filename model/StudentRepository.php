<?php

use StudentModel as Student;
use CourseModel as Course;
use ErrorModel as Error;

class StudentRepository extends BaseRepository implements StudentRepositoryInterface
{
	/**
	 * static instance
	 */
	private static $studentRepository = null;


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
		if (self::$studentRepository == null) {
			self::$studentRepository = new StudentRepository();
		}

		return self::$studentRepository;
	}

	public function create($name, $surname, $birthday)
	{
		return new Student($name, $surname, $birthday);
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

		if (file_exists(ROOT_PATH . "/data/student.txt")) {
			$fh = fopen(ROOT_PATH . "/data/student.txt", "r") or die ('Failed!');
		} else {
			new Error("student.txt does not exist");
			return $objectArray;
		}


		while (!feof($fh)) {
			$a = fgetcsv($fh);

			if ($a[0] !== '' && $a[0] !== 'id' && $a[0] !== null) {
				array_push($objectArray, new Student($a[1], $a[2], $a[3], $a[4], $a[5], $a[0], false));
			}
		};

		fclose($fh);

		return $objectArray;
	}

	public function getAllGradeByStudent(Student $student)
	{
		$objectArray = array();

		if (file_exists(ROOT_PATH . "/data/grade.txt")) {
			$fh = fopen(ROOT_PATH . "/data/grade.txt", "r");
		} else {
			new Error("grade.txt does not exist");
			return $objectArray;
		}

		while (!feof($fh)) {
			$a = fgetcsv($fh);

			if ($a[0] !== '' && $a[0] !== 'id' && $a[0] !== null && $a[1] == $student->getId()) {
				array_push($objectArray, GradeRepository::getInstance()->getById($a[0]));
			}
		};

		fclose($fh);

		return $objectArray;
	}

	public function getAllCourseByStudent(Student $student)
	{
		$objectArray = array();

		if (file_exists(ROOT_PATH . "/data/student_course.txt")) {
			$fh = fopen(ROOT_PATH . "/data/student_course.txt", "r");
		} else {
			new Error("student_course.txt does not exist");
			return $objectArray;
		}

		while (!feof($fh)) {
			$a = fgetcsv($fh);

			if ($a[0] !== '' && $a[0] !== 'id' && $a[0] !== null && $a[0] == $student->getId()) {
				array_push($objectArray, CourseRepository::getInstance()->getById($a[1]));
			}
		};

		fclose($fh);

		return $objectArray;
	}

	/**
	 * @param Course $course
	 */
	public function addCourse(Student $student, Course $course)
	{
		if (file_exists(ROOT_PATH . "/data/student_course.txt")) {
			$fh = fopen(ROOT_PATH . "/data/student_course.txt", 'a') or die ('Failed!');
		} else {
			$fh = fopen(ROOT_PATH . "/data/student_course.txt", 'w') or die ('Failed!');
			fputcsv($fh, array('student_id', 'course_id'));
		}

		fputcsv($fh, array($student->getId(), $course->getId()));
		fclose($fh);
	}

	/**
	 * @return array
	 */
	public function getCompletedCourse(Student $student)
	{
		$array = $this->getAllGradeByStudent($student);
		$array_buffer = array();

		foreach ($array as $grade) {
			if ($this->transformGradeToInt($grade->getGrade()) > 0) {
				array_push($array_buffer, $grade);
			}
		}

		return $array_buffer;
	}

	public function getCurrentCourse(Student $student)
	{
		$array = $this->getAllCourseByStudent($student);
		$array_buffer = array();

		foreach ($array as $course) {
			if ($course->getSemester() == self::getCurrentSemester()) {
				array_push($array_buffer, $course);
			}
		}

		return $array_buffer;
	}

	/**
	 * Returns Workload
	 * @return int
	 */
	public function getWorkload(Student $student)
	{
		$workload = 0;
		$courses = $this->getCurrentCourse($student);

		foreach ($courses as $course) {
			$workload += $course->getEcts();
		}

		$result = $workload * 1.6;

		// Update Database
		$student->setWorkload($result);
		$student->update();

		return $result;
	}

	/**
	 * Returns GPA as float
	 * @return float
	 */
	public function getGpa(Student $student)
	{
		$gradeArray = $this->getCompletedCourse($student);
		$ects_total = 0;
		$grade_weight = 0;

		foreach ($gradeArray as $grade) {
			$ects = CourseRepository::getInstance()->getById($grade->getCourseId())->getEcts();
			$ects_total += $ects;
			$grade_weight += $ects * $this->transformGradeToInt($grade->getGrade());
		}

		if ($ects_total !== 0) {
			$gpa = number_format($grade_weight / $ects_total, 1);

			// Update Database
			$student->setGPA($gpa);
			$student->update();

			return $gpa;
		} else {
			return 0;
		}
	}

	/**
	 * Transfers GPA to String Representation of Status
	 * @return string
	 */
	public function getStatus(Student $student)
	{
		$gpa = $this->getGpa($student);
		if ($gpa <= 1.99) {
			return 'unsatisfactory';
		} elseif (2 <= $gpa && $gpa <= 2.99) {
			return 'satisfactory';
		} elseif (3 <= $gpa && $gpa <= 3.99) {
			return 'honour';
		} elseif (4 <= $gpa && $gpa <= 5) {
			return 'high honour';
		}

		return 'no status';
	}


	/**
	 * Transfers Grade into Integer Representation
	 * @param $grade
	 * @return int
	 */
	public function transformGradeToInt($grade)
	{
		switch ($grade) {
			case 'A' :
				return 5;
			case 'B' :
				return 4;
			case 'C' :
				return 3;
			case 'D' :
				return 2;
			case 'E' :
				return 1;
			case 'F' :
				return 0;
		}

		return null;
	}

} 