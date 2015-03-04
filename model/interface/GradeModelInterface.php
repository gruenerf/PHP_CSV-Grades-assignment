<?php

/**
 * Interface GradeModelInterface
 */
interface GradeModelInterface extends ModelInterface
{
	/**
	 * @return mixed
	 */
	public function getCourseId();

	/**
	 * @param $courseId
	 * @return mixed
	 */
	public function setCourseId($courseId);

	/**
	 * @return mixed
	 */
	public function getGrade();

	/**
	 * @param $grade
	 * @return mixed
	 */
	public function setGrade($grade);

	/**
	 * @return mixed
	 */
	public function getSemester();

	/**
	 * @param $semster
	 * @return mixed
	 */
	public function setSemester($semster);

	/**
	 * @return mixed
	 */
	public function getStudentId();

	/**
	 * @param $studentId
	 * @return mixed
	 */
	public function setStudentId($studentId);

	/**
	 * @return mixed
	 */
	public function getDate();

	/**
	 * @param DateTime $date
	 * @return mixed
	 */
	public function setDate(DateTime $date);
} 