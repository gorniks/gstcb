<?php

class PagesController extends Controller{

	public function __construct($data = array()){
		parent::__construct($data);
		$this->model = new Page();
	}

	public function page(){
		$this->data['current_page'] = $this->params['0'];

		$start = $this->data['current_page'] * Config::get('pages_in_pagination') - Config::get('pages_in_pagination') + 1;
		$offset = $start + Config::get('pages_in_pagination') - 1;

		$this->data['pages'] = $this->model->getList(2, true, 'desc', $start, $offset);
		$this->data['pagination'] = $this->model->getPagination(2);
	}

	public function index(){
		$this->data['pages'] = $this->model->getList(2, true, 'desc', 1, 4);
		//$this->data['pagination'] = $this->model->getPagination(2);
	}

	public function view(){
		$params = App::getRouter()->getParams();

		if ( isset($params[0]) ){
			$alias = strtolower($params[0]);
			$this->data['page'] = $this->model->getByAlias($alias);
		}
	}

	public function admin_index(){
		$this->data['pages'] = $this->model->getList();
	}

	public function admin_add(){
		$this->data['categories'] = $this->model->getCategories();

		if ( $_POST ){
			$result = $this->model->save($_POST);
			if ( $result ){
				Session::setFlash('Page was saved.');
			} else {
				Session::setFlash('Error.');
			}
			Router::redirect('/admin/pages/');
		}
	}

	public function admin_edit(){
		$this->data['categories'] = $this->model->getCategories();
		if ( $_POST ){
			$id = isset($_POST['id']) ? $_POST['id'] : null;
			$result = $this->model->save($_POST, $id);
			if ( $result ){
				Session::setFlash('Page was saved.');
			} else {
				Session::setFlash('Error.');
			}
			Router::redirect('/admin/pages/');
		}

		if ( isset($this->params[0]) ){
			$this->data['page'] = $this->model->getById($this->params[0]);
		} else {
			Session::setFlash('Wrong page id.');
			Router::redirect('/admin/pages/');
		}
	}

	public function admin_delete(){
		if ( isset($this->params[0]) ){
			$result = $this->model->delete($this->params[0]);
			if ( $result ){
				Session::setFlash('Page was deleted.');
			} else {
				Session::setFlash('Error.');
			}
		}
		Router::redirect('/admin/pages/');
	}

}