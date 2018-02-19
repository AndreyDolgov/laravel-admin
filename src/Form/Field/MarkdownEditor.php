<?php

namespace Encore\Admin\Form\Field;

use Encore\Admin\Form\Field;

class MarkdownEditor extends Field
{
    protected $view = 'admin::form.editor';

    protected static $css = [
        '/packages/admin/bootstrap-markdown-editor/dist/css/bootstrap-markdown-editor.css',
    ];

    protected static $js = [
        '//cdnjs.cloudflare.com/ajax/libs/ace/1.1.3/ace.js',
        '//cdnjs.cloudflare.com/ajax/libs/marked/0.3.2/marked.min.js',
        '/packages/admin/bootstrap-markdown-editor/dist/js/bootstrap-markdown-editor.js',
    ];

    public function render()
    {

        $_name = ($this->elementName)?$this->elementName:$this->column;

        $this->script = <<<EOT

$('textarea[name="$_name"]').markdownEditor({
    preview: true,
    onPreview: function (content, callback) {
        callback( marked(content) );
    }
});

EOT;

        return parent::render();
    }
}