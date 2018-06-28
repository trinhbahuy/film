<div class="profile-area">
  <div class="container">
    <div class="row">
      <div class="side-bar col-md-3">
          <div class="left-side">
            <h3 class="show-user-name">
              Xin chào, </span> <?php echo AuthComponent::user('name'); ?></h2>
            </h3>
            <ul class="user_sidebar_menu">
                <li><a href="/film_hunter/users/favourites"><i class="fa fa-heart"></i> Phim yêu thích</a></li>
                <li><a href="/film_hunter/users/posts"><i class="fa fa-pencil"></i> Nhận xét của tôi</a></li>
                <li><a href="/film_hunter/users/profile"><i class="fa fa-user"></i> Thông tin tài khoản</a></li>
            </ul>
          </div>
      </div>
      <div class="col-md-9">
        <h4 class="posts-title"><i class="fa fa-edit"></i> Comments about films</h4>
        <?php if(count($posts) > 0) { ?>
        <table class="table table-responsive">
          <tbody id="tbl_posts">
            <?php foreach ($posts as $post): ?>
            <tr>
              <td>
                <img src="<?php echo $this->webroot.'img/film_avatar/'. $post['Film']['avatar']; ?>">
              </td>
              <td width="80%;">
                <a href="/film_hunter/pages/movie/<?php echo $post['Film']['id']; ?>" style="color: #295cf9;"><?php echo $post['Film']['name']; ?></a>
                <p class="post-content">
                  <?php echo $post['Post']['content']; ?>
                  <span style="color: green; font-weight: 600; font-size: 14px;">
                    <i class="fa fa-check"></i> Approved</span>
                </p>
                <p class="post-time"><i class="fa fa-clock-o"></i><?php  echo date('d/m/Y, H:i:s', strtotime($post['Post']['created_at'])); ?></p>
              </td>
            </tr>
            <?php endforeach; ?>
            
          </tbody>
        </table>
        <ul class="pagination justify-content-center">
          <?php 
              echo $this->Paginator->prev( '<<', array( 'class' => '', 'tag' => 'li' ), null, array( 'class' => 'disabled page-item page-item', 'tag' => 'li' ) );
              echo $this->Paginator->numbers( array( 'tag' => 'li', 'separator' => '', 'currentClass' => 'disabled page-item page-link' ) );
              echo $this->Paginator->next( '>>', array( 'class' => '', 'tag' => 'li' ), null, array( 'class' => 'disabled page-item page-link', 'tag' => 'li' ) );
          ?>
        </ul>
        <?php } else { ?>
          <p style="margin-top: 20px;">Comments list is empty !</p>
          <div class="post-img text-center">
          <img src="<?php echo $this->webroot.'img/post_empty.png'; ?>" alt="post empty">
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>
