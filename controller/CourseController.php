<?php

use CourseModel as Course;
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

	function updateCourse(Course $course)
	{
		$this->courseRepository->update($course);
	}

	function getAllCourse()
	{
		return $this->courseRepository->getAll();
	}

	// TODO ????
	function getAllCourseCurrent()
	{
		return Database::getInstance()->getAll('Course', 'current');
	}
} 