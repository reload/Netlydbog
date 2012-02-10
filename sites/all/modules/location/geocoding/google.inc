<?php
// $Id: google.inc,v 1.11 2008/10/09 19:38:16 bdragon Exp $

/**
 * @file
 * Google geocoder.
 */

/**
 * Return the list of ISO3166 codes supported by this geocoder.
 * Coverage list: http://gmaps-samples.googlecode.com/svn/trunk/mapcoverage_filtered.html
 * Possibly in the future, allow to autogenerate this by pulling down and parsing the spreadsheet?
 */
function google_geocode_country_list() {
  return array(
    'al',
    'at',
    'au',
    'ba',
    'be',
    'bg',
    'br',
    'by',
    'ca',
    'ch',
    'ci',
    'cl',
    'cz',
    'de',
    'dk',
    'ec',
    'ee',
    'es',
    'fi',
    'fr',
    'gr',
    'hk',
    'hu',
    'ie',
    'in',
    'it',
    'jp',
    'li',
    'lt',
    'lu',
    'lv',
    'md',
    'me',
    'mo',
    'mx',
    'nc',
    'ni',
    'nl',
    'no',
    'pl',
    'pt',
    'ro',
    'ru',
    'rs',
    'se',
    'sg',
    'si',
    'sk',
    'sm',
    'sv',
    'th',
    'tr',
    'tw',
    'ua',
    'uk',
    'us',
    'uy',
  );
}

/**
 * Return general information about this geocoder.
 */
function google_geocode_info() {
  return array(
    'name' => 'Google Maps',
    'url' => 'http://maps.google.com',
    'tos' => 'http://www.google.com/help/terms_local.html',
    'general' => TRUE,
  );
}

/**
 * Perform a geocode on a location array.
 * @param $location
 *   The location array to process.
 * @return
 *   an associative array with keys 'lat' and 'lon' containing the coordinates.
 */
function google_geocode_location($location = array()) {
  switch ($location['country']) {
    case 'li':
      $location['country'] = 'Liechtenstein';
      $query = location_address2singleline($location);
      break;

    case 'at':
      $location['country'] = 'Austria';
      $query = location_address2singleline($location);
      break;

    case 'uk':
      // @@@ Bdragon: Doesn't google support UK postcodes now?
      if ($location['street'] && $location['city']) {
        unset($location['postal_code']);
      }
      elseif ($location['postal_code']) {
        unset($location['city']);
        unset($location['street']);
        unset($location['additional']);
      }
      else {
        unset($location['postal_code']);
      }
      $query = location_address2singleline($location);
      break;

    default:
      $query = location_address2singleline($location);
      break;
  }

  $key = variable_get('location_geocode_google_apikey', '');
  if (function_exists('gmap_get_key')) {
    $key = gmap_get_key();
  }

  $service_url = 'http://maps.google.com/maps/geo?output=xml&key='. $key .'&q=';

  $http_reply = drupal_http_request($service_url . urlencode($query));

  $status_code_match = array();
  preg_match('/<code>(.*)<\/code>/', $http_reply->data, $status_code_match);
  $status_code = $status_code_match[1];
  if ($status_code != 200) {
    return NULL;
  }

  $accuracy_code_match = array();
  preg_match('/Accuracy="([0-9])"/', $http_reply->data, $accuracy_code_match);
  $accuracy_code = $accuracy_code_match[1];
  if ($accuracy_code < 3) {
    return NULL;
  }

  $latlon_match = array();
  preg_match('/<coordinates>(.*)<\/coordinates>/', $http_reply->data, $latlon_match);

  $latlon_exploded = explode(',', $latlon_match[1]);

  return array('lat' => $latlon_exploded[1], 'lon' => $latlon_exploded[0]);
}

/**
 * General settings for this geocoder.
 */
function google_geocode_settings() {
  $form = array();
  $key = '';
  if (function_exists('gmap_get_key')) {
    $key = gmap_get_key();
  }

  if (!empty($key)) {
    $form['location_geocode_google_apikey'] = array(
      '#type' => 'item',
      '#title' => t('Google Maps API Key'),
      '#value' => $key,
      '#description' => t('The key in use was automatically provided by GMap.'),
    );
  }
  else {
    $form['location_geocode_google_apikey'] = array(
      '#type' => 'textfield',
      '#title' => t('Google Maps API Key'),
      '#size' => 64,
      '#maxlength' => 128,
      '#default_value' => variable_get('location_geocode_google_apikey', ''),
      '#description' => t('In order to use the Google Maps API geocoding web-service, you will need a Google Maps API Key.  You can obtain one at the !sign_up_link for the !google_maps_api.  PLEASE NOTE: You will <em>not</em> have to re-enter your API key for each country for which you have selected Google Maps for geocoding.  This setting is global.', array('!sign_up_link' => '<a href="http://www.google.com/apis/maps/signup.html">sign-up page</a>', '!google_maps_api' => '<a href="http://www.google.com/apis/maps/">Google Maps API</a>'))
    );
  }

  return $form;
}
