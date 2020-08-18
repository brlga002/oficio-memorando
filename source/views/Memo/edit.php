<?php $v->layout("dash::_theme"); ?>
<?= $cardDocumento ?>

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800"><?= $titulo ?></h1>
<p class="mb-4"><?= $subTitulo ?></p>

<form class="user" action="<?= url("documento/{$action}"); ?>" method="post">
    <div class="form-group row">
        <div class="col-sm-6 mb-4 mb-sm-0">
            <label for="assuntoDoc">Numero documento (Automatico, é dado um numero quando assinado)</label>
            <input type="text" class="form-control" name="numeroDoc" placeholder="numeroDoc" value="<?= $documento->numeroDoc ?>">
        </div>
        <div class="col-sm-3 mb-3 mb-sm-0">
            <label for="assuntoDoc">Ano (não editavel)</label>
            <input type="text" class="form-control" name="anoDoc" placeholder="Ano" value="<?= $documento->anoDoc ?>">
        </div>
        <div class="col-sm-3 mb-3 mb-sm-0">
            <label for="id_tipomemo">Tipo Doc</label>
            <select class="form-control" name="id_tipoDoc" required>
                <option></option>
                <?php foreach ($documento->tiposDoc() as $tipo): ?>
                    <option value="<?= $tipo->id; ?>" <?= ($tipo->id === $documento->id_tipoDoc) ? "selected" : "" ?>>
                        <?= $tipo->nomeTipoDoc; ?>
                    </option>
                <?php endforeach ?>
            </select>
        </div>
        <div class="col-sm-2">
            <label for="dataDoc">Data Doc</label>
            <input type="date" class="form-control" name="dataDoc" value="<?= ($documento->dataDoc !== NULL) ? $documento->dataDoc : date("Y-m-d") ?>">
        </div>
        <div class="col-sm-10 mb-10 mb-sm-0">
            <label for="assuntoDoc">Assunto</label>
            <input type="text" class="form-control" name="assuntoDoc" placeholder="Assunto" value="<?= $documento->assuntoDoc ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="destinatarioDoc">Destinatario</label>
        <textarea  class="form-control" name="destinatarioDoc" placeholder="Destinatário" rows="3"><?= $documento->destinatarioDoc ?></textarea>
    </div>
    <div class="form-group">
        <label for="conteudoDoc">Conteúdo</label>
        <textarea  class="form-control" name="conteudoDoc" id="editor1" placeholder="Conteúdo" rows="12"><?= $documento->conteudoDoc ?></textarea>
    </div>




    <button type="submit" class="btn btn-primary btn-user btn-block">
        Salvar
    </button>
    <hr>
</form>
<?php $v->start("modal"); ?>
    <!-- Modal Delete -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Deseja deletar?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Selecione "Deletar" abaixo se caso queira deletar o memo: <p><strong id="nomeDoc"></strong></p>.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-danger" id="urlDeletarDoc" href="#">Deletar <i class="fas fa-trash"></i></a>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Delete -->
<?php $v->end(); ?>

<?php $v->start("js"); ?>
    <!-- JS Delete -->
    <script>
        $(function () {
            $("body").on("click", "[data-memo]", function (e) {
                e.preventDefault();
                var data = $(this).data();
                var urlDeletarDoc = $("#urlDeletarDoc");
                var nomeDoc = $("#nomeDoc");
                urlDeletarDoc.attr("href",data["url"]);
                nomeDoc.html(data["memo"]);
                $("#deleteModal").modal()
            });
        });
    </script>
    <!-- JS Delete -->

    <script src="https://cdn.ckeditor.com/4.8.0/full-all/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( 'editor1', {
            // Define the toolbar: http://docs.ckeditor.com/ckeditor4/docs/#!/guide/dev_toolbar
            // The full preset from CDN which we used as a base provides more features than we need.
            // Also by default it comes with a 3-line toolbar. Here we put all buttons in a single row.
            toolbar: [
                { name: 'document', items: [ 'Print','Source'] },
                { name: 'clipboard', items: [ 'Undo', 'Redo'] },
                { name: 'styles', items: [ 'Format', 'Font', 'FontSize' ] },
                { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat', 'CopyFormatting' ] },
                { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
                { name: 'align', items: [ 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock' ] },
                { name: 'links', items: [ 'Link', 'Unlink' ] },
                { name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote' ] },
                { name: 'insert', items: [ 'Table' ] },
                { name: 'tools', items: [ 'Maximize' ] },
                { name: 'editing', items: [ 'Scayt' ] }
            ],

            // Since we define all configuration options here, let's instruct CKEditor to not load config.js which it does by default.
            // One HTTP request less will result in a faster startup time.
            // For more information check http://docs.ckeditor.com/ckeditor4/docs/#!/api/CKEDITOR.config-cfg-customConfig
            customConfig: '',

            // Sometimes applications that convert HTML to PDF prefer setting image width through attributes instead of CSS styles.
            // For more information check:
            //  - About Advanced Content Filter: http://docs.ckeditor.com/ckeditor4/docs/#!/guide/dev_advanced_content_filter
            //  - About Disallowed Content: http://docs.ckeditor.com/ckeditor4/docs/#!/guide/dev_disallowed_content
            //  - About Allowed Content: http://docs.ckeditor.com/ckeditor4/docs/#!/guide/dev_allowed_content_rules
            disallowedContent: 'img{width,height,float}',
            extraAllowedContent: 'img[width,height,align]',

            // Enabling extra plugins, available in the full-all preset: http://ckeditor.com/presets-all
            extraPlugins: 'tableresize,uploadimage,uploadfile',

            /*********************** File management support ***********************/
            // In order to turn on support for file uploads, CKEditor has to be configured to use some server side
            // solution with file upload/management capabilities, like for example CKFinder.
            // For more information see http://docs.ckeditor.com/ckeditor4/docs/#!/guide/dev_ckfinder_integration

            // Uncomment and correct these lines after you setup your local CKFinder instance.
            // filebrowserBrowseUrl: 'http://example.com/ckfinder/ckfinder.html',
            // filebrowserUploadUrl: 'http://example.com/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
            /*********************** File management support ***********************/

            // Make the editing area bigger than default. 800
            height: 350,

            // An array of stylesheets to style the WYSIWYG area.
            // Note: it is recommended to keep your own styles in a separate file in order to make future updates painless.
            contentsCss: [ 'https://cdn.ckeditor.com/4.8.0/full-all/contents.css', 'mystyles.css' ],

            // This is optional, but will let us define multiple different styles for multiple editors using the same CSS file.
            bodyClass: 'document-editor',

            // Reduce the list of block elements listed in the Format dropdown to the most commonly used.
            format_tags: 'p;h1;h2;h3;pre',

            // Simplify the Image and Link dialog windows. The "Advanced" tab is not needed in most cases.
            removeDialogTabs: 'image:advanced;link:advanced',

            // Define the list of styles which should be available in the Styles dropdown list.
            // If the "class" attribute is used to style an element, make sure to define the style for the class in "mystyles.css"
            // (and on your website so that it rendered in the same way).
            // Note: by default CKEditor looks for styles.js file. Defining stylesSet inline (as below) stops CKEditor from loading
            // that file, which means one HTTP request less (and a faster startup).
            // For more information see http://docs.ckeditor.com/ckeditor4/docs/#!/guide/dev_styles
            stylesSet: [
                /* Inline Styles */
                { name: 'Marker', element: 'span', attributes: { 'class': 'marker' } },
                { name: 'Cited Work', element: 'cite' },
                { name: 'Inline Quotation', element: 'q' },

                /* Object Styles */
                {
                    name: 'Special Container',
                    element: 'div',
                    styles: {
                        padding: '5px 10px',
                        background: '#eee',
                        border: '1px solid #ccc'
                    }
                },
                {
                    name: 'Compact table',
                    element: 'table',
                    attributes: {
                        cellpadding: '5',
                        cellspacing: '0',
                        border: '1',
                        bordercolor: '#ccc'
                    },
                    styles: {
                        'border-collapse': 'collapse'
                    }
                },
                { name: 'Borderless Table', element: 'table', styles: { 'border-style': 'hidden', 'background-color': '#E6E6FA' } },
                { name: 'Square Bulleted List', element: 'ul', styles: { 'list-style-type': 'square' } }
            ],
            removePlugins: 'scayt,wsc',
            disableNativeSpellChecker: false
        } );
    </script>
<?php $v->end() ?>