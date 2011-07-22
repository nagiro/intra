<?php

class Encript
{
        
  static public function Encripta($sData, $sKey = 'ccg')
  {
    $sResult = ''; 
    for($i=0;$i<strlen($sData);$i++){ 
        $sChar    = substr($sData, $i, 1); 
        $sKeyChar = substr($sKey, ($i % strlen($sKey)) - 1, 1); 
        $sChar    = chr(ord($sChar) + ord($sKeyChar)); 
        $sResult .= $sChar; 
    } 
    return self::encode_base64($sResult);      	  	  	
  }
  
  static public function Desencripta($sData, $sKey = 'ccg')
  {

    $sResult = ''; 
    $sData   = self::decode_base64($sData); 
    for($i=0;$i<strlen($sData);$i++){ 
        $sChar    = substr($sData, $i, 1); 
        $sKeyChar = substr($sKey, ($i % strlen($sKey)) - 1, 1); 
        $sChar    = chr(ord($sChar) - ord($sKeyChar)); 
        $sResult .= $sChar; 
    } 
    return $sResult; 
  }

  static private function encode_base64($sData){ 
    $sBase64 = base64_encode($sData); 
    return strtr($sBase64, '+/', '-_'); 
  } 
    
  static private function decode_base64($sData){ 
    $sBase64 = strtr($sData, '-_', '+/'); 
    return base64_decode($sBase64); 
  }  

}
