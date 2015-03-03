<?php

use StudentModel as Student;
use CourseModel as Course;

interface StudentRepositoryInterface extends RepositoryInterface
{
	public function create($name, $surname, $birthday);

	public function addRegisteredCourse(Student $student, Course $course);

	public function getCompletedCourse(Student $student);

	public function getCurrentCourse(Student $student);

	public function getAllGradeByStudent(Student $student);

	public function getAllCourseByStudent(Student $student);

	public function getWorkload(Student $student);

	public function geteGpa(Student $student);

	public function getStatus(Student $student);

	public function transformGradeToInt($grade);
} 