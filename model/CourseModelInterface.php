<?php

interface CourseModelInterface extends ModelInterface
{
	public function getEcts();

	public function setEcts($ects);

	public function getName();

	public function setName($name);

	public function getGroup();

	public function setGroup($group);

	public function getSemester();

	public function setSemester($semester);
} 