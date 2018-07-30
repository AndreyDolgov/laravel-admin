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
    
    
     
         $('#$area_id').attr('contenteditable',true);
        
         var cb_nd_config={h1:{class:'heading heading--1',selector:'.heading.heading--1'},
                h2:{class:'heading heading--2',selector:'.heading.heading--2'},
                h3:{class:'heading heading--3',selector:'.heading.heading--3'},
                ul:{class:'list',selector:'.list'},
                li:{class:'list__item',selector:'.list__item'},
                a:{class:'link',selector:'.link'}
            };
         $('#$area_id').on('input focus paste copy cut delete blur keyup',function(){
                for(element in cb_nd_config){
                    var i=0;
                    $(this).find(element).not('.visually-hidden ,'+cb_nd_config[element].selector).each(function(e,b){
                        $(this).addClass(cb_nd_config[element].class);
                        i++
                    });
                }
            })
     
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
