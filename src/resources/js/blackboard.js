$(function () {
    CodeMirror.fromTextArea(document.getElementById('settings-additionalJs'), {
        indentUnit: 4,
        styleActiveLine: true,
        lineNumbers: true,
        lineWrapping: true,
        theme: 'blackboard'
    });
});