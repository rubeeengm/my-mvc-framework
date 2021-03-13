<?php
declare(strict_types=1);

namespace app\models;

use app\core\DatabaseModel;

class UserModel extends DatabaseModel {
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 2;

    public string $firstName = '';
    public string $lastName = '';
    public string $email = '';
    public int $status = self::STATUS_INACTIVE;
    public string $password = '';
    public string $confirmPassword = '';

    public function tableName(): string {
        return 'USERS';
    }

    /**
     * Persist information
     * @return bool
     */
    public function save() : bool {
        $this->status = self::STATUS_INACTIVE;

        $this->password = password_hash(
            $this->password, PASSWORD_DEFAULT
        );

        return parent::save();
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

    public function attributes(): array {
        return ['firstName', 'lastName', 'email', 'password', 'status'];
    }
}