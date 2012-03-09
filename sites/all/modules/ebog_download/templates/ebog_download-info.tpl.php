<?php
/**
 * @file
 *
 * Template for info messages.
 */
?>
<div class="ebog-download-info">
  <p><?php print $data['message']; ?></p>
  <?php if (isset($data['link'])) { ?>
  <p><a class="ebog-dlink" href="<?php print $data['link']; ?>"><?php print t('Download');?></a></p>
  <?php } ?>
</div>
