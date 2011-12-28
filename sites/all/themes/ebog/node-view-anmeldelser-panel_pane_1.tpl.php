<?php 
module_load_include('client.inc', 'ting');
$tingObj = ting_get_object_by_id($node->field_book[0]['ting_object_id']);
?>

<div class="line">
  <div class="unit size1of1">
    <?php print elib_displaybookNEW($tingObj,'','textright')?>
  </div>
  <div class="unit size1of1">
    <?php print truncate_utf8($node->field_review[0]['safe'],1000,true,true);?> <?php print l(t('LÆS MERE →'),$node->path)?>
  </div>
</div>

