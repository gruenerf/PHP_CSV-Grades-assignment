<?php

/**
 * Class LecturerModel
 */
use ErrorModel as Error;

class LecturerModel implements LecturerModelInterface
{
	/**
	 * Private variables
	 */

	private $id, $title, $name, $surname, $birthday, $workload;

	/**
	 * Static counter for ids
	 * @var int
	 */

	private static $counter = 0;


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
	 * @param $title
	 * @param $name
	 * @param $surname
	 * @param $birthday
	 * @param string $workload
	 * @param null $id
	 * @param bool $save
	 */
	public function __construct($title, $name, $surname, $birthday, $workload = "undefined", $id = NULL, $save = true)
	{
		$this->title = $title;
		$this->name = $name;
		$this->surname = $surname;
		$this->birthday = $birthday;
		$this->workload = $workload;

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
		if (file_exists(ROOT_PATH . "/data/lecturer.txt")) {
			$fh = fopen(ROOT_PATH . "/data/lecturer.txt", 'a') or die ('Failed!');
		} else {
			$fh = fopen(ROOT_PATH . "/data/lecturer.txt", 'w') or die ('Failed!');
			fputcsv($fh, array('id', 'title', 'name', 'surname', 'birthday', 'workload'));
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
		$objectArray = LecturerRepository::getInstance()->getAll();

		for ($i = 0; $i < count($objectArray); $i++) {
			if ($objectArray[$i]->getId() == $this->getId()) {
				$objectArray[$i] = $this;
				break;
			}
		}

		if (!unlink(ROOT_PATH . "/data/lecturer.txt")) {
			new Error("Error deleting lecturer.txt");
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
			$id = self::$counter;
		} else {
			$id = $this->getId();
		}
		return array($id, $this->getTitle(), $this->getName(), $this->getSurname(), $this->getBirthday(), $this->getWorkload());
	}
} 