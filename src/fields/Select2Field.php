<?php
namespace plokko\FormBuilder\fields;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;

class Select2Field extends SelectField
{
    static
        $init=false;
    protected
        $select2Options=[];

    private static function init()
    {
        // Push code to "scripts" section //
        View::startSection('scripts');
        ?><link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2-rc.1/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2-rc.1/js/select2.min.js"></script>
        <script>/**Selec2Field init**/
        $(document).ready(function(){
            $('select.plokko_select2field').each(function(){
                var e=$(this);
                var opt=e.data('options');

                if(opt.ajax){

                    if(opt.ajax.data && !$.isFunction(opt.ajax.data))
                    {
                        opt.ajax.data=(function(dt){
                            return function(params){
                                params.page = params.page || 1;
                                var e={};
                                $.each(dt,function(k,v){
                                    e[k]=(v=='term'||v=='page')?params[v]||null:v;
                                });
                                return e;
                            };
                        })(opt.ajax.data);
                    }


                    opt.ajax.processResults=function (data, params)
                    {
                        params.page = params.page || 1;
                        if($.isArray(data)){
                            //Simple data array//
                            var items=[];
                            $.each(data,function(k,v){
                                if(typeof v == "string")
                                    items.push({id:v,text:v});
                                else{//object
                                    var e={id: (v.id||v[Object.keys(v)[0]])};//v.id,or first field value
                                    e.text=
                                        v.text||(v[Object.keys(v)[1]]||e.id);//v.text, second field value or id
                                    items.push(e);
                                }
                            });
                            return {results:items};

                        }else{
                            if(data.items){
                                // Select2 formatted array //
                                /*{
                                    items: [{id:string,text:string},...]
                                    total_count: int // Total number of elements
                                }*/
                                var dt={results: data.items};
                                if(data.total_count){
                                    dt.pagination={more:(params.page * 30) < data.total_count};
                                }

                                return dt;
                            }
                        }
                    };
                }

                e.select2(opt);
            });
        });
        </script><?
        View::appendSection();
    }

    /**
     * @param array $opt
     * @return $this
     */
    function select2Options(array $opt)
    {
        $this->select2Options=$opt;
        return $this;
    }

    /**
     * Load a
     * @param string $url data source url, should return a JSON array,
     * @param array $opt Array of options:
     *      cache - bool
     *      dataType - string - default:'json'
     *      delay - int - default:250
     *      data - array - tells how to parse the query parameters (term for searched term,page for page) default:['search'=>'term','page'=>'page']
     *
     * @return Select2Field $this
     */
    function ajax($url,array $opt=[])
    {
        $opt['url']=$url;

        // Merge with default values //
        $opt=array_merge([
            'cache'=>true,
            'dataType'=>'json',
            'delay'=>250,
            'data'=>['search'=>'term','page'=>'page'],
        ],$opt);

        $this->select2Options['ajax']=($opt);
        return $this;
    }

    function render()
    {
        self::init();
        $this->addClass('plokko_select2field');
        //attach select2 options as data
        $this->option('data-options',json_encode($this->select2Options));
        return parent::render();
    }
}