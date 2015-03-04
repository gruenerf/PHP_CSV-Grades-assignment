<?php

use StudentModel as Student;
use CourseModel as Course;

interface StudentRepositoryInterface extends RepositoryInterface
{
	public function create($name, $surname, $birthday);

	public function addCourse(Student $student, Course $course);

	public function getCompletedCourse(Student $student);

	public function getCurrentCourse(Student $student);

	public function getAllGradeByStudent(Student $student);

	public function getAllCourseByStudent(Student $student);

	public function getWorkload(Student $student);

	public function getGpa(Student $student);

	public function getStatus(Student $student);

	public function checkIfStudentIsRegisteredForCourse(Student $student, Course $course);

	public function checkIfStudentHasBeenGradedInCourse(Student $student, Course $course);
} 