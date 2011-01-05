<div>
  <div style="float:left;" class="cover">
    <?php echo l(theme('imagecache', 'book_cover_65_102', $node->field_book_cover[0]['filepath']), $node->path, array('html' => true)); ?><br />
  </div>
  <div style="float:left;padding-left:10px;" class="content2">
    
    <h6><?php echo l($node->title, $node->path) ?></h6>
    
    <h5><?php echo implode(', ', showEntriesFromVocab($node, 1)) // showing author('s) ?></h5>
    
    <div class="rating">
      <?php echo $node->field_rating[0]['view'] ?>
      <img style="float:left;padding-left:10px;" src="/sites/all/themes/netsound/img/stream.png" />
      <img style="float:left;padding-left:10px;" src="/sites/all/themes/netsound/img/fetch.png" />
    </div>

    <div class="reader">
      <div>Anmelder</div>
      <?php $comment = fetchNewestComment($node) ?>
      <div><?php echo $comment->name ?></div>
      <div class="link-green" style="font-family: arial; float: left; width: 250px; font-size: 14px; color: rgb(102, 102, 102); line-height: 1.3em;"><?php echo substr($comment->comment,0,300) . '...' ?> <?php echo l('Læs mere', $node->path, array('fragment' => 'comment-' . $comment->cid)) ?></div>
    </div>
  </div>
  
  <div class="clear-box"></div>
  
</div>