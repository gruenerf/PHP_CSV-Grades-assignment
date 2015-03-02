<?php

/**
 * Class GradeModel
 */
class GradeModel
{
	/**
	 * Private variables
	 */

	private $id, $studentId, $courseId, $grade, $year;

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

	public function getCourseId()
	{
		return $this->courseId;
	}

	public function setCourseId($courseId)
	{
		$this->courseId = $courseId;
	}

	public function getGrade()
	{
		return $this->grade;
	}

	public function setGrade($grade)
	{
		$this->grade = $grade;
	}

	public function getYear()
	{
		return $this->year;
	}

	public function setYear($year)
	{
		$this->year = $year;
	}

	public function getStudentId()
	{
		return $this->studentId;
	}

	public function setStudentId($studentId)
	{
		$this->studentId = $studentId;
	}

	/**
	 * Constructor
	 * @param $student
	 * @param $course
	 * @param $grade
	 * @param int $id
	 * @param bool $save
	 */

	public function __construct($studentId, $courseId, $grade, $year, $id = 0, $save = true)
	{
		$this->studentId = $studentId;
		$this->courseId = $courseId;
		$this->grade = $grade;
		$this->year = $year;

		if ($save) {
			$this->id = Database::getInstance()->save($this);
		} else {
			$this->id = $id;
		}
	}
}