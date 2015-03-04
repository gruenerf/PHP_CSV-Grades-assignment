<?php

interface GradeModelInterface extends ModelInterface
{
	public function getCourseId();

	public function setCourseId($courseId);

	public function getGrade();

	public function setGrade($grade);

	public function getSemester();

	public function setSemester($semster);

	public function getStudentId();

	public function setStudentId($studentId);

	public function getDate();

	public function setDate(DateTime $date);
} 