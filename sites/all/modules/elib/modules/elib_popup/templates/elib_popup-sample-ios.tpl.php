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
<audio controls="controls">
  <source src="<?php echo $data['link']; ?>" type="audio/mp3" />
  <?php print t('Your browser does not support the audio tag.'); ?>
</audio> 
