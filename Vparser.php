<?php

class Vparser {
   private $file;
   private $result;

   const COMMA = ',';
   const L_BKT = '{';
   const R_BKT = '}';
   const COLON = ':';
   const QUOTE = '"';

   public function __construct() {}

   public function load ($file) {
      $this->file = file($file);
   }

   public function parse () {
      $result = [];
      $fileCount = count($this->file);

      for ($i = 0; $i < $fileCount; $i++) {
         $exploded = explode(static::QUOTE, trim($this->file[$i]));
         $count = count($exploded);

         if($count === 1) { // } or {
            $bkt = $exploded[0];
            $result[] = $bkt;

            if($bkt === static::R_BKT && $fileCount > $i + 1) {
               $next = $this->file[$i + 1];
               $next = trim($next);

               if($next !== static::R_BKT) {
                  $result[] = static::COMMA;
               }
            }
         }

         else if($count === 3) { // key of object
            $result[] = static::QUOTE . $exploded[1] . static::QUOTE . static::COLON;
         }

         else if($count === 5) { // key - value
            $result[] = static::QUOTE . $exploded[1] . static::QUOTE . static::COLON;
            $result[] = static::QUOTE . $exploded[3] . static::QUOTE;

            if($fileCount > $i + 1) {
               $next = $this->file[$i + 1];
               $next = trim($next);

               if($next !== static::R_BKT) {
                  $result[] = static::COMMA;
               }
            }
         }
      }

      $this->result = static::L_BKT . implode('', $result) . static::R_BKT;
   }

   public function toObj () {
      return json_decode($this->result);
   }
}
