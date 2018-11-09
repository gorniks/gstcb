<?php

class ContactsController extends Controller{

    public function __construct($data = array()){
        parent::__construct($data);
        $this->model = new Message();
    }

    public function index(){
        if ( $_POST ){
            if ( $this->model->save($_POST) ){
                Session::setFlash('Спасибо, форма отправлена!');
                echo "Спасибо, форма отправлена!";
            } else {
                echo "Ошибка!";
            }
            exit;
        }
    }

    public function admin_index(){
        $this->data = $this->model->getList();
    }

    public function content(){
        $this->data = $this->model->getContent();
    }

    public function admin_delete(){
        if ( isset($this->params[0]) ){
            $result = $this->model->delete($this->params[0]);
            if ( $result ){
                Session::setFlash('Message was deleted.');
            } else {
                Session::setFlash('Error.');
            }
        }
        Router::redirect('/admin/contacts/');
    }

}