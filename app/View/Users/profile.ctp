<div class="profile-area">
  <div class="container">
    <div class="row">
      <div class="offset-sm-3 col-sm-9"><?php echo $this->Flash->render('success_msg') ?></div>
      <div class="offset-sm-3 col-sm-9"><?php echo $this->Flash->render('pass_warning_msg') ?></div>
    </div>
    <div class="row">
        <div class="side-bar col-md-3">
          <div class="left-side">
            <h3 class="show-user-name">
              Welcome, </span> <?php echo AuthComponent::user('name'); ?></h2>
            </h3>
            <ul class="user_sidebar_menu">
                <li><a href="/film_hunter/users/favourites"><i class="fa fa-heart"></i> Favourite films</a></li>
                <li><a href="/film_hunter/users/posts"><i class="fa fa-pencil"></i> My comments</a></li>
                <li><a href="/film_hunter/users/profile"><i class="fa fa-user"></i> Account info</a></li>
            </ul>
          </div>
      </div>
      <div class="col-md-9">
        <h4 class="update-profile-title"><i class="fa fa-refresh"></i> Update account's info</h4>
        <form action="/film_hunter/users/profile" method="post" enctype="multipart/form-data">
          <div class="row">
          <div class="col-sm-8">
          <?php if (strtotime($user['User']['updated_at']) >0 ) { ?>
          <p id="updated_time">Last updated <span class="fa fa-clock-o"></span>:<i> <?php echo $user['User']['updated_at']; ?></i></p>
          <?php } ?>
          <div class="row name-group">
            <div class="col-sm-3">
              <label class="control-label strong" for="name">Name</label>
            </div>
            <div class="col-sm-9 name-field">
              <input type="text" name="data[User][name]" class="form-control" value="<?php echo $user['User']['name']; ?>" id="name" spellcheck="false" autocomplete="off" required>
              <span class="name-error-msg"></span>
            </div>
          </div>
          <div class="row email-group">
            <div class="col-sm-3">
              <label class="control-label strong" for="email">Email</label>
            </div>
            <div class="col-sm-9">
              <input type="text" class="form-control" readonly value="<?php echo $user['User']['email']; ?>">
            </div>
          </div>
          <div class="row age-group">
            <div class="col-sm-3">
              <label class="control-label strong" for="age">Age</label>
            </div>
            <div class="col-sm-3">
              <select name="data[User][age]" class="form-control">
                <?php for($i = 18; $i <= 80; $i++) { ?>
                  <option value="<?php echo $i ?>" <?php if ($i == $user['User']['age']) echo "selected"; ?>><?php echo $i ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="row gender-group">
            <div class="col-sm-3">
              <label class="control-label strong" for="email">Gender</label>
            </div>
            <div class="col-sm-9">
              <input type="radio" value="0" name="data[User][gender]" <?php echo ($user['User']['gender'] == 0) ? "checked" : "" ?>> Male
              <input type="radio" value="1" name="data[User][gender]" <?php echo ($user['User']['gender'] == 1) ? "checked" : "" ?>> Female
            </div>
          </div>
          <div class="row change-pass-group">
            <div class="col-sm-12">
              <input type="checkbox" id="chk_change_pwd" name="chk_change_pwd"> Change password
            </div>
          </div>
          <div class="change-password" style="display: none;">
            <div class="row old-pass-group">
              <div class="col-sm-3">
                <label class="control-label strong" for="password">Old pass</label>
              </div>
              <div class="col-sm-9">
                <input type="password" class="form-control" name="old_pass" id="old_pass">
                <span class="error-old-pass"></span>
              </div>
            </div>
            <div class="row new-pass-group">
              <div class="col-sm-3">
                <label class="control-label strong" for="new-pass">New pass</label>
              </div>
              <div class="col-sm-9">
                <input type="password" class="form-control" name="new_pass" id="new_pass">
                <span class="error-new-pass"></span>
              </div>
            </div>
            <div class="row confirm-pass-group">
              <div class="col-sm-3">
                <label class="control-label strong" for="confirm-pass">Confirm pass</label>
              </div>
              <div class="col-sm-9">
                <input type="password" class="form-control" name="confirm_pass" id="confirm_pass">
                <span class="error-confirm-pass"></span>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="row user-profile">
            <button class="btn btn-sm btn-success btn-reset-img pull-right"><span class="fa fa-refresh pull-right"></span></button>
            <img src="<?php echo $this->webroot.'img/user_avatar/'.$user['User']['user_avatar']; ?>" id="blah">
          </div>
          <div class="upload-btn-wrapper">
              <button class="btn btn-block btn-sm" disabled>Update profile</button>
              <input type="file" name="data[User][user_avatar]" />
            </div>
          <p class="error-file-msg"></p>
        </div>
        </div>
          <button type="submit" class="btn btn-primary btn-update-profile"><i class="fa fa-refresh"></i> Update</button>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
$(document).ready(function() {
    $(".btn-reset-img").on('click', function(event) {
        event.preventDefault();
        $('.btn-update-profile').prop('disabled', false);
        $(".error-file-msg").text('');
        $("#blah").replaceWith('<img src="<?php echo $this->webroot.'img/user_avatar/'.$user['User']['user_avatar']; ?>" id="blah" />');
        $('.btn-update-profile').css('opacity', '1').prop('disabled', false);
    });
    $("#name").on('keyup', function(event) {
        var name = $.trim($(this).val());
        if (name == '') {
            $('.btn-update-profile').prop('disabled', true);
        } else {
            if (name.length < 3) {
                $('.btn-update-profile').prop('disabled', true);
                $(".name-error-msg").text('Name must be at least 3 characters');
            } else {
                $(".name-error-msg").text('');
                $('.btn-update-profile').prop('disabled', false);
            }
        }
    });
    $("#chk_change_pwd").on('click', function(event) {
        if($(this).is(":checked")) {
            changeStatus();
            $(".change-password").slideDown('slow').css('display', 'block');
            
            $("#old_pass").on('keyup', function(event) {
                var old_pass = $("#old_pass").val();
                if (old_pass.length < 6 || old_pass.length > 8 ) {
                    $(".error-old-pass").text('Password length must be between 6 and 8 characters');  
                    changeStatus();
                    return false;
                } else {
                    changeStatus();
                    $(".error-old-pass").text('');
                }
            });
            $("#new_pass").on('keyup', function(event) {
                var new_pass = $("#new_pass").val();
                if (new_pass.length < 6 || new_pass.length > 8) {
                    $(".error-new-pass").text('New password length must be between 6 and 8 characters');
                    changeStatus();
                    return false;
                } else {
                    changeStatus();
                    $(".error-new-pass").text('');
                }
                
            });
            $("#confirm_pass").on('keyup', function(event) {
                var confirm_pass = $("#confirm_pass").val();
                var new_pass = $("#new_pass").val();
                if (new_pass != confirm_pass) {
                    $(".error-confirm-pass").text('Confirm password did not match new password');
                    changeStatus();
                    return false;
                } else {
                    changeStatus();
                    $(".error-confirm-pass").text('');
                }
                
            });

        } else {
            $(".change-password").slideUp('slow').css('display', 'none');
            $('.btn-update-profile').css('opacity', '1').prop('disabled', false);
        }
    });

    $("input[type='file']").change(function() {
        $(".error-file-msg").text('');
        var extension = $("input[type='file']").val().split('.').pop().toLowerCase();
        if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)
        {
            $(".error-file-msg").html('<span class="fa fa-remove"></span> Invalid image file. Only except jpg, jpeg, png, gif format');
            $("input[type='file']").val('');
            $("#blah").replaceWith('<img src="<?php echo $this->webroot.'img/user_avatar/'.$user['User']['user_avatar']; ?>" id="blah" />');
            $('.btn-update-profile').css('opacity', '0.3').prop('disabled', true);
            return false;
        }
        $('.btn-update-profile').css('opacity', '1').prop('disabled', false);
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#blah').attr('src', e.target.result);
            };
            reader.readAsDataURL(this.files[0]);
        }
    });
});
function changeStatus() {
    var old_pass = $("#old_pass").val();
    var new_pass = $("#new_pass").val();
    var confirm_pass = $("#confirm_pass").val();
    if (new_pass.length < 6 || new_pass.length > 8 || old_pass.length < 6 || old_pass.length > 8 || new_pass != confirm_pass) {
        $('.btn-update-profile').css('opacity', '0.3').prop('disabled', true);
    } else {
        $('.btn-update-profile').css('opacity', '1').prop('disabled', false);
    }
}
</script>

