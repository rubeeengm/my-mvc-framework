<?php
declare(strict_types=1);

namespace app\models;

use app\core\Model;

class RegisterModel extends Model {
    public String $firstName = '';
    public String $lastName = '';
    public String $email = '';
    public String $password = '';
    public String $confirmPassword = '';

    public function register() {
        echo "Creating new User";
    }

    public function rules(): array {
        return [
            'firstName' => [self::RULE_REQUIRED]
            , 'lastName' => [self::RULE_REQUIRED]
            , 'email' => [
                self::RULE_REQUIRED
                , self::RULE_EMAIL
            ]
            , 'password' => [
                self::RULE_REQUIRED
                , [
                    self::RULE_MIN
                    , 'min' => 8
                ]
                , [
                    self::RULE_MAX
                    , 'max' => 24
                ]
            ]
            , 'confirmPassword' => [
                self::RULE_REQUIRED
                , [
                    self::RULE_MATCH
                    , 'match' => 'password'
                ]
            ]
        ];
    }
}