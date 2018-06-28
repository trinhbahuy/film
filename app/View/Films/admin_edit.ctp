<h3>Edit film</h3>
<div class="row">
    <div class="col-sm-6">
        <form method="post" enctype="multipart/form-data" action="/film_hunter/admin/films/edit/<?php echo $film['Film']['id']; ?>">
            <input type="hidden" id="film_id" value="<?php echo $film['Film']['id']; ?>">
            <div class="form-group">
                <label>Film name</label>
                <input type="text" name="name" onkeyup="return chkFilmName(this.value);"class="form-control" value="<?php echo $film['Film']['name']; ?>" spellcheck="false" autocomplete="off" required/>
                <p id="error_name_msg"></p>
                <p id="available_name"></p>
            </div>
            <div class="form-group">
                <label>Content</label>
                <textarea class="form-control" rows="5" name="content" spellcheck="false" autocomplete="off" required><?php echo $film['Film']['content']; ?></textarea>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="film-avatar">Avatar</label><br>
                    <i style="color: #ca9806;">* Only format: png, jpeg, jpg, gif</i>
                    <div class="change-film-avatar">
                        <button class="btn btn-sm btn-success btn-reset-avt pull-right"><span class="fa fa-refresh pull-right"></span></button>
                        <img src="<?php echo $this->webroot.'img/film_avatar/'.$film['Film']['avatar']; ?>" id="update_fav">
                    </div> 
                    <div class="change-avt-wrapper">
                        <button class="btn btn-sm" disabled>Change avatar</button>
                        <input type="file" name="data[Film][avatar]" id="change_film_avt" />
                    </div>
                    <p class="error-file-msg"></p>
                </div>
                <div class="col-md-6">
                    <label for="movie">Movie</label><br>
                    <i style="color: #ca9806;">* Only format: mp4, wmv, avi, mov</i>
                    <div class="change-film-upload">
                        <button class="btn btn-sm btn-success btn-reset-file-upload pull-right"><span class="fa fa-refresh pull-right"></span></button>
                        <video controls>
                            <source src="<?php echo $this->webroot.'/movie/'.$film["Film"]["movie"]; ?>" type="video/mp4" id="update_film_upload">
                        </video>
                    </div>
                    <div class="change-upload-file">
                        <button class="btn btn-sm" disabled>Upload new file</button>
                        <input type="file" name="data[Film][movie]" accept="video/*"/>
                    </div>
                    <p class="error-file-upload"></p> 
                    <p class="success-file-upload"></p>
                </div>
            </div>
            <div class="form-group">
                <br>
                <label>View</label>
                <input type="text" class="form-control" value="<?php echo $film['Film']['views']; ?>" readonly />
            </div>
            <div class="form-group">
                <br>
                <label>Rated</label>
                <input type="text" class="form-control" value="<?php echo $film['Film']['rated']; ?>" readonly />
            </div>
            <div class="form-group">
                <label>IMDB</label>
                <input type="number" name="imdb" class="form-control" value="<?php echo $film['Film']['IMDb']; ?>" required/>
            </div>
            <div class="form-group">
                <label>Release Year</label>
                <input type="number" name="release_year" class="form-control" value="<?php echo $film['Film']['release_year']; ?>" required/>
            </div>
            <div class="form-group">
                <label>Categories</label>
                 <select class="form-control select2-multi" name="categories[]" multiple="multiple" required>
                    <?php foreach($categories as $cat): ?>
                        <option value='<?php echo $cat['Category']['id']; ?>'><?php echo $cat['Category']['category_name']; ?></option>
                    <?php endforeach; ?>
                    <?php foreach($cates as $value): ?>
                        <option value='<?php echo $value['id']; ?>' selected > <?php echo $value['category_name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Tags</label>
                <select class="form-control select2-multi" name="tags[]" multiple="multiple">
                    <?php foreach($tags as $tag): ?>
                        <option value='<?php echo $tag['Tag']['id']; ?>'><?php echo $tag['Tag']['tag_name']; ?></option>
                    <?php endforeach; ?>
                    <?php foreach($selected_tags as $s_tag){ ?>
                        <option value='<?php echo $s_tag['id']; ?>' selected > <?php echo $s_tag['tag_name']; ?></option>
                    <?php }; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-success btn-update-film"><span class="fa fa-refresh"></span> Update film</button>
        </form>
    </div>
</div>
<script>
    function chkFilmName(film_name) {
        if (film_name == '') {
            $("#error_name_msg").html('<span class="fa fa-remove">This field is required</span>').delay(2000).fadeIn('slow');
            $("#available_name").text('');
            $('.btn-update-film').prop('disabled', true);
        } else {
            if (film_name.length < 3) {
                $('.btn-update-film').prop('disabled', true);
                $("#available_name").text('');
                $("#error_name_msg").text('Name must be at least 3 characters');
            } else {
                
                var film_id = $("#film_id").val();
                $.ajax({
                    url: '/film_hunter/admin/films/chkUniqueName',
                    type: 'POST',
                    data: {'film_name': film_name, 'film_id': film_id},
                    success: function(data) {
                        console.log(data);
                        var json = JSON.parse(data);
                        if (json.check == true) {
                            $("#error_name_msg").html('<span class="fa fa-remove"> '+json.true_msg+'</span>').delay(2000).fadeIn('slow');
                            $("#available_name").text('');
                            $('.btn-update-film').prop('disabled', true);
                            return false;
                        } 
                        if (json.check == false) {
                            if (film_name.length >= 3) {
                                $("#available_name").html('<span class="fa fa-check"> '+json.false_msg+'</span>').delay(2000).fadeIn('slow');
                                $("#error_name_msg").text('');
                                $('.btn-update-film').prop('disabled', false);
                                return false;
                            }
                            
                        }
                    }
                });
            }
        }
    }
    $(document).ready(function() {
        $(".change-avt-wrapper > input[type='file']").change(function() {
            $(".error-file-msg").text('');
            var extension = $("input[type='file']").val().split('.').pop().toLowerCase();
            if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)
            {
                $(".error-file-msg").html('<span class="fa fa-remove"></span> Invalid image file. Only except jpg, jpeg, png, gif format');
                $(".change-avt-wrapper > input[type='file']").val('');
                $("#update_fav").replaceWith('<img src="<?php echo $this->webroot.'img/film_avatar/'.$film['Film']['avatar']; ?>" id="update_fav" />');
                $('.btn-update-film').css('opacity', '0.3').prop('disabled', true);
                return false;
            }
            $('.btn-update-film').css('opacity', '1').prop('disabled', false);
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#update_fav').attr('src', e.target.result);
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
        $(".change-upload-file > input[type='file']").change(function() {
            $(".success-file-upload").text('');
            $(".error-file-upload").text('');
            var extension = $(".change-upload-file > input[type='file']").val().split('.').pop().toLowerCase();
            if(jQuery.inArray(extension, ['mp4','wmv','avi','mov']) == -1)
            {
                $(".error-file-upload").html('<span class="fa fa-remove"></span> Invalid video format. Only except mov, wmv, mp4, avi');
                $(".change-upload-file > input[type='file']").val('');
                $("#update_film_upload").attr('src', '');
                $('.btn-update-film').css('opacity', '0.3').prop('disabled', true);
                return false;
            }
            $('.btn-update-film').css('opacity', '1').prop('disabled', false);
            var $source = $('#update_film_upload');
            $source[0].src = URL.createObjectURL(this.files[0]);
            $source.parent()[0].load();
            $(".success-file-upload").html('<span class="fa fa-check"> Uploaded file successfully!</span>').delay(3000).fadeOut('slow');
        });
        //reset image upload
        $(".btn-reset-avt").on('click', function(event) {
            event.preventDefault();
            $(".error-file-msg").text('');
            $("#update_fav").replaceWith("<img src='<?php echo $this->webroot.'img/film_avatar/'.$film['Film']['avatar']; ?>' id='update_fav' />");
            $('.btn-update-film').css('opacity', '1').prop('disabled', false);
        });
        $(".btn-reset-file-upload").on('click', function(event) {
            event.preventDefault();
            $(".error-file-upload").text('');
            $("#update_film_upload").replaceWith("<img src='<?php echo $this->webroot.'img/film_avatar/'.$film['Film']['movie']; ?>' id='update_film_upload' />");
            $('.btn-update-film').css('opacity', '1').prop('disabled', false);
        });
    });
</script>