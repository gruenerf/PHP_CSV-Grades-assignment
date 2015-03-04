<?php

use StudentModel as Student;
use CourseModel as Course;

class StudentController
{
	private $studentRepository;

	public function __construct(StudentRepositoryInterface $studentRepository)
	{
		$this->studentRepository = $studentRepository;
	}

	function create($surname, $name, $birthday)
	{
		return $this->studentRepository->create($surname, $name, $birthday);
	}

	function update(Student $student)
	{
		$this->studentRepository->update($student);
	}

	function getById($id){
		return $this->studentRepository->getById($id);
	}

	function getAll()
	{
		return $this->studentRepository->getAll();
	}

	function getAllGradeByStudent(Student $student)
	{
		return $this->studentRepository->getAllGradeByStudent($student);
	}

	function getAllCompletedCourse(Student $student)
	{
		return $this->studentRepository->getCompletedCourse($student);
	}

	function getAllRegisteredCourse(Student $student)
	{
		return $this->studentRepository->getAllCourseByStudent($student);
	}

	function addCourse(Student $student, Course $course)
	{
		$this->studentRepository->addCourse($student, $course);
	}

	function getWorkload(Student $student)
	{
		return $this->studentRepository->getWorkload($student);
	}

	function getGpa(Student $student)
	{
		return $this->studentRepository->getGPA($student);
	}

	function getStatus(Student $student)
	{
		return $this->studentRepository->getStatus($student);
	}


}