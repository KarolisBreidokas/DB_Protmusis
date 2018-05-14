<?php
  class Klase
  {
      private static $alentele=config::DB_PREFIX.'KLASĖ';
      private static $blentele=config::DB_PREFIX.'MOKYTOJAS';
      private static function shortQuerryString(){
        $alen=self::$alentele;
        return
        "SELECT A.ID as id,concat(year(A.Mokymosi_Pradžia),A.Raidė) as val
        from {$alen} as A";
      }
      private static function QuerryString()
      {
          $alen=self::$alentele;
          $blen=self::$blentele;
          return
        "SELECT A.ID as id, A.Raidė as raide,
                A.Mokymosi_Pradžia as pradz, B.Vardas as avrd
                ,B.Pavardė as apvd
        FROM {$alen} AS A
        JOIN {$blen} AS B ON A.FK_MOKYTOJAS=B.ID";
      }

      public static function GetQList(){
        $query= self::shortQuerryString();
        $data = mysql::select($query);
        return $data;
      }
      public static function GetList($limit = null, $offset = null)
      {
          $limitOffsetString = "";
          if (isset($limit)) {
              $limitOffsetString .= " LIMIT {$limit}";

              if (isset($offset)) {
                  $limitOffsetString .= " OFFSET {$offset}";
              }
          }

          $query= self::QuerryString().$limitOffsetString;
          $data = mysql::select($query);
          return $data;
      }
      public static function getCount()
      {
          $len=self::$alentele;
          $query = "  SELECT COUNT(`A.ID`) as `kiekis`
          FROM {$len} as A";
          $data = mysql::select($query);
          return $data[0]['kiekis'];
      }
      public static function getItem($id)
      {
          $query= self::QuerryString()." WHERE A.ID='{$id}'";
          $data = mysql::select($query);
          return $data[0];
      }
  }
