<?php

use CourseModel as Course;
use LecturerModel as Lecturer;

interface LecturerRepositoryInterface extends RepositoryInterface
{
	public function create($title, $name, $surname, $birthday);

	public function calculateWorkload(Lecturer $lecturer);

	public function getPreviousCourse(Lecturer $lecturer);

	public function getAllCourseByLecturer(Lecturer $lecturer);

	public function addCourse(Lecturer $lecturer, Course $course);

	public function getCurrentCourse(Lecturer $lecturer);
}