<h3>Edit User</h3>
<div class="row">
    <div class="col-sm-6">
        <?php echo $this->Flash->render('success_msg') ?>
        <form method="post" action="/film_hunter/admin/users/edit/<?php echo $user['User']['id']; ?>">
            <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" value="<?php echo $user['User']['name'] ;?>" required readonly/>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="text" class="form-control" value="<?php echo $user['User']['email'] ;?>" required readonly/>
            </div>
            <div class="form-group">
                <label>Age</label>
                <input type="text" class="form-control" value="<?php echo $user['User']['age'] ;?>" required readonly />
            </div>
            <div class="form-group">
                <label>Gender</label>
                <select class="form-control" disabled>
                    <option value="0" <?php if($user['User']['gender'] == 0) echo "selected"; ?>>Female</option>
                    <option value="1" <?php if($user['User']['gender'] == 1) echo "selected"; ?>>Male</option>
                </select>
            </div>
            <div class="form-group">
                <label>Role</label>
                <select class="form-control" name="role">
                    <option value="0" <?php if($user['User']['role'] == 0) echo "selected"; ?>>Normal User</option>
                    <option value="1" <?php if($user['User']['role'] == 1) echo "selected"; ?>>Admin</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success btn-update-user"><span class="fa fa-refresh"></span> Update</button>
        </form>
    </div>
</div>