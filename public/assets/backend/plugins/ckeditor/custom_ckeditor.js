$(function () {
    $('.ckeditor-control').each(function () {
        CKEDITOR.instances[this];
        CKEDITOR.replace(this, {
            uiColor: '#0e1726',
            height: 150,
            extraPlugins: 'colorbutton,colordialog',
            removeButtons: 'PasteFromWord',
            mathJaxLib: 'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.4/MathJax.js?config=TeX-AMS_HTML',
            filebrowserUploadMethod: 'form',
            filebrowserUploadUrl: "",
            filebrowserImageUploadUrl: "",
            colorButton_foreStyle: {
                element: 'font',
                attributes: {'color': '#009688'}
            },
            removeButtons: 'Save,NewPage,ExportPdf,Preview,Print,Copy,PasteFromWord,Find,Replace,Scayt,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Strike,RemoveFormat,NumberedList,BulletedList,Outdent,Indent,Blockquote,CreateDiv,BidiLtr,BidiRtl,Language,Anchor,Image,Table,HorizontalRule,Smiley,SpecialChar,PageBreak,Iframe,TextColor,BGColor,ShowBlocks,About,Templates',
            toolbarGroups: [
                {name: 'basicstyles', groups: ['basicstyles', 'cleanup']},
                {name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi', 'paragraph']},
                {name: 'clipboard', groups: ['clipboard', 'undo']},
                {name: 'styles', groups: ['styles']},
                {name: 'links', groups: ['links']},
                {name: 'document', groups: ['mode', 'document', 'doctools']},
                {name: 'editing', groups: ['find', 'selection', 'spellchecker', 'editing']},
                {name: 'forms', groups: ['forms']},
                {name: 'insert', groups: ['insert']},
                {name: 'colors', groups: ['colors']},
                {name: 'tools', groups: ['tools']},
                {name: 'others', groups: ['others']},
                {name: 'about', groups: ['about']}
            ]
        });
        if (CKEDITOR.env.ie && CKEDITOR.env.version == 8) {
            toastr.error("Please note that this plugin is not compatible with Internet Explorer 8.")
        }
    });
});