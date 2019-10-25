<?php

class App{

	protected $controller = "Home";
	protected $action = "sayhi";
	protected $params = [];

	function __construct(){
		$arr = $this->UrlProcess();

		// process controller
		if(file_exists('./mvc/controllers/'.$arr[0].'.php')){
			$this->controller = $arr[0];
			unset($arr[0]);
		}
		require_once './mvc/controllers/'.$this->controller.'.php';


		// process action
		if(isset($arr[1])){
			if(method_exists($this->controller, $arr[1])){
				$this->action = $arr[1];
			}
			unset($arr[1]);
		}
		

		// process params
		$this->params = $arr ? array_values($arr) : [];  // check if arr is empty

		call_user_func_array([$this->controller, $this->action], $this->params);
		
	}

	function UrlProcess(){
		if(isset($_GET['url'])){
			$url = filter_var(trim($_GET['url'], "/")); // sanitize url
			return explode('/', $url);
		}
		
	}
}
?>
