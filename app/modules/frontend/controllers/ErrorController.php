<?php

namespace Application\Frontend\Controllers;

class ErrorController extends ControllerBase
{

	public function show404Action($exception) {
		
		$this->view->exception = $exception;
		
	}
	
	public function show503Action($exception) {
		
		$this->view->exception = $exception;
		
	}
	
}