<?php

class Model {
   public function user_info()
   {
      // simulates real data
      return array(
         'first' => 'Jeffrey',
         'last'  => 'Way'
      );
   }
   
   public function getallnews() {
       $result = mysql_query('SELECT * FROM news');
       while($row = mysql_fetch_assoc($result))
       {
           $data[] = $row;
       };
       return $data;
   }
   
   public function getnews($id) {
       $result = mysql_query('SELECT * FROM news WHERE id = '.$id);
       $row = mysql_fetch_array($result, MYSQL_ASSOC);
       return $row;
   }
   
   public function getmainnews() {
       $result = mysql_query('SELECT * FROM news');
       while($row = mysql_fetch_assoc($result))
       {
           $data[] = $row;
       };
       return $data;
   }
   
   public function getpage($alias) {
       $result = mysql_query("SELECT * FROM pages WHERE alias = '".$alias."'");
       $row = mysql_fetch_array($result, MYSQL_ASSOC);
       return $row;
   }
   
   public function getrules($id) {
		$result = mysql_query("SELECT rules FROM users WHERE id = '".$id."'");
		$row = mysql_fetch_array($result, MYSQL_ASSOC);
		return $row;
	}
	
	public function getprofile($user_id) {
		$result = mysql_query("SELECT * FROM users WHERE id = '".$user_id."'");
		$row = mysql_fetch_array($result, MYSQL_ASSOC);
		return $row;
	}
   
   
}
