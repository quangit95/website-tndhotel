function myCustomInitInstance(inst) {
    inst.on('change', function() {
        $areaInput = $('[name="' + inst.id + '"]');
        $areaInput.val(inst.getContent());
    });
};

tinymce.init({
    mode: 'specific_textareas',
    editor_selector: 'mce-editor',
    convert_urls: false,
    image_dimensions: false,
    relative_urls: false,
    plugins: [
        'textcolor colorpicker',
        'advlist autolink lists link image charmap print preview anchor',
        'searchreplace visualblocks code fullscreen',
        // 'insertdatetime media table contextmenu paste moxiemanager'
        'insertdatetime media table contextmenu paste phpvnn'
    ],
    toolbar: 'insertfile undo redo | styleselect | bold italic | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
    init_instance_callback: 'myCustomInitInstance'
});
