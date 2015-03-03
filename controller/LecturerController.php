<?php

use LecturerModel as Lecturer;
use CourseModel as Course;

class LecturerController
{
	private $lecturerRepository;

	public function __construct(LecturerRepositoryInterface $lecturerRepository)
	{
		$this->lecturerRepository = $lecturerRepository;
	}

	function newLecturer($title, $surname, $name, $birthday)
	{
		$this->lecturerRepository->create($title, $surname, $name, $birthday);
	}

	function updateLecturer(Lecturer $lecturer)
	{
		$this->lecturerRepository->update($lecturer);
	}

	function getAllLecturer()
	{
		return $this->lecturerRepository->getAll();
	}

	function getAllCourseByLecturerPrevious(Lecturer $lecturer)
	{
		return $this->lecturerRepository->getPreviousCourse($lecturer);
	}

	function getAllCourseByLecturerCurrent(Lecturer $lecturer)
	{
		return $this->lecturerRepository->getCurrentCourse($lecturer);
	}

	function addCourse(Lecturer $lecturer, Course $course)
	{
		$this->lecturerRepository->addCourse($lecturer, $course);
	}

	function getWorkload(Lecturer $lecturer)
	{
		return $this->lecturerRepository->getWorkload($lecturer);
	}

} 