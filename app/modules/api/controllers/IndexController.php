<?php

namespace Application\Api\Controllers;

class IndexController extends ControllerBase
{

	public function indexAction()
	{
//		throw new \Exception('test exception');
		$this->_response['message'] = 'Available actions';
		return [];
	}
	
}