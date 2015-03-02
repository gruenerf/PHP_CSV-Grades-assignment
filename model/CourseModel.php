<?php

/**
 * Class CourseModel
 */
class CourseModel
{
	/**
	 * Private variables
	 */

	private $id, $name, $ects, $group, $semester;

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

	public function getEcts()
	{
		return $this->ects;
	}

	public function setEcts($ects)
	{
		$this->ects = $ects;
	}

	public function getName()
	{
		return $this->name;
	}

	public function setName($name)
	{
		$this->name = $name;
	}

	public function getGroup()
	{
		return $this->group;
	}

	public function setGroup($group)
	{
		$this->group = $group;
	}

	public function getSemester()
	{
		return $this->semester;
	}

	public function setSemester($semester)
	{
		$this->semester = $semester;
	}

	/**
	 * Constructor
	 * @param $name
	 * @param $ects
	 * @param $group
	 * @param int $id
	 * @param bool $save
	 */

	public function __construct($name, $ects, $group, $semester, $id = 0, $save = true)
	{
		$this->name = $name;
		$this->ects = $ects;
		$this->group = $group;
		$this->semester = $semester;

		if ($save) {
			$this->id = Database::getInstance()->save($this);
		} else {
			$this->id = $id;
		}

	}

} 