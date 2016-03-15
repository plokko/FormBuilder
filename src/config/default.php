<?php
return [
    /** Default view for FormBuilder **/
    'view'=>'formbuilder::bootstrap.form.base',
    /** Registered FormField providers as type=>classname **/
    'fieldProviders'=>[
        'select'    => plokko\FormBuilder\fields\SelectField::class,

        'text'      => plokko\FormBuilder\fields\InputField::class,
        'email'     => plokko\FormBuilder\fields\InputField::class,
        'hidden'    => plokko\FormBuilder\fields\InputField::class,
        'number'    => plokko\FormBuilder\fields\InputField::class,
        'password'  => plokko\FormBuilder\fields\InputField::class,

        'file'      => plokko\FormBuilder\fields\FileField::class,

        'radio'     => plokko\FormBuilder\fields\CheckboxField::class,
        'checkbox'  => plokko\FormBuilder\fields\CheckboxField::class,

        'group'    => plokko\FormBuilder\fields\FieldGroup::class,

        'radios'    => plokko\FormBuilder\fields\RadioGroup::class,
        'radiogroup'    => plokko\FormBuilder\fields\RadioGroup::class,


        'textarea'  => plokko\FormBuilder\fields\InputField::class,
        'select2'    => plokko\FormBuilder\fields\Select2Field::class,


    ],
];