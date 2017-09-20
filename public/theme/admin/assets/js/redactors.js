
$(function()
{
    $('#content').redactor({
        focus: true,
        imageUpload: 'uploadImage',
        plugins: ['video','inlinestyle','source','alignment','table','fullscreen','fontsize','fontcolor'],

    });
});