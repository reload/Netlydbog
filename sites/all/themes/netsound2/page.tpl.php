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
 */
?>


<?php // dsm(get_defined_vars()) ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language; ?>" lang="<?php print $language->language; ?>" dir="<?php print $language->dir; ?>">
<head>
  <title><?php print $head_title; ?></title>
  <?php print $head; ?>
  <?php print $styles; ?>
  <!--[if IE]>
  <link type="text/css" rel="stylesheet" media="all" href="/sites/all/themes/netsound2/css/ie.css" />
  <![endif]-->
  <?php print $scripts; ?>
</head>

<body class="<?php print $body_classes;?>">

  <?php if (!empty($admin)) print $admin; ?>
  <div class="pagewrap">
  
    <div class="clear-block top-area">
      
      <div class="logo">
        <h2 id="site-name"><?php print l($site_name,'<front>',array('title' => t('Home'))) ?></h2>
        <h3 id="slogan"><?php print $site_slogan ?></h3>
      </div>
      <div class="topmenu right">
        <?php if ($header) { ?>
          <?php print $header; ?>
        <?php } ?>
        
        
        <?php print theme_links($primary_links);//('links', $primary_links,array()); ?>
      </div>


    </div>
 
    <div class="body clearfix">
      <div class="main">
      <?php if($messages): ?>
      <div class="messageouter"><?php print $messages ?></div>
      <?php endif; ?>
      
      <?php print $content; ?>
      
      </div>
      
       <?php// if ($breadcrumb) { print $breadcrumb; } // themename_breadcrumb in template.php ?>
          <?php if ($help OR $messages) { ?>
              <?php print $help ?>
              
          <?php } ?>

          <?php if ($tabs) { ?>
            <?php print $tabs; ?>
          <?php }; ?>

          
      <!-- <div class="right">
      <?php print mothership_userprofile($user); ?>
      </div> -->
    </div>

    <div class="footer">

   
      <?php print $footer; ?>

      <?php print $feed_icons; ?>
    </div>

  <?php print $closure; ?>
  </div>
</body>
</html>