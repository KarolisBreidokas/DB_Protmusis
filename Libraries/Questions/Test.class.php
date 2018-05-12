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
}

class TestAnswers{
  private static $lentele=config::DB_PREFIX.'TESTINIO_KLAUSIMO_ATSAKYMAS';
  private static function QuerryString($Question_Id)
  {
      $len=self::$lentele;
      return
      "SELECT A.ID as id, A.Klausimas as klausimas,
              A.Taškų_Skaičius as tsk_sk,A.Šaltinis as saltinis
      FROM {$len} AS A
      WHERE A.FK_TESTINIS_KLAUSIMAS={$Question_Id}";
  }
  public static function GetList($Question_Id)
  {
      $query= self::QuerryString().$limitOffsetString;
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
}
