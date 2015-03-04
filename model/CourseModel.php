<?php

/**
 * Class CourseModel
 */
use ErrorModel as Error;
class CourseModel implements CourseModelInterface
{
	/**
	 * Private variables
	 */

	private $id, $name, $ects, $group, $semester;

	/**
	 * Static counter for ids
	 * @var int
	 */

	private static $counter = 0;

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
	 * @param $semester
	 * @param null $id
	 * @param bool $save
	 */
	public function __construct($name, $ects, $group, $semester, $id = NULL, $save = true)
	{
		$this->name = $name;
		$this->ects = $ects;
		$this->group = $group;

		// If Semester is passed by date transform it
		if ($semester instanceof DateTime) {
			$semesterBuffer = CourseRepository::getInstance()->dateToSemester($semester);
			$currentSemester = CourseRepository::getInstance()->getCurrentSemester();

			// The current semester is the latest semester courses can be asigned to. Courses in the future are set back to current semester.
			// Courses in the past are set as usual.
			if (CourseRepository::getInstance()->compareSemesterDate($currentSemester, $semesterBuffer)) {
				$this->semester = $semesterBuffer;
			} else {
				$this->semester = $currentSemester;
			}
		}
		else{
			$this->semester = $semester;
		}

		if ($save) {
			$this->id = $this->save();
		} else {
			$this->id = $id;
		}

	}

	/**
	 * Saves the Object
	 */
	public function save()
	{
		if (file_exists(ROOT_PATH . "/data/course.txt")) {
			$fh = fopen(ROOT_PATH . "/data/course.txt", 'a') or die ('Failed!');
		} else {
			$fh = fopen(ROOT_PATH . "/data/course.txt", 'w') or die ('Failed!');
			fputcsv($fh, array('id', 'name', 'ects', 'group', 'semester'));
		}

		fputcsv($fh, $this->toArray());

		fclose($fh);

		return self::$counter++;
	}

	/**
	 * Updates the Object
	 */
	public function update()
	{
		$objectArray = CourseRepository::getInstance()->getAll();

		for ($i = 0; $i < count($objectArray); $i++) {
			if ($objectArray[$i]->getId() == $this->getId()) {
				$objectArray[$i] = $this;
				break;
			}
		}

		if (!unlink(ROOT_PATH . "/data/course.txt")) {
			new Error("Error deleting course.txt");
		}

		foreach ($objectArray as $object) {
			$object->save($object);
		}
	}

	/**
	 * Returns Array representation of Class
	 *
	 * @return array
	 */
	public function toArray()
	{
		if ($this->getId() === null) {
			$id = self::$counter;
		} else {
			$id = $this->getId();
		}

		return array($id, $this->getName(), $this->getEcts(), $this->getGroup(), $this->getSemester());
	}

}