<h3>All users</h3>
<a href="/film_hunter/admin/users/add">New User</a>
<table class="table table-bordered table-striped" id="list_users">
  <thead>
    <tr>
      <th>#</th>
      <th>Name</th>
      <th>Email</th>
      <th>Age</th>
      <th>Gender</th>
      <th>Role</th>
      <th>Created at</th>
      <th>Edit</th>
      <th>Delete</th>
    </tr>
  </thead>
  <tbody>
    <?php  foreach ($users as $user) { ?>
    <tr>
      <th scope="row"><?php echo $user['User']['id']; ?></th>
      <td><?php echo $user['User']['name']; ?></td>
      <td><?php echo $user['User']['email']; ?></td>
      <td><?php echo $user['User']['age']; ?></td>
      <td><?php if ($user['User']['gender'] == 1) {echo "Male";} else{ echo "Female";}?></td>
      <td>
          <?php if($user['User']['role'] == 1) { ?>
            <span class="badge badge-success">Admin</span>
          <?php } else { ?>
            <span class="badge badge-default" style="color: white; background: #91959a;">Normal User</span>
          <?php } ?>
      </td>
      <td><?php echo $user['User']['created_at']; ?></td>
      <td><a href="/film_hunter/admin/users/edit/<?php echo $user['User']['id']; ?>"><button class="btn btn-primary" type="button">Edit</button> </a></td>
      <td><a onclick="return confirm('Are you sure?');" href="/film_hunter/admin/users/delete/<?php echo $user['User']['id']; ?>"><button type="button" class="btn btn-danger">Delete</button></a></td>
    </tr>
    <?php } ?>
  </tbody>
</table>
