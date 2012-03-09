<?php

$path = drupal_get_path('module', 'ting') . '/lib/';
require_once($path . 'ting-client/lib/log/TingClientLogger.php');

/**
 * Dummy logger which does nothing
 */
class TingClientVoidLogger extends TingClientLogger {
  protected function doLog($message, $severity) {
    //Do nothing
  }
}

