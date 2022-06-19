function delete_table_data(id, url_data, color = '') {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'post',
        url: url_data,
        data: 'id=' + id,
        success: function(data) {

            if (data.success == 'deleted') {
                $('#' + id).remove();
                var html = `<div class="alert alert-` + color + `  alert-dismissible fade show text-capitalize" role="alert">
                <strong>` + data.msg + `<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              </div>`
                $(".msg").html(html)

                setTimeout(function() {
                    $(".msg").html('')
                }, 3000)

            }
        }

    })


}




function delete_table_data_with_method(id, url_data, color = '', method) {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: method,
        url: url_data,
        data: 'id=' + id,
        success: function(data) {

            if (data.message == 'deleted') {
                location.reload();
            }
        }

    })


}



function configure_meeting(div_id, button_id) {

    $("#" + div_id).submit(function(e) {
        e.preventDefault();
        $('#' + button_id).prop('disabled', true);
        $("#" + button_id).text('please wait..');

        var page_load = `<div class="overlay-wrapper">
            <div class="overlay"><i class="fas fa-3x fa-sync-alt fa-spin"></i><div class="text-bold pt-2">please wait...</div></div>
          </div>`
        $('.pageloader').html(page_load)

        var user_form = new FormData($(this)[0])
        $.ajax({
            type: "post",
            Headers: {
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            },
            url: '/assign-meeting-to-users/process',
            data: user_form,
            success: function(data) {
                if (data.success) {

                    toastr.success(data.success)
                    setTimeout(function() {
                        location.reload();
                    }, 2000);

                    $("#" + button_id).text('data saved and send  successfully');

                } else {
                    $('.pageloader').html(' ')
                    $('#' + button_id).prop('disabled', false);
                    $.each(data.errors, function(key, value) {
                        toastr.error(value)
                    })
                    $("#" + button_id).text('retry');

                }

            },

            contentType: false,
            processData: false,
            cache: false,

        });
    })




}



function summerNote(id) {
    $('#' + id).summernote({
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['float', ['floatLeft', 'floatRight', 'floatNone']],
            ['remove', ['removeMedia']],
            ['link', ['linkDialogShow', 'unlink']],
            ['font', ['bold', 'underline', 'clear']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'codeview', 'help']],



        ],


    });

}



function summerNoteTwo(id) {
    $('#' + id).summernote({
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['float', ['floatLeft', 'floatRight', 'floatNone']],
            ['link', ['linkDialogShow', 'unlink']],
            ['font', ['bold', 'underline', 'clear']],
            ['table', ['table']],
            ['view', ['fullscreen', 'codeview', 'help']],



        ],


    });

}


function get_mobile_number() {



    $(function() {
        $('#myModal').modal({
            show: true,
            keyboard: false,
            backdrop: 'static'
        });
    });





    $("#submit_mobile_number").submit(function(e) {
        e.preventDefault();
        var plan_form = new FormData($(this)[0])
        $.ajax({
            type: "post",
            Headers: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            },
            url: '/submit-mobile-number/process',
            data: plan_form,
            success: function(data) {

                if (data.errors) {

                    $.each(data.errors, function(key, value) {
                        toastr.error(value)
                    })
                    $("#mobile_number_err").html(data.errors.mobile_number)

                } else {

                    $("#mobile_number_err").html(' ')
                    toastr.success(data.success)
                    setTimeout(function() {
                        location.reload();

                    }, 2000);


                }

            },
            contentType: false,
            processData: false,
            cache: false,

        });

    })



}




function userChart() {

    $("#chart_box").submit(function(e) {
        e.preventDefault();

        var role_form_data = new FormData($(this)[0])

        $.ajax({
            type: "post",
            Headers: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            },
            url: '/chart/process',
            data: role_form_data,
            success: function(data) {
                $(".user_chart_show_on_page_load").html(' ')

                if (data.errors) {

                    $.each(data.errors, function(key, value) {
                        toastr.error(value)
                    })


                } else {
                    $("#user_chart").html(data.message)
                    $("#chart_box")[0].reset()

                }

            },
            contentType: false,
            processData: false,
            cache: false,

        });





    })


}


function get_chart_data_document_ready() {
    var old_html = "";

    setInterval(function() {


        var receiver_id = $("#receiver_id").val();
        $.ajax({
            type: "get",
            url: '/chart/get-data',
            data: 'receiver_id=' + receiver_id,
            success: function(data) {
                $("#user_chart").html(' ')
                if (data.errors) {
                    $.each(data.errors, function(key, value) {
                        toastr.error(value)
                    })

                } else {




                    if (old_html != data.message) {
                        $('.user_chart_show_on_page_load').scrollTop($('.user_chart_show_on_page_load')[0].scrollHeight);
                    }
                    old_html = data.message;
                    $(".user_chart_show_on_page_load").html(old_html)
                    $("#new_messages").html(data.unread_count)
                    $('#new_messages').prop('title', data.unread_count + ' New Messages');


                }

            },
            contentType: false,
            processData: false,
            cache: false,

        });




    }, 3000);

}

function get_chart() {


    var old_html = '';
    var receiver_id = $("#receiver_id").val();
    $.ajax({
        type: "get",
        url: '/chart/get-data',
        data: 'receiver_id=' + receiver_id,
        success: function(data) {
            $("#user_chart").html(' ')
            if (data.errors) {
                $.each(data.errors, function(key, value) {
                    toastr.error(value)
                })

            } else {

                if (old_html != data.message) {
                    $('.user_chart_show_on_page_load').scrollTop($('.user_chart_show_on_page_load')[0].scrollHeight);
                }
                old_html = data.message;
                $(".user_chart_show_on_page_load").html(old_html)
                $("#new_messages").html(data.unread_count)
                $('#new_messages').prop('title', data.unread_count + ' New Messages');
            }

        },
        contentType: false,
        processData: false,
        cache: false,

    });


}




function purchase_plan_by_zero() {


    $("#buy_course_zero").submit(function(e) {
        e.preventDefault();
        $("#buy_course_zero_button").prop("disabled", true);
        var buy_course = new FormData($(this)[0])
        $.ajax({
            type: "post",
            Headers: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            },
            url: '/buy-course-zero/process',
            data: buy_course,
            success: function(data) {

                if (data.errors) {

                    $.each(data.errors, function(key, value) {
                        toastr.error(value)
                    })

                } else {
                    if (data.success) {
                        toastr.success(data.success)
                        setTimeout(function() {
                            location.reload();

                        }, 2000);




                    }
                }

            },
            contentType: false,
            processData: false,
            cache: false,

        });

    })

}