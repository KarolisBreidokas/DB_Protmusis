<?php
class Pupil
{
    private static $alentele=config::DB_PREFIX.'MOKINYS';
    private static $blentele=config::DB_PREFIX.'KLASĖ';
    private static $clentele=config::DB_PREFIX.'KOMANDA';
    private static $dlentele=config::DB_PREFIX.'MODERATORIUS';
    public static function checkDependant($id)
    {
        $len=self::$dlentele;
        $query="SELECT count(A.ID) as kiekis
      FROM {$len}
      where A.FK_MOKINYS={$id}";
        $data=mysql::select($query);
        return $data[0]['kiekis'];
    }

    private static function smallQuerryString()
    {
        $len=self::$alentele;
        return
      "SELECT A.ID as id, concat(A.Vardas,' ',A.Pavardė) as val
      FROM {$len} AS A";
    }
    public static function GetQList()
    {
        $query= self::smallQuerryString();
        $data = mysql::select($query);
        return $data;
    }
    private static function classQueryString($id)
    {
        $alen=self::$alentele;
        $dlen=self::$dlentele;
        return "SELECT A.ID as id, A.Vardas as vardas,
              A.Pavardė as pavarde,A.FK_KOMANDA as FK_komanda,
              COUNT(B.ID) as dep
      FROM {$alen} AS A
      Left JOIN {$dlen} AS B ON A.ID=B.FK_MOKINYS
      where A.FK_KLASĖ={$id}
      GROUP BY A.ID";
    }
    private static function QuerryString()
    {
        $alen=self::$alentele;
        $blen=self::$blentele;
        $clen=self::$clentele;
        return
      "SELECT A.ID as id, A.Vardas as vardas,
              A.Pavardė as pavarde, B.Raidė as kraide,
              year(B.Mokymosi_Pradžia) as kprad,
              ifnull(C.Pavadinimas,'Nėra')  as pav
      FROM {$alen} AS A
      JOIN {$blen} AS B ON A.FK_KLASĖ=B.ID
      LEFT JOIN {$clen} AS C ON A.FK_KOMANDA=C.ID";
    }
    private static function itemQuerryString($id)
    {
        $alen=self::$alentele;
        return
        "SELECT A.ID as id, A.Vardas as vardas,
                A.Pavardė as pavarde, A.FK_KLASĖ as FK_klase,
                A.FK_KOMANDA as FK_komanda
        FROM {$alen} AS A
        where A.ID={$id}";
    }

    public static function GetItem($id)
    {
        $query=self::itemQuerryString($id);
        $data=mysql::select($query);
        return $data[0];
    }
    public static function getClassList($id)
    {
        $query=self::classQueryString($id);

        $data=mysql::select($query);
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
    public static function insert($data)
    {
        $len=self::$alentele;
        $query="INSERT INTO {$len}(Vardas,Pavardė,FK_KLASĖ,FK_KOMANDA) values
        (
          '{$data['vardas']}',
          '{$data['pavarde']}',
          {$data['FK_klase']},
          {$data['FK_komanda']}
        )";
        return mysql::query($query);
    }
    public static function update($data)
    {
        $len=self::$alentele;
        $query="UPDATE {$len} set
            Vardas='{$data['vardas']}',
            Pavardė='{$data['pavarde']}',
            FK_KLASĖ={$data['FK_klase']},
            FK_KOMANDA={$data['FK_komanda']}
            where ID={$data['id']}";
        return mysql::query($query);
    }
    private static function removeind($pid)
    {
        $len=self::$alentele;
        $blen=self::$dlentele;
        $query="DELETE FROM {$len} where ID in(SELECT A.ID as id
        FROM (select * from {$len}) AS A
        left join {$blen} as B on A.ID=B.FK_MOKINYS
    WHERE A.FK_KLASĖ={$pid} group by A.ID having  count(B.FK_MOKINYS)=0)";
        return mysql::query($query);
    }


    public static function updateOnClass($data)
    {
        $len=self::$alentele;
        self::removeind($data['id']);
        if (isset($data['ids'])) {
            for ($i=0;$i<sizeof($data['ids']);$i++) {
                $query="";
                if ($data['deps'][$i]>0) {
                    $query="UPDATE {$len} set
                Vardas='{$data['vardai'][$i]}',
                Pavardė='{$data['pavardes'][$i]}',
                FK_KOMANDA={$data['FK_komandos'][$i]}
                where ID={$data['ids'][$i]}";
                } else {
                    $query="INSERT into {$len}(Vardas,Pavardė,FK_KOMANDA,FK_KLASĖ) values
              ('{$data['vardai'][$i]}','{$data['pavardes'][$i]}',{$data['FK_komandos'][$i]},{$data['id']})";
                }

                mysql::query($query);
            }
        }
        return true;
    }
    public static function insertOnClass($data)
    {
        $len=self::$alentele;
        self::removeind($data['id']);
        if (isset($data['ids'])) {
            for ($i=0;$i<sizeof($data['ids']);$i++) {
                    $query="INSERT into {$len}(Vardas,Pavardė,FK_KOMANDA,FK_KLASĖ) values
              ('{$data['vardai'][$i]}','{$data['pavardes'][$i]}',{$data['FK_komandos'][$i]},{$data['id']})";


                mysql::query($query);
            }
        }
        return true;
    }
    public static function delete($id)
    {
        $len=self::$alentele;
        $query="DELETE FROM {$len} where ID={$id}";
        return mysql::query($query);
    }
}
