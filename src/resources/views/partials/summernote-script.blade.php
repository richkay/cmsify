<script type="text/javascript">
    function initSummernote() {
        return $('.Summernote').summernote({
            height: 400,
            callbacks: {
                onImageUpload: function (files) {
                    sendFile(files[0], $(this), $(this)[0].name);
                }
            }
        });
    }

    function sendFile(file, editor, context) {
        var formData = new FormData();
        formData.append("file", file);
        formData.append("context", context); // posts, etc...
        formData.append("_token", $('#token').attr('value'));

        $.ajax({
            type: 'POST',
            url: '/cmsify/api/images', // api/v1/cms/images/upload
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (url) {
                editor.summernote('insertImage', url);
            },
            error: function (response) {

            }
        });
    }

</script>