<?php

use CourseModel as Course;
class CourseController
{
	private $courseRepository;

	function __construct(CourseRepositoryInterface $courseRepository)
	{
		$this->courseRepository = $courseRepository;
	}

	function create($name, $ects, $group, $semester)
	{
		return $this->courseRepository->create($name, $ects, $group, $semester);
	}

	function update(Course $course)
	{
		$this->courseRepository->update($course);
	}

	function getById($id){
		return $this->courseRepository->getById($id);
	}

	function getAll()
	{
		return $this->courseRepository->getAll();
	}

	function getNumberOfGroups(Course $course)
	{
		return $this->courseRepository->getNumberOfCurrentGroups($course);
	}

	function getNumberPreviouslyTaught(Course $course){
		return $this->courseRepository->getNumberPreviouslyTaught($course);
	}

	function getCurrentCoursesGroupsAndPreviously(){
		return $this->courseRepository->getCurrentCoursesGroupsAndPreviously();
	}
} 