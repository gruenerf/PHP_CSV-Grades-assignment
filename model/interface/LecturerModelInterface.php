<?php

interface LecturerModelInterface extends ModelInterface
{
	public function getTitle();

	public function setTitle($title);

	public function getBirthday();

	public function setBirthday($birthday);

	public function getName();

	public function setName($name);

	public function getSurname();

	public function setSurname($surname);

	public function getWorkload();

	public function setWorkload($workload);
}