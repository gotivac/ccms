/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function (config) {
    var host = "http://" + window.location.hostname;
    config.filebrowserBrowseUrl = host + '/ccms/kcfinder/browse.php?type=files';
    config.filebrowserImageBrowseUrl = '/ccms/kcfinder/browse.php?type=images';
    config.filebrowserFlashBrowseUrl = host + '/ccms/kcfinder/browse.php?type=flash';
    config.filebrowserUploadUrl = host + '/ccms/kcfinder/upload.php?type=files';
    config.filebrowserImageUploadUrl = host + '/ccms/kcfinder/upload.php?type=images';
    config.filebrowserFlashUploadUrl = host + '/ccms/kcfinder/upload.php?type=flash';
    config.toolbar = [
        {name: 'document', items: ['Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates']},
        {name: 'clipboard', items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo']},
        '/',
        {name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat']},
        {name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock']},
        {name: 'links', items: ['Link', 'Unlink', 'Anchor']},
        '/',
        {name: 'insert', items: ['Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe']},
        {name: 'styles', items: ['Styles', 'Format', 'Font', 'FontSize']},
        {name: 'colors', items: ['TextColor', 'BGColor']},
        {name: 'tools', items: ['Maximize', 'ShowBlocks']}
    ];
    config.height = 500;
    config.allowedContent = true;
};
