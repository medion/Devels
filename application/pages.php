<?php

class Pages {
    public $load;
    public $model;

    function __construct($alias)
   {
      $this->load = new Load();
      $this->model = new Model();
      $this->view($alias);      
   }
   
    function view($alias)
    {
        if (empty($alias)) {
            header('Location: /404');
        }
        else
        {
			$alias = htmlspecialchars($alias);
            $data = $this->model->getpage($alias);
            if (empty($data)) {
                header('Location: /404');
            }
			$id = $_SESSION['user_id'];
			//print_r($data2);
			if ($this->check_admin($id)) {
				$data['admin'] = '<a href="/admin/add">Додати новину</a>';
				$_SESSION['rules'] = 1;
			}
            $this->load->view('pages_view_new.php', $data);
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