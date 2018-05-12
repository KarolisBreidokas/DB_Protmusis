<?php
class QuestionsVisual
{
    private static $alentele=config::DB_PREFIX.'VAIZDO_KLAUSIMAS';
    private static $blentele=config::DB_PREFIX.'Vaizdo_tipas';

    private static $dlentele=config::DB_PREFIX.'VAIZDO_KLAUSIMAS_RAUNDE';
    private static function QuerryString()
    {
        $Alen=self::$alentele;
        $Blen=self::$blentele;
        return
        "SELECT A.ID as id, A.Klausimas as klausimas,
                A.Teisingas_Atsakymas as atsakymas, A.Taškų_Skaičius as tsk_sk,
                A.Šaltinis as saltinis, B.name as type,
                A.Vaizdinė_Medžiaga as medziaga
        FROM {$Alen} AS A
        LEFT JOIN {$Blen} AS B ON A.tipas = B.id";
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
        echo mysql::error();
        return $data;
    }

    public static function getCount()
    {
        $len=self::$alentele;
        $query = "SELECT COUNT(A.id_VAIZDO_KLAUSIMAI) as `kiekis`
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
        $len=self::$alentele;
        $query="  UPDATE {$len} set
                    Klausimas='{$data['klausimas']}',
                    Teisingas_Atsakymas='{$data['atsakymas']}',
                    Taškų_Skaičius={$data['tsk_sk']},
                    tipas=".(isset($data['type'])?$data['type']:"NULL").",
                    Vaizdinė_Medžiaga=".(isset($data['medziaga'])?$data['medziaga']:"NULL").",
                    Šaltinis='{$data['saltinis']}'
                  WHERE
                    ID={$data['id']}";
                    var_dump( $query);
        return mysql::query($query);
    }

    public static function checkDependant($id)
    {
        $len=self::$dlentele;
        $query="SELECT count(A.ID) as cnt from {$len} as A where A.FK_ATVIRO_TIPO_KLAUSIMAS={$id}";
        $data = mysql::select($query);
        return $data[0]['cnt'];
    }
    public static function insert($data)
    {
        $len=self::$alentele;
        $query="  INSERT INTO {$len}(ID,Klausimas,Teisingas_Atsakymas,Taškų_Skaičius,tipas,Vaizdinė_Medžiaga,Šaltinis)
                        VALUES
                          ({$data['id']},
                           '{$data['klausimas']}',
                           '{$data['atsakymas']}',
                            {$data['tsk_sk']},
                            ".(isset($data['type'])?$data['type']:"NULL").",
                            ".(isset($data['medziaga'])?$data['medziaga']:"NULL").",
                           '{$data['saltinis']}')";
        return mysql::query($query);
    }
    public static function delete($id){
      $len=self::$alentele;
      $query="DELETE FROM {$len} where ID={$id}";
      return mysql::query($query);
    }
}
