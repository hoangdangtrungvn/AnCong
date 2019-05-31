$(document).ready(function () {
    var url = $('#data-tables').attr('data-url');
    var table = $('#data-tables').DataTable({
        order: [[0, 'asc']],
    });
})