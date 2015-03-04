<?php

use CourseModel as Course;

/**
 * Interface CourseRepositoryInterface
 */
interface CourseRepositoryInterface extends RepositoryInterface
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
	 * @return mixed
	 */
	public function getCurrentCourses();

	/**
	 * @param CourseModel $course
	 * @return mixed
	 */
	public function getNumberOfCurrentGroups(Course $course);

	/**
	 * @param CourseModel $course
	 * @return mixed
	 */
	public function getNumberPreviouslyTaught(Course $course);

	/**
	 * @return mixed
	 */
	public function getCurrentCoursesGroupsAndPreviously();
} 