<?php 
module_load_include('client.inc', 'ting');
$tingObj = ting_get_object_by_id($node->field_book[0]['ting_object_id']);
?>

<?php print elib_displaybookNEW($tingObj,'','textright')?>
<div>
  <?php print truncate_utf8($node->field_review[0]['safe'],1000,true,true);?>
</div>
