<?php
namespace plokko\FormBuilder\Contracts;

interface FormBuilderField
{
    public function __construct(&$form,$name);

    function getLabel();
    function label();

    function setLabel($label);


    function isGroup();
}