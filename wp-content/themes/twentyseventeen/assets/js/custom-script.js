$(document).ready(function () {
    $('.validateText').on('keyup change keydown keypress', function (event) {
        $(this).val($(this).val().replace(/[^a-zA-Z0-9 ()-äÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙ#*/-_.,?¡¿<>$%"]/gi, ''));
    });
    $('.validateNit').on('keyup change keydown keypress', function (event) {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
});
