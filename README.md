# FormBuilder
Laravel Helper module for creating forms and input fields

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

##Customization