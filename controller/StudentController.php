<?php

use StudentModel as Student;
use CourseModel as Course;

/**
 * Class StudentController
 */
class StudentController implements StudentControllerInterface
{
	/**
	 * @var StudentRepositoryInterface
	 */
	private $studentRepository;

	/**
	 * @param StudentRepositoryInterface $studentRepository
	 */
	public function __construct(StudentRepositoryInterface $studentRepository)
	{
		$this->studentRepository = $studentRepository;
	}

	/**
	 * @param $surname
	 * @param $name
	 * @param $birthday
	 * @return mixed
	 */
	function create($surname, $name, $birthday)
	{
		return $this->studentRepository->create($surname, $name, $birthday);
	}

	/**
	 * @param StudentModel $student
	 */
	function update(Student $student)
	{
		$this->studentRepository->update($student);
	}

	/**
	 * @param $id
	 * @return mixed
	 */
	function getById($id){
		return $this->studentRepository->getById($id);
	}

	/**
	 * @return mixed
	 */
	function getAll()
	{
		return $this->studentRepository->getAll();
	}

	/**
	 * @param StudentModel $student
	 * @return mixed
	 */
	function getAllGradeByStudent(Student $student)
	{
		return $this->studentRepository->getAllGradeByStudent($student);
	}

	/**
	 * @param StudentModel $student
	 * @return mixed
	 */
	function getAllCompletedCourse(Student $student)
	{
		return $this->studentRepository->getCompletedCourse($student);
	}

	/**
	 * @param StudentModel $student
	 * @return mixed
	 */
	function getAllRegisteredCourse(Student $student)
	{
		return $this->studentRepository->getCurrentCourse($student);
	}

	/**
	 * @param StudentModel $student
	 * @param CourseModel $course
	 */
	function addCourse(Student $student, Course $course)
	{
		$this->studentRepository->addCourse($student, $course);
	}

	/**
	 * @param StudentModel $student
	 * @return mixed
	 */
	function getWorkload(Student $student)
	{
		return $this->studentRepository->getWorkload($student);
	}

	/**
	 * @param StudentModel $student
	 * @return mixed
	 */
	function getGpa(Student $student)
	{
		return $this->studentRepository->getGPA($student);
	}

	/**
	 * @param StudentModel $student
	 * @return mixed
	 */
	function getStatus(Student $student)
	{
		return $this->studentRepository->getStatus($student);
	}


}