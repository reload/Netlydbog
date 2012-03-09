function ajaxify_regions_success_block(data)
{
  for(key in data) {
     var block = $('#block-'+key+'-ajax-content').replaceWith(data[key]['content']);
     Drupal.attachBehaviors(block);
  }
}