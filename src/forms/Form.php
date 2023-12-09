<?php

namespace inserveofgod\forms;

use inserveofgod\models\Model;

/**
 * class Form
 * 
 * @package inserveofgod\forms
 */
class Form {
    /**
     * Creates a form by action and method
     * 
     * @param string action
     * @param string method
     * @return Form
     */
    public static function begin(string $action, string $method):Form {
        echo sprintf("<form action='%s' method='%s'>", $action, $method);

        return new Form();
    }

    /**
     * Closes the created form
     * 
     * @return void
     */
    public static function end():void {
        echo "</form>";
    }

    /**
     * Creates form field by entity model and its attribute
     * 
     * @param Model model
     * @param array attributes
     * @return string
     */
    public static function field(Model $model, array $attributes):string {
        $name = $attributes['name'];
        $value = $model->{$name} ?? '';

        return sprintf("
            <div class='mb-3'>
                <label for='%s' class='form-label'>%s</label>
                <input type='%s' class='form-control %s' id='%s' name='%s' placeholder='%s' %s>
                <p class='invalid-feedback'>
                    %s
                </p>
            </div>
        ",

            $name,
            $attributes['label'],
            $attributes['type'],
            $model->hasError($name) ? 'is-invalid' : '',
            $name,
            $name,
            $attributes['placeholder'],
            ($value) ? "value=$value" : '',
            $model->getFirstError($name),
        );
    }
}
