<div class="subpage">
  
  <div class="image left">
    <div>
    <?php echo theme('imagecache', 'book_cover_detailed_page', $node->field_book_cover[0]['filepath']); ?>
    </div>
    <div style="text-align:center;margin:20px 0;">
      <img src="/sites/all/themes/netsound/img/stream.png" />
      <img src="/sites/all/themes/netsound/img/fetch.png" />
    </div>
  </div>
  
  <div class="info left">
    <div class="h6 green"><?php echo $node->title ?></div>
    <h5>Af: <?php echo implode(showEntriesFromVocab($node, 1)) ?></h5>
    <div class="rating"><?php echo $node->field_rating[0]['view'] ?></div>
    <div class="blue"><label for="reader">OPLÆSER</label> <?php echo $node->field_reader[0]['view'] ?></div>
    <div class="blue"><label for="genre">GENRER</label> <?php echo implode(', ', showEntriesFromVocab($node, 2)) ?></div>
    <div class="blue"><label for="released">UDGIVET</label> <?php echo $node->field_release_year[0]['view'] ?></div>
    <div class="blue"><label for="read">OPLÆST</label> <?php echo $node->field_read_year[0]['view'] ?></div>
    <div class="blue"><label for="isbn">ISBN</label> <?php echo $node->field_isbn[0]['view'] ?></div>
    <div class="blue"><label for="format">FORMAT</label> MP3 DRM</div>
    <div class="blue"><label for="language">SPROG</label> <?php echo implode(', ', showEntriesFromVocab($node, 3)) ?></div>
    <div class="blue"><label for="forlag">FORLAG</label> <?php echo implode(', ', showEntriesFromVocab($node, 4)) ?> </div>
    <div class="blue"><label for="length">LÆNGDE</label> <?php echo $node->field_length[0]['view'] ?> min.</div>
  </div>
  
  <div class="about left" style="margin-bottom:20px;">
    <?php echo substr($node->content['body']['#value'],0,300) ?>
    <?php if (strlen(trim($node->content['body']['#value'])) > 300): ?>
      <span id="showhide" style="display:none;">
        <?php echo substr($node->content['body']['#value'],300) ?>
      </span>
      <a id="showhidebutton" href="#">LÆS MERE →</a>
    <?php endif; ?>
  </div>
  
  <div class="clear-box" style="border-top:1px dotted #666;margin:20px 0;"></div>
  
  <div class="review-header left green">
    VORES ANMELDELSE
  </div>
  <div class="review-content left" style="margin-bottom:20px;">
    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
  </div>

  <div class="clear-box" style="border-top:1px dotted #666;padding-top:20px;"></div>

  <div class="review-header left green">
    ANMELDELSE FRA LITTERATURSIDEN
  </div>
  <div class="review-content left">
    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
  </div>
  
    <div class="clear-box"></div>
    
</div>

<script type="text/javascript" charset="utf-8">
  $(function() {
    $('#showhidebutton').bind('click', function() {
      $('#showhide').toggle();
    });
  })
</script>
