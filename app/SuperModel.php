<?php


namespace App;


abstract class SuperModel
{
    public function __construct()
    {
        foreach ($this->attributes as $attribute) {
            $this->{$attribute} = "";
        }
    }

    /**
     * Insert the model with attributes into the child's presumed table, except for the ID which should be IDENTITY
     */
    public function save(){
        $values = [];
        foreach ($this->attributes as $attribute) {
            if($attribute=="id")
                continue;
            $values[$attribute] = $this->{$attribute};
        }
        $this->id = self::insert($values);
    }

    /**
     * Delete the row with the ID of the current object from the child's presumed table
     * @return int
     */
    public function delete(){
        return DB::delete("DELETE FROM ". self::getTableName(static::class) ." WHERE id=:id",[
            'id' => $this->id
        ]);
    }

    /**
     * Insert a row into the child's presumed table
     * @param array $values $column=>$value array
     * @return int id of the inserted row
     */
    public static function insert($values)
    {
        $valuesString = "";
        $keysString = "";
        end($values);
        $lastElement = key($values);
        foreach ($values as $key => $value) {
            $valuesString .= ":" . $key;
            $keysString .= $key;
            if ($key != $lastElement) {
                $valuesString .= ",";
                $keysString .= ",";
            }
        }

        $insertId = DB::selectOne("INSERT INTO " . self::getTableName(static::class) . " (" . $keysString . ") OUTPUT Inserted.id VALUES(" . $valuesString . ")", $values);
        return $insertId["id"];
    }

    /**
     * Selects all rows from the child table
     * @return array fetched rows
     */
    public static function all()
    {
        $result = DB::select("SELECT * FROM " . self::getTableName(static::class));
        return self::resultArrayToClassArray($result, static::class);
    }

    /**
     * Selects all rows from the child table in the provided order and by the provided column
     * @param string $column column to sort by
     * @param string $order order to sort in
     * @return array fetched rows
     */
    public static function allOrderBy($column = "id", $order = "ASC")
    {
        $result = DB::select("SELECT * FROM " . self::getTableName(static::class) . " ORDER BY " . $column . " " . $order);
        return self::resultArrayToClassArray($result, static::class);
    }

    /**
     * Selects 1 row WHERE $column=$value
     * @param $column
     * @param $value
     * @return mixed
     */
    public static function oneWhere($column, $value)
    {
        $result = DB::selectOne("SELECT TOP 1 * FROM " . self::getTableName(static::class) . " WHERE " . $column . "=:value", array(
            'value' => $value
        ));
        if($result==null)
            return false;
        $class = static::class;
        $obj = new $class();
        $obj->fillAttributes($result);
        return $obj;
    }

    /**
     * Get the table name for the child class
     * @param string $class child's class name
     * @return string child's presumed table name
     */
    private static function getTableName($class)
    {
        $xp = explode("\\", $class);
        return self::pluralize(strtolower(end($xp)));
    }

    /**
     * Fill the class's attributes
     * @param $stdClassObject
     */
    private function fillAttributes($stdClassObject)
    {
        foreach ($this->attributes as $attribute) {
            if($stdClassObject instanceof \stdClass){
                $attr =  $stdClassObject->{$attribute};
            }else{
                $attr = $stdClassObject[$attribute];
            }
            $this->{$attribute} = $attr;
        }
//        unset($this->attributes);
    }

    /**
     * Convert stdClass array to $class array
     * @param $resultArray
     * @param $class
     * @return array
     */
    private static function resultArrayToClassArray($resultArray, $class)
    {
        $returnArray = [];
        foreach ($resultArray as $result) {
            $obj = new $class();
            $obj->fillAttributes($result);
            array_push($returnArray,$obj);
        }
        return $returnArray;
    }

    /**
     * Simple function to pluralize a word
     * @param string $word word to pluralize
     * @return string pluralized word
     */
    public static function pluralize($word)
    {
        $last_letter = strtolower($word[strlen($word) - 1]);
        switch ($last_letter) {
            case 's':
                return $word . 'es';
            case 'y':
                return substr($word, 0, -1) . 'ies';
            default:
                return $word . 's';
        }
    }
}
