<div class="container" style="margin-top: 100px;">
   <div class="row">
      <div class="col-lg-12">
         <div class="row">
            <?php foreach($top_views as $film): ?>
            <div class="col-lg-3 col-md-6 mb-4">
               <div class="card h-100">
                  <a class="film" href="/film_hunter/pages/movie/<?php echo $film['Film']['id']; ?>"><img class="card-img-top" src=<?php echo $this->webroot.'img/film_avatar/'. $film['Film']['avatar']?> alt=""></a>
                  <div class="card-body">
                     <h4 class="card-title">
                        <a class="film" href="/film_hunter/films/preview/<?php echo $film['Film']['id']; ?>"><?php echo $film['Film']['name']; ?></a>
                     </h4>
                     <h5>IMDb: <?php echo $film['Film']['IMDb'] ?></h5>
                     <p class="card-text" >
                        <?php echo substr($film['Film']['content'], 0, 130) ?><?php echo strlen($film['Film']['content']) > 130 ? "..." : "" ?>
                     </p>
                  </div>
                  <div class="card-footer">
                     <small class="text-muted">
                     <?php 
                        for($i=1; $i<=5; $i++){ 
                            if($i <= $film['Film']['average_rate'])
                                echo "<span><i class='text-warning fa fa-star'></i></span>";
                            else 
                                echo "<span'><i class='text-warning fa fa-star-o'></i></span>";
                            }
                        ?>
                     </small>
                  </div>
               </div>
            </div>
            <?php endforeach; ?>
         </div>
         <!-- /.row -->
      </div>
      <!-- /.col-lg-9 -->
   </div>
   <!-- /.row -->
   <ul class="pagination justify-content-center">
      <?php 
         echo $this->Paginator->prev( '<<', array( 'class' => '', 'tag' => 'li' ), null, array( 'class' => 'disabled page-item page-item', 'tag' => 'li' ) );
         echo $this->Paginator->numbers( array( 'tag' => 'li', 'separator' => '', 'currentClass' => 'disabled page-item page-link' ) );
         echo $this->Paginator->next( '>>', array( 'class' => '', 'tag' => 'li' ), null, array( 'class' => 'disabled page-item page-link', 'tag' => 'li' ) );
         ?>
   </ul>
</div>
<!-- /.container -->
