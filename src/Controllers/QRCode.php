<?php
class QRCode{

   const CHT = "qr";
   const API_URL = "http://chart.apis.google.com/chart";

   public function getQRCodeUrl($data, $width, $height, $encoding=false, $correctionlevel=false){

      $data = urlencode($data);
      $url = QRCode::APIURL."?cht".QR::CHT."&chl=".$data."&chs=".$width."x".$height;

      if($output_encoding)
      {
         $url.="&choe".$output_encoding;
      }

      if($error_correction_level)
      {
         $url.="&chld".$error_correction_level;
      }

      return $url;
   }
}
   