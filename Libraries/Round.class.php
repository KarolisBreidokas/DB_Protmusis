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
          $query= self::QuerryString()." WHERE A.id_KLASĖS='{$id}'";
          $data = mysql::select($query);
          return $data[0];
      }
  }
  class Moderator{
    private static $alentele=config::DB_PREFIX.'MODERATORIUS';
    private static $blentele=config::DB_PREFIX.'ATVIRO_TIPO_ATSAKYMAS';
    private static $clentele=config::DB_PREFIX.'VAIZDO_KLAUSIMO_ATSAKYMAS';
    private static function DependantCount($id){
      $blen=self::$blentele;
      $clen=self::$clentele;
      $count=0;
      $query="SELECT count(*)as count from {$blen} where FK_MODERATORIUS={$id}";
      $ans=mysql::select($query);
      if($ans!=false){
        $count=$ans[0]['count'];
      }
      $query="SELECT count(*)as count from {$clen} where FK_MODERATORIUS={$id}";
      $ans=mysql::select($query);
      if($ans!=false){
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
              A.FK_MOKINYS as mokinys,count(B.ID)+count(C.ID) as dep
      FROM {$alen} AS A
      LEFT JOIN {$blen} as B on A.ID=B.FK_MODERATORIUS
      LEFT JOIN {$clen} as C on A.ID=C.FK_MODERATORIUS
      where A.FK_Raundas={$id}
      GROUP BY A.ID";
    }
    public static function GetList($id){
      $query=QuerryString($id);
      $data=mysql::select($query);
    }
  }
  class OpenInRound{
    private static $alentele=config::DB_PREFIX.'ATVIRAS_KLAUSIMAS_RAUNDE';
    private static $blentele=config::DB_PREFIX.'ATVIRO_TIPO_ATSAKYMAS';
    private static function DependantCount($id){
      $blen=self::$blentele;
      $clen=self::$clentele;
      $count=0;
      $query="SELECT count(*)as count from {$blen} where FK_ATVIRAS_KLAUSIMAS_RAUNDE={$id}";
      $ans=mysql::select($query);
      if($ans!=false){
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
      "SELECT A.ID as id, A.Klausimo_Numeris as num,
              A.FK_ATVIRO_TIPO_KLAUSIMAS as klausimas,count(B.ID) as dep
      FROM {$alen} AS A
      LEFT JOIN {$blen} as B on A.ID=B.FK_ATVIRAS_KLAUSIMAS_RAUNDE
      where A.FK_Raundas={$id}
      GROUP BY A.ID";
    }
    public static function GetList($id){
      $query=QuerryString($id);
      $data=mysql::select($query);
    }
  }
  class VisualInRound{
    private static $alentele=config::DB_PREFIX.'VAIZDO_KLAUSIMAS_RAUNDE';
    private static $blentele=config::DB_PREFIX.'VAIZDO_KLAUSIMO_ATSAKYMAS';
    private static function DependantCount($id){
      $blen=self::$blentele;
      $clen=self::$clentele;
      $count=0;
      $query="SELECT count(*)as count from {$blen} where FK_VAIZDO_KLAUSIMAS_RAUNDE={$id}";
      $ans=mysql::select($query);
      if($ans!=false){
        $count=$ans[0]['count'];
      }
      return $count;
    }
    private static function QuerryString($id)
    {
        $alen=self::$alentele;
        $blen=self::$blentele;
        return
      "SELECT A.ID as id, A.Klausimo_Numeris as num,
              A.FK_ATVIRO_TIPO_KLAUSIMAS as klausimas,count(B.ID) as dep
      FROM {$alen} AS A
      LEFT JOIN {$blen} as B on A.ID=B.FK_ATVIRAS_KLAUSIMAS_RAUNDE
      where A.FK_Raundas={$id}
      GROUP BY A.ID";
    }
    public static function GetList($id){
      $query=QuerryString($id);
      $data=mysql::select($query);
    }
  }
  class TestInRound{
    private static $alentele=config::DB_PREFIX.'TESTINIS_KLAUSIMAS_RAUNDE';
    private static $blentele=config::DB_PREFIX.'TESTINIS_ATSAKYMAS_RAUNDE';
    private static function DependantCount($id){
      $blen=self::$blentele;
      $clen=self::$clentele;
      $count=0;
      $query="SELECT count(*)as count from {$blen} where FK_VAIZDO_KLAUSIMAS_RAUNDE={$id}";
      $ans=mysql::select($query);
      if($ans!=false){
        $count=$ans[0]['count'];
      }
      return $count;
    }
    private static function QuerryString($id)
    {
        $alen=self::$alentele;
        $blen=self::$blentele;
        return
      "SELECT A.ID as id, A.Klausimo_Numeris as num,
              A.FK_ATVIRO_TIPO_KLAUSIMAS as klausimas,count(B.ID) as dep
      FROM {$alen} AS A
      LEFT JOIN {$blen} as B on A.ID=B.FK_ATVIRAS_KLAUSIMAS_RAUNDE
      where A.FK_Raundas={$id}
      GROUP BY A.ID";
    }
    public static function GetList($id){
      $query=QuerryString($id);
      $data=mysql::select($query);
    }
  }