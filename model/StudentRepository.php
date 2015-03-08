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

	/**
	 * Creates a new studentObject
	 * @param $name
	 * @param $surname
	 * @param $birthday
	 * @return mixed|StudentModel
	 */
	public function create($name, $surname, $birthday)
	{
		return new Student($name, $surname, $birthday);
	}


	/**
	 * Returns the highest id of the csv file
	 * @return int
	 */
	public function getHighestId()
	{
		if (file_exists(ROOT_PATH . "/data/student.txt")) {
			$rows = file(ROOT_PATH . "/data/student.txt");
		} else {
			new Error("student.txt does not exist");
			return 0;
		}

		$last_row = array_pop($rows);
		$data = str_getcsv($last_row);

		if($data[0] == 'id'){
			return 0;
		}

		return $data[0];
	}

	/**
	 * Returns a studentObject with a certain id
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
	 * Returns all studentobjects
	 * @return array|mixed
	 */
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

	/**
	 * Returns all grades of a student
	 * @param StudentModel $student
	 * @return array|mixed
	 */
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

	/**
	 * Returns all courses of a student (prev and current)
	 * @param StudentModel $student
	 * @return array|mixed
	 */
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

			if ($a[0] !== '' && $a[0] !== 'id' & $a[0] !== null & $a[0] == $student->getId()) {
				array_push($objectArray, CourseRepository::getInstance()->getById($a[1]));
			}
		};

		fclose($fh);

		return $objectArray;
	}

	/**
	 * Adds a course to a student
	 * @param StudentModel $student
	 * @param CourseModel $course
	 * @return mixed|void
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
	 * Returns all completed courses of a student
	 * means all courses passed (Grade of D or better)
	 * @param StudentModel $student
	 * @return array|mixed
	 */
	public function getCompletedCourse(Student $student)
	{
		$array = $this->getAllGradeByStudent($student);
		$array_buffer = array();

		foreach ($array as $grade) {
			if (self::transformGradeToInt($grade->getGrade()) > 1) {
				array_push($array_buffer, $grade);
			}
		}

		return $array_buffer;
	}

	/**
	 * Returns all courses a student visits in the current semester
	 * @param StudentModel $student
	 * @return array|mixed
	 */
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
	 * @param StudentModel $student
	 * @return int|mixed
	 */
	public function getWorkload(Student $student)
	{
		$ects = 0;
		$courses = $this->getCurrentCourse($student);

		foreach ($courses as $course) {
			$ects += $course->getEcts();
		}

		$result = $ects * 1.6;

		// Update Database
		$student->setWorkload($result);
		$student->update();

		return $result;
	}

	/**
	 * Returns GPA as float
	 * @param StudentModel $student
	 * @return int|mixed|string
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
	 * @param StudentModel $student
	 * @return mixed|string
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
	 * Returns true if student is or has been registered to a course
	 * @param StudentModel $student
	 * @param CourseModel $course
	 * @return bool
	 */
	public function checkIfStudentIsRegisteredForCourse(Student $student, Course $course)
	{

		if (file_exists(ROOT_PATH . "/data/student_course.txt")) {
			$fh = fopen(ROOT_PATH . "/data/student_course.txt", "r");
		} else {
			new Error("student_course.txt does not exist");
			return false;
		}

		while (!feof($fh)) {
			$a = fgetcsv($fh);

			if ($a[0] !== '' && $a[0] !== 'id' && $a[0] !== null && $a[0] == $student->getId() && $a[1] == $course->getId()) {
				fclose($fh);
				return true;
			}
		};

		fclose($fh);

		return false;
	}

	/**
	 * Checks if student already been graded in a course
	 * @param StudentModel $student
	 * @param CourseModel $course
	 * @return array
	 */
	public function checkIfStudentHasBeenGradedInCourse(Student $student, Course $course)
	{
		$array = $this->getAllGradeByStudent($student);

		$arrayBuffer = array();

		foreach ($array as $grade) {
			if ($grade->getCourseId() == $course->getId()) {
				array_push($arrayBuffer,
					array($grade->getDate(), $grade->getGrade())
				);
			}
		}

		if (!empty($arrayBuffer)) {

			$newest = array();
			foreach ($arrayBuffer as $array) {
				if (empty($newest)) {
					$newest = array($array[0], $array[1]);
				} elseif (new DateTime($newest[0]) < new DateTime($array[0])) {
					$newest = array($array[0], $array[1]);
				}
			}

			return array(true, $newest[1]);
		}

		return array(false, null);
	}

} 