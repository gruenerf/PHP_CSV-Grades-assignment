<?php

/**
 * Class Database
 *
 * Does:
 * Save
 * Update
 * Get
 * Add
 */
class Database
{
	// static Database instance
	private static $db = null;

	// static counter for ids
	private static $counter = 0;

	// Empty constructor for singleton
	public function __construct()
	{
	}

	// Singleton returns the one database instance
	public static function getInstance()
	{
		if (self::$db == null) {
			self::$db = new Database();
		}

		return self::$db;
	}

	/**
	 * Saves objects into csv files
	 *
	 * @param $o
	 */
	public function save($o)
	{
		switch (get_class($o)) {
			case 'CourseModel' :
				if (file_exists(ROOT_PATH . "/data/course.txt")) {
					$fh = fopen(ROOT_PATH . "/data/course.txt", 'a') or die ('Failed!');
				} else {
					$fh = fopen(ROOT_PATH . "/data/course.txt", 'w') or die ('Failed!');
					fputcsv($fh, array('id', 'name', 'ects', 'group', 'semester'));
				}
				break;

			case 'GradeModel' :
				if (file_exists(ROOT_PATH . "/data/grade.txt")) {
					$fh = fopen(ROOT_PATH . "/data/grade.txt", 'a') or die ('Failed!');
				} else {
					$fh = fopen(ROOT_PATH . "/data/grade.txt", 'w') or die ('Failed!');
					fputcsv($fh, array('id', 'studentId', 'courseId', 'grade', 'year'));
				}
				break;

			case 'LecturerModel' :
				if (file_exists(ROOT_PATH . "/data/lecturer.txt")) {
					$fh = fopen(ROOT_PATH . "/data/lecturer.txt", 'a') or die ('Failed!');
				} else {
					$fh = fopen(ROOT_PATH . "/data/lecturer.txt", 'w') or die ('Failed!');
					fputcsv($fh, array('id', 'title', 'name', 'surname', 'birthday', 'workload'));
				}
				break;

			case 'StudentModel' :
				if (file_exists(ROOT_PATH . "/data/student.txt")) {
					$fh = fopen(ROOT_PATH . "/data/student.txt", 'a') or die ('Failed!');
				} else {
					$fh = fopen(ROOT_PATH . "/data/student.txt", 'w') or die ('Failed!');
					fputcsv($fh, array('id', 'name', 'surname', 'birthday', 'workload', 'gpa'));
				}
				break;

			case 'ErrorModel' :
				if (file_exists(ROOT_PATH . "/data/errorlog.txt")) {
					$fh = fopen(ROOT_PATH . "/data/errorlog.txt", 'a') or die ('Failed!');
				} else {
					$fh = fopen(ROOT_PATH . "/data/errorlog.txt", 'w') or die ('Failed!');
					fputcsv($fh, array('id', 'date', 'message'));
				}
				break;
		}

		fputcsv($fh, $this->toArray($o));

		fclose($fh);

		return self::$counter++;
	}

	/**
	 * Updates a certain object
	 *
	 * @param $o
	 */
	public function update($o)
	{
		$objectArray = self::getAll(get_class($o));

		for ($i = 0; $i < count($objectArray); $i++) {
			if ($objectArray[$i]->getId() == $o->getId()) {
				$objectArray[$i] = $o;
				break;
			}
		}

		switch (get_class($o)) {
			case 'CourseModel' :
				if (!unlink(ROOT_PATH . "/data/course.txt")) {
					new ErrorModel("Error deleting course.txt");
				}
				break;
			case 'GradeModel' :
				if (!unlink(ROOT_PATH . "/data/grade.txt")) {
					new ErrorModel("Error deleting grade.txt");
				}
				break;
			case 'LecturerModel' :
				if (!unlink(ROOT_PATH . "/data/lecturer.txt")) {
					new ErrorModel("Error deleting lecturer.txt");
				}
				break;
			case 'StudentModel' :
				if (!unlink(ROOT_PATH . "/data/student.txt")) {
					new ErrorModel("Error deleting student.txt");
				}
				break;
		}

		foreach ($objectArray as $object) {
			$this->save($object);
		}
	}

	/**
	 * Returns Object by Id
	 *
	 * @param $type
	 * @param $id
	 * @return null
	 */
	public function getById($type, $id)
	{
		$array = array();

		switch ($type) {
			case 'Course' :
				$array = $this->getAll('CourseModel');
				break;

			case 'Grade' :
				$array = $this->getAll('GradeModel');
				break;

			case 'Lecturer' :
				$array = $this->getAll('LecturerModel');
				break;

			case 'Student' :
				$array = $this->getAll('StudentModel');
				break;
		}

		foreach ($array as $object) {
			if (intval($object->getId()) === intval($id)) {
				return $object;
			}
		}

		return null;
	}

	/**
	 * Returns Array with all Objects of a certain Class
	 *
	 * @param $s
	 * @return array
	 */
	public function getAll($s)
	{
		$objectArray = array();

		switch ($s) {
			case 'CourseModel' :
				if (file_exists(ROOT_PATH . "/data/course.txt")) {
					$fh = fopen(ROOT_PATH . "/data/course.txt", "r") or die ('Failed!');
				} else {
					new ErrorModel("course.txt does not exist");
					return $objectArray;
				}
				break;

			case 'GradeModel' :
				if (file_exists(ROOT_PATH . "/data/grade.txt")) {
					$fh = fopen(ROOT_PATH . "/data/grade.txt", "r") or die ('Failed!');
				} else {
					new ErrorModel("grade.txt does not exist");
					return $objectArray;
				}
				break;

			case 'LecturerModel' :
				if (file_exists(ROOT_PATH . "/data/lecturer.txt")) {
					$fh = fopen(ROOT_PATH . "/data/lecturer.txt", "r") or die ('Failed!');
				} else {
					new ErrorModel("lecturer.txt does not exist");
					return $objectArray;
				}
				break;

			case 'StudentModel' :
				if (file_exists(ROOT_PATH . "/data/student.txt")) {
					$fh = fopen(ROOT_PATH . "/data/student.txt", "r") or die ('Failed!');
				} else {
					new ErrorModel("student.txt does not exist");
					return $objectArray;
				}
				break;
		}


		while (!feof($fh)) {
			$a = fgetcsv($fh);

			if ($a[0] !== '' && $a[0] !== 'id' && $a[0] !== null) {

				switch ($s) {
					case 'CourseModel' :
						array_push($objectArray, new CourseModel($a[1], $a[2], $a[3], $a[4], $a[0], false));
						break;

					case 'GradeModel' :
						array_push($objectArray, new GradeModel($a[1], $a[2], $a[3], $a[4], $a[0], false));
						break;

					case 'LecturerModel' :
						array_push($objectArray, new LecturerModel($a[1], $a[2], $a[3], $a[4], $a[5], $a[0], false));
						break;

					case 'StudentModel' :
						array_push($objectArray, new StudentModel($a[1], $a[2], $a[3], $a[4], $a[5], $a[0], false));
						break;
				}
			}
		};

		fclose($fh);

		return $objectArray;
	}

	/**
	 * Returns Array of related objects
	 *
	 * @param $o
	 * @param $class -> String get all Objects of $class that have a relation to $o
	 * @param $time -> previous/current optional
	 * @return array
	 */
	function getAllBy($o, $class, $time = '')
	{
		$objectArray = array();

		// Index where object id is found in CSV. Typically 0.
		$arrayIndex = 0;
		$arrayIndex2 = 1;

		switch (get_class($o)) {

			case 'StudentModel' :
				if ($class == 'Grade') {
					if (file_exists(ROOT_PATH . "/data/grade.txt")) {
						$fh = fopen(ROOT_PATH . "/data/grade.txt", "r");
						$arrayIndex = 1;
						$arrayIndex2 = 0;
					} else {
						new ErrorModel("grade.txt does not exist");
						return $objectArray;
					}
				} elseif ($class == 'Course') {
					if (file_exists(ROOT_PATH . "/data/student_course.txt")) {
						$fh = fopen(ROOT_PATH . "/data/student_course.txt", "r");
					} else {
						new ErrorModel("student_course.txt does not exist");
						return $objectArray;
					}
				}
				break;

			case 'LecturerModel':
				if ($class == 'Course') {
					if ($time == 'current') {
						if (file_exists(ROOT_PATH . "/data/lecturer_course_current.txt")) {
							$fh = fopen(ROOT_PATH . "/data/lecturer_course_current.txt", "r");
						} else {
							new ErrorModel("lecturer_course_current.txt does not exist");
							return $objectArray;
						}
					} elseif ($time == 'previous') {
						if (file_exists(ROOT_PATH . "/data/lecturer_course_previous.txt")) {
							$fh = fopen(ROOT_PATH . "/data/lecturer_course_previous.txt", "r");
						} else {
							new ErrorModel("lecturer_course_previous.txt does not exist");
							return $objectArray;
						}
					}
				}
				break;
		}

		while (!feof($fh)) {
			$a = fgetcsv($fh);

			if ($a[0] !== '' && $a[0] !== 'id' && $a[0] !== null && $a[$arrayIndex] == $o->getId()) {
				array_push($objectArray, $this->getById($class, $a[$arrayIndex2]));
			}
		};

		fclose($fh);

		return $objectArray;
	}

	/**
	 * Adds Object $o2 to Object $o1
	 * @param $o
	 * @param $o2
	 * @param $time -> previous/current optional
	 */
	function add($o, $o2, $time = '')
	{
		if ($o instanceof LecturerModel) {
			if ($time == 'previous') {
				$fh = fopen(ROOT_PATH . "/data/lecturer_course_previous.txt", 'a') or die ('Failed!');
			} else {
				$fh = fopen(ROOT_PATH . "/data/lecturer_course_current.txt", 'a') or die ('Failed!');
			}
		} elseif ($o instanceof StudentModel) {
			$fh = fopen(ROOT_PATH . "/data/student_course.txt", 'a') or die ('Failed!');
		}

		fwrite($fh, $o->getId() . "," . $o2->getId() . "\n");
		fclose($fh);
	}

	/**
	 * Converts objects into arrays
	 *
	 * @param $o
	 * @return array
	 */
	private function toArray($o)
	{
		if ($o->getId() === null) {
			$id = self::$counter;
		} else {
			$id = $o->getId();
		}

		switch (get_class($o)) {
			case 'CourseModel' :
				return array($id, $o->getName(), $o->getEcts(), $o->getGroup(), $o->getSemester());

			case 'GradeModel' :
				return array($id, $o->getStudentId(), $o->getCourseId(), $o->getGrade(), $o->getYear());

			case 'LecturerModel' :
				return array($id, $o->getTitle(), $o->getSurname(), $o->getName(), $o->getBirthday(), $o->getWorkload());

			case 'StudentModel' :
				return array($id, $o->getSurname(), $o->getName(), $o->getBirthday(), $o->getWorkload(), $o->getGPA());

			case 'ErrorModel' :
				return array($id, $o->getDate()->format('Y-m-d H:i:s'), $o->getErrorMessage());
		}

		return null;
	}
}
