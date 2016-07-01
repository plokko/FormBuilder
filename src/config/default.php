<?php
return [
    /** Default view for FormBuilder **/
    'view'=>'formbuilder::bootstrap.form.base',
    /** Registered FormField providers as type=>classname **/
    'fieldProviders'=>[

        'text'      => plokko\FormBuilder\fields\InputField::class,
        'hidden'    => plokko\FormBuilder\fields\InputField::class,
        'password'  => plokko\FormBuilder\fields\InputField::class,
        'textarea'  => plokko\FormBuilder\fields\InputField::class,

        //HTML5 input types//
        'date'=> plokko\FormBuilder\fields\InputField::class,
        'datetime'=> plokko\FormBuilder\fields\InputField::class,
        'datetime-local'=> plokko\FormBuilder\fields\InputField::class,
        'email'=> plokko\FormBuilder\fields\InputField::class,
        'month'=> plokko\FormBuilder\fields\InputField::class,
        'number'=> plokko\FormBuilder\fields\InputField::class,
        'range'=> plokko\FormBuilder\fields\InputField::class,
        'search'=> plokko\FormBuilder\fields\InputField::class,
        'tel'=> plokko\FormBuilder\fields\InputField::class,
        'time'=> plokko\FormBuilder\fields\InputField::class,
        'url'=> plokko\FormBuilder\fields\InputField::class,
        'week'=> plokko\FormBuilder\fields\InputField::class,
        /////

        'file'      => plokko\FormBuilder\fields\FileField::class,

        'select'    => plokko\FormBuilder\fields\SelectField::class,
        'select2'    => plokko\FormBuilder\fields\Select2Field::class,

        'radio'     => plokko\FormBuilder\fields\CheckboxField::class,
        'checkbox'  => plokko\FormBuilder\fields\CheckboxField::class,

        'group'    => plokko\FormBuilder\fields\FieldGroup::class,

        'radios'    => plokko\FormBuilder\fields\RadioGroup::class,
        'radiogroup'    => plokko\FormBuilder\fields\RadioGroup::class,

    ],
];