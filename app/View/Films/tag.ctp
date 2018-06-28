  <div class="container">
        <h3>Related film with tag: "<?php echo $tag['Tag']['tag_name']; ?>"</h3>
        <?php if(!empty($films)){?>
        <div class="row">
        <?php foreach($films as $film): ?>
          <div class="col-lg-3 col-md-4 col-sm-6 portfolio-item">
            <div class="card h-100">
              <a href="/film_hunter/films/preview/<?php echo $film['Film']['id']; ?>"><img class="card-img-top" src= <?php echo $this->webroot.'img/film_avatar/'. $film['Film']['avatar']; ?> alt=""></a>
              <div class="card-body">
                <h4 class="card-title">
                  <a href="/film_hunter/films/preview/<?php echo $film['Film']['id']; ?>"><?php echo $film['Film']['name']; ?></a>
                </h4>
                <p class="card-text" >
                <?php 
                  App::import('Model', 'Film');
                  echo Film::string_limit_words($film['Film']['content'], 100); ?>
                </p>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
        </div>
        <ul class="pagination justify-content-center">
            <?php 
                echo $this->Paginator->prev( '<<', array( 'class' => '', 'tag' => 'li' ), null, array( 'class' => 'disabled page-item page-item', 'tag' => 'li' ) );
                echo $this->Paginator->numbers( array( 'tag' => 'li', 'separator' => '', 'currentClass' => 'disabled page-item page-link' ) );
                echo $this->Paginator->next( '>>', array( 'class' => '', 'tag' => 'li' ), null, array( 'class' => 'disabled page-item page-link', 'tag' => 'li' ) );
            } ?>
        </ul>
    </div>
  