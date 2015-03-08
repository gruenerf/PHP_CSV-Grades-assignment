<?php

use CourseModel as Course;

/**
 * Interface CourseControllerInterface
 */
interface CourseControllerInterface
{
	/**
	 * @param $name
	 * @param $ects
	 * @param $group
	 * @param $semester
	 * @return mixed
	 */
	public function create($name, $ects, $group, $semester);

	/**
	 * @param Course $course
	 * @return mixed
	 */
	public function update(Course $course);

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
	 * @param Course $course
	 * @return mixed
	 */
	public function getNumberOfGroups(Course $course);

	/**
	 * @param Course $course
	 * @return mixed
	 */
	public function getNumberPreviouslyTaught(Course $course);

	/**
	 * @return mixed
	 */
	public function getCurrentCoursesGroupsAndPreviously();
} 