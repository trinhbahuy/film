<h1>Edit Category</h1>
<?php
   echo $this->Form->create('Category');
   echo $this->Form->input('category_name', ['class' => 'form-control']);
   echo $this->Form->input('id', array('type' => 'hidden'));
 ?>
<br>
<button type="submit" class="btn btn-info"><span class="fa fa-refresh"></span> Update Category</button>
<?php
   echo $this->Form->end();
?>
