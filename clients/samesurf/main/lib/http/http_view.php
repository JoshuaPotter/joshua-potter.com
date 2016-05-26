<?php

class http_view {
   
	protected $_blocks; 
	protected $_layout; 
	protected $_locale;
	protected $_params;
	protected $_errors;
	protected $_title;
	protected $_js;
	protected $_js_files;
	protected $_css_files;
	protected $_css;


	public function __construct($locale) {
		$this->_locale = $locale;
		$this->_blocks = array();
		$this->_js = array();
		$this->_js_files = array();
		$this->_css = array();
		$this->_css_files = array();
			
	}	

	public function display() {
		echo $this->render();
	} 
		
	public function render() {
	  
		$view = new stdClass(); 
		$view->locale = $this->_locale;

		$view->defaults = new stdClass();
		$view->errors = new stdClass();

		if (isset($this->_params)) {	
			foreach ($this->_params as $key => $value) {
				$view->defaults->$key = $value;
			}
		}

		if (isset($this->_errors)) {
			foreach ($this->_errors as $key => $value) {
				$view->errors->$key = $value;
			}
		}

		$blocks = new stdClass();
		foreach ($this->_blocks as $key => $value) {
			ob_start();
			require $value;
			$block = ob_get_clean();
			$blocks->$key = $block;
		}	

		$view->title = $this->_title;

		ob_start();
       	require $this->layout;
       	$rendered_layout = ob_get_clean();	
		return $rendered_layout;
	} 

	public function setLayout($name) {
		$this->layout = $name;
	}

	public function setBlock($name, $file) {
		$this->_blocks[$name] = $file;
	}

	public function setParams($params) {
		$this->_params = $params;
	}	

	public function setErrors($errors) {
		$this->_errors = $errors;
	}	
	
	public function setTitle($title) {
	 	$this->_title = $title;	
	}
	
	public function addJSFile($file) {
	 	array_push($this->_js_files, $file);	
	}

	public function addJS($js) {
	 	array_push($this->_js, $js);	
	}

	public function addCSSFile($file) {
	 	array_push($this->_css_files, $file);	
	}

	public function addCSS($file) {
	 	array_push($this->_css, $file);	
	}

	public function include_css_files() {
		foreach($this->_css_files as $file) {
			echo "<link rel='stylesheet' type='text/css' href='$file'/>\n";
		}
	}

	public function include_js_files() {
		foreach($this->_js_files as $file) {
			echo "<script type='text/javascript' src='$file'></script>\n";
		}
	}


}
