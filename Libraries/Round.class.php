<?php
  class Round
  {
      private static $alentele=config::DB_PREFIX.'RAUNDAS';
      private static $blentele=config::DB_PREFIX.'Raundo_stadija';
      private static function QuerryString()
      {
          $alen=self::$alentele;
          $blen=self::$blentele;
          return
        "SELECT A.ID as id, A.Data as data,
                A.Laikas as laikas, B.name as stadija
        FROM {$alen} AS A
        JOIN {$blen} AS B ON A.Pasiruošimo_Stadija=B.ID";
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
      public static function GenerateReport($dateFrom, $dateTo)
      {
          $alen=self::$alentele;
          $ablen=config::DB_PREFIX.'Dalyvauja';
          $blen=config::DB_PREFIX.'KOMANDA';
          $c11len=config::DB_PREFIX.'ATVIRO_TIPO_ATSAKYMAS';
          $c12len=config::DB_PREFIX.'ATVIRAS_KLAUSIMAS_RAUNDE';
          $c13len=config::DB_PREFIX.'ATVIRO_TIPO_KLAUSIMAS';
          $c21len=config::DB_PREFIX.'VAIZDO_KLAUSIMO_ATSAKYMAS';
          $c22len=config::DB_PREFIX.'VAIZDO_KLAUSIMAS_RAUNDE';
          $c23len=config::DB_PREFIX.'VAIZDO_KLAUSIMAS';
          $c31len=config::DB_PREFIX.'TESTINIS_ATSAKYMAS_RAUNDE';
          $c32len=config::DB_PREFIX.'TESTINIO_KLAUSIMO_ATSAKYMAS';
          $c33len=config::DB_PREFIX.'TESTINIS_KLAUSIMAS';
          $c34len=config::DB_PREFIX.'TESTINIS_KLAUSIMAS_RAUNDE';
          $whereClauseString = "";
          if (!empty($dateFrom)) {
              $whereClauseString .= " AND A.Data>='{$dateFrom}'";
              if (!empty($dateTo)) {
                  $whereClauseString .= " AND A.Data<='{$dateTo}'";
              }
          } else {
              if (!empty($dateTo)) {
                  $whereClauseString .= " AND A.Data<='{$dateTo}'";
              }
          }
          $queryString="
          SELECT A.ID As RID,A.Data,A.Laikas,B.ID as TID, B.Pavadinimas, ifnull(C1.tsk,0)+ ifnull(C2.tsk,0)+ ifnull(C3.tsk,0) As taskai, sum( ifnull(C2.teisingi,0)+ ifnull(C1.teisingi,0)+ ifnull(C3.teisingi,0)) as 'Teisingų_kiekis'
          FROM {$alen} as A
          JOIN {$ablen} as AB on AB.FK_RAUNDAS=A.ID
          JOIN {$blen} as B on AB.FK_KOMANDA=B.ID
          LEFT JOIN (
            SELECT A1.FK_KOMANDA, A2.FK_RAUNDAS, sum(ifnull((Teisingas * Taškų_skaičius),0)) as tsk, sum(ifnull(Teisingas,0)) as teisingi
            FROM {$c11len} AS A1
            JOIN {$c12len} AS A2 ON A1.FK_ATVIRAS_KLAUSIMAS_RAUNDE = A2.ID
            JOIN {$c13len} AS A3 ON A2.FK_ATVIRO_TIPO_KLAUSIMAS = A3.ID
            group by A2.FK_RAUNDAS,A1.FK_KOMANDA
          ) as C1 on C1.FK_KOMANDA=B.ID and C1.FK_RAUNDAS=A.ID
          LEFT JOIN (
            SELECT A1.FK_KOMANDA, A2.FK_RAUNDAS,  sum(ifnull((Teisingas * Taškų_skaičius),0)) as tsk, sum(ifnull(Teisingas,0)) as teisingi
            FROM {$c21len} AS A1
            JOIN {$c22len} AS A2 ON A1.FK_VAIZDO_KLAUSIMAS_RAUNDE= A2.ID
            JOIN {$c23len} AS A3 ON A2.FK_VAIZDO_KLAUSIMAS = A3.ID
            group by A2.FK_RAUNDAS,A1.FK_KOMANDA
          ) as C2 on C2.FK_KOMANDA=B.ID and C2.FK_RAUNDAS=A.ID

          LEFT JOIN (
            SELECT A1.FK_KOMANDA, A4.FK_RAUNDAS,  sum(ifnull((Teisingas * Taškų_skaičius),0)) as tsk, sum(ifnull(Teisingas,0)) as teisingi
            FROM {$c31len} AS A1
            JOIN {$c32len} AS A2 ON A1.FK_TESTINIO_KLAUSIMO_ATSAKYMAS= A2.ID
            JOIN {$c33len} AS A3 ON A2.FK_TESTINIS_KLAUSIMAS = A3.ID
            JOIN {$c34len} AS A4 ON A4.ID=A1.FK_TESTINIS_KLAUSIMAS_RAUNDE
            group by A4.FK_RAUNDAS,A1.FK_KOMANDA
          ) as C3 on C3.FK_KOMANDA=B.ID and C3.FK_RAUNDAS=A.ID
          Where  A.Pasiruošimo_Stadija=4".$whereClauseString."
          group by A.ID ,B.ID with rollup
          ";
          return mysql::select($queryString);
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
  class Moderator
  {
      private static $alentele=config::DB_PREFIX.'MODERATORIUS';
      private static $blentele=config::DB_PREFIX.'ATVIRO_TIPO_ATSAKYMAS';
      private static $clentele=config::DB_PREFIX.'VAIZDO_KLAUSIMO_ATSAKYMAS';
      private static function DependantCount($id)
      {
          $blen=self::$blentele;
          $clen=self::$clentele;
          $count=0;
          $query="SELECT count(*)as count from {$blen} where FK_MODERATORIUS={$id}";
          $ans=mysql::select($query);
          if ($ans!=false) {
              $count=$ans[0]['count'];
          }
          $query="SELECT count(*)as count from {$clen} where FK_MODERATORIUS={$id}";
          $ans=mysql::select($query);
          if ($ans!=false) {
              $count=$ans[0]['count'];
          }
          return $count;
      }
      private static function QuerryString($id)
      {
          $alen=self::$alentele;
          $blen=self::$blentele;
          $clen=self::$clentele;
          return
      "SELECT A.ID as id, A.Pagrindinis_Moderatorius as main,
              A.FK_MOKINYS as FK_mokinys, count(B.FK_MODERATORIUS)+count(C.FK_MODERATORIUS) as dep
      FROM {$alen} AS A
      LEFT JOIN {$blen} as B on A.ID=B.FK_MODERATORIUS
      LEFT JOIN {$clen} as C on A.ID=C.FK_MODERATORIUS
      where A.FK_Raundas={$id}
      GROUP BY A.ID";
      }
      public static function GetList($id)
      {
          $query=self::QuerryString($id);
          $data=mysql::select($query);
          var_dump($data);
          return $data;
      }
  }
  class OpenInRound
  {
      private static $alentele=config::DB_PREFIX.'ATVIRAS_KLAUSIMAS_RAUNDE';
      private static $blentele=config::DB_PREFIX.'ATVIRO_TIPO_ATSAKYMAS';
      private static function DependantCount($id)
      {
          $blen=self::$blentele;
          $clen=self::$clentele;
          $count=0;
          $query="SELECT count(*)as count from {$blen} where FK_ATVIRAS_KLAUSIMAS_RAUNDE={$id}";
          $ans=mysql::select($query);
          if ($ans!=false) {
              $count=$ans[0]['count'];
          }
          return $count;
      }
      private static function QueryString($id)
      {
          $alen=self::$alentele;
          $blen=self::$blentele;
          return
      "SELECT A.ID as id, A.Klausimo_Numeris as num,
              A.FK_ATVIRO_TIPO_KLAUSIMAS as FK_klausimas,count(B.FK_ATVIRAS_KLAUSIMAS_RAUNDE) as dep
      FROM {$alen} AS A
      LEFT JOIN {$blen} as B on A.ID=B.FK_ATVIRAS_KLAUSIMAS_RAUNDE
      where A.FK_Raundas={$id}
      GROUP BY A.ID";
      }
      public static function GetList($id)
      {
          $query=self::QueryString($id);
          $data=mysql::select($query);
          return $data;
      }
  }
  class VisualInRound
  {
      private static $alentele=config::DB_PREFIX.'VAIZDO_KLAUSIMAS_RAUNDE';
      private static $blentele=config::DB_PREFIX.'VAIZDO_KLAUSIMO_ATSAKYMAS';
      private static function DependantCount($id)
      {
          $blen=self::$blentele;
          $clen=self::$clentele;
          $count=0;
          $query="SELECT count(*)as count from {$blen} where FK_VAIZDO_KLAUSIMAS_RAUNDE={$id}";
          $ans=mysql::select($query);
          if ($ans!=false) {
              $count=$ans[0]['count'];
          }
          return $count;
      }
      private static function QueryString($id)
      {
          $alen=self::$alentele;
          $blen=self::$blentele;
          return
      "SELECT A.ID as id, A.Klausimo_Numeris as num,
              A.FK_VAIZDO_KLAUSIMAS as klausimas,count(B.FK_VAIZDO_KLAUSIMAS_RAUNDE) as dep
      FROM {$alen} AS A
      LEFT JOIN {$blen} as B on A.ID=B.FK_VAIZDO_KLAUSIMAS_RAUNDE
      where A.FK_Raundas={$id}
      GROUP BY A.ID";
      }
      public static function GetList($id)
      {
          $query=self::QueryString($id);
          $data=mysql::select($query);

          return $data;
      }
  }
  class TestInRound
  {
      private static $alentele=config::DB_PREFIX.'TESTINIS_KLAUSIMAS_RAUNDE';
      private static $blentele=config::DB_PREFIX.'TESTINIS_ATSAKYMAS_RAUNDE';
      private static function DependantCount($id)
      {
          $blen=self::$blentele;
          $clen=self::$clentele;
          $count=0;
          $query="SELECT count(*)as count from {$blen} where FK_VAIZDO_KLAUSIMAS_RAUNDE={$id}";
          $ans=mysql::select($query);
          if ($ans!=false) {
              $count=$ans[0]['count'];
          }
          return $count;
      }
      private static function QueryString($id)
      {
          $alen=self::$alentele;
          $blen=self::$blentele;
          return
      "SELECT A.ID as id, A.Klausimo_Numeris as num,
              A.FK_TESTINIS_KLAUSIMAS as FK_klausimas,count(B.FK_TESTINIS_KLAUSIMAS_RAUNDE) as dep
      FROM {$alen} AS A
      LEFT JOIN {$blen} as B on A.ID=B.FK_TESTINIS_KLAUSIMAS_RAUNDE
      where A.FK_Raundas={$id}
      GROUP BY A.ID";
      }
      public static function GetList($id)
      {
          $query=self::QueryString($id);
          $data=mysql::select($query);

          return $data;
      }
  }

  class ParticipatingTeams
  {
      private static $alentele=config::DB_PREFIX.'Dalyvauja';
      private static function QueryString($id)
      {
          $alen=self::$alentele;
          return
          "SELECT A.FK_KOMANDA as FK_komanda
              FROM {$alen} AS A
              where A.FK_Raundas={$id}";
      }

      public static function GetList($id)
      {
          $query=self::QueryString($id);
          $data=mysql::select($query);

          return $data;
      }
  }
