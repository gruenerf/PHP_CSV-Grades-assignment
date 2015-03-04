<?php

interface StudentModelInterface extends ModelInterface
{
	public function getBirthday();

	public function setBirthday($birthday);

	public function getName();

	public function setName($name);

	public function getSurname();

	public function setSurname($surname);

	public function getGPA();

	public function setGPA($gpa);

	public function getWorkload();

	public function setWorkload($workload);
} 