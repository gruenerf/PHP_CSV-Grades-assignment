<?php

use CourseModel as Course;

/**
 * Class CourseController
 */
class CourseController
{
	/**
	 * @var CourseRepositoryInterface
	 */
	private $courseRepository;

	/**
	 * @param CourseRepositoryInterface $courseRepository
	 */
	function __construct(CourseRepositoryInterface $courseRepository)
	{
		$this->courseRepository = $courseRepository;
	}

	/**
	 * @param $name
	 * @param $ects
	 * @param $group
	 * @param $semester
	 * @return mixed
	 */
	function create($name, $ects, $group, $semester)
	{
		return $this->courseRepository->create($name, $ects, $group, $semester);
	}

	/**
	 * @param CourseModel $course
	 */
	function update(Course $course)
	{
		$this->courseRepository->update($course);
	}

	/**
	 * @param $id
	 * @return mixed
	 */
	function getById($id){
		return $this->courseRepository->getById($id);
	}

	/**
	 * @return mixed
	 */
	function getAll()
	{
		return $this->courseRepository->getAll();
	}

	/**
	 * @param CourseModel $course
	 * @return mixed
	 */
	function getNumberOfGroups(Course $course)
	{
		return $this->courseRepository->getNumberOfCurrentGroups($course);
	}

	/**
	 * @param CourseModel $course
	 * @return mixed
	 */
	function getNumberPreviouslyTaught(Course $course){
		return $this->courseRepository->getNumberPreviouslyTaught($course);
	}

	/**
	 * @return mixed
	 */
	function getCurrentCoursesGroupsAndPreviously(){
		return $this->courseRepository->getCurrentCoursesGroupsAndPreviously();
	}
} 