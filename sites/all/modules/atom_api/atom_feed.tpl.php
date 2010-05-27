<?php
// $Id$

/**
 * @file
 * Template to render Atom feed.
 */

// Print the XML declaration in case PHP has short_open_tag enabled.
print '<?xml version="1.0" encoding="'. $feed['encoding'] .'"?>'."\n";
?>
<feed xmlns="http://www.w3.org/2005/Atom">
  <title><?php print check_plain($feed['title']); ?></title>
<?php if (!empty($feed['subtitle'])): ?>
  <subtitle><?php print check_plain($feed['subtitle']); ?></subtitle>
<?php endif; ?>
  <id><?php print check_plain($feed['id']); ?></id>
  <link rel="self" href="<?php print check_plain($feed['self_link']); ?>"/>
<?php if (!empty($feed['alternate_link'])): ?>
  <link rel="alternate" href="<?php print check_plain($feed['alternate_link']); ?>"/>
<?php endif; ?>
  <updated><?php print $feed['updated']; ?></updated>
<?php if (!empty($feed['author'])): ?>
  <author>
  <?php if (!empty($feed['author']['name'])): ?>
    <name><?php print check_plain($feed['author']['name']); ?></name>
  <?php endif; ?>
  <?php if (!empty($feed['author']['email'])): ?>
    <email><?php print check_plain($feed['author']['email']); ?></email>
  <?php endif; ?>
  <?php if (!empty($feed['author']['uri'])): ?>
    <uri><?php print check_plain($feed['author']['uri']); ?></uri>
  <?php endif; ?>
  </author>
<?php endif; ?>
<?php if (!empty($feed['rights'])): ?>
  <rights><?php print check_plain($feed['rights']); ?></rights>
<?php endif; ?>
  <generator uri="http://drupal.org/" version="<?php print VERSION; ?>">Drupal</generator>
<?php print $feed['entries']; ?>
</feed>

