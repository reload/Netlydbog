<?php
// $Id: location_test_case.php,v 1.1 2008/01/24 22:27:21 bdragon Exp $

/**
 * @file
 * Location specific assertions.
 */

/**
 * Test each element of an array for being within a range.
 */
class ArrayWithinMarginExpectation extends WithinMarginExpectation {
  var $_canonicalvalues;
  var $_margin;

  /**
   *    Sets the values to compare against and the fuzziness of
   *    the match. Used for comparing floating point values.
   *    @param mixed $arr        Array of test values to match.
   *    @param mixed $margin       Fuzziness of match.
   *    @param string $message     Customised message on failure.
   *    @access public
   */
  function ArrayWithinMarginExpectation($arr, $margin = 0.01, $message = '%s') {
    $this->SimpleExpectation($message);
    foreach ($arr as $k => $v) {
      $this->_upper[$k] = $v + $margin;
      $this->_lower[$k] = $v - $margin;
    }
    $this->_canonicalvalues = $arr;
    $this->_margin = $margin;
  }

  /**
   *    Tests the expectation. True if it matches the
   *    held value.
   *    @param mixed $compare        Comparison value.
   *    @return boolean              True if correct.
   *    @access public
   */
  function test($compare) {
    // First of all, if the count is off, there's DEFINATELY a problem.
    if (count($compare) != count($this->_canonicalvalues)) {
      return FALSE;
    }
    $pass = TRUE;
    foreach ($compare as $k => $v) {
      $pass = $pass && ($v <= $this->_upper[$k]) && ($v >= $this->_lower[$k]);
    }
    return $pass;
  }

  /**
   *    Creates a the message for being within the range.
   *    @param mixed $compare        Value being tested.
   *    @access private
   */
  function _withinMessage($compare) {
    $difference = array();
    foreach($compare as $k => $v) {
      $difference[$k] = abs($v - $this->_canonicalvalues[$k]);
    }
    return 'Within expectation [('. implode(',', $compare) .') and ('. implode(',', $this->_canonicalvalues) .'), margin '. $this->_margin .' ('. implode(',', $difference) .')]';
  }

  /**
   *    Creates a the message for being within the range.
   *    @param mixed $compare        Value being tested.
   *    @access private
   */
  function _outsideMessage($compare) {
    if (count($compare) != count($this->_canonicalvalues)) {
      return 'Expectation failed, array size mismatch [('. implode(',', $compare) .') and ('. implode(',', $this->_canonicalvalues) .')]';
    }
    $differror = array();
    foreach ($compare as $k => $v) {
      $differror[$k] = 'OK';
      if ($v > $this->_upper[$k]) {
        $differror[$k] = '+'. ($v - $this->_upper[$k]);
      }
      if ($v < $this->_lower[$k]) {
        $differror[$k] = '-'. ($this->_lower[$k] - $v);
      }
    }
    return 'Outside expectation [('. implode(',', $compare) .') and ('. implode(',', $this->_canonicalvalues) .') exceed margin '. $this->_margin .' by ('.  implode(',', $differror) .')]';
  }
}
