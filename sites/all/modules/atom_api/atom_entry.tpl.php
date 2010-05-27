<?php
// $Id$

/**
 * @file
 * Template to render Atom feed entry.
 */
?>
  <entry>
    <title><?php print check_plain($entry['title']); ?></title>
<?php if (!empty($entry['summary'])): ?>
    <summary><?php print check_plain($entry['summary']); ?></summary>
<?php endif; ?>
    <id><?php print check_plain($entry['id']); ?></id>
<?php if (!empty($entry['alternate_link'])): ?>
    <link rel="alternate" href="<?php print check_plain($entry['alternate_link']); ?>"/>
<?php endif; ?>
<?php if (!empty($entry['published'])): ?>
    <published><?php print check_plain($entry['published']); ?></published>
<?php endif; ?>
    <updated><?php print check_plain($entry['updated']); ?></updated>

<?php foreach ($entry['authors'] as $author): ?>
    <author>
  <?php if (!empty($author['name'])): ?>
      <name><?php print check_plain($author['name']); ?></name>
  <?php endif; ?>
  <?php if (!empty($author['email'])): ?>
      <email><?php print check_plain($author['email']); ?></email>
  <?php endif; ?>
  <?php if (!empty($author['uri'])): ?>
      <uri><?php print check_plain($author['uri']); ?></uri>
  <?php endif; ?>
    </author>
<?php endforeach; ?>

<?php foreach (array_filter($entry['categories']) as $cat): ?>
    <category term="<?php print $cat['term']; ?>"/>
<?php endforeach; ?>
  </entry>

