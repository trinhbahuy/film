<h3>All films requested by users</h3>
<table class="table table-bordered table-striped" id="list_requests">
  <thead>
    <tr>
      <th>#</th>
      <th>User name</th>
      <th>Request content</th>
      <th>Created at</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <?php  foreach ($requests as $request) { ?>
    <tr>
      <th><?php echo $request['Request']['id']; ?></th>
      <th><?php echo $request['User']['name']; ?></th>
      <td><?php echo $request['Request']['request_name']; ?></td>
      <td><?php echo $request['Request']['created_at']; ?></td>
      <td><a href="/film_hunter/users/accept/<?php echo $request['User']['id']. "/". $request['Request']['id'];?>"><button type="button" class="btn btn-primary">Accept</button></a>
        <a href="/film_hunter/users/reject/<?php echo $request['User']['id']. "/". $request['Request']['id']; ?>"><button type="button" class="btn btn-danger">Reject</button></a>
      </td>
    </tr>
    <?php } ?>
  </tbody>
</table>