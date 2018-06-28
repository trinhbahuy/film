<h3>List films</h3>
<a href="/film_hunter/admin/films/add">New film</a>
<table class="table table-bordered table-striped">
  <thead>
    <tr>
      <th scope="col" style="width: 20px;">#</th>
      <th scope="col">Name</th>
      <th scope="col">Content</th>
      <th scope="col">Avatar</th>
      <th scope="col">Movie</th>
      <th scope="col">Categories</th>
      <th scope="col">View</th>
      <th scope="col">Rated</th>
      <th scope="col">IDMB</th>
      <!-- <th scope="col">Category</th> -->
      <th scope="col">Release</th>
      <th scope="col" style="width: 40px;">Edit</th>
      <th scope="col" style="width: 40px;">Delete</th>
    </tr>
  </thead>
  <tbody>
    <?php  foreach ($films as $film) { ?>
    <tr>
      <th scope="row"><?php echo $film['Film']['id']; ?></th>
      <td>
          <?php echo $film['Film']['name']; ?>
          <a href="/film_hunter/pages/movie/<?php echo $film['Film']['id']; ?>" target="_blank"><span class="fa fa-external-link"></span></a>
      </td>
      
      <td><textarea class="form-control" rows="6" readonly placeholder="Content"><?php echo $film['Film']['content']; ?></textarea></td>
      <td><img id="film_img" src=<?php echo $this->webroot.'img/film_avatar/'.$film['Film']['avatar']; ?>></td>
      <td><?php echo $film['Film']['movie']; ?></td>
      <td>
      <?php foreach ($film['Category'] as $cat) { ?>
          <p><span class="badge badge-success"><?php echo $cat['category_name']; ?></span></p>
      <?php } ?>
      </td>
      <td><?php echo $film['Film']['views']; ?></td>
      <td><?php echo $film['Film']['rated']; ?></td>
      <td><?php echo $film['Film']['IMDb']; ?></td>
      <td><?php echo $film['Film']['release_year']; ?></td>
      <td><a href="/film_hunter/admin/films/edit/<?php echo $film['Film']['id']; ?>"><button class="btn btn-primary" type="button">Edit</button> </a></td>
      <td><a onclick="return confirm('Are you sure?');" href="/film_hunter/admin/films/delete/<?php echo $film['Film']['id']; ?>"><button type="button" class="btn btn-danger">Delete</button></a></td>
    </tr>
    <?php } ?>
  </tbody>
  
</table>