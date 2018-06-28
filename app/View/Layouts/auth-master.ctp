<!DOCTYPE html>
<html>
   <head>
      <title>Film Hunter</title>
      <?php
         echo $this->Html->script('jquery.min');
         echo $this->Html->css('bootstrap.min');
         
           
         ?>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   </head>
   <body>
      <!-- header --> 
      <!-- header -->
      <?php echo $this->Session->flash(); ?>
      <?php echo $this->fetch('content'); ?>
      <?php echo $this->Html->script('bootstrap.min'); ?>
   </body>
</html>
