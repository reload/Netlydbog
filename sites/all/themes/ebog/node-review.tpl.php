<div class="clear-block">
<?php
  $n = node_load($nid);
  module_load_include('client.inc', 'ting');
?>
<div style="width:230px;margin-left:10px;float:right;"><?php print elib_displaybookNEW(ting_get_object_by_id($n->field_book[0]['ting_object_id']),'','medium')?></div>
  <?php print $n->field_review[0]['value'] ?>
  <div class="meta">
    <?php $u = user_load($node->uid);?>
    <br />
    <?php print t('Skrevet af: !name / !email - Kl. !time',array('!name' => $u->name, '!email' => $u->mail, '!time' => format_date($node->created, 'custom', "H.i, j F Y")))?>
    <?php if (count($taxonomy)) { ?>
       <?php print $terms ?>
    <?php } ?>
  </div>
</div>
