<?php

namespace Application\Api\Controllers;

class ErrorController extends ControllerBase
{

	public function show404Action($exception) {
		
		$this->_response['code'] = 400;
		$this->_response['message'] = $exception->getMessage();
		
		if(APPLICATION_ENV !== 'production') {
			return [
				'file' => $exception->getFile(),
				'line' => $exception->getLine(),
				'trace' => $exception->getTrace()
			];
		}
		
		return null;
	}
	
	public function show503Action($exception) {

		$this->_response['code'] = 500;
		$this->_response['message'] = $exception->getMessage();
		
		if(APPLICATION_ENV !== 'production') {
			return [
				'file' => $exception->getFile(),
				'line' => $exception->getLine(),
				'trace' => $exception->getTrace()
			];
		}
		
		return null;
		
	}
	
}