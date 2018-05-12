<?php
class Pupil{
  private static $alentele=config::DB_PREFIX.'MOKINYS';
  private static $blentele=config::DB_PREFIX.'KLASĖ';
  private static $clentele=config::DB_PREFIX.'KOMANDA';
  private static function QuerryString()
  {
      $alen=self::$alentele;
      $blen=self::$blentele;
      return
      "SELECT A.id_Mokiniai as id, A.Vardas as vardas,
              A.Pavardė as pavarde, B.Raidė as kraide,
              year(B.Mokymosi_Pradžia) as kprad,
              ifnull(C.Pavadinimas,'Nėra')  as pav
      FROM {$alen} AS A
      JOIN {$blen} AS B ON A.fk_KLASĖSid_KLASĖS=B.id_KLASĖS
      LEFT JOIN {$clen} AS C ON A.fk_KOMANDOSid_KOMANDOS=C.id_KOMANDOS";
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
}
 ?>
