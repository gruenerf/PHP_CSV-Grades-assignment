<?php

/**
 * Class StudentModel
 */
use ErrorModel as Error;

class StudentModel implements StudentModelInterface
{
	/**
	 * Private variables
	 */

	private $id, $name, $surname, $birthday, $workload, $gpa;

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
	 * @param $name
	 * @param $surname
	 * @param $birthday
	 * @param string $workload
	 * @param string $gpa
	 * @param null $id
	 * @param bool $save
	 */
	public function __construct($name, $surname, $birthday, $workload = "undefined", $gpa = "undefined", $id = NULL, $save = true)
	{
		$this->name = $name;
		$this->surname = $surname;
		$this->birthday = $birthday;
		$this->workload = $workload;
		$this->gpa = $gpa;

		if ($save) {
			$this->id = $this->save($this);
		} else {
			$this->id = $id;
		}
	}

	/**
	 * Saves the Object
	 */
	public function save()
	{
		if (file_exists(ROOT_PATH . "/data/student.txt")) {
			$fh = fopen(ROOT_PATH . "/data/student.txt", 'a') or die ('Failed!');
		} else {
			$fh = fopen(ROOT_PATH . "/data/student.txt", 'w') or die ('Failed!');
			fputcsv($fh, array('id', 'name', 'surname', 'birthday', 'workload', 'gpa'));
		}

		fputcsv($fh, $this->toArray());

		fclose($fh);

		return $_SESSION['studentId']++;
	}

	/**
	 * Updates the Object
	 */
	public function update()
	{
		$objectArray = StudentRepository::getInstance()->getAll();

		for ($i = 0; $i < count($objectArray); $i++) {
			if ($objectArray[$i]->getId() == $this->getId()) {
				$objectArray[$i] = $this;
				break;
			}
		}

		if (!unlink(ROOT_PATH . "/data/student.txt")) {
			new Error("Error deleting student.txt");
		}

		foreach ($objectArray as $object) {
			$object->save();
		}
	}

	/**
	 * Returns Array representation of Class
	 *
	 * @return array
	 */
	public function toArray()
	{


		if ($this->getId() === NULL) {
			if (isset($_SESSION['studentId'])) {
				$id = $_SESSION['studentId'];
			} else {
				$_SESSION['studentId'] = 1;
				$id = $_SESSION['studentId'];
			}
		} else {
			$id = $this->getId();
		}

		return array($id, $this->getName(), $this->getSurname(), $this->getBirthday(), $this->getWorkload(), $this->getGPA());
	}

}