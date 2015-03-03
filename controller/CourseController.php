<?php

class CourseController
{
	private $courseRepository;

	public function __construct(CourseRepositoryInterface $courseRepository)
	{
		$this->courseRepository = $courseRepository;
	}

	function newCourse($name, $ects, $group, $semester)
	{
		return $this->courseRepository->create($name, $ects, $group, $semester);
	}

	function updateCourse($course)
	{
		if (get_class($course) == 'CourseModel') {
			Database::getInstance()->update($course);
		} else {
			new ErrorModel('Object not from type CourseModel');
		}
	}

	function getAllCourse()
	{
		return Database::getInstance()->getAll('CourseModel');
	}

	function getAllCourseByStudent(StudentInterface $student)
	{
		return Database::getInstance()->getAllBy($student, 'Course');
	}

	function getAllCourseByLecturerPrevious($lecturer)
	{
		if (get_class($lecturer) == 'LecturerModel') {
			return Database::getInstance()->getAllBy($lecturer, 'Course', 'previous');
		} else {
			new ErrorModel('Object not from type LecturerModel');
		}
	}

	function getAllCourseByLecturerCurrent($lecturer)
	{
		if (get_class($lecturer) == 'LecturerModel') {
			return Database::getInstance()->getAllBy($lecturer, 'Course', 'current');
		} else {
			new ErrorModel('Object not from type LecturerModel');
		}
	}

	function getAllCourseCurrent()
	{
		return Database::getInstance()->getAll('Course', 'current');
	}
} 