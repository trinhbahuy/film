<h3>All posts</h3>
<table class="table table-bordered table-striped" id="post_lists">
  <thead>
    <tr>
      <th scope="col" style="width: 20px;">#</th>
      <th scope="col">Content</th>
      <th scope="col">By</th>
      <th scope="col">At film</th>
      <th scope="col">Created at</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <?php  foreach ($posts as $post) { ?>
    <tr>
      <th scope="row"><?php echo $post['Post']['id']; ?></th>
      <td><?php echo $post['Post']['content']; ?></td>
      <td><?php echo $post['User']['name']; ?></td>
      <td><?php echo $post['Film']['name']; ?></td>
      <td><?php echo $post['Post']['created_at']; ?></td>
      <td>
        <a onclick="return confirm('Are you sure to delete this post?');" href="/film_hunter/admin/posts/delete/<?php echo $post['Post']['id']; ?>"><button type="button" class="btn btn-danger">Delete</button></a>
      </td>
    </tr>
    <?php } ?>
    
  </tbody>
  
</table>


