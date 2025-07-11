jQuery(document).ready(function($) {
    // Botão de upload de logo
    $('#futstream-upload-logo-btn').on('click', function(e) {
        e.preventDefault();

        // Abre o frame de mídia do WordPress
        var mediaUploader = wp.media({
            title: 'Escolher Logo',
            button: {
                text: 'Selecionar Logo'
            },
            multiple: false  // Permite apenas uma imagem
        });

        // Quando uma imagem é selecionada
        mediaUploader.on('select', function() {
            // Pega a imagem selecionada
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            
            // Define a URL da imagem no campo de input
            $('#futstream-logo-url').val(attachment.url);
            
            // Atualiza a prévia da logo
            $('#futstream-logo-preview').html(
                '<img src="' + attachment.url + '" style="max-width: 150px; margin-top: 10px;">'
            );
        });

        // Abre o uploader de mídia
        mediaUploader.open();
    });
});
