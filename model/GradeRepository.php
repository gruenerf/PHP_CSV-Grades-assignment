<?php

use GradeModel as Grade;
use ErrorModel as Error;

class GradeRepository extends BaseRepository implements GradeRepositoryInterface
{

	/**
	 * static instance
	 */
	private static $gradeRepository = null;


	/**
	 * Empty constructor for singleton
	 */
	public function __construct()
	{
	}

	/**
	 *  Singleton returns the one instance
	 */
	public static function getInstance()
	{
		if (self::$gradeRepository == null) {
			self::$gradeRepository = new GradeRepository();
		}

		return self::$gradeRepository;
	}

	/**
	 * creates a Grade object
	 * @param $studentId
	 * @param $courseId
	 * @param $grade
	 * @param DateTime $date
	 * @return GradeModel|mixed
	 */
	public function create($studentId, $courseId, $grade, DateTime $date)
	{
		return new Grade($studentId, $courseId, $grade, $date);
	}

	/**
	 * Returns the highest id of the csv file
	 * @return int
	 */
	public function getHighestId()
	{
		if (file_exists(ROOT_PATH . "/data/grade.txt")) {
			$rows = file(ROOT_PATH . "/data/grade.txt");
		} else {
			new Error("grade.txt does not exist");
			return 0;
		}

		$last_row = array_pop($rows);
		$data = str_getcsv($last_row);

		if($data[0] == 'id'){
			return 0;
		}

		return $data[0];
	}

	/**
	 * Returns a grade object with a certain id
	 * @param $id
	 * @return mixed|null
	 */
	public function getById($id)
	{
		$array = $this->getAll();

		foreach ($array as $object) {
			if (intval($object->getId()) === intval($id)) {
				return $object;
			}
		}

		return null;
	}

	/**
	 * Returns all gradeObjects
	 * @return array|mixed
	 */
	public function getAll()
	{
		$objectArray = array();

		if (file_exists(ROOT_PATH . "/data/grade.txt")) {
			$fh = fopen(ROOT_PATH . "/data/grade.txt", "r") or die ('Failed!');
		} else {
			new Error("grade.txt does not exist");
			return $objectArray;
		}

		while (!feof($fh)) {
			$a = fgetcsv($fh);

			if ($a[0] !== '' && $a[0] !== 'id' && $a[0] !== null) {
				array_push($objectArray, new Grade($a[1], $a[2], $a[3], new DateTime($a[5]), $a[0], false));
			}
		};

		fclose($fh);

		return $objectArray;
	}

	/**
	 * returns a grade array which is sorted after a certain attribute eiter ascending or descending
	 * @param $attr
	 * @param $dir
	 * @return array|mixed
	 */
	public function getAllSorted($attr, $dir)
	{
		$array = $this->getAll();

		$arrayBuffer = array();

		foreach ($array as $grade) {
			$tempArray = array();
			$tempArray['title'] = CourseRepository::getInstance()->getById($grade->getCourseId())->getName();
			$tempArray['group'] = CourseRepository::getInstance()->getById($grade->getCourseId())->getGroup();
			$tempArray['name'] = StudentRepository::getInstance()->getById($grade->getStudentId())->getName();
			$tempArray['surname'] = StudentRepository::getInstance()->getById($grade->getStudentId())->getSurname();
			$tempArray['semester'] = $grade->getSemester();
			$tempArray['date'] = StudentRepository::getInstance()->dateToSemester(new DateTime($grade->getDate()));
			$tempArray['grade'] = $grade->getGrade();

			array_push($arrayBuffer, $tempArray);
		}

		// sort array ascending
		if ($dir == 'asc') {
			usort($arrayBuffer, function ($a, $b) use ($attr) {
				if ($attr == 'title' | $attr == 'name' | $attr == 'surname' | $attr == 'grade') {
					return strcmp($a[$attr], $b[$attr]);
				} elseif ($attr == 'semester' | $attr == 'date') {
					return self::compareSemesterDate($a[$attr], $b[$attr]);
				} else {
					return $a[$attr] - $b[$attr];
				}
			});
			return $arrayBuffer;
		} // sort array descending
		elseif ($dir == 'desc') {
			usort($arrayBuffer, function ($a, $b) use ($attr) {
				if ($attr == 'title' | $attr == 'name' | $attr == 'surname' | $attr == 'grade') {
					return strcmp($b[$attr], $a[$attr]);
				} elseif ($attr == 'semester' | $attr == 'date') {
					return self::compareSemesterDate($b[$attr], $a[$attr]);
				} else {
					return $b[$attr] - $a[$attr];
				}
			});
			return $arrayBuffer;
		} else {
			return $arrayBuffer;
		}

	}

	/**
	 * Uploads grades after they were first validated
	 * @param array $csvArray
	 * @return array|mixed
	 */
	public function uploadGrades(array $csvArray)
	{
		$notifications = array();

		if (!empty($csvArray)) {
			foreach ($csvArray as $grade) {

				// Does the student exist
				if ($student = StudentRepository::getInstance()->getById($grade[0])) {

					// Does the course exist
					if ($course = CourseRepository::getInstance()->getById($grade[1])) {

						// Is the student registered for course
						if (StudentRepository::getInstance()->checkIfStudentIsRegisteredForCourse($student, $course)) {
							$gradedArray = StudentRepository::getInstance()->checkIfStudentHasBeenGradedInCourse($student, $course);

							// Assuming Grade E+F means not passing the exam
							if (!$gradedArray[0] | ($gradedArray[0] && self::transformGradeToInt($gradedArray[1]) < 2)) {

								// Create grade
								GradeRepository::getInstance()->create($grade[0], $grade[1], $grade[2], new DateTime($grade[3]));
							} else {
								// Throw notification
								array_push($notifications, ErrorRepository::getInstance()->create('Student with id=' . $grade[0] . ' has already passed Course with id=' . $grade[1] . '.')->getErrormessage());
							}
						} else {
							// Throw notification
							array_push($notifications, ErrorRepository::getInstance()->create('Student with id=' . $grade[0] . ' has not been registered for course with id=' . $grade[1] . '.')->getErrormessage());
						}
					} else {
						// Throw notification
						array_push($notifications, ErrorRepository::getInstance()->create('Course with id=' . $grade[1] . ' does not exist!')->getErrormessage());
					}
				} else {
					// Throw notification
					array_push($notifications, ErrorRepository::getInstance()->create('Student with id=' . $grade[0] . ' does not exist!')->getErrormessage());
				}
			}

			// Throw notification
			array_push($notifications, 'Upload completed');
			return $notifications;

		} else {

			// Throw notification
			array_push($notifications, ErrorRepository::getInstance()->create('No grades were uploaded!')->getErrormessage());
			return $notifications;
		}
	}


}