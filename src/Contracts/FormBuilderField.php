<?php
namespace plokko\FormBuilder\Contracts;

interface FormBuilderField
{
    public function __construct(&$form,$name);

    /// Set //
    function label($label);

    /// Render ///
    function renderLabel();
    function render();

    //
    function isGroup();
}