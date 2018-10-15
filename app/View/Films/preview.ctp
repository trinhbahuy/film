
<div class="container preview-film">
  <div class="row">
    <div class="col-md-6 film-avatar">
        <img class="card-img-bottom" src= "<?php echo $this->webroot.'img/film_avatar/'. $film['Film']['avatar']; ?>" alt="Film Image" style="border: 10px solid white;" id="film_img">
        <a class="film" href="/film_hunter/pages/movie/<?php echo $film['Film']['id']; ?>"><img src="<?php echo $this->webroot.'img/play_icon.png' ?>" alt="play icon" id="play_icon"></a>
        <a class="film" href="/film_hunter/pages/movie/<?php echo $film['Film']['id']; ?>" class="btn btn-info btn-block">Watch</a>
    </div>
    <div class="col-md-6">
        <div class="card film-information">
          <div class="card-header bg-info text-center text-white">Film Information</div>
          <div class="card-body">
              <h5 class="card-title"><?php echo $film['Film']['name']; ?></h5>
              <div class="rating" style="direction: ltr !important;">
              <?php 
                  for($i=1; $i<=5; $i++){ 
                      if($i <= $film['Film']['average_rate'])
                          echo "<span><i class='text-warning fa fa-star'></i></span>";
                      else 
                          echo "<span><i class='text-warning fa fa-star-o'></i></span>";
                  }
              ?>
              </div>
              <p class="view-count"><strong>View(s): </strong> <?php echo $film['Film']['views']; ?></p>
              <p class="release-year"><strong>Release year:</strong> <?php echo $film['Film']['release_year']; ?></p>
              <p class="category"><strong>Category:</strong> 
              <?php foreach($film['Category'] as $cat) { ?>
                <span class="badge badge-success"><?php echo $cat['category_name']; ?></span>

              <?php } ?>
              </p>
              <p class="director"><strong>Director:</strong> <?php echo $film['Film']['director']; ?></p>
              <div class="description">
                <p style="text-align: justify;"><strong>Description:</strong> <?php echo $film['Film']['content']; ?></p>
              </div>
          </div>
        </div>
    </div>
  </div>
  <?php if (count($related_films)) { ?>
  <h1 class="my-4">Related Films</h1>
  <div class="row">
    <?php foreach($related_films as $key => $related_film) { ?>
        <div class="col-lg-3 col-md-4 col-sm-6 portfolio-item">
          <div class="card h-100">
            <a class="film" href="/film_hunter/films/preview/<?php echo $related_film['id']; ?>"><img class="card-img-top" src= <?php echo $this->webroot.'img/film_avatar/'. $related_film['avatar']; ?> alt=""></a>
            <div class="card-body">
              <h4 class="card-title">
                <a class="film" href="/film_hunter/films/preview/<?php echo $related_film['id']; ?>"><?php echo $related_film['name']; ?></a>
              </h4>
              <p class="card-text" >
                <?php echo substr($related_film['content'], 0, 130) ?><?php echo strlen($related_film['content']) > 130 ? "..." : "" ?>
                </p>
            </div>
          </div>
        </div>
    <?php } ?>
  </div>
  <?php } ?>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('.rating input').change(function () {
            var $radio = $(this);
            $('.rating .selected').removeClass('selected');
            $radio.closest('label').addClass('selected');
        });
    });
</script>
