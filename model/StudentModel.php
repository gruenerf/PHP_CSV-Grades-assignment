<?php

/**
 * TODO:
 * Make gpa calculation with check for amount of courses taken
 */

/**
 * Class StudentModel
 */
class StudentModel
{
	/**
	 * Private variables
	 */

	private $id, $surname, $name, $birthday, $workload, $gpa;


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

	public function getGPA()
	{
		return $this->gpa;
	}

	public function setGPA($gpa)
	{
		$this->gpa = $gpa;
	}

	public function getWorkload()
	{
		return $this->workload;
	}

	public function setWorkload($workload)
	{
		$this->workload = $workload;
	}

	/**
	 * Constructor
	 * @param $surname
	 * @param $name
	 * @param $birthday
	 * @param int $id
	 * @param bool $save
	 */
	public function __construct($surname, $name, $birthday, $workload = "undefined", $gpa = "undefined", $id = 0, $save = true)
	{
		$this->name = $name;
		$this->surname = $surname;
		$this->birthday = $birthday;
		$this->workload = $workload;
		$this->gpa = $gpa;

		if ($save) {
			$this->id = Database::getInstance()->save($this);
		} else {
			$this->id = $id;
		}
	}

	/**
	 * @param Course $course
	 */
	public function addRegisteredCourse(CourseModel $course)
	{
		Database::getInstance()->add($this, $course);
	}

	/**
	 * @return array
	 */
	public function getCompletedCourse()
	{
		return Database::getInstance()->getAllBy($this, 'Grade');
	}

	/**
	 * @return array
	 */
	public function getRegisteredCourse()
	{
		return Database::getInstance()->getAllBy($this, 'Course');
	}

	/**
	 * Returns Workload
	 * @return int
	 */
	public function calculateWorkload()
	{
		$workload = 0;
		$courses = $this->getRegisteredCourse();

		foreach ($courses as $course) {
			$workload += $course->getEcts();
		}

		$result = $workload * 1.6;

		// Update Database
		$this->setWorkload($result);
		Database::getInstance()->update($this);

		return $result;
	}

	/**
	 * Returns GPA as float
	 * @return float
	 */
	public function calculateGpa()
	{
		$gradeArray = $this->getCompletedCourse();
		$ects_total = 0;
		$grade_weight = 0;

		foreach ($gradeArray as $grade) {
			$ects = Database::getInstance()->getById('Course', $grade->getCourseId())->getEcts();
			$ects_total += $ects;
			$grade_weight += $ects * $this->transformGradeToInt($grade->getGrade());
		}

		if ($ects_total !== 0) {
			$gpa = number_format($grade_weight / $ects_total, 1);

			// Update Database
			$this->setGPA($gpa);
			Database::getInstance()->update($this);

			return $gpa;
		} else {
			return 0;
		}
	}

	/**
	 * Transfers Grade into Integer Representation
	 * @param $grade
	 * @return int
	 */
	private function transformGradeToInt($grade)
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
	 * @return string
	 */
	public function getStatus()
	{
		$gpa = $this->calculateGpa();
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