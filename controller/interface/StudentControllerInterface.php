<?php

use StudentModel as Student;
use CourseModel as Course;

/**
 * Interface StudentControllerInterface
 */
interface StudentControllerInterface
{
	/**
	 * @param $surname
	 * @param $name
	 * @param $birthday
	 * @return mixed
	 */
	public function create($surname, $name, $birthday);

	/**
	 * @param StudentModel $student
	 * @return mixed
	 */
	public function update(Student $student);

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
	 * @param StudentModel $student
	 * @return mixed
	 */
	public function getAllGradeByStudent(Student $student);

	/**
	 * @param StudentModel $student
	 * @return mixed
	 */
	public function getAllCompletedCourse(Student $student);

	/**
	 * @param StudentModel $student
	 * @return mixed
	 */
	public function getAllRegisteredCourse(Student $student);

	/**
	 * @param StudentModel $student
	 * @param CourseModel $course
	 * @return mixed
	 */
	public function addCourse(Student $student, Course $course);

	/**
	 * @param StudentModel $student
	 * @return mixed
	 */
	public function getWorkload(Student $student);

	/**
	 * @param StudentModel $student
	 * @return mixed
	 */
	public function getGpa(Student $student);

	/**
	 * @param StudentModel $student
	 * @return mixed
	 */
	public function getStatus(Student $student);
} 