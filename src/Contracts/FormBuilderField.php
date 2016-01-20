<?php
namespace plokko\FormBuilder\Contracts;

interface FormBuilderField
{
    public function __construct(&$form,$name);

    function label($label);
    function renderLabel();

    function isGroup();
}