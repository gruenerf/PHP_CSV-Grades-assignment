<?php

use LecturerModel as Lecturer;
use CourseModel as Course;

/**
 * Interface LecturerControllerInterface
 */
interface LecturerControllerInterface
{
	/**
	 * @param $title
	 * @param $surname
	 * @param $name
	 * @param $birthday
	 * @return mixed
	 */
	public function create($title, $surname, $name, $birthday);

	/**
	 * @param LecturerModel $lecturer
	 * @return mixed
	 */
	public function update(Lecturer $lecturer);

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
	 * @param LecturerModel $lecturer
	 * @return mixed
	 */
	public function getAllCourseByLecturerPrevious(Lecturer $lecturer);

	/**
	 * @param LecturerModel $lecturer
	 * @return mixed
	 */
	public function getAllCourseByLecturerCurrent(Lecturer $lecturer);

	/**
	 * @param LecturerModel $lecturer
	 * @param CourseModel $course
	 * @return mixed
	 */
	public function addCourse(Lecturer $lecturer, Course $course);

	/**
	 * @param LecturerModel $lecturer
	 * @return mixed
	 */
	public function getWorkload(Lecturer $lecturer);
} 