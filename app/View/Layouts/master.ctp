<!DOCTYPE html>
<html>
   <head>
      <title>Film Hunter</title>
      <?php
         echo $this->Html->script('jquery.min');
           echo $this->Html->script('plugins/jquery-validate/jquery.validate');
         echo $this->Html->css('bootstrap.min');
         echo $this->Html->css('style');
         echo $this->Html->css('rating.css');
           echo $this->Html->css('favourite.css');
           echo $this->Html->css('like_button.css');
         ?>
      <link rel="short icon" href="<?php echo $this->webroot.'/img/logo.png'; ?>">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   </head>
   <body>
      <div id="main">
         <header>
            <div class="top0">
               <div class="container">
                  <div class="row">
                     <div class="col-sm-12">
                        <div class="auth-form-wrapper clearfix">
                           <ul class="auth">
                              <?php if (AuthComponent::user('id')) { ?>
                              <li><a class='waves-effect waves-dark' href='/film_hunter/users/logout'> Logout </a></li>
                              <li><a class='waves-effect waves-dark' href='/film_hunter/users/profile'><?php echo AuthComponent::user('name') ?></a></li>
                              <?php } else { ?>
                              <li><a class='waves-effect waves-dark' href='/film_hunter/users/register'> Register </a></li>
                              <li><a class='waves-effect waves-dark' href='/film_hunter/users/login'> Login </a></li>
                              <?php } ?>
                           </ul>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="top1">
               <div class="container">
                  <div class="row">
                     <div class="col-sm-12">
                        <div class="top1_inner clearfix">
                           <div class="logo_wrapper"><a href="index.html" class="logo"><img src="<?php echo $this->webroot.'/img/logo.png'; ?>" alt="" style="width: 250px; height: 100px;"></a></div>
                           <div class="search-form-wrapper clearfix">
                              <form id="search-form" method="post" action="/film_hunter/films/search" class="navbar-form" >
                                 <input type="text" name="data[Film][search]" placeholder="Searching films..." required>
                                 <a href="javascript:void(0)" onClick="document.getElementById('search-form').submit()"></a>
                              </form>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="top2">
               <div class="menu_wrapper">
                  <div class="container">
                     <div class="row">
                        <div class="col-sm-12">
                           <div class="navbar navbar_">
                              <div class="navbar-inner navbar-inner_">
                                 <div class="nav-collapse nav-collapse_ collapse">
                                    <ul class="nav sf-menu clearfix">
                                       <li><a href="/film_hunter/pages/index">Home</a></li>
                                       <li class="nav-item dropdown">
                                          <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="navbardrop">Category<em></em></a>
                                          <div class="dropdown-menu" style="width: 450px;">
                                             <table class="table">
                                                <?php foreach($categoriess as $categories): ?>
                                                <tr>
                                                   <?php foreach($categories as $category): ?>
                                                   <td> <a href="/film_hunter/films/category/<?php echo $category['Category']['id']; ?>"> <?php echo $category['Category']['category_name']; ?> </a></td>
                                                   <?php endforeach; ?>
                                                </tr>
                                                <?php endforeach; ?>
                                             </table>
                                          </div>
                                       </li>
                                       <!--  <li><a href="#">Country</a></li> -->
                                       <li class="nav-item dropdown">
                                          <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="navbardrop">Release Year<em></em></a>
                                          <div class="dropdown-menu" style="width: 300px;">
                                             <table class="table">
                                                <?php foreach($yearss as $years): ?>
                                                <tr>
                                                   <?php foreach($years as $year): ?>
                                                   <td> <a href="/film_hunter/films/year/<?php echo $year['films']['release_year']; ?>"> <?php echo $year['films']['release_year']; ?> </a></td>
                                                   <?php endforeach; ?>
                                                </tr>
                                                <?php endforeach; ?>
                                             </table>
                                          </div>
                                       </li>
                                       <li><a href="/film_hunter/pages/topviews">Top Views</a></li>
                                       <?php if (AuthComponent::user('id')) { ?>
                                       <li style="margin-top:3px;">
                                          <div class="dropdown">
                                             <button class="btn btn-success dropdown-toggle" data-toggle="dropdown" > Request Us </button>
                                             <div class="dropdown-menu dropdown-menu-right" style="padding: 5px;">
                                                <form method="post" action="/film_hunter/films/save_request" >
                                                   <label>What Film you want?</label>
                                                   <div class="clearfix"></div>
                                                   <input type="text" name="request_name" style="padding: 7px; width: 300px;">
                                                   <button type="submit" class="btn btn-info"><span class="fa fa-send"></span>  Send</button>
                                                </form>
                                             </div>
                                          </div>
                                       </li>
                                       <?php } ?>                 
                                    </ul>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </header>
         <div id="content">
            <?php echo $this->Session->flash(); ?>
            <?php echo $this->fetch('content'); ?>
         </div>
         <footer>
            <div class="bot1">
               <div class="container">
                  <div class="row">
                     <div class="col-sm-3 col-md-3">
                        <div class="block_title">Menu</div>
                        <ul class="ul0">
                           <li><a href="/film_hunter/pages/index">Home</a></li>
                           <li><a href="/film_hunter/pages/topviews">Top views</a></li>
                           <li><a href="/film_hunter/users/login">Login</a></li>
                           <li><a href="/film_hunter/users/register">Register</a></li>
                        </ul>
                     </div>
                     <div class="col-sm-3 col-md-3">
                        <div class="block_title">New Films</div>
                        <ul class="ul0">
                           <?php foreach ($new_films as $key => $new_film) { ?>
                           <li><a href="/film_hunter/films/preview/<?php echo $new_film['Film']['id'] ?>"><?php echo $new_film['Film']['name'] ?></a></li>
                           <?php } ?>                                                                                   
                        </ul>
                     </div>
                     <div class="col-sm-3 col-md-3">
                        <div class="block_title">Find us on:</div>
                        <ul class="ul_social">
                           <li><a href="https://www.facebook.com/" target="_blank"><img src="<?php echo $this->webroot.'/img/social_ic1.jpg' ?>" alt="facebook icon" class="img"><span>Facebook</span></a></li>
                           <li><a href="https://www.twitter.com/" target="_blank"><img src="<?php echo $this->webroot.'/img/social_ic2.jpg' ?>" alt="twitter icon" class="img"><span>Twitter</span></a></li>
                           <li><a href="https://www.linkedin.com/" target="_blank"><img src="<?php echo $this->webroot.'/img/social_ic3.jpg' ?>" alt="linked in icon" class="img"><span>Linked in</span></a></li>
                           <li><a href="https://www.pinterest.com/" target="_blank"><img src="<?php echo $this->webroot.'/img/social_ic4.jpg' ?>" alt="pinterest" class="img"><span>Pinterest</span></a></li>
                        </ul>
                     </div>
                     <div class="col-sm-3 col-md-3">
                        <div class="block_title">Information</div>
                        <p class="txt">
                           Film Hunter is best website for proving best films to our world !
                        </p>
                     </div>
                  </div>
               </div>
            </div>
            <div class="bot2">
               <div class="container">
                  <div class="row">
                     <div class="col-sm-12 text-center">
                        <div class="copyright">Copyright © 2018. FilmHunter, All rights reserved.</div>
                     </div>
                  </div>
               </div>
            </div>
         </footer>
         <?php echo $this->Html->script('bootstrap.min'); ?>
         <script>
            $(document).ready(function() {
                $(".alert.alert-success").delay(2000).slideUp('slow');
                $(".alert.alert-danger").delay(6000).slideUp('slow');
            });
         </script>
      </div>
   </body>
</html>
