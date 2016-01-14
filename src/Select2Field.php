<?php
namespace plokko\FormBuilder;

use PAGE;

class Select2Field extends SelectField
{
    protected
        $select2Options=[];

    function __construct(&$form, $name)
    {
        //ADD JS/CSS requirements//
        PAGE::addScript('//cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/js/select2.min.js');
        PAGE::addStyle('//cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/css/select2.min.css');
        ///
        parent::__construct($form, $name);
    }


    function options($opt)
    {
        $select2Options=$opt;
        return $this;
    }

    /*
     * ajax: {
    url: "https://api.github.com/search/repositories",
    dataType: 'json',
    delay: 250,
    data: function (params) {
      return {
        q: params.term, // search term
        page: params.page
      };
    },
    processResults: function (data, params) {
      // parse the results into the format expected by Select2
      // since we are using custom formatting functions we do not need to
      // alter the remote JSON data, except to indicate that infinite
      // scrolling can be used
      params.page = params.page || 1;

      return {
        results: data.items,
        pagination: {
          more: (params.page * 30) < data.total_count
        }
      };
    },
    cache: true
  },l
     *
     * function ajax($url,$k,$v){}
    */
    /**
     * @return string
     */
    function toString(){
        if(!isset($this->opt['id']))
            $this->opt['id']=uniqid('select2field_');
        $id=$this->opt['id'];
        return parent::toString().'<script>$("#'.htmlspecialchars($id).'").select2('.htmlspecialchars(json_encode($this->select2Options)).');</script>';
    }
}