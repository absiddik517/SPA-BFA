<?php

if(!function_exists('exception_message')){
  function exception_message($e){
    return $e->getMessage();
  }
}