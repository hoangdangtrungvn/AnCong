$(document).ready(function () {
    $("#order").change(function () {
        var value = this.value;
        if (value === 'oldest') {
            location.href = '/coordinators?order=oldest';
        } else {
            location.href = '/coordinators';
        }
    });

    $(".js-doctors-dropdown, .js-dieticians-dropdown").change(function () {
        var doctor_uri = $(this).attr('data-doctor-uri');
        var doctor_id = $(this).val();
        var user_id = $(this).attr('data-user-id');
        $('.js-user-id-input').val(user_id);
        $('.js-doctor-id-input').val(doctor_id);
        $('.js-doctor-uri-input').val(doctor_uri);
        $('.js-coordinator-modal').modal('show');
    });

    $('.js-status-true').click(function () {
        if ($(this).hasClass('text-success')) {
            if ($('.js-status-false').hasClass('text-danger')) {
                location.href = '/coordinators?status=false';
            } else {
                location.href = '/coordinators';
            }
        } else {
            location.href = '/coordinators?status=true';
        }
    });

    $('.js-status-false').click(function () {
        if ($(this).hasClass('text-danger')) {
            if ($('.js-status-true').hasClass('text-success')) {
                location.href = '/coordinators?status=true';
            } else {
                location.href = '/coordinators';
            }
        } else {
            location.href = '/coordinators?status=false';
        }
    });

    if (!$('.js-status-true').hasClass('text-success') && !$('.js-status-false').hasClass('text-danger')) {
        $('.js-status-true').addClass('text-success');
        $('.js-status-false').addClass('text-danger');
    }
})