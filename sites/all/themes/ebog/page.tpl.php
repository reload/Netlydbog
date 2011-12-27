<?php
// $Id: page.tpl.php,v 1.1.2.16 2010/11/16 14:39:39 himerus Exp $
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language ?>" lang="<?php print $language->language ?>" dir="<?php print $language->dir ?>">

<head>
  <title><?php print $head_title; ?></title>
  <?php print $head; ?>
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" />
  <?php print $styles; ?>
  <?php print $scripts; ?>
  <link rel="apple-touch-icon" href="images/ereolen.png" />
</head>

<body class="<?php print $body_classes; ?>">
  <?php if (!empty($admin)) print $admin; ?>
  <div id="page" class="clearfix">
    <div id="header">
      <div id="site-header" class="container-<?php print $branding_wrapper_width; ?> clearfix">
        <div id="branding" class="grid-<?php print $header_logo_width; ?>">
          <?php if ($linked_logo_img): ?>
            <?php print $linked_logo_img; ?>
          <?php endif; ?>
          <?php if ($linked_site_name): ?>
            <?php if ($title): ?>
              <h2 id="site-name" class=""><?php print $linked_site_name; ?></h2>
            <?php else: ?>
              <h1 id="site-name" class=""><?php print $linked_site_name; ?></h1>
            <?php endif; ?>
          <?php endif; ?>
        </div><!-- /#branding -->

        <?php if ($navigation): ?>
          <div id="site-menu" class="grid-<?php print $header_menu_width; ?>">
          <?php if($navigation): ?>
            <div><?php print $navigation; ?></div>
          <?php endif; ?>
          </div><!-- /#site-menu -->
        <?php endif; ?>

        <?php if ($search): ?>
          <div id="search-box" class="grid-<?php print $search_width; ?>"><?php print $search; ?></div><!-- /#search-box -->
        <?php endif; ?>
      </div><!-- /#site-header -->

      <?php if($header_first): ?>
      <div id="header-regions" class="container-<?php print $header_wrapper_width; ?> clearfix">
        <?php if($header_first): ?>
          <div id="header-first" class="<?php print $header_first_classes; ?>">
            <?php print $header_first; ?>
          </div><!-- /#header-first -->
        <?php endif; ?>
      </div><!-- /#header-regions -->
      <?php endif; ?>
    </div><!-- /#header -->

    <div id="main-content-container" class="container-<?php print $content_container_width; ?> clearfix">
      <div id="main-wrapper" class="column <?php print $main_content_classes; ?>">
        <?php if($help || $messages): ?>
          <?php print $help; ?><?php print $messages; ?>
        <?php endif; ?>

        <?php if (!empty($mission)) {
          print $mission;
        }?>
        <?php if($content_top): ?>
        <div id="content-top">
          <?php print $content_top; ?>
        </div><!-- /#content-top -->
        <?php endif; ?>
        <?php if ($tabs): ?>
          <div id="content-tabs" class=""><?php print $tabs; ?></div><!-- /#content-tabs -->
        <?php endif; ?>

        <?php if ($title): ?>
          <h1 class="title" id="page-title"><?php print $title; ?></h1>
        <?php endif; ?>

        <div id="main-content" class="region clearfix">
          <?php print $content; ?>
        </div><!-- /#main-content -->

        <?php if($content_bottom): ?>
        <div id="content-bottom">
          <?php print $content_bottom; ?>
        </div><!-- /#content-bottom -->
        <?php endif; ?>
      </div><!-- /#main-wrapper -->

      <?php if ($sidebar_first): ?>
        <div id="sidebar-first" class="column sidebar region <?php print $sidebar_first_classes; ?>">
          <?php print $sidebar_first; ?>
        </div><!-- /#sidebar-first -->
      <?php endif; ?>
    </div><!-- /#main-content-container -->

    <div id="footer">
      <?php if($footer_first || $footer_message): ?>
      <div id="footer-wrapper" class="container-<?php print $footer_container_width; ?> clearfix">
        <?php if($footer_first): ?>
          <div id="footer-first" class="<?php print $footer_first_classes; ?>">
            <?php print $footer_first; ?>
          </div><!-- /#footer-first -->
        <?php endif; ?>
      </div><!-- /#footer-wrapper -->
      <?php endif; ?>
    </div>
  </div><!-- /#page -->
  <?php print $closure; ?>
</body>
</html>
