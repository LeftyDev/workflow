function viewDocModal() {
    $('#modal').fadeToggle(300);
    $('#modal-box').css('min-height', 0).slideToggle(300, function () {
        $(this).css('min-height', 520)
    });
}

$(document).ready(function () {
});