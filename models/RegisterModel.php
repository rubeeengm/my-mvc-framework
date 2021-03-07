<?php
declare(strict_types=1);

namespace app\models;

use app\core\Model;

class RegisterModel extends Model {
    public String $firstName;
    public String $lastName;
    public String $email;
    public String $password;
    public String $confirmPassword;

    public function register() {
        echo "Creating new User";
    }
}