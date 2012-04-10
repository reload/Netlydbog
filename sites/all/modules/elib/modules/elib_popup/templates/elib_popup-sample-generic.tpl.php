<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<h4>
  <?php echo t('You are now listening the book')?>:<br /> 
  <?php echo $data['title']?>
</h4>
<br />
<div id="audio-player">
  <?php echo t('Since your browser does not support flash, we can not play the teaser for you, but you can download it')?>
  <?php echo l(t('here'), $data['link'])?>
  <?php echo t('And even play it on your computer')?>.
</div>
