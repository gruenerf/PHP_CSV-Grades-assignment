<?php

use LecturerModel as Lecturer;
use CourseModel as Course;

/**
 * Class LecturerController
 */
class LecturerController implements LecturerControllerInterface
{
	/**
	 * @var LecturerRepositoryInterface
	 */
	private $lecturerRepository;

	/**
	 * @param LecturerRepositoryInterface $lecturerRepository
	 */
	public function __construct(LecturerRepositoryInterface $lecturerRepository)
	{
		$this->lecturerRepository = $lecturerRepository;
	}

	/**
	 * @param $title
	 * @param $surname
	 * @param $name
	 * @param $birthday
	 * @return mixed
	 */
	function create($title, $surname, $name, $birthday)
	{
		return $this->lecturerRepository->create($title, $surname, $name, $birthday);
	}

	/**
	 * @param LecturerModel $lecturer
	 */
	function update(Lecturer $lecturer)
	{
		$this->lecturerRepository->update($lecturer);
	}

	/**
	 * @param $id
	 * @return mixed
	 */
	function getById($id){
		return $this->lecturerRepository->getById($id);
	}

	/**
	 * @return mixed
	 */
	function getAll()
	{
		return $this->lecturerRepository->getAll();
	}

	/**
	 * @param LecturerModel $lecturer
	 * @return mixed
	 */
	function getAllCourseByLecturerPrevious(Lecturer $lecturer)
	{
		return $this->lecturerRepository->getPreviousCourse($lecturer);
	}

	/**
	 * @param LecturerModel $lecturer
	 * @return mixed
	 */
	function getAllCourseByLecturerCurrent(Lecturer $lecturer)
	{
		return $this->lecturerRepository->getCurrentCourse($lecturer);
	}

	/**
	 * @param LecturerModel $lecturer
	 * @param CourseModel $course
	 */
	function addCourse(Lecturer $lecturer, Course $course)
	{
		$this->lecturerRepository->addCourse($lecturer, $course);
	}

	/**
	 * @param LecturerModel $lecturer
	 * @return mixed
	 */
	function getWorkload(Lecturer $lecturer)
	{
		return $this->lecturerRepository->getWorkload($lecturer);
	}

} 