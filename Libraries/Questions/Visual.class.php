<?php
class QuestionsVisual
{
    private static $alentele=config::DB_PREFIX.'VAIZDO_KLAUSIMAS';
    private static $blentele=config::DB_PREFIX.'Vaizdo_tipas';

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
        $query= self::QuerryString()." WHERE A.id_VAIZDO_KLAUSIMAI='{$id}'";

        $data = mysql::select($query);
        return $data[0];
    }
}
