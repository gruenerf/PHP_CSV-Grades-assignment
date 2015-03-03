<?php

interface CourseRepositoryInterface extends RepositoryInterface
{
	public function create($name, $ects, $group, $semester);
} 