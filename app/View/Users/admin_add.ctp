<h3>Add New User</h3>
<div class="row">
    <div class="col-sm-6">
        <form method="post" action="/film_hunter/admin/users/add" id="addUserFrm">
            <div class="form-group">
                <label>User name</label>
                <input type="text" name="u_name" class="form-control" placeholder="username" autocomplete="off" spellcheck="false" />
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="text" name="u_email" class="form-control" autocomplete="off" spellcheck="false" placeholder="example@gmail.com" onkeyup="return chkEmailExisted(this.value);" />
                <p id="available_email"></p>
                <p id="existed_email" class="error_email"></p>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="u_pass" class="form-control" placeholder="password" />
            </div>
            <div class="row">
                <div class="form-group col-sm-4">
                    <label>Age</label>
                    <select name="u_age" class="form-control">
                        <?php for($i = 18; $i <= 65; $i++) { ?>
                        <option value="<?php echo $i ?>"><?php echo $i ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group col-sm-4">
                    <label>Gender</label>
                    <select name="u_gender" class="form-control">
                        <option value="0">Female</option>
                        <option value="1" selected="selected">Male</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label>Role</label>
                <select name="u_role" class="form-control">
                    <option value="0" selected="selected">User</option>
                    <option value="1">Admin</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success btn-add-user"><span class="fa fa-save"></span> Save</button>
        </form>
    </div>
</div>
<script>
    $(document).ready(function() {
        $(".btn-add-user").on('click', function(event) {
            $("#addUserFrm").validate({
                rules: {
                    u_name: {
                        required: true,
                        minlength: 3,
                        maxlength: 20,
                    },
                    u_email: {
                        required: function() {
                            chkEmailExisted();
                        },
                    },
                    u_pass: {
                        required: true,
                        minlength: 6,
                        maxlength: 8,
                    }
                },
                submitHandler: function(form) {
                    $(".error-file-msg").text('');
                    $(".error-file-upload").text('');
                    $("#available_email").text('');
                    $("#existed_email").text('');
                    form.submit();
                }
            });
        });
    });
    function chkEmailExisted(u_email) {
        var u_email = $("input[name='u_email']").val();
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/; 
        if (u_email == '') {
            $(".error_email").text('This field is required !');
            return false;
        } else {
            if (regex.test(u_email) == true) {
                $.ajax({
                    url: '/film_hunter/admin/users/chkEmailExisted',
                    type: 'POST',
                    data: {'u_email': u_email},
                    success: function(data) {
                        var json = JSON.parse(data);
                        if (json.check == true) {
                            $("#existed_email").html('<span class="fa fa-remove"> '+json.true_msg+'</span>').fadeIn('fast');
                            $("#available_email").text('');
                            $('.btn-add-user').prop('disabled', true);
                            return false;
                        } 
                        if (json.check == false) {
                            if (u_email.length >= 3) {
                                $("#available_email").html('<span class="fa fa-check"> '+json.false_msg+'</span>').fadeIn('fast');
                                $("#existed_email").text('');
                                $('.btn-add-user').prop('disabled', false);
                                return false;
                            }
                            
                        }
                     }
                });
            } else {
                $("#existed_email").text('');
                $("#available_email").text('');
                $('.btn-add-user').prop('disabled', true);
                $(".error_email").text('Wrong email format');
            }
        }
    }
</script>