<?php
declare(strict_types=1);

namespace app\core;

abstract class Model {
    public const RULE_REQUIRED  = 'required';
    public const RULE_EMAIL  = 'email';
    public const RULE_MIN  = 'min';
    public const RULE_MAX  = 'max';
    public const RULE_MATCH  = 'match';
    public const RULE_UNIQUE  = 'unique';

    public array $errors = [];

    public function loadData($data) : void {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    abstract public function rules() : array;

    /**
     * Validate all the rules configured for the attribute
     * @return bool
     */
    public function validate() : bool {
        foreach ($this->rules() as $attribute => $rules) {
            $value = $this->{$attribute};

            foreach ($rules as $rule) {
                $ruleName = $rule;

                if (!is_string($ruleName)) {
                    $ruleName = $rule[0];
                }

                if ($ruleName === self::RULE_REQUIRED && !$value) {
                    $this->addError($attribute, self::RULE_REQUIRED);
                }

                if ($ruleName === self::RULE_EMAIL
                    && !filter_var($value, FILTER_VALIDATE_EMAIL)
                ) {
                    $this->addError($attribute, self::RULE_EMAIL);
                }

                if ($ruleName === self::RULE_MIN && strlen($value) < $rule['min']) {
                    $this->addError($attribute, self::RULE_MIN, $rule);
                }

                if ($ruleName === self::RULE_MAX && strlen($value) > $rule['max']) {
                    $this->addError($attribute, self::RULE_MAX, $rule);
                }

                if ($ruleName === self::RULE_MATCH
                    && $value !== $this->{$rule['match']}
                ) {
                    $this->addError($attribute, self::RULE_MATCH, $rule);
                }

                if ($ruleName === self::RULE_UNIQUE) {
                    $className = $rule['class'];
                    $uniqueAttribute = $rule['attribute'] ?? $attribute;
                    $tableName = $className::tableName();

                    $statement = Application::$app->database->prepare(
                        "SELECT * FROM $tableName WHERE $uniqueAttribute = :attribute"
                    );
                    $statement->bindValue(":attribute", $value);
                    $statement->execute();

                    $record = $statement->fetchObject();

                    if ($record) {
                        $this->addError(
                            $attribute, self::RULE_UNIQUE, ['field' => $attribute]
                        );
                    }
                }
            }
        }

        return empty($this->errors);
    }

    /**
     * Ad new error message to specific attribute
     * @param String $attribute
     * @param String $rule
     * @param array $params
     */
    public function addError(String $attribute, String $rule, $params = []) : void {
        $message = $this->errorMessages()[$rule] ?? '';

        foreach ($params as $key => $value) {
            $message = str_replace("{{$key}}", $value, $message);
        }

        $this->errors[$attribute][] = $message;
    }

    /**
     * Get associative array of error messages
     * @return string[]
     */
    public function errorMessages() : array {
        return [
            self::RULE_REQUIRED => 'This field is required'
            , self::RULE_EMAIL => 'This filed must be valid email address'
            , self::RULE_MIN => 'Min length of this field must be {min}'
            , self::RULE_MAX => 'Max length of this field must be {max}'
            , self::RULE_MATCH => 'This field must be the same as {match}'
            , self::RULE_UNIQUE => 'Record with this {field} already exists'
        ];
    }

    /**
     * Evaluate if the attribute of model has any error
     * @param String $attribute
     * @return array
     */
    public function hasError(String $attribute) : array {
        return $this->errors[$attribute] ?? [];
    }

    /**
     * Get the first error message of specific attribute of model
     * @param String $attribute
     * @return String
     */
    public function getFirstError(String $attribute) : String {
        return $this->errors[$attribute][0] ?? '';
    }
}