<?php

/**
 * Class LecturerModel
 */
class LecturerModel
{
	/**
	 * @var int
	 */
	private static $counter = 0;

	/**
	 * @param Lecturer $o
	 */
	public static function saveLecturer(Lecturer $o)
	{
		if (file_exists(ROOT_PATH . "/data/lecturer.txt")) {
			$fh = fopen(ROOT_PATH . "/data/lecturer.txt", 'a') or die ('Failed!');
		} else {
			$fh = fopen(ROOT_PATH . "/data/lecturer.txt", 'w') or die ('Failed!');
			fputcsv($fh, array('id', 'title', 'surname', 'name', 'birthday'));
		}

		fputcsv($fh, self::toArray($o));

		fclose($fh);

		self::$counter++;
	}

	/**
	 * @param $id
	 * @return null
	 */
	public static function getLecturerById($id)
	{
		$lecturerArray = self::getAllLecturer();

		foreach ($lecturerArray as $lecturer) {
			if (intval($lecturer->getId()) === $id) {
				return $lecturer;
			}
		}

		return null;
	}

	/**
	 * @param Lecturer $lecturer
	 */
	public static function updateLecturer(Lecturer $lecturer)
	{
		$lecturerArray = self::getAllLecturer();

		for ($i = 0; $i < count($lecturerArray); $i++) {
			if ($lecturerArray[$i]->getId() === $lecturer->getId()) {
				$lecturerArray[$i] = $lecturer;
				break;
			}
		}

		$fh = fopen(ROOT_PATH . "/data/lecturer.txt", "w");

		fputcsv($fh, array('id', 'title', 'surname', 'name', 'birthday'));
		foreach ($lecturerArray as $lecturer) {
			fputcsv($fh, self::toArray($lecturer));
		}

		fclose($fh);
	}

	/**
	 * @return array
	 */
	public static function getAllLecturer()
	{
		$lecturerArray = array();
		if (file_exists(ROOT_PATH . "/data/lecturer.txt")) {
			$fh = fopen(ROOT_PATH . "/data/lecturer.txt", "r") or die ('Failed!');
		} else {
			new Error("lecturer file does not exist");
			return $lecturerArray;
		}

		while (!feof($fh)) {
			$a = fgetcsv($fh);

			if ($a[0] !== '' && $a[0] !== 'id' && $a[0] !== null) {
				array_push($lecturerArray, new Lecturer($a[1], $a[2], $a[3], $a[4], $a[0], false));
			}
		};

		fclose($fh);

		return $lecturerArray;
	}

	/**
	 * @param Lecturer $l
	 * @param Course $c
	 */
	public static function addPreviousCourse(Lecturer $l, Course $c)
	{
		$fh = fopen(ROOT_PATH . "/data/lecturer_course_previous.txt", 'a') or die ('Failed!');

		fwrite($fh, $l->getId() . "," . $c->getId() . "\n");

		fclose($fh);
	}

	/**
	 * @param Lecturer $l
	 * @param Course $c
	 */
	public static function addCurrentCourse(Lecturer $l, Course $c)
	{
		$fh = fopen(ROOT_PATH . "/data/lecturer_course_current.txt", 'a') or die ('Failed!');

		fwrite($fh, $l->getId() . "," . $c->getId() . "\n");

		fclose($fh);
	}

	/**
	 * @param Lecturer $o
	 * @return string
	 */
	private static function toArray(Lecturer $o)
	{
		if ($o->getId() === null) {
			$id = self::$counter;
		} else {
			$id = $o->getId();
		}

		return array($id, $o->getTitle(), $o->getSurname(), $o->getName(), $o->getBirthday());
	}

} 