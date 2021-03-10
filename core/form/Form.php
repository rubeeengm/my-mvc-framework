<?php
declare(strict_types=1);

namespace app\core\form;

use app\core\Model;

class Form {

    /**
     * Create a begin of form tag html
     * @param String $action
     * @param String $method
     * @return Form
     */
    public static function begin(String $action, String $method) : Form {
        echo sprintf(
            '<form action="%s" method="%s">'
            , $action, $method
        );

        return new Form();
    }

    /**
     * Create the end of form tag html
     */
    public static function end() : void {
        echo '</form>';
    }

    /**
     * Create a new instance of Field class
     * @param Model $model
     * @param String $attribute
     * @return Field
     */
    public function field(Model $model, String $attribute) : Field {
        return new Field($model, $attribute);
    }
}