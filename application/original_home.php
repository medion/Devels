<?php

class Controller {
   public $load;
   public $model;

   function __construct($http)
   {
      $this->load = new Load();
      $this->model = new Model();
      
      
      $this->home($http);
   }

   function home($http)
   {
      //$data = $this->model->user_info();
      $data = $http;
      $this->load->view('someview.php', $data);
   }
   

   
   

}
