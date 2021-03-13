<?php
declare(strict_types=1);

namespace app\core;

use PDOStatement;

abstract class DatabaseModel extends Model {

    /**
     * Get the table name from the model
     * @return string
     */
    abstract public function tableName() : string;

    /**
     * Get all attributes from the model
     * @return array
     */
    abstract public function attributes() : array;

    /**
     * Save information in the database
     * @return bool
     */
    public function save() : bool {
        $tableName = $this->tableName();
//        $attributes = array_map(
//            fn($attribute) => strtoupper($attribute), $this->attributes()
//        );
        $attributes = $this->attributes();
        $params = array_map(fn($attribute) => ":$attribute", $attributes);

        $statement = self::prepare(
            "INSERT INTO $tableName (".implode(',', $attributes).")
            VALUES(".implode(',', $params).")"
        );
        
        foreach ($attributes as $attribute) {
            $statement->bindValue(":$attribute", $this->{$attribute});
        }

        $statement->execute();

        return true;
    }

    /**
     * Get the Object PDOStatement with the prepared statement
     * @param String $statement
     * @return PDOStatement
     */
    public static function prepare(String $statement) : PDOStatement {
        return Application::$app->database->pdo->prepare($statement);
    }
}