<div class="container">
   <?php echo $this->Flash->render('success_msg') ?>
   <!-- Page Heading -->
   <h1 class="my-4"> New Films
   </h1>
   <div class="row">
      <?php foreach($films as $film): ?>
      <div class="col-lg-3 col-md-4 col-sm-6 portfolio-item">
         <div class="card h-100">
            <a href="/film_hunter/films/preview/<?php echo $film['Film']['id']; ?>"><img class="card-img-top" src= <?php echo $this->webroot.'img/film_avatar/'. $film['Film']['avatar']; ?> alt=""></a>
            <div class="card-body">
               <h4 class="card-title">
                  <a class="film" href="/film_hunter/films/preview/<?php echo $film['Film']['id']; ?>"><?php echo $film['Film']['name']; ?></a>
               </h4>
               <p class="card-text" >
                  <?php echo substr($film['Film']['content'], 0, 130) ?><?php echo strlen($film['Film']['content']) > 130 ? "..." : "" ?>
               </p>
            </div>
         </div>
      </div>
      <?php endforeach; ?>
      <ul class="pagination" style="margin: auto;">
         <?php 
            echo $this->Paginator->prev( '<<', array( 'class' => '', 'tag' => 'li' ), null, array( 'class' => 'disabled page-item page-item', 'tag' => 'li' ) );
            echo $this->Paginator->numbers( array( 'tag' => 'li', 'separator' => '', 'currentClass' => 'disabled page-item page-link' ) );
            echo $this->Paginator->next( '>>', array( 'class' => '', 'tag' => 'li' ), null, array( 'class' => 'disabled page-item page-link', 'tag' => 'li' ) );
            ?>
      </ul>
   </div>
   <h1 class="my-4">Top Views
   </h1>
   <div class="row">
      <?php foreach($top_views as $top_view): ?>
      <div class="col-lg-3 col-md-4 col-sm-6 portfolio-item">
         <div class="card h-100">
            <a href="/film_hunter/pages/movie/<?php echo $top_view['Film']['id']; ?>"><img class="card-img-top" src= <?php echo $this->webroot.'img/film_avatar/'. $top_view['Film']['avatar']; ?> alt=""></a>
            <div class="card-body">
               <h4 class="card-title">
                  <a class="film" href="/film_hunter/films/preview/<?php echo $top_view['Film']['id']; ?>"><?php echo $top_view['Film']['name']; ?></a>
               </h4>
               <p class="card-text" >
                  <?php echo substr($film['Film']['content'], 0, 130) ?><?php echo strlen($film['Film']['content']) > 130 ? "..." : "" ?>
               </p>
            </div>
         </div>
      </div>
      <?php endforeach; ?>
   </div>
   <!-- /.row -->
</div>
