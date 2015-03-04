<?php

/**
 * Interface StudentModelInterface
 */
interface StudentModelInterface extends ModelInterface
{
	/**
	 * @return mixed
	 */
	public function getBirthday();

	/**
	 * @param $birthday
	 * @return mixed
	 */
	public function setBirthday($birthday);

	/**
	 * @return mixed
	 */
	public function getName();

	/**
	 * @param $name
	 * @return mixed
	 */
	public function setName($name);

	/**
	 * @return mixed
	 */
	public function getSurname();

	/**
	 * @param $surname
	 * @return mixed
	 */
	public function setSurname($surname);

	/**
	 * @return mixed
	 */
	public function getGPA();

	/**
	 * @param $gpa
	 * @return mixed
	 */
	public function setGPA($gpa);

	/**
	 * @return mixed
	 */
	public function getWorkload();

	/**
	 * @param $workload
	 * @return mixed
	 */
	public function setWorkload($workload);
} 