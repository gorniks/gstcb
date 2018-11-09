<?php

class AboutController extends Controller{

	public function __construct($data = array()){
		parent::__construct($data);
		$this->model = new Page();
	}

	public function index(){
		$this->data['pages'] = $this->model->getAboutContent();
	}
}

?>