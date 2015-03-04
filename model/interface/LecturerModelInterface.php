<?php

/**
 * Interface LecturerModelInterface
 */
interface LecturerModelInterface extends ModelInterface
{
	/**
	 * @return mixed
	 */
	public function getTitle();

	/**
	 * @param $title
	 * @return mixed
	 */
	public function setTitle($title);

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
	public function getWorkload();

	/**
	 * @param $workload
	 * @return mixed
	 */
	public function setWorkload($workload);
}