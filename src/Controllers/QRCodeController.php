<?php

namespace App\Controllers;

class QRCodeController{

   const CHT = "qr";
   const API_URL = "http://chart.apis.google.com/chart";

   public function getQRCodeUrl($Pianta, $width, $height, $encoding=false, $correctionlevel=false){
      //file_put_contents('/Users/simone/Desktop/Hanami/Hanami-back/src/Debug/dentro_qrcode.txt', print_r(var_dump($data), true), FILE_APPEND);

      $data = "localhost:8080/pianta/{$Pianta->getId()}";
      //$data = urlencode($data);
      
      $url = QRCodeController::API_URL."?cht=".QRCodeController::CHT."&chs=".$width."x".$height."&chl=".$data;
      
      if($encoding)
      {
         $url.="&choe".$encoding;
      }

      if($correctionlevel)
      {
         $url.="&chld".$correctionlevel;
      }

      return $url;
   }
}
   