<?php

use CourseModel as Course;

interface CourseRepositoryInterface extends RepositoryInterface
{
	public function create($name, $ects, $group, $semester);

	public function getCurrentCourses();

	public function getNumberOfCurrentGroups(Course $course);

	public function getNumberPreviouslyTaught(Course $course);

	public function getCurrentCoursesGroupsAndPreviously();
} 