<?php

interface ErrorRepositoryInterface extends RepositoryInterface
{
	public function create($errormessage);
}