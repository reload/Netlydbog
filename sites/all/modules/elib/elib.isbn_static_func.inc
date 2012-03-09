<?php
//ISBN 10/13 <-> 13/10 Converter
#
/* ========================================================================== */
#
/* */
#
/* isbnConv.phps */
#
/* Author: Priyadarsan (2007)*/
#
/* */
#
/* a program to convert isbn 10 to isbn 13 format and vice versa */
#
/* (Code: http://www.freebookzone.com/others/isbnConv.phps) */
#
/* Ex. usage file available at http://www.freebookzone.com/others/isbnConv.htm */
#
/* Disclaimer: This program is a modified PHP version of the original java 
   source code by booksprice.com */
#
/* ========================================================================== */


/**
* Function:   convertFromIsbn13ToIsbn10
* Description:  Converts an EAN or an ISBN 13 to ISBN 10
* @param isbn13OrEAN
* @return ISBN 10
*/
function convertFromIsbn13ToIsbn10($isbn13OrEAN)
{
  $isbn10 = "";
  if ($isbn13OrEAN==null)
  {
    return false;   
  }
  $isbn13OrEAN = str_replace(" ","",str_replace("-","",$isbn13OrEAN));
  $isbnLen=strlen($isbn13OrEAN);
  if ($isbnLen!=13)
  {
    //Invalid length
    return false;
  }

  $isbn10 = substr($isbn13OrEAN,3,9);
  $sum = 0;
  $isbnLen=strlen($isbn10);

  for ($i = 0; $i < $isbnLen; $i++) 
  {
    $current = substr($isbn10,$i,1);
    if($current<0||$current>9)
    {
      //Invalid ISBN
      return false;
    }
    $sum+= $current*(10-$i);
  }
  $modulu = $sum%11;
  $checkDigit = 11 - $modulu;

  //if the checkDigit is 10 should be x
  if ($checkDigit==10)
    $isbn10 .= 'X';
  else if($checkDigit==11)
    $isbn10 .= '0';
  else
    $isbn10 .= $checkDigit;
    
  return $isbn10;
}

/**
* Function:   convertToEAN
* Description:  Converts a ISBN 10 to EAN
* @param isbn10
* @return EAN
*/
function convertToEAN($isbn10)
{
  $isbn13 = "";
  $prefix = "978";
  if($isbn10==null)
  {
    return $isbn10;
  }
    
  $isbn10 = str_replace("-","",$isbn10);
  $len=strlen($isbn10);
    
  if($len<9 || $len>10){
    //Invalid Length
    return $isbn10;
  }
  //remove the last digit
  if($len==10)
  {
    $isbn10 = substr($isbn10,0,9);
  }
    
  $isbn13 = $prefix . $isbn10;
  $len=strlen($isbn13);
    
  $sum = 0;
  for ($i = 0; $i < $len; $i++) 
  {
    $currentNumber = (int)substr($isbn13,$i,1);
    if($currentNumber<0||$currentNumber>9)
    {
      //Invalid ISBN
      return false;
    }
      
    if($i % 2 == 0)
    {
      $sum += $currentNumber;
    }
    else
    {
      $sum += $currentNumber*3;
    }
  }
    
  $result = $sum/10;
  $modulu = $sum%10;
  $checkDigit = 10 - $modulu;
  //if the checkDigit is 10 should be zero
  $checkDigit=$checkDigit==10?0:$checkDigit;
  $isbn13 .= $checkDigit;
  return $isbn13;
}

/**
* Function:   formatISBN13
* Description:  Format a ISBN 13
* @param isbn13
* @return hyphenated isbn13
*/
function formatISBN13($isbn13)
{
    $j=0;
    $isbn13Fmt="";
    for ($i=0;$i<17;$i++){
      if($i==3||$i==5||$i==12||$i==15){
        $str = '-';
      }
      else {
        $str = substr($isbn13,$j,1);
        $j++;
      }
      $isbn13Fmt.=$str;
    }
    return $isbn13Fmt;
}
?>

