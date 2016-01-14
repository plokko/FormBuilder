#FormBuilder

##Creating the form

###Accessing formbuilder

    $fb=FormBuilder(['route'=>'test.create']);
    $fb->setView('my.custom.blade.view');
    
    
###Adding a field

    $fb->text('field_name','value')->title('My field');
    $fb->field_name->text('value')->title('My field,width attribute access');
    $fb->checkbox('fieldname2')->title('My checkbox');
    
Setting the field label with title attribute

###adding a group field (radio,etc.)
    
    $grp=$fb->group('name','default-val')->title('My radio options');
    $grp->radio('1')->title('value1 label');
    $grp->radio('2')->title('value2 label');
    
##Blade

###Use in blade

    <?php
        
        $fb=\FormBuilder::get(['url'=>'users','class'=>'form-horizontal']);
        //declare formbuilder
        $fb['name']->text()->value('aaa')->title('User name');
        $fb->active->checkbox(1)->value(0);
        //etc...
    
    ?>
    <!--Render the form-->
    {!!$fb!!}
    
    
###Customize blade template

    @foreach($fields AS $field)
        @if(!$field->isGroup())
        
            {!!$field->label()!!}
            {!!$field!!}
            
        @else
        
            {!!$field->label()!!}
       
            @foreach($field AS $f)
                {!!$f->label()!!}
                {!!$f!!}
            @endforeach
            
        @endif
    @endforeach
    
    
    