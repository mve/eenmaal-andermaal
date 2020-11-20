<?php

namespace App;

use PDO;

class DB
{
    /**
     * The database connection with PDO
     * @return PDO
     */
    private static function connection()
    {
        try {
            $options = [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];

            if (env("DB_CONNECTION") == "sqlsrv") {
                $dbh = new PDO("sqlsrv:Server=" . env("DB_HOST") . ";Database=" . env("DB_DATABASE"), env("DB_USERNAME"), env("DB_PASSWORD"), $options);

            } else {
                $dbh = new PDO(env("DB_CONNECTION") . ':host=' . env("DB_HOST") . ';port=' . env("DB_PORT") . ';dbname=' . env("DB_DATABASE"), env("DB_USERNAME"), env("DB_PASSWORD"), $options);
            }
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $dbh;
        } catch (\PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    /**
     * Prepare the connection and optionally bind the query parameters
     * @param $query
     * @param array $values
     * @return bool|\PDOStatement
     */
    private static function prepareAndBind($query, $values = [])
    {
        $dbh = self::connection();
        $stmt = $dbh->prepare($query);
        foreach ($values as $key => &$value) {
            $stmt->bindParam($key, $value);
        }
        $stmt->execute();
        return $stmt;
    }

    /**
     * Bind parameters and select rows from the database
     *
     * @param $query
     * @param array $values
     * @return array
     */
    public static function select($query, $values = [])
    {
        $dbh = self::connection();
        $stmt = $dbh->prepare($query);
        foreach ($values as $key => &$value) {
            $stmt->bindParam($key, $value);
        }
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Bind parameters and select 1 row from the database
     * @param $query
     * @param array $values
     * @return mixed
     */
    public static function selectOne($query, $values = [])
    {
        $dbh = self::connection();
        $stmt = $dbh->prepare($query);
        foreach ($values as $key => &$value) {
            $stmt->bindParam($key, $value);
        }
        $stmt->execute();
        return $stmt->fetch();
    }

    /**
     * Bind parameters and insert 1 row into the database
     * Use this instead of selectOne if you need to get true/false instead of the id
     * @param $query
     * @param array $values
     * @return bool
     */
    public static function insertOne($query, $values = []){
        $dbh = self::connection();
        $stmt = $dbh->prepare($query);
        foreach ($values as $key => &$value) {
            $stmt->bindParam($key, $value);
        }
        return $stmt->execute();
    }

    /**
     * Bind parameters and delete a row from the database
     * @param $query
     * @param array $values
     * @return int
     */
    public static function delete($query, $values = [])
    {
        $dbh = self::connection();
        $stmt = $dbh->prepare($query);
        foreach ($values as $key => &$value) {
            $stmt->bindParam($key, $value);
        }
        $stmt->execute();
        return $stmt->rowCount();
    }
}
