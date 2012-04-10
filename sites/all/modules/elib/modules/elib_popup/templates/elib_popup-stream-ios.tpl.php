<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<h4>
  <?php echo t('You are now listening to the book')?>:<br /> 
  <?php echo $data['title']?>
</h4>
<br />
<iframe style="width: 100%;" src="<?php echo $data['link']; ?>"></iframe>
