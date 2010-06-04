<div class="feature-tab">

<?php print l($node->title,$node->path, array('attributes' => array('class' => 'tab'))) ?>

<ul class="line">

<?php foreach($node->field_ting_ref as $object):?>

<?php print $object['view']?>

<?php endforeach;?>

</ul>

<?php //dsm($node);?>


</div>
