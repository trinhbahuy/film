<h3>Create New Film</h3>
<div class="row">
    <div class="col-sm-6">
        <?php if (isset($errorss)) foreach ($errorss as $errors) { ?>
            <?php foreach ($errors as $error) { ?>
                <div class="alert alert-danger"> <?php echo $error; ?></div>
            <?php } ?>
        <?php } ?>
        <form method="post" enctype="multipart/form-data" action="/film_hunter/admin/films/add" id="frmAddFilm">
            <div class="form-group">
                <label>Film Name</label>
                <input type="text" name="name" onkeyup="return chkNameExisted(this.value);" spellcheck="false" autocomplete="off" class="form-control" placeholder="Film name"/>
                <p id="available_name"></p>
                <p id="existed_name"></p>
            </div>
            <div class="form-group">
                <label>Content</label>
                <textarea class="form-control" spellcheck="false" autocomplete="off" rows="5" name="content" placeholder="Content"></textarea>
                <p><i style="font-size: 14px; color: #827f78;">* Content must be at least 20 characters</i></p>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="film-avatar">Avatar</label><br>
                    <i style="color: #ca9806;">* Only format: png, jpeg, jpg, gif</i>
                    <div class="film-avatar">
                        <img src="<?php echo $this->webroot.'img/default-film.png' ?>" id="film_avatar">
                    </div> 
                    <div class="upload-btn-wrapper">
                        <button class="btn btn-sm" disabled>Update profile</button>
                        <input type="file" name="data[Film][avatar]" />
                    </div>
                    <p class="error-file-msg"></p>
                </div>
                <div class="col-md-6">
                    <label for="movie">Movie</label><br>
                    <i style="color: #ca9806;">* Only format: mp4, wmv, avi, mov</i>
                    <div class="film-upload">
                        <video controls>
                            <source src="" type="video/mp4" id="preview_film">
                        </video>
                    </div>
                    <div class="upload-file">
                        <button class="btn btn-sm" disabled>Upload file</button>
                        <input type="file" name="data[Film][movie]"/>
                    </div>
                    <p class="error-file-upload"></p> 
                    <p class="success-file-upload"></p>
                </div>
            </div>
            <div class="form-group">
                <label>IMDB</label>
                <input type="number" name="imdb" class="form-control" placeholder="IMDB" />
            </div>
            <div class="form-group">
                <label>Release Year</label>
                <input type="number" name="release_year" class="form-control" placeholder="Release Year"  />
            </div>
            <div class="form-group">
                <label>Categories</label>
                <select class="form-control select2-multi" name="categories[]" multiple="multiple" required>
                    <?php foreach($categories as $cat): ?>
                        <option value='<?php echo $cat['Category']['id']; ?>'><?php echo $cat['Category']['category_name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                    <label>Tags</label>
                    <input type="text" data-role="tagsinput" name="data[Tag][tag_name]" class="form-control">
                </div>
            <button type="submit" class="btn btn-primary btn-add-film"><span class="fa fa-save"></span> Save</button>
            <button type="button" class="btn btn-default btn-reset-form pull-right"><span class="fa fa-refresh"></span> Reset</button>
        </form>
    </div>
</div>

