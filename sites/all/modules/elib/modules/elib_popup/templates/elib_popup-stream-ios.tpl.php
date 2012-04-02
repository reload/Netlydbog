<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<h4>
  <?php echo t('You are now listening to the book')?> - 
  <?php echo $data['title']?>
</h4>
<br />
<iframe src="<?php echo $data['link']; ?>"></iframe>
