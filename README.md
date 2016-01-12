# FormBuilder
Laravel Helper for creating form

##Install

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
