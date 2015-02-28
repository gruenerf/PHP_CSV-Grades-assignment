<?php

/**
 * Class Database
 *
 * Does:
 * Save
 * Update
 */
class Database
{
	// static Database instance
	private static $db = null;

	// static counter for ids
	private static $counter;

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
		switch (getQualifiedClassName($o)) {
			case Course :
				if (file_exists(ROOT_PATH . "/data/course.txt")) {
					$fh = fopen(ROOT_PATH . "/data/course.txt", 'a') or die ('Failed!');
				} else {
					$fh = fopen(ROOT_PATH . "/data/course.txt", 'w') or die ('Failed!');
					fputcsv($fh, array('id', 'name', 'ects', 'group', 'semester'));
				}

			case Grade :
				if (file_exists(ROOT_PATH . "/data/grade.txt")) {
					$fh = fopen(ROOT_PATH . "/data/grade.txt", 'a') or die ('Failed!');
				} else {
					$fh = fopen(ROOT_PATH . "/data/grade.txt", 'w') or die ('Failed!');
					fputcsv($fh, array('id', 'studentId', 'courseId', 'grade', 'year'));
				}

			case Lecturer :
				if (file_exists(ROOT_PATH . "/data/lecturer.txt")) {
					$fh = fopen(ROOT_PATH . "/data/lecturer.txt", 'a') or die ('Failed!');
				} else {
					$fh = fopen(ROOT_PATH . "/data/lecturer.txt", 'w') or die ('Failed!');
					fputcsv($fh, array('id', 'title', 'surname', 'name', 'birthday'));
				}

			case Student :
				if (file_exists(ROOT_PATH . "/data/student.txt")) {
					$fh = fopen(ROOT_PATH . "/data/student.txt", 'a') or die ('Failed!');
				} else {
					$fh = fopen(ROOT_PATH . "/data/student.txt", 'w') or die ('Failed!');
					fputcsv($fh, array('id', 'surname', 'name', 'birthday'));
				}

			case Error :
				if (file_exists(ROOT_PATH . "/data/errorlog.txt")) {
					$fh = fopen(ROOT_PATH . "/data/errorlog.txt", 'a') or die ('Failed!');
				} else {
					$fh = fopen(ROOT_PATH . "/data/errorlog.txt", 'w') or die ('Failed!');
					fputcsv($fh, array('date', 'message'));
				}
		}

		fputcsv($fh, $this->toArray($o));

		fclose($fh);

		self::$counter++;
	}

	/**
	 * Updates a certain object
	 *
	 * @param $o
	 */
	public function update($o)
	{
		$objectArray = self::getAll(getQualifiedClassName($o));

		for ($i = 0; $i < count($objectArray); $i++) {
			if ($objectArray[$i]->getId() === $o->getId()) {
				$objectArray[$i] = $o;
				break;
			}
		}

		switch ($o) {
			case Course :
				if (!unlink(ROOT_PATH . "/data/course.txt")) {
					new ErrorModel("Error deleting course.txt");
				}
			case Grade :
				if (!unlink(ROOT_PATH . "/data/grade.txt")) {
					new ErrorModel("Error deleting grade.txt");
				}
			case Lecturer :
				if (!unlink(ROOT_PATH . "/data/lecturer.txt")) {
					new ErrorModel("Error deleting lecturer.txt");
				}
			case Student :
				if (!unlink(ROOT_PATH . "/data/student.txt")) {
					new ErrorModel("Error deleting student.txt");
				}
		}

		foreach ($objectArray as $object) {
			$this->save($object);
		}
	}

	/**
	 * Returns Object by Id
	 *
	 * @param String $type
	 * @param int $id
	 * @return null
	 */
	function getById(String $type, Integer $id)
	{

		switch ($type) {
			case Course :
				$array = $this->getAll('Course');

			case Grade :
				$array = $this->getAll('Grade');

			case Lecturer :
				$array = $this->getAll('Lecturer');

			case Student :
				$array = $this->getAll('Student');
		}

		foreach ($array as $object) {
			if (intval($object->getId()) === $id) {
				return $object;
			}
		}

		return null;
	}

	/**
	 * Returns Array with all Objects of a certain Class
	 *
	 * @param String $s
	 * @return array
	 */
	function getAll(String $s)
	{
		$objectArray = array();

		switch ($s) {
			case Course :
				if (file_exists(ROOT_PATH . "/data/course.txt")) {
					$fh = fopen(ROOT_PATH . "/data/course.txt", "r") or die ('Failed!');
				} else {
					new ErrorModel("course file does not exist");
					return $objectArray;
				}

			case Grade :
				if (file_exists(ROOT_PATH . "/data/grade.txt")) {
					$fh = fopen(ROOT_PATH . "/data/grade.txt", "r") or die ('Failed!');
				} else {
					new ErrorModel("grade file does not exist");
					return $objectArray;
				}

			case Lecturer :
				if (file_exists(ROOT_PATH . "/data/lecturer.txt")) {
					$fh = fopen(ROOT_PATH . "/data/lecturer.txt", "r") or die ('Failed!');
				} else {
					new ErrorModel("lecturer file does not exist");
					return $objectArray;
				}

			case Student :
				if (file_exists(ROOT_PATH . "/data/student.txt")) {
					$fh = fopen(ROOT_PATH . "/data/student.txt", "r") or die ('Failed!');
				} else {
					new ErrorModel("student file does not exist");
					return $objectArray;
				}
		}


		while (!feof($fh)) {
			$a = fgetcsv($fh);

			if ($a[0] !== '' && $a[0] !== 'id' && $a[0] !== null) {

				switch ($s) {
					case Course :
						array_push($objectArray, new Course($a[1], $a[2], $a[3], $a[4], $a[0], false));

					case Grade :
						array_push($objectArray, new Grade($a[1], $a[2], $a[3], $a[4], $a[0], false));

					case Lecturer :
						array_push($objectArray, new Lecturer($a[1], $a[2], $a[3], $a[4], $a[0], false));

					case Student :
						array_push($objectArray, new Student($a[1], $a[2], $a[3], $a[0], false));
				}
			}
		};

		fclose($fh);

		return $objectArray;
	}

	/**
	 * Returns Array of related objects
	 *
	 * @param Object $o
	 * @param String $class -> get all Objects of $class that have a relation to $o
	 * @param String $time -> previous/current optional
	 * @return array
	 */
	function getAllBy($o, String $class, String $time = '')
	{
		$objectArray = array();

		switch (getQualifiedClassName($o)) {
			case Course :

			case Student :
				if ($class == 'Grade') {
					if (file_exists(ROOT_PATH . "/data/grade.txt")) {
						$fh = fopen(ROOT_PATH . "/data/grade.txt", "w");
					} else {
						new Error("grade file does not exist");
						return $objectArray;
					}
				} elseif ($class == 'Course') {
					if (file_exists(ROOT_PATH . "/data/student_course.txt")) {
						$fh = fopen(ROOT_PATH . "/data/student_course.txt", "r");
					} else {
						new Error("student_course file does not exist");
						return $objectArray;
					}
				}

			case Lecturer:
				if ($class == 'Course') {
					if ($time == 'current') {
						if (file_exists(ROOT_PATH . "/data/lecturer_course_current.txt")) {
							$fh = fopen(ROOT_PATH . "/data/lecturer_course_current.txt", "r");
						} else {
							new Error("lecturer_course_current file does not exist");
							return $objectArray;
						}
					} elseif ($time == 'previous') {
						if (file_exists(ROOT_PATH . "/data/lecturer_course_previous.txt")) {
							$fh = fopen(ROOT_PATH . "/data/lecturer_course_previous.txt", "r");
						} else {
							new Error("lecturer_course_previous file does not exist");
							return $objectArray;
						}
					}
				}
		}

		while (!feof($fh)) {
			$a = fgetcsv($fh);

			if ($a[0] !== '' && $a[0] !== 'id' && $a[0] !== null && $a[0] == $o->getId()) {
				array_push($objectArray, $this->getById($class, $a[1]));
			}
		};

		fclose($fh);

		return $objectArray;
	}

	/**
	 * Adds Object $o2 to Object $o1
	 * @param $o
	 * @param $o2
	 * @param String $time -> previous/current optional
	 */
	function add($o, $o2, String $time = '')
	{
		if ($o instanceof LecturerModel) {
			if ($time == 'previous') {
				$fh = fopen(ROOT_PATH . "/data/lecturer_course_previous.txt", 'a') or die ('Failed!');
			} else {
				$fh = fopen(ROOT_PATH . "/data/lecturer_course_current.txt", 'a') or die ('Failed!');
			}
		} elseif ($o instanceof StudentModel) {
			$fh = fopen(ROOT_PATH . "/data/student_course_registered.txt", 'a') or die ('Failed!');
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

		switch (getQualifiedClassName($o)) {
			case Course :
				return array($id, $o->getName(), $o->getEcts(), $o->getGroup(), $o->getSemester());

			case Grade :
				return array($id, $o->getStudentId(), $o->getCourseId(), $o->getGrade(), $o->getYear());

			case Lecturer :
				return array($id, $o->getTitle(), $o->getSurname(), $o->getName(), $o->getBirthday());

			case Student :
				return array($id, $o->getSurname(), $o->getName(), $o->getBirthday());

			case Error :
				return array($id, $o->getDate(), $o->getErrorMessage());
		}

	}
}
