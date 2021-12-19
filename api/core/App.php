<?php

class App{

	protected $controller = 'TransaksiController';
	protected $method = 'index';
	protected $params = [];

	public function __construct(){
		$url = $this->parseURL();
		
		if(!empty($url[0])){
			if(file_exists('api/controllers/' . $url[0] . '.php')){
				$this->controller = $url[0];
				unset($url[0]);
			}

		}
		
		require_once 'api/controllers/' . $this->controller . '.php';
		$this->controller = new $this->controller;

		if(isset($url[0])){
			
			if(method_exists($this->controller, $url[0])){
				$this->method = $url[0];
				unset($url[0]);
			}
		}

		if(!empty($url)){
			$this->params = array_values($url);
		}

		//jalankan controller
		call_user_func_array([$this->controller, $this->method], $this->params);
	}

	public function parseURL(){
		if( isset($_GET['url'])){
			$url = rtrim($_GET['url'], '/');
			$url = filter_var($url, FILTER_SANITIZE_URL);
			$url = explode('/',$url);
			return $url;
		}
	}
}