<?php


namespace App;


use Carbon\Carbon;

abstract class SuperModel
{
    public function __construct()
    {

    }

    /**
     * Insert the model with attributes into the child's presumed table, except for the ID which should be IDENTITY
     */
    public function save()
    {
        $values = [];
        $arr = get_object_vars($this);
        foreach ($arr as $key => $value) {
            $values[$key] = $value;
        }
        $this->id = self::insert($values);
    }

    /**
     * Update the model with attributes into the child's presumed table at the row with the ID of the object
     */
    public function update($updatedAt = true)
    {
        // $values = [];
        // $arr = get_object_vars($this);
        // $arr['updated_at'] = Carbon::now()->toDateTimeString();

        // foreach ($arr as $key => $value) {
        //     if ($key == "created_at")
        //         continue;
        //     $values[$key] = $value;
        // }

        $values = [];
        $arr = get_object_vars($this);
        $arr['updated_at'] = Carbon::now()->toDateTimeString();

        foreach ($arr as $key => $value) {
            if ($key == "created_at" || ($updatedAt && $key == "updated_at"))
                continue;
            $values[$key] = $value;
        }

        $setString = "";
        end($values);
        $lastElement = key($values);
        foreach ($values as $key => $value) {
            if ($key == "id")
                continue;
            $setString .= $key . "=:" . $key;
            if ($key != $lastElement) {
                $setString .= ",";
            }
        }

        $insertId = DB::insertOne("UPDATE " . self::getTableName(static::class) . " SET " . $setString . " WHERE id=:id", $values);
        return $insertId;
    }

    /**
     * Delete the row with the ID of the current object from the child's presumed table
     * @return int affected rows
     */
    public function delete()
    {
        return self::deleteWhere('id', $this->id);
    }

    /**
     * Delete all rows WHERE $column = $value
     * @param $column
     * @param $value
     * @return int affected rows
     */
    public static function deleteWhere($column, $value)
    {
        return DB::delete("DELETE FROM " . self::getTableName(static::class) . " WHERE " . $column . "=:val", [
            'val' => $value
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
        return $insertId ? $insertId["id"] : $insertId;
    }

    /**
     * Selects all rows from the child table
     * @return array fetched rows
     */
    public static function all()
    {
        $result = DB::select("SELECT * FROM " . self::getTableName(static::class));
        return self::resultArrayToClassArray($result);
    }

    /**
     * Selects all rows from the child table WHERE $column=$value
     * @param $column
     * @param $value
     * @return array
     */
    public static function allWhere($column, $value)
    {
        $result = DB::select("SELECT * FROM " . self::getTableName(static::class) . " WHERE " . $column . "=:value", array(
            'value' => $value
        ));
        return self::resultArrayToClassArray($result);
    }

    /**
     * Select all rows from the child table WHERE $column=$value and orders
     *
     */
    public static function allWhereOrderBy($column, $value, $orderBy, $order = "ASC")
    {
        $result = DB::select("SELECT * FROM " . self::getTableName(static::class) . " WHERE " . $column . "=:value ORDER BY " . $orderBy . " " . $order, array(
            'value' => $value
        ));
        return self::resultArrayToClassArray($result);
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
        return self::resultArrayToClassArray($result);
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
        if ($result == null)
            return false;
        return self::resultToClass($result);
    }

    /**
     * Get the table name for the child class
     * @param string $class child's class name
     * @return string child's presumed table name
     */
    private static function getTableName($class)
    {
        $xp = explode("\\", $class);
        return self::pluralize(self::pascalCaseToSnakeCase(end($xp)));
    }

    /**
     * Fill the class's attributes
     * @param $stdClassObject
     */
    private function fillAttributes($stdClassObject)
    {
        foreach ($stdClassObject as $key => $value) {
            $this->{$key} = $value;
        }
//        unset($this->attributes);
    }

    /**
     * Convert result array to $class array
     * @param $resultArray
     * @return array
     */
    public static function resultArrayToClassArray($resultArray)
    {
        $class = static::class;
        $returnArray = [];
        foreach ($resultArray as $result) {
            $obj = new $class();
            $obj->fillAttributes($result);
            array_push($returnArray, $obj);
        }
        return $returnArray;
    }

    /**
     * Convert result to $class object
     * @param $result
     * @return mixed
     */
    public static function resultToClass($result)
    {
        $class = static::class;
        $obj = new $class();
        $obj->fillAttributes($result);
        return $obj;
    }

    /**
     * Convert object into array
     * @return array
     */
    public function toArray()
    {
        $returnArray = [];
        $vars = get_object_vars($this);

        foreach ($vars as $key => $value) {
            $returnArray[$key] = $value;
        }

        return $returnArray;
    }

    /**
     * Convert a PascalCase string to a snake_case_string
     * @param $string
     * @return string
     */
    private static function pascalCaseToSnakeCase($string)
    {
        $parts = preg_split("/(?=[A-Z])/", lcfirst($string));
        $returnString = "";
        $last = end($parts);
        foreach ($parts as $part) {
            $returnString .= $part . ($part == $last ? "" : "_");
        }
        return strtolower($returnString);
    }

    /**
     * Simple function to pluralize a word
     * @param string $word word to pluralize
     * @return string pluralized word
     */
    private static function pluralize($word)
    {
        $last_letter = $word[strlen($word) - 1];
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
