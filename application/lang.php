<?php

class Lang {
   public $lang;

    function getlang() 
   {
      if (isset($_SESSION['lang'])) {
         $lang = $_SESSION['lang'];
         return $lang;
      } else {
          $a = 'sssssss';
          return $a;
      }
   }
   
}