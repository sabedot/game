jQuery(document).ready(function ($) {
    $('#upload-logo-btn').on('click', function (e) {
        e.preventDefault();

        var mediaUploader = wp.media({
            title: 'Escolher Logo',
            button: { text: 'Selecionar' },
            multiple: false
        });

        mediaUploader.on('select', function () {
            var attachment = mediaUploader.state().get('selection').first().toJSON();

            // Preparar dados para upload
            var formData = new FormData();
            formData.append('action', 'futstream_upload_logo');
            formData.append('security', futstream_upload.nonce);
            formData.append('logo', attachment.url);

            $.ajax({
                url: futstream_upload.ajax_url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.success) {
                        // Atualizar prévia da logo
                        $('#logo-preview').attr('src', response.data.url);
                        $('input[name="futstream_general_options[logo]"]').val(response.data.url);
                        alert('Logo atualizada com sucesso!');
                    }
                }
            });
        });

        mediaUploader.open();
    });
});
