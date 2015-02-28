<?php

class Student
{
	private $id;
	private $surname;
	private $name;
	private $birthday;

	/**
	 * Getters/Setters
	 */

	public function getId()
	{
		return $this->id;
	}

	public function setId($id)
	{
		$this->id = $id;
	}

	public function getBirthday()
	{
		return $this->birthday;
	}

	public function setBirthday($birthday)
	{
		$this->birthday = $birthday;
	}

	public function getName()
	{
		return $this->name;
	}

	public function setName($name)
	{
		$this->name = $name;
	}

	public function getSurname()
	{
		return $this->surname;
	}

	public function setSurname($surname)
	{
		$this->surname = $surname;
	}

	/**
	 * Constructor
	 * @param $surname
	 * @param $name
	 * @param $birthday
	 * @param int $id
	 * @param bool $save
	 */
	public function __construct($surname, $name, $birthday, $id = 0, $save = false)
	{
		$this->name = $name;
		$this->surname = $surname;
		$this->birthday = $birthday;

		if ($save) {
			StudentModel::saveStudent($this);
		} else {
			$this->id = $id;
		}
	}

	/**
	 * @param Course $course
	 */
	public function addRegisteredCourse(Course $course)
	{
		StudentModel::addRegisteredCourse($this, $course);
	}

	/**
	 * @return array
	 */
	public function getCompletedCourses(){
		return GradeModel::getAllGradeByStudent($this);
	}

	/**
	 * @return array
	 */
	public function getRegisteredCourse()
	{
		return CourseModel::getAllRegisteredCourseByStudent($this);
	}

	/**
	 * Returns Workload
	 * @return int
	 */
	public function getWorkload()
	{
		$workload = 0;
		$courses = $this->getRegisteredCourse();

		foreach ($courses as $course) {
			$workload += $course->getEcts();
		}

		return $workload * 1.6;
	}

	/**
	 * Returns GPA as float
	 * @return float
	 */
	public function getGpa()
	{
		$gradeArray = GradeModel::getAllGradeByStudent($this);
		$ects_total = 0;
		$gpa = 0;

		foreach ($gradeArray as $grade) {
			$ects_total += $grade->getEcts();
			$gpa += $grade->getEcts() * $this->transformGradeToInt($grade->getGrade());
		}

		return $gpa / $ects_total;
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

	/**
	 * Transfers GPA to String Representation of Status
	 * @param $gpa
	 * @return string
	 */
	private function status($gpa)
	{
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

} 