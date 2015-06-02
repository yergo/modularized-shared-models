<?php

namespace Application\Api\Controllers;

use \Phalcon\Mvc\Controller;

class ControllerBase extends Controller {

	protected $_request = null;
	protected $_response = null;

	/**
	 * Initializes request vars to make it not necessary to invoke DI elements couple of times in controller.
	 */
	protected function initialize() {

		$this->_response = [
			'status' => null,
			'message' => null,
			'datetime' => date('Y-m-d H:i:s'),
			'code' => 200,
//			'request' => & $this->_request,
			'data' => []
		];
		
		try {
			
			$this->_request = [
				'action' => null,
				'method' => $this->di->getRequest()->getMethod(),
				'data'	 => $this->getJsonRequest(),
			];
			
		} catch(\Exception $e) {
			$this->dispatcher->forward([
				'controller' => 'error',
				'action'     => 'show503',
				'params'     => array(
					'exception' => $e
				)
			]);
			
			return false;
		}

	}

	/**
	 * Captures method result and tries to make a JSON response out of it.
	 * 
	 * @param \Phalcon\Mvc\Dispatcher $dispatcher
	 * @return \Phalcon\Http\Response
	 */
	protected function afterExecuteRoute($dispatcher) {

		$content = $dispatcher->getReturnedValue();

		if(is_object($content)) {
			if(is_callable(array($content, 'toArray'))) {
				$content = $content->toArray();
			} else {
				$content = (array) $content;
			}
		}

		$frame = $this->getFrame($content, $dispatcher);

		$this->response->setContentType('application/json', 'UTF-8');
		switch($frame['code']) {
			case 200:
				$this->response->setStatusCode(200, 'OK');
				break;
			case 400: 
				$this->response->setStatusCode(404, 'Not found');
				break;
			case 500: 
				$this->response->setStatusCode(503, 'Service Unavailable');
				break;
		}
		
		// clearing potential warnings
		$ob = ob_get_clean();
		if(strlen($ob) > 0) {
			/**
			 * @todo some logging of $ob !
			 */
			
		}
		
		// settinf response content as JSON
		$this->response->setJsonContent($frame);
		
		return $this->response->send();
	}

	/**
	 * Makes an array for JSON response frame.
	 * 
	 * @param mixed $content
	 * @param \Phalcon\Mvc\Dispatcher $dispatcher
	 * @return array
	 */
	protected function getFrame($content, $dispatcher) {

		$this->_request['action'] = $dispatcher->getControllerName() . '.' . $dispatcher->getActionName();
		
		$this->_response['data'] = $content;
		$this->_response['status'] = $this->_response['code'] === 200 ? 'success' : 'error';

		return $this->_response;
	}

	/**
	 * Captures input to interpret as JSON response.
	 * 
	 * @param bool $array
	 * @return array
	 */
	protected function getJsonRequest() {
		$input = $this->request->get('json') ?: file_get_contents('php://input') ;

		if($input !== null) {
			$data = json_decode($input, JSON_OBJECT_AS_ARRAY);
			
			if(json_last_error() !== JSON_ERROR_NONE) {
				throw new \Exception('JSON unhandled exception: ' . json_last_error_msg());
			}
		}
		
		return $data ?: [];
	}

}
