<?php
// $Id$
/* *
 * @file
 * page.tpl.php
 */

/**
 * documentation:
 * http://api.drupal.org/api/file/modules/system/page.tpl.php
 * -------------------------------------
 * page vars dsm(get_defined_vars())
 * -------------------------------------
 * <?php print $base_path; ?>
 * <?php print $is_front ?>
 * 
 */
?>


<?php // dsm(get_defined_vars()) ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language; ?>" lang="<?php print $language->language; ?>" dir="<?php print $language->dir; ?>">
<head>
  <title><?php print $head_title; ?></title>
  <?php print $head; ?>
  <?php print $styles; ?>
  <link type="text/css" rel="stylesheet" media="all" href="/sites/all/themes/netsound2/css/overlay.css" />
  <!--[if IE]>
  <link type="text/css" rel="stylesheet" media="all" href="/sites/all/themes/netsound2/css/ie.css" />
  <![endif]-->
  <?php print $scripts; ?>
</head>

<body class="<?php print $body_classes;?> clean">


<div class="audiobook-bookmark"> </div>

  <?php if (!empty($admin)) print $admin; ?>
  
  <div class="clean">
      
      <?php if($messages): ?>
      <div class="messageouter"><?php print $messages ?></div>
      <?php endif; ?>
      
      
      <?php print $content; ?>


       <?php// if ($breadcrumb) { print $breadcrumb; } // themename_breadcrumb in template.php ?>
          <?php if ($help OR $messages) { ?>
              <?php print $help ?>
            <?php } ?>
          


  <?php print $closure; ?>
  </div>
</body>
</html>