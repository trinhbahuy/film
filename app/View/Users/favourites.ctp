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
        <?php echo $this->Flash->render('success_msg') ?>
        <h4 class="favourites-title">Favourite films list</h4>
        <?php if(count($favourites) > 0) { ?>
        <table class="table table-responsive">
          <tbody id="tbl_favourites">
            <?php foreach ($favourites as $favourite): ?>
            <tr>
              <td>
                <img src="<?php echo $this->webroot.'img/film_avatar/'. $favourite['Film']['avatar']; ?>">
              </td>
              <td width="80%;"><a href="/film_hunter/pages/movie/<?php echo $favourite['Film']['id']; ?>"><?php echo $favourite['Film']['name']; ?></a>
              </td>
              <td>
                <?php
                    echo $this->Form->postLink(
                        'Remove',
                        array('action' => 'delete_favourite', $favourite['Favourite']['id']),
                        array('confirm' => 'Are you sure?, Yeah, why not!')
                    );
                ?>
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
          <p style="margin-top: 20px;">Favourite list is empty !</p>
          <div class="favourite-img text-center">
          <img src="<?php echo $this->webroot.'img/favourite_empty.png'; ?>" alt="favourite empty">
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>
