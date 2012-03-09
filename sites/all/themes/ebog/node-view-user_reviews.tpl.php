<?php 


  module_load_include('client.inc', 'ting');
  $obj = ting_get_object_by_id($node->field_book[0]['ting_object_id']);
  
  print elib_displaybookNEW($obj,array($node->field_review[0]['value'],$node->uid),'review'); 

        


?>