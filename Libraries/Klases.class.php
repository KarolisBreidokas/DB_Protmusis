<?php
include 'Libraries/Pupil.class.php';
  class Klase
  {
      private static $alentele=config::DB_PREFIX.'KLASĖ';
      private static $blentele=config::DB_PREFIX.'MOKYTOJAS';

      private static $dlentele=config::DB_PREFIX.'MOKINYS';
      public static function checkDependant($id)
      {
          $len=self::$dlentele;
          $query="SELECT count(A.ID) as kiekis
        FROM {$len} as A
        where A.FK_KLASĖ={$id}";
          $data=mysql::select($query);
          return $data[0]['kiekis'];
      }

      private static function shortQuerryString()
      {
          $alen=self::$alentele;
          return
        "SELECT A.ID as id,concat(year(A.Mokymosi_Pradžia),A.Raidė) as val
        from {$alen} as A";
      }
      private static function rawQuerryString($id)
      {
          $alen=self::$alentele;
          return
            "SELECT A.ID as id, A.Raidė as raide,A.Mokyklos_Laida as laida,
                      A.Mokymosi_Pradžia as pradz, A.FK_MOKYTOJAS as FK_mokytojas
              FROM {$alen} AS A
              where A.ID={$id}";
      }
      private static function QuerryString()
      {
          $alen=self::$alentele;
          $blen=self::$blentele;
          return
        "SELECT A.ID as id, A.Raidė as raide,A.Mokyklos_Laida as laida,
                A.Mokymosi_Pradžia as pradz, B.Vardas as avrd
                ,B.Pavardė as apvd
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
          $query = "  SELECT COUNT(A.ID) as kiekis
          FROM {$len} as A";
          $data = mysql::select($query);
          return $data[0]['kiekis'];
      }
      public static function getItem($id)
      {
          $query= self::rawQuerryString($id);
          $data = mysql::select($query);
          return $data[0];
      }
      public static function update($data)
      {
          $len=self::$alentele;
          $query="UPDATE  {$len} set
          Raidė='{$data['raide']}',
          Mokymosi_Pradžia='{$data['pradz']}',
          Mokyklos_Laida={$data['laida']},
          FK_MOKYTOJAS={$data['FK_mokytojas']}
          WHERE
            ID={$data['id']}";
          mysql::query($query);
          if (!empty(mysql::error())) {
              return false;
          }
          return Pupil::updateOnClass($data);
      }
      public static function insert($data){
        $len=self::$alentele;
        $query="INSERT {$len}(Raidė,Mokyklos_Laida,Mokymosi_Pradžia,FK_MOKYTOJAS) VALUES
        ('{$data['raide']}',
          {$data['laida']},
        '{$data['pradz']}',
        {$data['FK_mokytojas']})";
        mysql::query($query);
        if (!empty(mysql::error())) {
            return false;
        }
        $data['id']=mysql::getLastInsertedId();
        return Pupil::insertOnClass($data);
      }

      public static function delete($id)
      {
          $len=self::$alentele;
          $query="DELETE FROM {$len} where ID={$id}";
          return mysql::query($query);
      }
  }
class Teacher
{
    private static $alentele=config::DB_PREFIX.'MOKYTOJAS';
    private static function shortQuerryString()
    {
        $alen=self::$alentele;
        return
    "SELECT A.ID as id,concat(A.Vardas,' ',A.Pavardė) as val
    from {$alen} as A";
    }

    public static function GetQList()
    {
        $query= self::shortQuerryString();
        $data = mysql::select($query);
        return $data;
    }
}
