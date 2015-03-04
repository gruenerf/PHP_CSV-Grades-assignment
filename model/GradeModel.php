<?php

/**
 * Class GradeModel
 */
use ErrorModel as Error;

class GradeModel implements GradeModelInterface
{
	/**
	 * Private variables
	 */

	private $id, $studentId, $courseId, $grade, $semester, $date;

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

	public function getDate(){
		return $this->date;
	}

	public function setDate(DateTime $date){
		$this->date = $date;
	}

	/**
	 * Constructor
	 * @param $studentId
	 * @param $courseId
	 * @param $grade
	 * @param DateTime $date
	 * @param null $id
	 * @param bool $save
	 */
	public function __construct($studentId, $courseId, $grade, DateTime $date, $id = NULL, $save = true)
	{
		$this->studentId = $studentId;
		$this->courseId = $courseId;
		$this->grade = $grade;

		// is the semester in which the course was originally taught
		$this->semester = CourseRepository::getInstance()->getById($courseId)->getSemester();

		// the date when the exam was taken
		$this->date = $date->format('Y-m-d');

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
			fputcsv($fh, array('id', 'studentId', 'courseId', 'grade', 'courseSemester', 'date'));
		}

		fputcsv($fh, $this->toArray());

		fclose($fh);

		return $_SESSION['gradeId']++;
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
		if ($this->getId() === NULL) {
			if (isset($_SESSION['gradeId'])) {
				$id = $_SESSION['gradeId'];
			} else {
				$_SESSION['gradeId'] = 1;
				$id = $_SESSION['gradeId'];
			}
		} else {
			$id = $this->getId();
		}

		return array($id, $this->getStudentId(), $this->getCourseId(), $this->getGrade(), $this->getSemester(), $this->getDate());
	}
}