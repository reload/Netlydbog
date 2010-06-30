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
      <div class="maina">
      <?php if($messages): ?>
      <div class="messageouter"><?php print $messages ?></div>
      <?php endif; ?>
      
       <?php if ($tabs) { ?>
            <?php print $tabs; ?>
          <?php }; ?>
      
      
      
      <?php print $content; ?>
      
      </div>
      
       <?php// if ($breadcrumb) { print $breadcrumb; } // themename_breadcrumb in template.php ?>
          <?php if ($help OR $messages) { ?>
              <?php print $help ?>
              
          <?php } ?>

         
          
      <!-- <div class="right">
      <?php #print mothership_userprofile($user); ?>
      </div> -->
    </div>

    <div class="footer line">

   <div class="unit size1of2"><a href="http://ting.dk"><img src="/sites/all/themes/netsound2/img/tinglogo.png" alt=""/></a><?php  print $footer; ?></div>
   <div class="unit size1of2">
   
   <h1>om Netlydbog.dk</h1>
   <p>Netlydbog.dk drives af et bibliotekskonsortium, der består af bibliotekerne i Gentofte, København, Frederiksberg og Århus. 93 biblioteker abonnerer på servicen. Konsortiet har indgået aftale med Publizon A/S om levering af indhold og drift af IT platform og udlånssystem. Konsortiet har ansvar for portalen.</p>
   </div>
      

      <?php # print $feed_icons; ?>
    </div>

  <?php print $closure; ?>
  </div>
</body>
</html>