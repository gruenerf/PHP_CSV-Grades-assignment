<?php

interface ErrorModelInterface extends ModelInterface
{
	public function getDate();

	public function setDate($date);

	public function getErrormessage();

	public function setErrormessage($errormassage);
}