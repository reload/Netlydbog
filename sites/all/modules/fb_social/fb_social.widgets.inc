<?php
function fb_social_facepile_settings_form(){
  $form = array();

  $form['fb_social_facepile_numrows'] = array(
      '#type' => 'textfield', 
      '#title' => t('Num rows'), 
      '#description' => t('The maximum number of rows of profile pictures to show'), 
      '#default_value' => variable_get('fb_social_facepile_numrows', 1) 
  );
  
  $form['fb_social_facepile_url'] = array(
      '#type' => 'textfield', 
      '#title' => t('URL'), 
      '#description' => t('If you want the Facepile to display friends who have liked your page, specify the URL of the page here. If you want the Facepile to display users who have signed up for your site leave this empty.'), 
      '#default_value' => variable_get('fb_social_facepile_url', '') 
  );
  
  
  $form['fb_social_facepile_width'] = array(
      '#type' => 'textfield', 
      '#title' => t('Width'), 
      '#description' => t('The width of the widget in pixels'), 
      '#default_value' => variable_get('fb_social_facepile_width', 200) 
  );

  
  $form = system_settings_form($form);
  return $form;

}

function fb_social_livestream_settings_form(){
  $form = array();

  $form['fb_social_livestream_width'] = array(
      '#type' => 'textfield', 
      '#title' => t('Width'), 
      '#description' => t('The width of the widget in pixels'), 
      '#default_value' => variable_get('fb_social_livestream_width', 400) 
  );
  
  $form['fb_social_livestream_height'] = array(
      '#type' => 'textfield', 
      '#title' => t('Height'), 
      '#description' => t('The height of the widget in pixels'), 
      '#default_value' => variable_get('fb_social_livestream_height', 500) 
  );
  
  /*
  $form['fb_social_livestream_via'] = array(
      '#type' => 'textfield', 
      '#title' => t('Via Attribute URL'), 
      '#description' => t('The height of the widget in pixels'), 
      '#default_value' => variable_get('fb_social_livestream_height', 300) 
  );
  */
  
  $form['fb_social_livestream_posttofriends'] = array(
      '#type' => 'checkbox', 
      '#title' => t('Always post to friends'), 
      '#description' => t('If set, all user posts will always go to their profile. This option should only be used when users posts are likely to make sense outside of the context of the event'), 
      '#default_value' => variable_get('fb_social_livestream_posttofriends', 0) 
  );

  $form = system_settings_form($form);
  return $form;

}


function fb_social_recommendations_settings_form(){
  $form = array();
  
  $form['fb_social_recommendation_site'] = array(
      '#type' => 'textfield', 
      '#title' => t('Domain'), 
      '#description' => t('The domain for which to show recommendations'), 
      '#default_value' => variable_get('fb_social_recommendation_site', '') 
  );
  
  $form['fb_social_recommendation_width'] = array(
      '#type' => 'textfield', 
      '#title' => t('Width'), 
      '#description' => t('The width of the widget in pixels'), 
      '#default_value' => variable_get('fb_social_recommendation_width', 300) 
  );
  
  $form['fb_social_recommendation_height'] = array(
      '#type' => 'textfield', 
      '#title' => t('Height'), 
      '#description' => t('The height of the widget in pixels'), 
      '#default_value' => variable_get('fb_social_recommendation_height', 300) 
  );
  
  $form['fb_social_recommendation_header'] = array(
      '#type' => 'checkbox', 
      '#title' => t('Show the widget header'), 
      '#description' => t('Show the header in the recommendations widget'), 
      '#default_value' => variable_get('fb_social_recommendation_header', 1) 
  );
  
  $form['fb_social_recommendation_colorscheme'] = array(
      '#type' => 'select', 
      '#title' => t('Color'), 
      '#description' => t('The color scheme of the widget'), 
      '#default_value' => variable_get('fb_social_recommendation_colorscheme', 'light'), 
      '#options' => array(
          'dark' => t('dark'), 
          'light' => t('light') 
      ) 
  );
  
  $form['fb_social_recommendation_border_color'] = array(
      '#type' => 'textfield', 
      '#title' => t('Border color'), 
      '#description' => t('The border color of the widget'), 
      '#default_value' => variable_get('fb_social_recommendation_border_color', '') 
  );
  
  $form['fb_social_recommendation_font'] = array(
      '#type' => 'select', 
      '#title' => t('Font'), 
      '#description' => t('The font of the widget'), 
      '#default_value' => variable_get('fb_social_recommendation_font', 'arial'), 
      '#options' => array(
          'arial' => t('arial'), 
          'lucida grande' => t('lucida grande'), 
          'segoe ui' => t('segoe ui'),
          'tahoma' => t('tahoma'),
          'trebuchet ms' => t('trebuchet ms'),
          'verdana', 
      ) 
  );
  
  $form = system_settings_form($form);
  return $form;

}

function fb_social_activityfeed_settings_form(){
  $form = array();
  
  $form['fb_social_activityfeed_site'] = array(
      '#type' => 'textfield', 
      '#title' => t('Domain'), 
      '#description' => t('The domain for which to show recommendations'), 
      '#default_value' => variable_get('fb_social_activityfeed_site', '') 
  );
  
  $form['fb_social_activityfeed_width'] = array(
      '#type' => 'textfield', 
      '#title' => t('Width'), 
      '#description' => t('The width of the widget in pixels'), 
      '#default_value' => variable_get('fb_social_activityfeed_width', 300) 
  );
  
  $form['fb_social_activityfeed_height'] = array(
      '#type' => 'textfield', 
      '#title' => t('Height'), 
      '#description' => t('The height of the widget in pixels'), 
      '#default_value' => variable_get('fb_social_activityfeed_height', 300) 
  );
  
  $form['fb_social_activityfeed_header'] = array(
      '#type' => 'checkbox', 
      '#title' => t('Show the widget header'), 
      '#description' => t('Show the header in the recommendations widget'), 
      '#default_value' => variable_get('fb_social_activityfeed_header', 1) 
  );
  
  $form['fb_social_activityfeed_colorscheme'] = array(
      '#type' => 'select', 
      '#title' => t('Color'), 
      '#description' => t('The color scheme of the widget'), 
      '#default_value' => variable_get('fb_social_activityfeed_colorscheme', 'light'), 
      '#options' => array(
          'dark' => t('dark'), 
          'light' => t('light') 
      ) 
  );
  
  $form['fb_social_activityfeed_border_color'] = array(
      '#type' => 'textfield', 
      '#title' => t('Border color'), 
      '#description' => t('The border color of the widget'), 
      '#default_value' => variable_get('fb_social_activityfeed_border_color', '') 
  );
  
  $form['fb_social_activityfeed_font'] = array(
      '#type' => 'select', 
      '#title' => t('Font'), 
      '#description' => t('The font of the widget'), 
      '#default_value' => variable_get('fb_social_activityfeed_font', 'arial'), 
      '#options' => array(
          'arial' => t('arial'), 
          'lucida grande' => t('lucida grande'), 
          'segoe ui' => t('segoe ui'),
          'tahoma' => t('tahoma'),
          'trebuchet ms' => t('trebuchet ms'),
          'verdana', 
      ) 
  );
  
  $form['fb_social_activityfeed_recommendations'] = array(
      '#type' => 'checkbox', 
      '#title' => t('Show the widget header'), 
      '#description' => t('Show the header in the recommendations widget'), 
      '#default_value' => variable_get('fb_social_activityfeed_recommendations', 1) 
  );
  
  $form = system_settings_form($form);
  return $form;

}