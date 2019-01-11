<div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="row">
        <?php if (count($films_with_same_category) > 0) { ?>
        <?php foreach($films_with_same_category as $film): ?>
          <div class="col-lg-3 col-md-4 mb-4">
            <div class="card h-100">
              <a class="film" href="/film_hunter/pages/movie/<?php echo $film['id']; ?>"><img class="card-img-top" src=<?php echo $this->webroot.'img/film_avatar/'. $film['avatar']?> alt=""></a>
              <div class="card-body">
                <h4 class="card-title">
                  <a href="#"><?php echo $film['name']; ?></a>
                </h4>
                <h5>IMDb: <?php echo $film['IMDb'] ?></h5>
                
                <p><?php echo substr($film['content'], 0, 130) ?><?php echo strlen($film['content']) > 130 ? "..." : "" ?></p>
              </div>
              <div class="card-footer">
                <small class="text-muted">
                  <?php 
                  for($i=1; $i<=5; $i++){ 
                      if($i <= $film['average_rate'])
                          echo "<span><i class='text-warning fa fa-star'></i></span>";
                      else 
                          echo "<span><i class='text-warning fa fa-star-o'></i></span>";
                      }
                  ?>
                </small>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
        <?php } else { ?>
          <p>There is no film in this category</p>
        <?php } ?>
        </div>
      </div>
    </div>
</div>
