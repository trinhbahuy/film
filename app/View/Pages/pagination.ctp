<table class="table" id="posts_lists">
  <tbody>
    <?php if (count($posts) != 0) { ?>
    <?php foreach($posts as $post): ?>
    <tr id="single_post_<?php echo $post['Post']['id']; ?>">
      <td width="20%">
        <img src="https://image.ibb.co/jw55Ex/def_face.jpg" class="img img-rounded img-fluid" style="width: 80px; height: 80px;" />
        <p><small><i><?php echo $post['Post']['created_at']; ?></i></small></p>
      </td>
      <td>
        <p><strong><?php echo $post['User']['name']; ?></strong></p>
        <p id="post_<?php echo $post['Post']['id']; ?>">
          <?php echo $post['Post']['content']; ?>
          <?php if(AuthComponent::user('id') == $post['Post']['user_id']){ ?>
          <span class="fa fa-pencil pull-right edit-cmt-btn" id="<?php echo $post['Post']['id']; ?>" style="cursor:pointer;"></span>
          <?php } ?>
        </p>
        <form id="edit_cmt_frm_<?php echo $post['Post']['id']; ?>" style="display: none;">
            <textarea id="edit_cmt_<?php echo $post['Post']['id']; ?>" cols="60" rows="3" style="margin-bottom: 10px; background: #e4e4e4;" spellcheck="false"><?php echo $post['Post']['content']; ?></textarea>
            <div class="clearfix"></div>
            <button type="button" class="btn btn-danger btn-sm cancel-btn"><span class="fa fa-remove"></span> Cancel</button>
            <button type="button" id="<?php echo $post['Post']['id']; ?>" class="btn btn-success btn-sm update-cmt-btn"><span class="fa fa-refresh"></span> Update</button>
        </form>
      </td>
    </tr>
    <?php endforeach; ?>
    <?php } else { ?>
      <tr class="no-post"><td colspan="2"><p>No comment in this film !</p></td></tr>
    <?php } ?>
  </tbody>
</table>
<ul class="pagination justify-content-center">
    <?php 
        echo $this->Paginator->prev( '<<', array( 'class' => '', 'tag' => 'li' ), null, array( 'class' => 'disabled page-item page-item', 'tag' => 'li' ) );
        echo $this->Paginator->numbers( array( 'tag' => 'li', 'separator' => '', 'currentClass' => 'disabled page-item page-link' ) );
        echo $this->Paginator->next( '>>', array( 'class' => '', 'tag' => 'li' ), null, array( 'class' => 'disabled page-item page-link', 'tag' => 'li' ) );
    ?>
</ul>