<?php

use GradeModel as Grade;

/**
 * Interface GradeControllerInterface
 */
interface GradeControllerInterface
{
	/**
	 * @param $student
	 * @param $course
	 * @param $grade
	 * @param DateTime $date
	 * @return mixed
	 */
	public function create($student, $course, $grade, DateTime $date);

	/**
	 * @param GradeModel $grade
	 * @return mixed
	 */
	public function update($grade);

	/**
	 * @param $id
	 * @return mixed
	 */
	public function getById($id);

	/**
	 * @return mixed
	 */
	public function getAll();

	/**
	 * @param null $attr
	 * @param null $dir
	 * @return mixed
	 */
	public function getAllSorted($attr = null, $dir = null);

	/**
	 * @param array $csvArray
	 * @return mixed
	 */public function uploadGrades(array $csvArray);
} 