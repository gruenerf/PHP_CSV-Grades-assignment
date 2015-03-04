<?php

use StudentModel as Student;
use CourseModel as Course;

/**
 * Interface StudentRepositoryInterface
 */
interface StudentRepositoryInterface extends RepositoryInterface
{
	/**
	 * @param $name
	 * @param $surname
	 * @param $birthday
	 * @return mixed
	 */
	public function create($name, $surname, $birthday);

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
	public function getCompletedCourse(Student $student);

	/**
	 * @param StudentModel $student
	 * @return mixed
	 */
	public function getCurrentCourse(Student $student);

	/**
	 * @param StudentModel $student
	 * @return mixed
	 */
	public function getAllGradeByStudent(Student $student);

	/**
	 * @param StudentModel $student
	 * @return mixed
	 */
	public function getAllCourseByStudent(Student $student);

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

	/**
	 * @param StudentModel $student
	 * @param CourseModel $course
	 * @return mixed
	 */
	public function checkIfStudentIsRegisteredForCourse(Student $student, Course $course);

	/**
	 * @param StudentModel $student
	 * @param CourseModel $course
	 * @return mixed
	 */
	public function checkIfStudentHasBeenGradedInCourse(Student $student, Course $course);
} 