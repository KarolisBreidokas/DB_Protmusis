<?php
class QuestionsTest
{
    private static $lentele=config::DB_PREFIX.'TESTINIS_KLAUSIMAS';
    private static function QuerryString()
    {
        $len=self::$lentele;
        return
        "SELECT A.ID as id, A.Klausimas as klausimas,
                A.Taškų_Skaičius as tsk_sk, A.Šaltinis as saltinis
        FROM {$len} AS A";
    }
    private static function shortQuerryString()
    {
        $len=self::$lentele;
        return
      "SELECT A.ID as id, A.Klausimas as val
      FROM {$len} AS A";
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
        $len=self::$lentele;
        $query = "SELECT COUNT(A.ID) as `kiekis`
					FROM {$len} AS A";
        $data = mysql::select($query);
        return $data[0]['kiekis'];
    }
    public static function getItem($id)
    {
        $query= self::QuerryString()." WHERE A.ID='{$id}'";
        $data = mysql::select($query);
        return $data[0];
    }
    public static function update($data)
    {
        $len=self::$lentele;
        $query="UPDATE  {$len} set
        Klausimas='{$data['klausimas']}',
        Taškų_Skaičius={$data['tsk_sk']},
        Šaltinis='{$data['saltinis']}'
        WHERE
          ID={$data['id']}";
        mysql::query($query);
        if (!empty(mysql::error())) {
            return false;
        }
        return TestAnswers::update($data);
    }
}
class TestAnswers
{
    private static $lentele=config::DB_PREFIX.'TESTINIO_KLAUSIMO_ATSAKYMAS';
    private static $blentele=config::DB_PREFIX.'TESTINIS_ATSAKYMAS_RAUNDE';
    private static function QuerryString($Question_Id)
    {
        $len=self::$lentele;
        $blen=self::$blentele;
        return
      "SELECT A.ID as id, A.Atsakymas as atsakymas,
              A.Teisingas as teisingas, count(B.FK_TESTINIO_KLAUSIMO_ATSAKYMAS) as dep
      FROM {$len} AS A
      left join {$blen} as B on A.ID=B.FK_TESTINIO_KLAUSIMO_ATSAKYMAS
  WHERE A.FK_TESTINIS_KLAUSIMAS={$Question_Id}
      Group by A.ID" ;
    }
    public static function GetList($Question_Id)
    {
        $query= self::QuerryString($Question_Id);
        $data = mysql::select($query);
        return $data;
    }
    public static function getCount($Question_Id)
    {
        $len=self::$lentele;
        $query = "  SELECT COUNT(A.ID) as `kiekis`
        FROM {$len} AS A
        WHERE A.FK_TESTINIS_KLAUSIMAS={$Question_Id}";
        $data = mysql::select($query);
        return $data[0]['kiekis'];
    }
    private static function removeind($pid)
    {
        $len=self::$lentele;
        $blen=self::$blentele;
        $query="DELETE FROM {$len} where ID in(SELECT A.ID as id
        FROM (select * from {$len}) AS A
        left join {$blen} as B on A.ID=B.FK_TESTINIO_KLAUSIMO_ATSAKYMAS
    WHERE A.FK_TESTINIS_KLAUSIMAS={$pid} group by A.ID having  count(B.FK_TESTINIO_KLAUSIMO_ATSAKYMAS)=0)";
        return mysql::query($query);
    }
    public static function update($data)
    {
        $len=self::$lentele;
        self::removeind($data['id']);
        echo mysql::error();
        if (isset($data['ids'])) {
            for ($i=0;$i<sizeof($data['ids']);$i++) {
                $query="";
                if ($data['deps'][$i]>0) {
                    $query="UPDATE {$len} set
                Atsakymas='{$data['atsakymai'][$i]}',
                Teisingas={$data['teisingi'][$i]},
                where ID={$data['ids'][$i]}";
                } else {
                    $query="INSERT into {$len}(Atsakymas,Teisingas,FK_TESTINIS_KLAUSIMAS) values
              ('{$data['atsakymai'][$i]}',{$data['teisingi'][$i]},{$data['id']})";
                }

                mysql::query($query);
            }
        }
        return true;
    }
}
