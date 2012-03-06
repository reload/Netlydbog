<?php
/**
 * @file
 */
?>
<?php if ($conf['type'] == 'undefined') { ?>
  <p>USER PROVIDED WRONG URL TO VIDEO</p>
<?php } elseif (!empty($conf['embed_code']) AND !empty($conf['embed_url'])) { ?>
  <div class="ebog_embed_video">
		<?php if ($conf['type'] == 'youtube') { ?>
			<div class="ebog_embed_youtube">
				<object style="width:207px;height:144px;">
					<param name="movie" value="http://www.youtube.com/v/<?php echo $conf['embed_code']; ?>">
					<param name="allowFullScreen" value="true">
					<param name="allowScriptAccess" value="always">
					<embed
						src="https://www.youtube.com/v/<?php echo $conf['embed_code']; ?>"
						type="application/x-shockwave-flash"
						allowfullscreen="true"
						allowScriptAccess="always"
						width="207"
						height="144"
					>
				</object>
			</div>
		<?php } ?>

		<?php if ($conf['type'] == 'vimeo') { ?>
			<div class="ebog_embed_vimeo">
				<iframe
					src="http://player.vimeo.com/video/<?php echo $conf['embed_code']; ?>"
					width="207"
					height="144"
					frameborder="0"
					webkitAllowFullScreen
					allowFullScreen
				>
				</iframe>
			</div>
		<?php } ?>

		<?php if ($conf['title'] != '') { ?>
			<div class="ebog_embed_title">
				<?php echo $conf['title']; ?>
			</div>
		<?php } ?>

		<?php if ($conf['descr'] != '') { ?>
			<div class="ebog_embed_descr">
				<?php echo $conf['descr']; ?>
			</div>
		<?php } ?>
  </div>
  <div class="bottom-bar">
    <div class="see-more ebog_embed_see_more">
      <?php if ($conf['see_more_link'] != '' && $conf['see_more_title'] != '') { ?>
        <?php echo l($conf['see_more_title'], $conf['see_more_link']); ?>
      <?php } ?>
    </div>
  </div>
<?php } ?>
