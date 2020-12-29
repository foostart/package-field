<?php namespace Foostart\Field\Validators;

use Foostart\Category\Library\Validators\FooValidator;
use Event;
use \LaravelAcl\Library\Validators\AbstractValidator;
use Foostart\Field\Models\Field;

use Illuminate\Support\MessageBag as MessageBag;

class FieldValidator extends FooValidator
{

    protected $obj_field;

    public function __construct()
    {
        // add rules
        self::$rules = [
            'field_name' => ["required"],
            'field_overview' => ["required"],
            'field_description' => ["required"],
        ];

        // set configs
        self::$configs = $this->loadConfigs();

        // model
        $this->obj_field = new Field();

        // language
        $this->lang_front = 'field-front';
        $this->lang_admin = 'field-admin';

        // event listening
        Event::listen('validating', function($input)
        {
            self::$messages = [
                'field_name.required'          => trans($this->lang_admin.'.errors.required', ['attribute' => trans($this->lang_admin.'.fields.name')]),
                'field_overview.required'      => trans($this->lang_admin.'.errors.required', ['attribute' => trans($this->lang_admin.'.fields.overview')]),
                'field_description.required'   => trans($this->lang_admin.'.errors.required', ['attribute' => trans($this->lang_admin.'.fields.description')]),
            ];
        });


    }

    /**
     *
     * @param ARRAY $input is form data
     * @return type
     */
    public function validate($input) {

        $flag = parent::validate($input);
        $this->errors = $this->errors ? $this->errors : new MessageBag();

        //Check length
        $_ln = self::$configs['length'];

        $params = [
            'name' => [
                'key' => 'field_name',
                'label' => trans($this->lang_admin.'.fields.name'),
                'min' => $_ln['field_name']['min'],
                'max' => $_ln['field_name']['max'],
            ],
            'overview' => [
                'key' => 'field_overview',
                'label' => trans($this->lang_admin.'.fields.overview'),
                'min' => $_ln['field_overview']['min'],
                'max' => $_ln['field_overview']['max'],
            ],
            'description' => [
                'key' => 'field_description',
                'label' => trans($this->lang_admin.'.fields.description'),
                'min' => $_ln['field_description']['min'],
                'max' => $_ln['field_description']['max'],
            ],
        ];

        $flag = $this->isValidLength($input['field_name'], $params['name']) ? $flag : FALSE;
        $flag = $this->isValidLength($input['field_overview'], $params['overview']) ? $flag : FALSE;
        $flag = $this->isValidLength($input['field_description'], $params['description']) ? $flag : FALSE;

        return $flag;
    }


    /**
     * Load configuration
     * @return ARRAY $configs list of configurations
     */
    public function loadConfigs(){

        $configs = config('package-field');
        return $configs;
    }

}