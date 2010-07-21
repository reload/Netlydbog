<div<?php print $id_node . $classes; ?>>
<?php if($title):?>
  <h1 class="header"><?php print $title;?></h1>
<?php endif;?>

<?php

$n = node_load($nid);
?>


  <?php print $n->body ?>

  <div class="meta">
    
    
    
    <?php $u = user_load($node->uid);?>
    
    <?php print t('Skrevet af: !name / !email - Kl. !time',array('!name' => $u->name, '!email' => $u->mail, '!time' => format_date($node->created, 'custom', "H.i, j F Y")))?>

    
    <?php if (count($taxonomy)) { ?>
       <?php print $terms ?>
    <?php } ?>
  </div>
</div>
