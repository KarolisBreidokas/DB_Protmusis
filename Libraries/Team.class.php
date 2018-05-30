<?php
  class Team
  {
      private static $alentele=config::DB_PREFIX.'KOMANDA';
      private static $blentele=config::DB_PREFIX.'MOKYTOJAS';
      private static function shortQuerryString()
      {
        $alen=self::$alentele;
        return
        "SELECT A.ID as id, A.Pavadinimas as val
        from {$alen} as A";
      }
      private static function QuerryString()
      {
          $alen=self::$alentele;
          $blen=self::$blentele;
          return
        "SELECT A.ID as id, A.Pavadinimas as raide,
                A.Šūkis as pradz, B.Vardas as avrd
                ,B.Pavardė as apvd,
        FROM {$alen} AS A
        JOIN {$blen} AS B ON A.FK_MOKYTOJAS=B.ID";
      }

      public static function GetQList()
      {
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
      public static function GenerateReport()
      {
          $alen=self::$alentele;
          $b2len=config::DB_PREFIX.'ATVIRO_TIPO_ATSAKYMAS';
          $b3len=config::DB_PREFIX.'VAIZDO_KLAUSIMO_ATSAKYMAS';
          $b1len=config::DB_PREFIX.'TESTINIS_ATSAKYMAS_RAUNDE';
          $b11len=config::DB_PREFIX.'TESTINIO_KLAUSIMO_ATSAKYMAS';
          $query="SELECT A.Pavadinimas,
                  B1.ats as Test_ats,B1.teis as Test_teis,
                  B2.ats as Open_ats,B2.teis as Open_teis,
                  B3.ats as Visual_ats,B3.teis as Visual_teis
                  FROM {$alen} AS A
                LEFT JOIN  AS B1 ON B1.FK_KOMANDA=A.ID
                LEFT JOIN(
                  select A.FK_KOMANDA,count(A.FK_KOMANDA) as ats,ifnull(sum(A1.teisingas),0) as teis
                  FROM {$b1len} as A
                  JOIN {$b11len} AS A1 ON A.FK_TESTINIO_KLAUSIMO_ATSAKYMAS=A1.ID
                  group by FK_KOMANDA
                )AS B1 on B1.FK_KOMANDA=A.ID
                LEFT JOIN(
                  select A.FK_KOMANDA,count(A.FK_KOMANDA) as ats,ifnull(sum(A.teisingas),0) as teis
                  FROM ATVIRO_TIPO_ATSAKYMAS as A
                  group by FK_KOMANDA
                )AS B2 on B2.FK_KOMANDA=A.ID
                LEFT JOIN(
                select A.FK_KOMANDA,count(A.FK_KOMANDA) as ats,ifnull(sum(A.teisingas),0) as teis
                FROM {$b3len} as A
                group by FK_KOMANDA
              )AS B3 on B3.FK_KOMANDA=A.ID";
          return mysql::select($query);
      }

  }
