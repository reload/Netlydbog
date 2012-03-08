<?php
/**
 * @file
 * NanoSOAP class for simple interaction with SOAP webservices.
 */

class NanoSOAPClient {
  const XML_HEADER = '<?xml version="1.0" encoding="UTF-8"?>';
  const USER_AGENT = 'NanoSOAP for Drupal';

  /**
   * SOAP endpoint, the URL to call SOAP requests on.
   *
   * @var string
   */
  public $endpoint;

  /**
   * DOMDocument instance for the request body.
   *
   * @var DOMDocument
   */
  public $doc;

  /**
   * The XML string sent as part of a request. For debugging purposes.
   *
   * @var string
   */
  public $requestBodyString;

  /**
   * Construct the SOAP client, using the specified options.
   */
  function __construct($endpoint, $options = array()) {
    $this->endpoint = $endpoint;
    if (isset($options['namespaces']) && $options['namespaces']) {
      $this->namespaces = $options['namespaces'] + array('SOAP-ENV' => 'http://schemas.xmlsoap.org/soap/envelope/');
    }
    else {
      $this->namespaces = array('SOAP-ENV' => 'http://schemas.xmlsoap.org/soap/envelope/');
    }
  }

  /**
   * Make a cURL request.
   *
   * This is usually a SOAP request, but could ostensibly be used for
   * other things.
   *
   * @param string $url
   *   The URL to send the request to.
   * @param string $method
   *   The HTTP method to use. One of "GET" or "POST".
   * @param string $body
   *   The request body, ie. the SOAP envelope for SOAP requests.
   * @param array $headers
   *   Array of headers to be sent with the request.
   *
   * @return string
   *   The response for the server, or FALSE on failure.
   */
  function curlRequest($url, $method = 'GET', $body = '', $headers = array()) {
    // Array of cURL options. See the documentation for curl_setopt for
    // details on what options are available.
    $curl_options = array(
      CURLOPT_URL => $url,
      CURLOPT_USERAGENT => self::USER_AGENT,
      CURLOPT_RETURNTRANSFER => TRUE,
    );

    if ($method == 'POST') {
      $curl_options[CURLOPT_POST] = TRUE;

      if (!empty($body)) {
        $curl_options[CURLOPT_POSTFIELDS] = $body;
      }
    }

    if (!empty($headers)) {
      $curl_options[CURLOPT_HTTPHEADER] = $headers;
    }

    // Initialise and configure cURL.
    $ch = curl_init();
    curl_setopt_array($ch, $curl_options);

    $response = curl_exec($ch);

    if ($response === FALSE) {
      throw new NanoSOAPcURLException(curl_error($ch));
    }

    // Close the cURL instance before we return.
    curl_close($ch);
    return $response;
  }

  /**
   * Make a SOAP request.
   *
   * @param string $action
   *   The SOAP action to perform/call.
   * @param array $parameters
   *   The parameters to send with the SOAP request.
   *
   * @return string
   *   The SOAP response.
   */
  function call($action, $parameters = array()) {
    // Set content type and send the SOAP action as a header.
    $headers = array(
      'Content-Type: text/xml',
      'SOAPAction: ' . $action,
    );

    // Make a DOM document from the envelope and get the Body tag so we
    // can add our request data to it.
    $this->doc = new DOMDocument();
    $this->doc->loadXML($this->generateSOAPenvelope());
    $body = $this->doc->getElementsByTagName('Body')->item(0);

    // Convert the parameters into XML elements and add them to the
    // body. The root element of this structure will be the action.
    $elem = $this->convertParameter($action, $parameters);
    $body->appendChild($elem);

    // Render and store the final request string.
    $this->requestBodyString = $this->doc->saveXML();

    // Send the SOAP request to the server via CURL.
    return $this->curlRequest($this->endpoint, 'POST', $this->requestBodyString, $headers);
  }

  /**
   * Convert parameters to DOM structure.
   *
   * @param string $name
   *   The parameter name.
   * @param mixed $value
   *   Value of the parameter as array or string-compatible.
   *
   * @return DOMElement
   *   The generated element.
   */
  function convertParameter($name, $value) {
    // If value is an array, flatten it.
    if (is_array($value)) {
      // If array has numeric keys, we treat it as simple key/value elements.
      $keys = array_keys($value);
      if (is_numeric(array_shift($keys))) {
        $elem = $this->flattenArray($name, $value);
      }
      else {
        $elem = $this->doc->createElement($name);

        foreach ($value as $key => $subvalue) {
          $subelem = $this->convertParameter($key, $subvalue);

          // If we get an array of elements back, append them all to
          // the parent element.
          if (is_array($subelem)) {
            foreach ($subelem as $sub) {
              $elem->appendChild($sub);
            }
          }
          // Append a single returned element to the parent.
          else {
            $elem->appendChild($subelem);
          }
        }
      }
    }
    // If name is numeric, it's just a simple value. We create an
    // element with the value only.
    elseif (is_numeric($name)) {
      $elem = $this->doc->createElement($value);
    }
    else {
      $elem = $this->doc->createElement($name, htmlspecialchars($value, ENT_QUOTES, 'UTF-8', FALSE));
    }

    return $elem;
  }

  /**
   * Flatten parameter array.
   */
  function flattenArray($name, $array) {
    $elems = array();

    foreach ($array as $key => $value) {
      if (is_array($value)) {
        $elems[] = $this->convertParameter($name, $value);
      }
      else {
        $elems[] = $this->doc->createElement($name, $value);
      }
    }

    return $elems;
  }

  /**
   * Generate SOAP envelope.
   */
  function generateSOAPenvelope() {
    $ns_string = '';
    foreach ($this->namespaces as $key => $url) {
      if ($key == '') {
        $ns_string .= ' xmlns="' . $url . '"';
      }
      else {
        $ns_string .= ' xmlns:' . $key . '="' . $url . '"';
      }
    }
    $envelope = array(
      'header' => self::XML_HEADER,
      'env_start' => '<SOAP-ENV:Envelope' . $ns_string . '>',
      'body_start' => '<SOAP-ENV:Body>',
      'body_end' => '</SOAP-ENV:Body>',
      'env_end' => '</SOAP-ENV:Envelope>',
    );

    return implode("\n", $envelope);
  }
}

class NanoSOAPcURLException extends Exception {}
