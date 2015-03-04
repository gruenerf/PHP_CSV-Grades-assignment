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

	public function create($studentId, $courseId, $grade)
	{
		return new Grade($studentId, $courseId, $grade);
	}

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
				array_push($objectArray, new Grade($a[1], $a[2], $a[3], $a[0], false));
			}
		};

		fclose($fh);

		return $objectArray;
	}

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
			$tempArray['grade'] = $grade->getGrade();

			array_push($arrayBuffer, $tempArray);
		}

		if ($dir == 'asc') {
			usort($arrayBuffer, function ($a, $b) use ($attr) {
				if ($attr == 'title' | $attr == 'name' | $attr == 'surname' | $attr == 'grade') {
					return strcmp($a[$attr], $b[$attr]);
				} elseif ($attr == 'semester') {
					return self::compareSemesterDate($a[$attr], $b[$attr]);
				} elseif ($attr == 'group') {
					return $a[$attr] - $b[$attr];
				}
			});
			return $arrayBuffer;
		} elseif ($dir == 'desc') {
			usort($arrayBuffer, function ($a, $b) use ($attr) {
				if ($attr == 'title' | $attr == 'name' | $attr == 'surname' | $attr == 'grade') {
					return strcmp($b[$attr], $a[$attr]);
				} elseif ($attr == 'semester') {
					return self::compareSemesterDate($b[$attr], $a[$attr]);
				} elseif ($attr == 'group') {
					return $b[$attr] - $a[$attr];
				}
			});
			return $arrayBuffer;
		} else {
			return $arrayBuffer;
		}

	}

	public function uploadGrades(array $csvArray)
	{
		$notifications = array();

		if (!empty($csvArray)) {
			foreach ($csvArray as $grade) {
				if ($student = StudentRepository::getInstance()->getById($grade[0])) {
					if ($course = CourseRepository::getInstance()->getById($grade[1])) {
						if (StudentRepository::getInstance()->checkIfStudentIsRegisteredForCourse($student, $course)) {
							$gradedArray = StudentRepository::getInstance()->checkIfStudentHasBeenGradedInCourse($student, $course);
							var_dump($gradedArray);

							// Assuming Grade E+F means not passing the exam
							if (!$gradedArray[0] | ($gradedArray[0] && self::transformGradeToInt($gradedArray[1]) < 2)) {

								// Create grade
								GradeRepository::getInstance()->create($grade[0], $grade[1], $grade[2]);
							} else {
								array_push($notifications, ErrorRepository::getInstance()->create('Student with id=' . $grade[0] . ' has already passed Course with id=' . $grade[1] . '.')->getErrormessage());
							}
						} else {
							array_push($notifications, ErrorRepository::getInstance()->create('Student with id=' . $grade[0] . ' has not been registered for course with id=' . $grade[1] . '.')->getErrormessage());
						}
					} else {
						array_push($notifications, ErrorRepository::getInstance()->create('Course with id=' . $grade[1] . ' does not exist!')->getErrormessage());
					}
				} else {
					array_push($notifications, ErrorRepository::getInstance()->create('Student with id=' . $grade[0] . ' does not exist!')->getErrormessage());
				}
			}

			array_push($notifications, 'Upload completed');
			return $notifications;
		} else {
			array_push($notifications, ErrorRepository::getInstance()->create('No grades were uploaded!')->getErrormessage());
			return $notifications;
		}
	}


}