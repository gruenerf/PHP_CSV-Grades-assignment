<?php

class LecturerController
{
	private $lecturerRepository;

	public function __construct(LecturerRepositoryInterface $lecturerRepository)
	{
		$this->lecturerRepository = $lecturerRepository;
	}

	function newLecturer($title, $surname, $name, $birthday)
	{
		return new LecturerModel($title, $surname, $name, $birthday);
	}

	function updateLecturer($lecturer)
	{
		if (get_class($lecturer) == 'LecturerModel') {
			Database::getInstance()->update($lecturer);
		} else {
			new ErrorModel('Object not from type LecturerModel');
		}
	}

	function getAllLecturer()
	{
		return Database::getInstance()->getAll('LecturerModel');
	}

	function getAllCourseByLecturerPrevious($lecturer)
	{
		if (get_class($lecturer) == 'LecturerModel') {
			return $lecturer->getPreviousCourse();
		} else {
			new ErrorModel('Object not from type LecturerModel');
		}
	}

	function getAllCourseByLecturerCurrent($lecturer)
	{
		if (get_class($lecturer) == 'LecturerModel') {
			return $lecturer->getCurrentCourse();
		} else {
			new ErrorModel('Object not from type LecturerModel');
		}
	}

	function addPreviousCourse($lecturer, $course)
	{
		if (get_class($lecturer) == 'LecturerModel' && get_class($course) == 'CourseModel') {
			$lecturer->addPreviousCourse($course);
		} else {
			new ErrorModel('Object not from type LecturerModel/CourseModel');
		}
	}

	function addCurrentCourse($lecturer, $course)
	{
		if (get_class($lecturer) == 'LecturerModel' && get_class($course) == 'CourseModel') {
			$lecturer->addCurrentCourse($course);
		} else {
			new ErrorModel('Object not from type LecturerModel/CourseModel');
		}
	}

	function getWorkload($lecturer)
	{
		if (get_class($lecturer) == 'LecturerModel') {
			return $lecturer->calculateWorkload();
		} else {
			new ErrorModel('Object not from type StudentModel');
		}
	}

} 