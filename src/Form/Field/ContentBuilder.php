<?php

namespace Encore\Admin\Form\Field;

use Encore\Admin\Form\Field;

class ContentBuilder extends Field
{
    protected $view = 'admin::form.editor';

    protected static $css = [
        '/packages/admin/ContentBuilder/assets/vodafone/content.css',
        '/packages/admin/ContentBuilder/scripts/contentbuilder.css',
        '/styles/framework.min.css',
        '/styles/home.min.css',
    ];

    protected static $js = [
        '/packages/admin/ContentBuilder/scripts/contentbuilder.js',
        '/packages/admin/ContentBuilder/scripts/saveimages.js',
    ];

    public function render()
    {
        $area_id = $this->id . rand(1,100000);
        $this->script = <<<EOT
    
    
     
        $('#$area_id').contentbuilder({
             zoom: 1,
             fileselect: '/manage/files/export',
             toolbar: 'left',
             snippetFile: '/admin/snippets/templates',   
             contenteditable:false,        
        });
        
        $('button[type="submit"]').click(function(){                    
             sHTML = $('#$area_id').data('contentbuilder').html();
            $('#field$area_id').val(sHTML);
        });
    
EOT;
        $this->view = 'admin::form.contentBuilder';

        return parent::render()->with(['area_id'=>$area_id]);
    }
}