<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<h4>
  <?php echo t('You are now listening to a taste of the book')?> - 
  <?php echo $data['title']?>
</h4>
<iframe src="<?php echo $data['link']?>" style="display: none;"></iframe>