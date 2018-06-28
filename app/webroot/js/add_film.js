$(document).ready(function() {
    //for adding film
    $(".upload-btn-wrapper > input[type='file']").change(function() {
        $(".error-file-msg").text('');
        var extension = $("input[type='file']").val().split('.').pop().toLowerCase();
        if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)
        {
            $(".error-file-msg").html('<span class="fa fa-remove"></span> Invalid image file. Only except jpg, jpeg, png, gif format');
            $(".upload-btn-wrapper > input[type='file']").val('');
            $("#film_avatar").replaceWith('<img src="/film_hunter/img/default-film.png" id="film_avatar" />');
            $('.btn-add-film').css('opacity', '0.3').prop('disabled', true);
            return false;
        }
        $('.btn-add-film').css('opacity', '1').prop('disabled', false);
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#film_avatar').attr('src', e.target.result);
            };
            reader.readAsDataURL(this.files[0]);
        }
    });
    $(".upload-file > input[type='file']").change(function() {
        $(".success-file-upload").text('');
        $(".error-file-upload").text('');
        var extension = $(".upload-file > input[type='file']").val().split('.').pop().toLowerCase();
        if(jQuery.inArray(extension, ['mp4','wmv','avi','mov']) == -1)
        {
            $(".error-file-upload").html('<span class="fa fa-remove"></span> Invalid video format. Only except mov, wmv, mp4, avi');
            $(".upload-file > input[type='file']").val('');
            $("#preview_film").attr('src', '');
            $('.btn-add-film').css('opacity', '0.3').prop('disabled', true);
            return false;
        }
        $('.btn-add-film').css('opacity', '1').prop('disabled', false);
        var $source = $('#preview_film');
        $source[0].src = URL.createObjectURL(this.files[0]);
        $source.parent()[0].load();
        $(".success-file-upload").html('<span class="fa fa-check"> Uploaded file successfully!</span>').delay(3000).fadeOut('slow');
    });
    //reset add film form
    $(".btn-reset-form").on('click', function(event) {
        $("#frmAddFilm")[0].reset();
    });
    $(".btn-add-film").click(function(event) {
        var x = $("#film_avatar").val();
        console.log(x);
        if ($("#film_avatar").val() == '') {
            $(".error-file-msg").text('Please choose an image');
        } 
        if ($("#preview_film").val() == '') {
            $(".error-file-upload").text('Please choose a video!');
        }
        $("#frmAddFilm").validate({
            rules: {
                name: {
                    required: function() {
                        chkNameExisted();
                    },
                    minlength: 3,
                },
                content: {
                    required: true,
                    minlength: 20
                },
                imdb: {
                    required: true,
                },
                release_year: {
                    required: true,
                    number: true,
                    range: [1990, 2017]
                }
            },
            messages: {
                name: {
                    minlength: "Film name must be at least 3 characters"
                },
                content: {
                    minlength: "Film content must be at least 20 characters"
                }
            },
            submitHandler: function(form) {
                $(".error-file-msg").text('');
                $(".error-file-upload").text('');
                form.submit();
            }
        });
    });
});
function chkNameExisted(name) {
    var film_name = $("input[name='name']").val();
    if (film_name == '') {
        return false;
    } else {
        $.ajax({
            url: '/film_hunter/admin/films/chkNameExisted',
            type: 'POST',
            data: {'film_name': film_name},
            success: function(data) {
                var json = JSON.parse(data);
                if (json.check == true) {
                    $("#existed_name").html('<span class="fa fa-remove"> '+json.true_msg+'</span>').delay(2000).fadeIn('slow');
                    $("#available_name").text('');
                    return false;
                } 
                if (json.check == false) {
                    if (film_name.length >= 3) {
                        $("#available_name").html('<span class="fa fa-check"> '+json.false_msg+'</span>').delay(2000).fadeIn('slow');
                        $("#existed_name").text('');
                        return false;
                    }
                    
                }
             }
        });
    }
}
