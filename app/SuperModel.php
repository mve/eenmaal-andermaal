<?php


namespace App;


use Illuminate\Support\Facades\DB;

abstract class SuperModel
{
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
     * Selects 1 row WHERE $column=$value
     * @param $column
     * @param $value
     * @return mixed
     */
    public static function oneWhere($column, $value){
        return DB::selectOne(DB::raw("SELECT TOP 1 * FROM " . self::getTableName(static::class) . " WHERE ".$column."=:value"),array(
            'value' => $value
        ));
    }

    /**
     * Insert a row into the child's presumed table
     * @param array $values $column=>$value array
     */
    public static function insert($values){
        $valuesString = "";
        $keysString = "";
        end($values);
        $lastElement = key($values);
        foreach($values as $key=>$value){
            $valuesString.= ":".$key;
            $keysString.= $key;
            if($key != $lastElement){
                $valuesString.= ",";
                $keysString.= ",";
            }
        }
        DB::insert(DB::raw("INSERT INTO ".self::getTableName(static::class)." (".$keysString.") VALUES(".$valuesString.")"), $values);
    }

    /**
     * Selects all rows from the child table
     * @return array fetched rows
     */
    public static function all()
    {
        return DB::select(DB::raw("SELECT * FROM " . self::getTableName(static::class)));
    }

    /**
     * Selects all rows from the child table in the provided order and by the provided column
     * @param string $column column to sort by
     * @param string $order order to sort in
     * @return array fetched rows
     */
    public static function allOrderBy($column = "id", $order = "ASC")
    {
        return DB::select(DB::raw("SELECT * FROM " . self::getTableName(static::class) . " ORDER BY ". $column . " ". $order));
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
