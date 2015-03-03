<?php

class StudentController
{
	private $lecturerRepository;

	public function __construct(LecturerRepositoryInterface $lectruerRepository)
	{
		$this->lecturerRepository = $lectruerRepository;
	}

	function newStudent($surname, $name, $birthday)
	{
		return new StudentModel($surname, $name, $birthday);
	}

	function updateStudent($student)
	{
		if (get_class($student) == 'StudentModel') {
			Database::getInstance()->update($student);
		} else {
			new ErrorModel('Object not from type StudentModel');
		}
	}

	function getAllStudent()
	{
		return Database::getInstance()->getAll('StudentModel');
	}

	function getAllGradeByStudent($student)
	{
		if (get_class($student) == 'StudentModel') {
			return Database::getInstance()->getAllBy($student, 'Grade');
		} else {
			new ErrorModel('Object not from type StudentModel');
		}
	}

	function getAllCompletedCourse($student)
	{
		if (get_class($student) == 'StudentModel') {
			return $student->getCompletedCourse();
		} else {
			new ErrorModel('Object not from type StudentModel');
		}
	}

	function getAllRegisteredCourse($student)
	{
		if (get_class($student) == 'StudentModel') {
			return $student->getRegisteredCourse();
		} else {
			new ErrorModel('Object not from type StudentModel');
		}
	}

	function addRegisteredCourse($student, $course)
	{
		if (get_class($student) == 'StudentModel' && get_class($course) == 'CourseModel') {
			$student->addRegisteredCourse($course);
		} else {
			new ErrorModel('Object not from type StudentModel/CourseModel');
		}
	}

	function getWorkload($student)
	{
		if (get_class($student) == 'StudentModel') {
			return $student->calculateWorkload();
		} else {
			new ErrorModel('Object not from type StudentModel');
		}
	}

	function getGpa($student)
	{
		if (get_class($student) == 'StudentModel') {
			return $student->calculateGpa();
		} else {
			new ErrorModel('Object not from type StudentModel');
		}
	}

	function getStatus($student)
	{
		if (get_class($student) == 'StudentModel') {
			return $student->getStatus();
		} else {
			new ErrorModel('Object not from type StudentModel');
		}
	}


}