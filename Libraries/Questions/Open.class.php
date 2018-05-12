<?php
class QuestionsOpen
{
    private static $lentele=config::DB_PREFIX.'ATVIRO_TIPO_KLAUSIMAS';
    private static $dlentele=config::DB_PREFIX.'ATVIRAS_KLAUSIMAS_RAUNDE';
    private static function QuerryString()
    {
        $len=self::$lentele;
        return
        "SELECT A.ID as id, A.Klausimas as klausimas,
                A.Teisingas_Atsakymas as atsakymas, A.Taškų_Skaičius as tsk_sk,
                A.Šaltinis as saltinis
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
        $query = "  SELECT COUNT(A.ID) as `kiekis`
					FROM {$len} as A";
        $data = mysql::select($query);
        return $data[0]['kiekis'];
    }
    public static function checkDependant($id)
    {
        $len=self::$dlentele;
        $query="SELECT count(A.ID) as cnt from {$len} as A where A.FK_ATVIRO_TIPO_KLAUSIMAS={$id}";
        $data = mysql::select($query);
        return $data[0]['cnt'];
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
        $query="  UPDATE {$len}  set
                    Klausimas='{$data['klausimas']}',
                    Teisingas_Atsakymas='{$data['atsakymas']}',
                    Taškų_Skaičius={$data['tsk_sk']},
                    Šaltinis='{$data['saltinis']}'
                  WHERE
                    ID={$data['id']}";
        return mysql::query($query);
    }
    public static function insert($data)
    {
        $len=self::$lentele;
        $query="  INSERT INTO {$len}(ID,Klausimas,Teisingas_Atsakymas,Taškų_Skaičius,Šaltinis)
                        VALUES
                          ({$data['id']},
                           '{$data['klausimas']}',
                           '{$data['atsakymas']}',
                            {$data['tsk_sk']},
                           '{$data['saltinis']}')";
        return mysql::query($query);
    }
    public static function delete($id){
      $len=self::$lentele;
      $query="DELETE FROM {$len} where ID={$id}";
      return mysql::query($query);
    }
}
