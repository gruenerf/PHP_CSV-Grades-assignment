<?php

/**
 * Interface CourseModelInterface
 */
interface CourseModelInterface extends ModelInterface
{
	/**
	 * @return mixed
	 */
	public function getEcts();

	/**
	 * @param $ects
	 * @return mixed
	 */
	public function setEcts($ects);

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
	public function getGroup();

	/**
	 * @param $group
	 * @return mixed
	 */
	public function setGroup($group);

	/**
	 * @return mixed
	 */
	public function getSemester();

	/**
	 * @param $semester
	 * @return mixed
	 */
	public function setSemester($semester);
} 