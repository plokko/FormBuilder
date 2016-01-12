# FormBuilder
Laravel Helper for creating form

##Installation

1. Require with composer
    composer require plokko/formbuilder

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
//.....


```
##Use

First create a new instance of **FormBuilder** with *make* command and assign it to a variable
```php
<?php
$fb=FormBuilder::make();
```

You can then add fields accessing the object as parameter
```php
$fb->field_name1;
```
or as an array
```php
$fb['field_name2[]'];
```

You can specify the field type or other parameters accessing the field as a method
```php
$fb->text_field1->text();
$fb['text-field2']->text();
$fb->text_required->text()->required();
$fb->date_field->date();
$fb->select_field->select();
```

You can then render the form withì
```html
{{$fb->openForm()}}<!--Open form-->

    <!--you can add custom html code here-->

    
    {!! $fb !!}<!--Render the form fields-->
    
    <button type=submit>Submit</button>
    
{{$fb->closeForm()}}<!--Close form-->
```


