<?php

class BaseRepository
{
	/**
	 * Updates a Object in the database
	 * @param $object
	 */
	public function update($object)
	{
		$object->update();
	}

	/**
	 * Transforms Grade into Integer Representation
	 * @param $grade
	 * @return int
	 */
	public function transformGradeToInt($grade)
	{
		switch ($grade) {
			case 'A' :
				return 5;
			case 'B' :
				return 4;
			case 'C' :
				return 3;
			case 'D' :
				return 2;
			case 'E' :
				return 1;
			case 'F' :
				return 0;
		}

		return null;
	}

	/**
	 * Returns String Representation of semester
	 *
	 * @param DateTime $date
	 * @return string
	 */
	public function dateToSemester(DateTime $date)
	{
		$year = $date->format('y');
		$month = $date->format('m');
		$semester = '';

		if ($month <= 6) {
			// summersemester
			$semester .= 'ss';
		} else {
			// wintersemester
			$semester .= 'ws';
		}

		return $semester . '' . $year;
	}

	/**
	 * Returns current Semester as String
	 *
	 * @return string
	 */
	public function getCurrentSemester()
	{
		return self::dateToSemester(new DateTime('now'));
	}

	/**
	 * Returns true when Semester2 is equal or older than Semester1
	 *
	 * @param $semester1
	 * @param $semester2
	 * @return bool
	 */
	public function compareSemesterDate($semester1, $semester2)
	{

		$length1 = strlen($semester1) - 2;
		$ss_ws1 = substr($semester1, 0, 2);
		$year1 = substr($semester1, 2, $length1);
		$length2 = strlen($semester2) - 2;
		$ss_ws2 = substr($semester2, 0, 2);
		$year2 = substr($semester2, 2, $length2);


		if ($year2 < $year1) {
			return true;
		} elseif ($year2 == $year1) {
			if ($ss_ws1 == $ss_ws2) {
				return true;
			} elseif ($ss_ws1 == 'ws') {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
} 