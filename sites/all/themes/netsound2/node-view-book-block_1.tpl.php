<div class="display-book top-books" style="width:175px;padding-left:13px;float:left;">
  <?php echo l(theme('imagecache', 'book_cover_detailed_page', $node->field_book_cover[0]['filepath']), $node->path, array('html' => true)); ?><br />
  <h6 class="title"><?php echo l($node->title, $node->path) ?></h6>
  <h5 class="author"><?php echo implode(', ', showEntriesFromVocab($node, 1)) // showing author('s) ?></h5>
  <div class="rating"><?php echo $node->field_rating[0]['view'] ?></div>
  <div class="clear-box"></div>
  <div class="icons">
    <img src="/sites/all/themes/netsound/img/stream.png" />
    <img src="/sites/all/themes/netsound/img/fetch.png" />
  </div>
</div>
