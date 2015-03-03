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

	function newStudent($surname, $name, $birthday)
	{
		return $this->studentRepository->create($surname, $name, $birthday);
	}

	function updateStudent(Student $student)
	{
		$this->studentRepository->update($student);
	}

	function getAllStudent()
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
		return $this->studentRepository->addRegisteredCourse($student);
	}

	function addRegisteredCourse(Student $student, Course $course)
	{
		$this->studentRepository->addRegisteredCourse($student, $course);
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