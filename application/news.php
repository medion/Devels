<?php

class News {
   public $load;
   public $model;

   function __construct($controller,$action,$id)
   {
      $this->load = new Load();
      $this->model = new Model();
      //$this->home($controller,$action);
      
      if ($action == 'view') {
          $this->view($controller,$action,$id);
      }
      else {
          $this->index($controller,$action,$id);
      }
      
   }

   function index()
   {
       $data['news'] = $this->model->getallnews();
	   $id = $_SESSION['user_id'];
			//print_r($data2);
			if ($this->check_admin($id)) {
				$data['admin'] = '<a href="/admin/add">Додати новину</a>';
				$_SESSION['rules'] = 1;
			}
       $this->load->view('news_new.php', $data);
   }
   
    function view($controller,$action,$id)
    {
		
        if (empty($id)) {
            header('Location: /404');
        }
        else
        {
			$id = (int) $id;
			$data = $this->model->getnews($id);
            if (empty($data)) {
                header('Location: /404');
            }
			$id = $_SESSION['user_id'];
			//print_r($data2);
			if ($this->check_admin($id)) {
				$data['admin'] = '<a href="/admin/add">Додати новину</a>';
				$_SESSION['rules'] = 1;
			}
            $this->load->view('news_view_new.php', $data);
       }
   }
   
   
   function check_admin($id) {
		$data = $this->model->getrules($id);
		if ($data['rules'] == 1){
			return true;
		}
		else {
			return false;
		}
	}
   
}