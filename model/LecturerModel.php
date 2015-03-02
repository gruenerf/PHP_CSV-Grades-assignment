<?php

/**
 * Class LecturerModel
 */
class LecturerModel
{
	/**
	 * Private variables
	 */

	private $id, $title, $surname, $name, $birthday, $workload;

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
	 *
	 * @param $title
	 * @param $name
	 * @param $surname
	 * @param $birthday
	 * @param $workload
	 * @param int $id
	 * @param bool $save
	 */

	public function __construct($title, $name, $surname,  $birthday, $workload = "undefined", $id = 0, $save = true)
	{
		$this->title = $title;
		$this->surname = $surname;
		$this->name = $name;
		$this->birthday = $birthday;
		$this->workload = $workload;

		if ($save) {
			$this->id = Database::getInstance()->save($this);
		} else {
			$this->id = $id;
		}
	}

	public function calculateWorkload()
	{
		$workload = 0;
		$courses = Database::getInstance()->getAllBy($this,'Course','current');

		foreach ($courses as $course) {
			$workload += $course->getEcts();
		}

		$result = $workload * 5;

		// Update Database
		$this->setWorkload($result);
		Database::getInstance()->update($this);

		return $result;
	}

	public function addPreviousCourse(CourseModel $course)
	{
		Database::getInstance()->add($this, $course, 'previous');
	}

	public function getPreviousCourse()
	{
		return Database::getInstance()->getAllBy($this,'Course','previous');
	}

	public function addCurrentCourse(CourseModel $course)
	{
		Database::getInstance()->add($this, $course, 'current');
	}

	public function getCurrentCourse()
	{
		return Database::getInstance()->getAllBy($this,'Course','current');
	}

} 