<?php

/**
 * Interface GradeRepositoryInterface
 */
interface GradeRepositoryInterface extends RepositoryInterface
{
	/**
	 * @param $studentId
	 * @param $courseId
	 * @param $grade
	 * @param DateTime $date
	 * @return mixed
	 */
	public function create($studentId, $courseId, $grade, DateTime $date);

	/**
	 * @param $attr
	 * @param $dir
	 * @return mixed
	 */
	public function getAllSorted($attr, $dir);

	/**
	 * @param array $csvArray
	 * @return mixed
	 */
	public function uploadGrades(array $csvArray);
}