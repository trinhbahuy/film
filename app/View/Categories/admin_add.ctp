<h2>Add Category</h2>
<?php echo $this->Form->create('Category'); ?>
<div class="form-group">
   <label for="is active">Category name</label>
   <input type="text" class="form-control" name="category_name" placeholder="Category name" required>
</div>
<div class="row col-sm-3">
   <div class="form-group">
      <label for="is active">Status</label>
      <select name="is_active" id="is_active" class="form-control">
         <option value="0">In active</option>
         <option value="1">Active</option>
      </select>
   </div>
</div>
<button type="submit" class="btn btn-success"><span class="fa fa-save"></span> Save category</button>
<?php echo $this->Form->end(); ?>