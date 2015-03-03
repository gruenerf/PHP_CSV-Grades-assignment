<?php

/**
 * Class GradeModel
 */
use ErrorModel as Error;

class GradeModel extends BaseModel implements GradeModelInterface
{
	/**
	 * Private variables
	 */

	private $id, $studentId, $courseId, $grade, $semester;

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

	public function getSemester()
	{
		return $this->semester;
	}

	public function setSemester($semester)
	{
		$this->semester = $semester;
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
	 * @param $studentId
	 * @param $courseId
	 * @param $grade
	 * @param null $id
	 * @param bool $save
	 */
	public function __construct($studentId, $courseId, $grade, $id = NULL, $save = true)
	{
		$this->studentId = $studentId;
		$this->courseId = $courseId;
		$this->grade = $grade;
		$this->year = CourseRepository::getInstance()->getById($courseId)->getSemester();

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
		if (file_exists(ROOT_PATH . "/data/grade.txt")) {
			$fh = fopen(ROOT_PATH . "/data/grade.txt", 'a') or die ('Failed!');
		} else {
			$fh = fopen(ROOT_PATH . "/data/grade.txt", 'w') or die ('Failed!');
			fputcsv($fh, array('id', 'studentId', 'courseId', 'grade', 'year'));
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
		$objectArray = GradeRepository::getInstance()->getAll();

		for ($i = 0; $i < count($objectArray); $i++) {
			if ($objectArray[$i]->getId() == $this->getId()) {
				$objectArray[$i] = $this;
				break;
			}
		}

		if (!unlink(ROOT_PATH . "/data/grade.txt")) {
			new Error("Error deleting grade.txt");
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
		if ($this->getId() === null) {
			$id = self::$counter;
		} else {
			$id = $this->getId();
		}

		return array($id, $this->getStudentId(), $this->getCourseId(), $this->getGrade(), $this->getYear());
	}
}