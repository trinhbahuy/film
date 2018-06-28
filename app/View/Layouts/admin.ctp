<!DOCTYPE html>
<html>
   <head>
      <meta charset="UTF-8">
      <title>FilmHunter | Admin Dashboard</title>
      <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
      <link rel="short icon" href="<?php echo $this->webroot.'/img/logo.png'; ?>">
      <?php
         echo $this->Html->css('plugins/bootstrap-tags/bootstrap-tagsinput');
         echo $this->Html->css('bootstrap.min');
         echo $this->Html->css('font-awesome/css/font-awesome.min');
         echo $this->Html->css('AdminLTE');
         echo $this->Html->css('film');
         echo $this->Html->css('plugins/select2/select2.min');
         echo $this->Html->script('jquery.min'); 
         echo $this->Html->script('plugins/jquery-validate/jquery.validate');
         ?>
      <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.css">
   </head>
   <body class="skin-blue">
      <header class="header">
         <a href="/film_hunter/pages/index" class="logo">FilmHunter</a>
         <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            </a>
            <div class="navbar-right">
               <ul class="nav navbar-nav">
                  <!-- User Account: style can be found in dropdown.less -->
                  <li class="dropdown user user-menu">
                     <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                     <i class="glyphicon glyphicon-user"></i>
                     <span><?php echo $admin['name']; ?> <i class="caret"></i></span>
                     </a>
                     <ul class="dropdown-menu" style="margin-top: 260px; margin-right: -27px;">
                        <!-- User image -->
                        <li class="user-header bg-light-blue">
                           <img src= <?php echo $this->webroot.'img/avatar.png' ?> alt="" class="img-circle" alt="User Image" />
                           <p>
                              <?php echo ($admin['name']=='huy')?'Huy Dep Trai':$admin['name']; ?>
                              <small></small>
                           </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                           <div class="pull-left">
                              <a href="/film_hunter/users/profile" class="btn btn-default btn-flat">Profile</a>
                           </div>
                           <div class="pull-right">
                              <a href="/film_hunter/users/logout" class="btn btn-default btn-flat">Sign out</a>
                           </div>
                        </li>
                     </ul>
                  </li>
               </ul>
            </div>
         </nav>
      </header>
      <div class="wrapper row-offcanvas row-offcanvas-left">
         <aside class="left-side sidebar-offcanvas">
            <section class="sidebar">
               <div class="user-panel">
                  <div class="pull-left image">
                     <img src= <?php echo $this->webroot.'img/avatar.png' ?> alt="" class="img-circle" alt="User Image" />
                  </div>
                  <div class="pull-left info">
                     <p>Hello, <?php echo $admin['name']; ?></p>
                     <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                  </div>
               </div>
               <form action="#" method="get" class="sidebar-form">
                  <div class="input-group">
                     <input type="text" name="q" class="form-control" placeholder="Search..."/>
                     <span class="input-group-btn">
                     <button type='submit' name='seach' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                     </span>
                  </div>
               </form>
               <ul class="sidebar-menu">
                  <li>
                     <a href="/film_hunter/admin/categories/index">
                     <i class="fa fa-cubes"></i> <span>Categories</span>
                     </a>
                  </li>
                  <li class="treeview">
                     <a href="#">
                     <i class="fa fa-film"></i>
                     <span>Films</span>
                     <i class="fa fa-angle-left pull-right"></i>
                     </a>
                     <ul class="treeview-menu">
                        <li><a href="/film_hunter/admin/films/add"><i class="fa fa-angle-double-right"></i> Add</a></li>
                        <li><a href="/film_hunter/admin/films/show"><i class="fa fa-angle-double-right"></i> List</a></li>
                     </ul>
                  </li>
                  <li class="treeview">
                     <a href="#">
                     <i class="fa fa-users"></i>
                     <span>Users</span>
                     <i class="fa fa-angle-left pull-right"></i>
                     </a>
                     <ul class="treeview-menu">
                        <li><a href="/film_hunter/admin/users/add"><i class="fa fa-angle-double-right"></i> Add</a></li>
                        <li><a href="/film_hunter/admin/users/show"><i class="fa fa-angle-double-right"></i> List</a></li>
                     </ul>
                  </li>
                  <li>
                     <a href="/film_hunter/admin/posts/index">
                     <i class="fa fa-pencil"></i> <span>Posts</span>
                     </a>
                  </li>
                  <li>
                     <a href="/film_hunter/admin/films/request">
                     <i class="fa fa-film"></i> <span>Request us</span>
                     </a>
                  </li>
               </ul>
            </section>
            <!-- /.sidebar -->
         </aside>
         <!-- Right side column. Contains the navbar and content of the page -->
         <aside class="right-side">
            <!-- Content Header (Page header) -->
            <!-- Main content -->
            <section class="content">
               <?php echo $this->Session->flash(); ?>
               <?php echo $this->fetch('content'); ?>
            </section>
            <!-- /.content -->
         </aside>
         <!-- /.right-side -->
      </div>
      <!-- ./wrapper -->
      <?php 
         echo $this->Html->script('bootstrap.min');
         echo $this->Html->script('app'); 
         echo $this->Html->script('add_film');
         echo $this->Html->script('plugins/bootstrap-tags/bootstrap-tagsinput');
         echo $this->Html->script('plugins/select2/select2.min');
         ?>
      <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.js"></script>
      <script>
         $(document).ready( function () {
             $(".alert.alert-success").delay(2000).slideUp('slow');
             $(".alert.alert-danger").delay(6000).slideUp('slow');
             $('.select2-multi').select2();
             $('#post_lists, #requests_list, #list_users, #list_requests').DataTable();
         });
      </script>
   </body>
</html>
