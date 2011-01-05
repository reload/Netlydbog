<h3>UGENS LYDBOG</h3>
<div style="width:710px;">
  
  <div style="float:left;width:165px;text-align:right;padding-right:10px;">
    <h6><?php echo l($node->title, $node->path) ?></h6>
    
    <h5>Af: <?php echo implode(', ', showEntriesFromVocab($node, 1)) // showing author('s) ?></h5>
    
    <div class="rating right"><?php echo $node->field_rating[0]['view'] ?></div>
    <div class="icons clear-box">
      <img src="/sites/all/themes/netsound/img/stream.png" />
      <img src="/sites/all/themes/netsound/img/fetch.png" />
    </div>
    
  </div>
  
  <div class="cover" style="float:left;width:180px">
    <?php echo l(theme('imagecache', 'book_cover_detailed_page', $node->field_book_cover[0]['filepath']), $node->path, array('html' => true)); ?>  
  </div>
  
  <div class="content" style="font-family:arial;float:left;width:340px;font-size:14px;color:#666;line-height:1.3em;">
    <?php echo $node->content['body']['#value'] ?>
  </div>
</div>
<div class="clear-box"></div>
