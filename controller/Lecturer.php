<?php

class Lecturer
{
	private $id;
	private $title;
	private $surname;
	private $name;
	private $birthday;

	/**
	 * Getter/Setter
	 */

	public function getId()
	{
		return $this->id;
	}

	public function setId($id)
	{
		$this->id = $id;
	}

	public function getTitle()
	{
		return $this->title;
	}

	public function setTitle($title)
	{
		$this->title = $title;
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
	 * @param $title
	 * @param $surname
	 * @param $name
	 * @param $birthday
	 * @param int $id
	 * @param bool $save
	 */

	public function __construct($title, $surname, $name, $birthday, $id = 0, $save = false)
	{
		$this->title = $title;
		$this->name = $name;
		$this->surname = $surname;
		$this->birthday = $birthday;

		if ($save) {
			LecturerModel::saveLecturer($this);
		} else {
			$this->id = $id;
		}
	}

	public function getWorkload()
	{
		$workload = 0;
		$courses = $this->getCurrentCourses();

		foreach ($courses as $course) {
			$workload += $course->getEcts();
		}

		return $workload * 5;
	}

	public function addPreviousCourse(Course $course)
	{
		LecturerModel::addPreviousCourse($this, $course);
	}

	public function getPreviousCourses()
	{
		return CourseModel::getAllPreviousCourseByLecturer($this);
	}

	public function addCurrentCourse(Course $course)
	{
		LecturerModel::addCurrentCourse($this, $course);
	}

	public function getCurrentCourses()
	{
		return CourseModel::getAllPreviousCourseByLecturer($this);
	}


}