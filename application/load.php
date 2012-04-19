<?php

class Load {
   function view( $file_name, $data = null ) 
   {
      if( is_array($data) ) {
         extract($data);
      }
      include 'views/' . $file_name;
   }
   
   function loggedin() {
    if (isset($_SESSION['user_id'])&&!empty($_SESSION['user_id'])) {
            return true;
        } else {
            return false;
        }
    }
}



