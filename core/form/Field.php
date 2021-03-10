<?php
declare(strict_types=1);

namespace app\core\form;

use app\core\Model;

class Field {
    public const TYPE_TEXT = 'text';
    public const TYPE_PASSWORD = 'password';
    public const TYPE_NUMBER = 'number';


    public Model $model;
    public String $attribute;
    public String $type;

    /**
     * Field constructor.
     * @param Model $model
     * @param String $attribute
     */
    public function __construct(Model $model, string $attribute) {
        $this->model = $model;
        $this->attribute = $attribute;
        $this->type = self::TYPE_TEXT;
    }

    public function __toString() {
        return sprintf(
            '<div class="form-group">
                    <label>%s</label>
                    <input type="%s" name="%s" value="%s" class="form-control%s">
                    <div class="invalid-feedback">%s</div>
                </div>'
            , $this->attribute
            , $this->type
            , $this->attribute
            , $this->model->{$this->attribute}
            , $this->model->hasError($this->attribute) ? ' is-invalid' : ''
            , $this->model->getFirstError($this->attribute)
        );
    }

    /**
     * Change the type of field to password and return the instance of Field
     * @return $this
     */
    public function passwordField() : Field {
        $this->type = self::TYPE_PASSWORD;
        return $this;
    }
}