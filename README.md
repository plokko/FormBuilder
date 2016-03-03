# FormBuilder
Laravel Helper module for creating forms and input fields
Version 0.2 Beta
## Changelog

* 0.2 beta - Rewritten from scratch, not compatible with previus versions

##Installation

1. Require with composer
```shell
composer require plokko/formbuilder
```
2. Add the provider and facades in the app config file
/config/app.php

```php
'providers' => [
    //...
    //FormBuilder//
    plokko\FormBuilder\FormBuilderProvider::class,
    //...
]
//...
'aliases' => [
    //...
    //FormBuilder//
    'FormBuilder'=> plokko\FormBuilder\Facades\FormBuilder::class,
    //...
]
//...
```

##Use

* create the **FormBuilder** instance
First create a new instance of **FormBuilder** in your view with the *make* command and assign it to a variable
```php
<?php
$fb=FormBuilder::make(['route'=>route('my.destination.route')]);
```
The *make* function accepts the same parameters as **laravelcollective/html** [**Form::open**](https://laravelcollective.com/docs/5.2/html#opening-a-form)

* declaring the fields
You can then add fields using the requested field type as method name and field name as value
```php
$fb->text('text_field'); //Input field (type=text)
$fb->email('email_field);//Email input field (type=email)
$fb->textarea('message');//Textarea_
```

* Accessing the fields

To set the options to the field you can access the field when declared
```php
$fb->text('field_required')->required()->addClass('required_field');
```

or you can retrieve it later by accessing it by name as a parameter or array
```php
$fb->field_required->value('My value');
$fb['field_required']->addClass('my-other-class');
```

If you try to access and undeclared field the field will be automatically declared as a text field
```php
$fb->undeclared_field->value(1);
// Equals to: //
$fb->text('undeclared_field')->value(1);
```

* Render the form

To render the form you should first open and close the form using the *openForm()* and *closeForm()* functions, rendering the fields with the *render()* function between them.

```php
{!! $fb->openForm() !!}
    <!--render the fields/-->
    {!! $fb->render() !!}
    
    <!--Add some basic submit buttons-->
    <button type=submit>Submit</button>
    <button type=reset>Reset</button>
    
{!! $fb->closeForm() !!}
```

## Customization

### Form view

You can specify how the form will be rendered by applying a view to the **FormBuilder** class
```php
<?php
$fb=FormBuilder::make(['route'=>route('my.destination.route')])
        ->view('my.custom.view');
```

You can specify the view like following where *$fields* is an array containing all the defined fields
```php
<?php
/**@var array $fields**/
?>
@foreach($fields AS $field)
    <?/**@var \plokko\FormBuilder\FormField $field**/?>
    <div class="form-group">
        {!! $field->label->render()!!}
        @if($field->type!='checkbox'&&$field->type!='radio')
            <?$field->addClass('form-control');/*Add class except for radio or checkbox fields*/?>
        @endif
        {!! $field->render() !!}
    </div>

@endforeach
```
The view will be called with the **render** function.

### Expanding functionalities

You can easly add or replace field types by changing the config file;
to do so first publish the config
```shell
php artisan vendor:publish
```

Then edit the */config/app.php* file

```php
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

        'textarea'  => plokko\FormBuilder\fields\InputField::class,
        'select2'    => plokko\FormBuilder\fields\Select2Field::class,

    ],
];
```

You can create a new field type by expanding the **plokko\FormBuilder\fields\FormField** class like so:
```php
<?php
namespace mynamespace;

use plokko\FormBuilder\fields\FormField;

class MyCustomField extends FormField
{
    //...
    function myFunction()
    {
        //...
        return $this;
    }
    //...
}
```

and then adding it in the config file like so
```php
<?php
return [
    /** Default view for FormBuilder **/
    'view'=>'my.default.form.view',
    /** Registered FormField providers as type=>classname **/
    'fieldProviders'=>[
        //...
        'myfield'=>mynamespace/MyCustomField::class,
        'myfield2'=>mynamespace/MyCustomField::class,
        //...
    ],
];
```

You can then add the field using the declared name:
```php
//...
$fb->myfield('field1')->myFunction();
$fb->myfield2('field2')->myFunction()->required()->value(2);
```
