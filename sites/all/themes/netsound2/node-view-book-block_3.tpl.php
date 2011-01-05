<li>
  <div style="float:left;width:65px;" class="cover">
    <?php echo l(theme('imagecache', 'book_cover_65_102', $node->field_book_cover[0]['filepath']), $node->path, array('html' => true)); ?><br />
  </div>
  
  <div style="float:left;padding-left:10px;width:250px;" class="content2">
    
    <h6><?php echo l($node->title, $node->path) ?></h6>
    
    <h5><?php echo implode(', ', showEntriesFromVocab($node, 1)) // showing author('s) ?></h5>
    
    <div class="rating">
      <?php echo $node->field_rating[0]['view'] ?>
      <img style="float:left;padding-left:10px;" src="/sites/all/themes/netsound/img/stream.png" />
      <img style="float:left;padding-left:10px;" src="/sites/all/themes/netsound/img/fetch.png" />
    </div>

    <div class="reader">
      <h5>Oplæser: <?php echo $node->field_reader[0]['value'] ?></h5>
    </div>
  </div>
  
  <div class="clear-box"></div>
  
</li>