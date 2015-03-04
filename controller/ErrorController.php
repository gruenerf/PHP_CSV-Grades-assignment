<?php

class ErrorController {
	private $errorRepository;

	function __construct(ErrorRepositoryInterface $errorRepository)
	{
		$this->errorRepository = $errorRepository;
	}

	function create($errormessage){
		return $this->errorRepository->create($errormessage);
	}
} 