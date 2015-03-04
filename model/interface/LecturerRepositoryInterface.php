<?php

use CourseModel as Course;
use LecturerModel as Lecturer;

/**
 * Interface LecturerRepositoryInterface
 */
interface LecturerRepositoryInterface extends RepositoryInterface
{
	/**
	 * @param $title
	 * @param $name
	 * @param $surname
	 * @param $birthday
	 * @return mixed
	 */
	public function create($title, $name, $surname, $birthday);

	/**
	 * @param LecturerModel $lecturer
	 * @return mixed
	 */
	public function getWorkload(Lecturer $lecturer);

	/**
	 * @param LecturerModel $lecturer
	 * @return mixed
	 */
	public function getPreviousCourse(Lecturer $lecturer);

	/**
	 * @param LecturerModel $lecturer
	 * @return mixed
	 */
	public function getAllCourseByLecturer(Lecturer $lecturer);

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
	public function getCurrentCourse(Lecturer $lecturer);
}