<div class="container">
   <!-- Page Heading -->
   <h1 class="my-4"> Your Favourite </h1>
   <!-- Project One -->
   <?php foreach($favourite as $film): ?>
   <div class="row" style="margin-bottom: 40px;">
      <div class="col-md-4">
         <a href="#">
         <img class="img-fluid rounded mb-3 mb-md-0" src=<?php echo $this->webroot.'img/film_avatar/'. $film['Film']['avatar']?> alt="">
         </a>
      </div>
      <div class="col-md-8">
         <h3> <?php echo $film['Film']['name']; ?> </h3>
         <p><?php echo $film['Film']['content']; ?></p>
         <a class="btn btn-primary" href="#">Remove</a>
      </div>
   </div>
   <hr>
   <?php endforeach; ?>
   <!-- /.row -->
   <!-- Pagination -->
   <ul class="pagination justify-content-center">
      <li class="page-item">
         <a class="page-link" href="#" aria-label="Previous">
         <span aria-hidden="true">&laquo;</span>
         <span class="sr-only">Previous</span>
         </a>
      </li>
      <li class="page-item">
         <a class="page-link" href="#">1</a>
      </li>
      <li class="page-item">
         <a class="page-link" href="#">2</a>
      </li>
      <li class="page-item">
         <a class="page-link" href="#">3</a>
      </li>
      <li class="page-item">
         <a class="page-link" href="#" aria-label="Next">
         <span aria-hidden="true">&raquo;</span>
         <span class="sr-only">Next</span>
         </a>
      </li>
   </ul>
</div>
