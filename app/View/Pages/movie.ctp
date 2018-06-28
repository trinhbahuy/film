<div class="container">
  <div class="row">
    <div class="col-md-8">
        <video controls style="width: 100%; height: 411px;">
            <source src= <?php echo $this->webroot.'movie/'. $film['Film']['movie']?> type="video/mp4">
        </video>
        <input type="hidden" id="user_id" value="<?php echo AuthComponent::user('id'); ?>">
        <input type="hidden" id="film_id" value="<?php echo $film['Film']['id']; ?>">
        <input type="hidden" id="star_point" value="<?php echo $film['Film']['average_rate']; ?>">
        <input type="hidden" id="favourite" value="<?php if(isset($favourite['Favourite']['favourite'])){
                                                            if ($favourite['Favourite']['favourite']==1) 
                                                                echo 1;
                                                            else 
                                                                echo 0;
                                                        }
                                                         else echo 2; ?>"
        >
        <input type="hidden" id="views" value="<?php echo $film['Film']['views']; ?>">
            <div class="row" style="margin: 15px -15px;">
              <div class="col-md-12"><strong><?php echo $film['Film']['name'] ?></strong></div>
            </div>
            <div class="row" style="margin: 15px -15px;">
              <div class="col-md-5"><p id="show_film_views"><span class="fa fa-eye"></span> <?php echo $film['Film']['views'] ?></p></div>
              <div class="rating col-md-3">
                  <label>
                      <input type="radio" name="rating" value="5" title="5 stars"> 5
                  </label>
                  <label>
                      <input type="radio" name="rating" value="4" title="4 stars"> 4
                  </label>
                  <label>
                      <input type="radio" name="rating" value="3" title="3 stars"> 3
                  </label>
                  <label>
                      <input type="radio" name="rating" value="2" title="2 stars"> 2
                  </label>
                  <label>
                      <input type="radio" name="rating" value="1" title="1 star"> 1
                  </label>
                  <p id="show_rated_msg" style="color: green; font-size: 14px;"></p>
              </div>

              <div class="col-md-2">
                  <p id="show_total_rates">Total Rate: <?php echo $film['Film']['rated']; ?></p>

              </div>
              <div class="col-md-2 favourite">
                  <label>
                      <input type="radio" value="favourite">
                  </label> 
                  <span id="count_favourites" data-id="<?php echo $favourites; ?>"><?php echo $favourites; ?></span>   
              </div>
            </div>
            <div class="film-content">
              <p id="short_content"><?php echo substr($film['Film']['content'], 0, 130) ?><?php echo strlen($film['Film']['content']) > 130 ? "..." : "" ?></p>
              <p id="full_content" style="display: none;">
                  <?php echo $film['Film']['content']; ?>
              </p>
              <button type="button" class="btn btn-default btn-sm" data-id = "0" id="film_content_btn">Show More</button>
              
            </div>
            <div class="film-tags">
            <?php if (count($film['Tag'])) { ?>
              <p>
              <strong>Tags:</strong>
              <?php foreach($film['Tag'] as $tag) { ?>
                <a href="/film_hunter/films/tag/<?php echo $tag['id']; ?>"><span class="badge badge-success"><?php echo $tag['tag_name']; ?></span></a>
              <?php } ?>
              </p>
            <?php } ?>
            </div>
            <div class="pb-cmnt-container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-info">
                            <div class="panel-body">
                                <form id="comment_frm">
                                    <textarea placeholder="Write your comment here!" class="pb-cmnt-textarea" spellcheck="false" name="comment" id="comment"></textarea>
                                    <button class="btn btn-primary" id="btn_send_cmt" type="submit" style="margin-top: 5px; margin-bottom: 20px; float: right;"><i class="fa fa-send"></i> Send</button>
                                </form>
                            </div>
                            <div class="clearfix"></div>
                            <div class="alert alert-success alert-dismissible success-msg" style="color: green; display: none;">
                              <button type="button" class="close" data-dismiss="alert">&times;</button>
                              Comment successfully !
                            </div>
                            <div class="alert alert-success alert-dismissible update-cmt-msg" style="color: green; display: none;">
                              <button type="button" class="close" data-dismiss="alert">&times;</button>
                              Update comment successfully !
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card" style="margin-top: 5px;">
              <div class="card-body">
                <span class="fa fa-comments-o" id="count_cmts" data-id="<?php echo count($film['Post']); ?>"> <?php echo count($film['Post']); ?> comments</span>
                <!-- <div class="sort-by pull-right">
                  <label for="sort_by" style="font-weight: 600;">Sort by</label>
                  <select name="sort_cmts_by">
                    <option value="new">Newest</option>
                    <option value="old">Oldest</option>
                  </select>
                </div> -->
                <table class="table" id="posts_lists">
                  <tbody>
                    <?php if (count($posts) != 0) { ?>
                    <?php foreach($posts as $post): ?>
                    <tr id="single_post_<?php echo $post['Post']['id']; ?>">
                      <td width="15%" class="text-center">
                        <img src="<?php echo $this->webroot.'img/user_avatar/'.$post['User']['user_avatar']; ?>" class="post-user-ava"  data-target="#show_profile" data-toggle="modal" data-id = "<?php echo $post['User']['id']; ?>" data-name="<?php echo $post['User']['name']; ?>" data-age = "<?php echo $post['User']['age']; ?>" data-gender = "<?php echo $post['User']['gender']; ?>" data-email = "<?php echo $post['User']['email']; ?>" />
                        <p><small><i><?php echo $post['Post']['created_at']; ?></i></small></p>
                      </td>
                      <td>
                        <p>
                          <strong>
                            
                            <?php echo $post['User']['name']; ?>
                          </strong>
                        </p>
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
                        <?php if ($post['Post']['updated_at'] != '') { ?>
                          <i class="updated-time pull-right" id="updated_post_<?php echo $post['Post']['id']; ?>">Last updated: <?php echo $post['Post']['updated_at']; ?></i>
                        <?php } else { ?>
                          <i class="updated-time pull-right" id="updated_post_<?php echo $post['Post']['id']; ?>"></i>
                        <?php } ?>
                      </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php } else { ?>
                      <tr class="no-post"><td colspan="2"><p>No comment in this film !</p></td></tr>
                    <?php } ?>
                  </tbody>
                </table>
                <?php if (count($posts) >= 5) { ?>
                <ul class="pagination justify-content-center">
                    <?php 
                        echo $this->Paginator->prev( '<<', array( 'class' => '', 'tag' => 'li' ), null, array( 'class' => 'disabled page-item page-item', 'tag' => 'li' ) );
                        echo $this->Paginator->numbers( array( 'tag' => 'li', 'separator' => '', 'currentClass' => 'disabled page-item page-link' ) );
                        echo $this->Paginator->next( '>>', array( 'class' => '', 'tag' => 'li' ), null, array( 'class' => 'disabled page-item page-link', 'tag' => 'li' ) );
                    ?>
                </ul>
                <?php } ?>
              </div>
            </div>
        </div>
    <div class="col-md-4">
      <h4 id="top_rate">Top Rate</h4>
      <?php foreach($top_rates as $top_rate):?>
      <div class="thumbnail one-film" >
        <a href="/film_hunter/pages/movie/<?php echo $top_rate['Film']['id']; ?>"><img class="img-fluid" src= <?php echo $this->webroot.'img/film_avatar/'. $top_rate['Film']['avatar']; ?>  style="width: 400px; height: 300px;" ></a>
        <div class="name-film"> 
            <h5><?php echo $top_rate['Film']['name']?> </h5>  
            <strong style="float: right;"> 
            <?php 
                for($i=1; $i<=5; $i++){ 
                    if($i <= $top_rate['Film']['average_rate'])
                        echo "<span><i class='text-warning fa fa-star'></i></span>";
                    else 
                        echo "<span><i class='text-warning fa fa-star-o'></i></span>";
                }
            ?>
            </strong>
        </div>
      </div>
      <br>
      <hr>
      <?php endforeach; ?>      
    </div>
  </div>

</div> 
<div class="container">
  <h3>You may like ?</h3>
  <div class="row col-lg-12">

   <?php foreach($random_films as $film): ?>
      <div class="col-md-3 col-sm-6 mb-4 one-film">
        <a href="/film_hunter/pages/movie/<?php echo $film['Film']['id']; ?>"><img style="width: 280px; height: 250px;"class="img-fluid" src= <?php echo $this->webroot.'img/film_avatar/'. $film['Film']['avatar']; ?>  >
        </a>
        <div class="name-film"> 
            <h5> <?php echo $film['Film']['name']?> </h5>  
            <strong style="float: right;"> 
            <?php 
                for($i=1; $i<=5; $i++){ 
                    if($i <= $film['Film']['average_rate'])
                        echo "<span><i class='text-warning fa fa-star'></i></span>";
                    else 
                        echo "<span><i class='text-warning fa fa-star-o'></i></span>";
                }
            ?>
            </strong>
        </div>
      </div>
    <?php endforeach; ?>

  </div>
</div>
<div class="container">
  <h3>Top Most Views</h3>
  <div class="row col-lg-12">

   <?php foreach($top_views as $top_view): ?>
      <div class="col-md-3 col-sm-6 mb-4 one-film">
        <a href="/film_hunter/pages/movie/<?php echo $top_view['Film']['id']; ?>"><img style="width: 280px; height: 250px;"class="img-fluid" src= <?php echo $this->webroot.'img/film_avatar/'. $top_view['Film']['avatar']; ?>  >
        </a>
        <div class="name-film"> 
            <h5><?php echo $top_view['Film']['name']?> </h5>  
            <strong style="float: right;"> 
            <?php 
                for($i=1; $i<=5; $i++){ 
                    if($i <= $top_view['Film']['average_rate'])
                        echo "<span><i class='text-warning fa fa-star'></i></span>";
                    else 
                        echo "<span><i class='text-warning fa fa-star-o'></i></span>";
                }
            ?>
            </strong>
        </div>
      </div>
    <?php endforeach; ?>

  </div>
</div>
</div>
<div id="divLoading">
  <p>
    <img src="<?php echo $this->webroot.'/img/heart-animation.gif' ?>">
  </p>
</div>
<!-- Show profile -->
<div class="modal" id="show_profile">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header header-profile">
        <h4 class="modal-title show-profile-title">User profile</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
          <div class="row form-group">
            <div class="col-sm-4">
                <label for="name">Username: </label>
            </div>
            <div class="col-sm-8">
                <p id="show_name"></p>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-sm-4">
                <label for="email">Email: </label>
            </div>
            <div class="col-sm-8">
                <p id="show_email"></p>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-sm-4">
                <label for="name">Age: </label>
            </div>
            <div class="col-sm-8">
                <p id="show_age"></p>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-sm-4">
                <label for="name">Gender: </label>
            </div>
            <div class="col-sm-8">
                <p id="show_gender"></p>
            </div>
          </div>
      </div>
      <div class="modal-footer footer-profile">
        <a href="/film_hunter/users/profile" class="btn btn-link"></a>
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><span class="fa fa-remove"></span> Close</button>
      </div>
    </div>
  </div>
</div>
<!-- End show profile -->
<script type="text/javascript">
    $(document).ready(function(){
        $(".post-user-ava").on('click', function(event) {
            $("#show_profile").show();
            var u_id = $(this).attr("data-id");
            var u_name = $(this).attr("data-name");
            var u_email = $(this).attr("data-email");
            var u_age = $(this).attr("data-age");
            var u_gender = $(this).attr("data-gender");
            var profile_link = $(this).attr("data-link");
            $("#show_name").text(u_name);
            if ($("#user_id").val() != u_id) {
                $("#show_email").text('*************');
            } else {
                $("#show_email").text(u_email);
            }
            $("#show_age").text(u_age);
            if (u_gender == 0) {
                $("#show_gender").text('Male');
            } else {
               $("#show_gender").text('Female');
            }
            if ($("#user_id").val() == u_id) {
                $(".footer-profile > a").text('View Profile');
            } else {
                $(".footer-profile > a").text('');
            }
        });
        var star_point = $("#star_point").val();
        if(star_point > 0 && star_point <= 5){
            for(i=1; i<=star_point; i++){
                $("input[value='"+i+"']").parent("label").addClass('selected');
            }
        }
        $('.rating input').change(function () {
            var $radio = $(this);
            $('.rating .selected').removeClass('selected');
            $radio.closest('label').addClass('selected');
            
            var point = $radio.val();
            var user_id = $('#user_id').val();
            var film_id = $('#film_id').val();
            if(user_id == ""){
                var choose = confirm('Please login for rating!');
                if(choose == true)
                    window.location = "/film_hunter/users/login";
            } else{
                $.ajax({
                    method: 'POST',
                    url: '/film_hunter/rates/rating',
                    data: {point: point, user_id: user_id, film_id: film_id},
                    dataType: 'json',
                    success: function(data) {
                        if (data.error == true) {
                          alert(data.error_msg);
                        } else {
                            $("#show_total_rates").replaceWith('<p id="show_total_rates">Total Rate: '+data+'</p>');
                            if (data == 1) {
                                $("#show_rated_msg").text('You have rated ' + point + ' star').delay(3000).fadeOut('slow');
                            } else {
                                $("#show_rated_msg").text('You have rated ' + point + ' stars').delay(3000).fadeOut('slow');
                            }
                        }
                    }
                });
            }
        });
        var favourite = $("#favourite").val();
        if(favourite == 1){
            $("input[value='favourite']").parent("label").addClass('selected');
        }
        $('.favourite input').on('click', function () {
            var $heart = $(this);
            var user_id = $('#user_id').val();
            var film_id = $('#film_id').val();
            if(user_id == ""){
                if(confirm('Please login to favourite film!') == true) {
                    window.location = "/film_hunter/users/login";
                }
            } else{
                if($("#favourite").val() == 1){
                    $heart.parent('label').removeClass('selected');
                    $("#favourite").val(0);
                    $.ajax({
                        method: 'POST',
                        url: '/film_hunter/favourite/dislike',
                        data: {user_id: user_id, film_id: film_id},
                        success: function(data) {
                            if (data.error == true) {
                                alert(data.error_msg);
                            } else {
                                var count = $("#count_favourites").attr("data-id");
                                count --;
                                $("#count_favourites").attr("data-id", count);
                                $("#count_favourites").text(count);
                            }
                        }
                   });
                }
                else{
                    $heart.parent('label').addClass('selected');
                    if($("#favourite").val() == 0){
                        $.ajax({
                            method: 'POST',
                            url: '/film_hunter/favourite/like_again',
                            data: {user_id: user_id, film_id: film_id},
                            success: function(data) {
                                if (data.error == true) {
                                    alert(data.error_msg);
                                } else {
                                    var count = $("#count_favourites").attr("data-id");
                                    count ++;
                                    $("#count_favourites").attr("data-id", count);
                                    $("#count_favourites").text(count);
                                    $("#divLoading").fadeIn('fast').delay(2000).fadeOut('slow');
                                }
                            }
                        });
                    } else {
                        $.ajax({
                          method: 'POST',
                          url: '/film_hunter/favourite/like',
                          data: {user_id: user_id, film_id: film_id},
                          success: function(data) {
                            if (data.error == true) {
                                alert(data.error_msg);
                            } else {
                                var count = $("#count_favourites").attr("data-id");
                                count ++;
                                $("#count_favourites").attr("data-id", count);
                                $("#count_favourites").text(count);
                                $("#divLoading").fadeIn('fast').delay(2000).fadeOut('slow');
                            }
                          }
                        });
                    }
                    $("#favourite").val(1);
                } 
            }
        });
        
        //show more, show less film's content 
        $("#film_content_btn").click(function(event) {
            if ($(this).attr('data-id') == 0) {
                $(this).attr('data-id', 1); 
                $("#full_content").fadeIn('slow');
                $("#short_content").css('display', 'none');
                $("#film_content_btn").text('Show Less');
            } else {
                $(this).attr('data-id', 0);
                $("#full_content").css('display', 'none');
                $("#short_content").fadeIn();
                $("#film_content_btn").text('Show More');
            }
        });
        $("#btn_send_cmt").on('click', function(event) {
          if ($("#user_id").val() == '') {
              if (confirm('Please login to write your comment !') == true) {
                window.location = "/film_hunter/users/login";
              }
              return false;
          } else {
            $("#comment_frm").validate({
              rules: {
                comment: {
                  required: true,
                  minlength: 3,
                  maxlength: 200
                }
              },
              messages: {
                comment: {
                  required: "Please enter your comment",
                  minlength: "Comment must be at least 3 characters",
                  maxlength: "Comment must not over 200 characters",
                }
              },
              submitHandler: function(data) {
                var content = $("#comment").val();
                var user_id = $('#user_id').val();
                var film_id = $('#film_id').val();
                $.ajax({
                  method: 'POST',
                  url: '/film_hunter/users/comment',
                  data: {'content': content, 'user_id': user_id, 'film_id': film_id},
                  dataType: 'json',
                  success: function(data) {
                    console.log(data);
                    if (data.error == true) {
                      alert(data.error_msg);
                    } else {
                      $("#comment").val('');
                      var count = $("#count_cmts").attr("data-id");
                      count ++;
                      $("#count_cmts").attr("data-id", count);
                      $("#count_cmts").html(" " + count + " comments");
                      $(".success-msg").css('display', 'block');
                      setTimeout(function() {
                        $(".success-msg").fadeOut('slow');
                      }, 2000);
                      var img_url = "<?php echo $this->webroot ?>";
                      $("#posts_lists > tbody").prepend('<tr><td width="15%" class="text-center"><img src="'+img_url+'/img/user_avatar/'+data['User'].user_avatar+'" class="post-user-ava" data-target="#show_profile" data-toggle="modal" data-id = "'+data['User'].id+'" data-name="'+data['User'].name+'" data-age = "'+data['User'].age+'" data-gender = "'+data['User'].gender+'" data-email = "'+data['User'].email+'"/><p><small><i>'+data['Post'].created_at+'</i></small></p></td><td><p><strong>'+data['User'].name+'</strong></p><p id="post_'+data['Post'].id+'">'+data['Post'].content+'<span class="fa fa-pencil pull-right edit-cmt-btn" id="'+data['Post'].id+'" style="cursor:pointer;"></span></p><form id="edit_cmt_frm_'+data['Post'].id+'" style="display: none;"><textarea id="edit_cmt_'+data['Post'].id+'" cols="60" rows="3" style="margin-bottom: 10px; background: #e4e4e4;">'+data['Post'].content+'</textarea><div class="clearfix"></div><button type="button" class="btn btn-danger btn-sm cancel-btn"><span class="fa fa-remove"></span> Cancel</button> <button type="button" id="'+data['Post'].id+'" class="btn btn-success btn-sm update-cmt-btn"><span class="fa fa-refresh"></span> Update</button></form><i class="updated-time pull-right" id="updated_post_'+data['Post'].id+'"></i></td></tr>');
                      $(".no-post").hide();
                    }
                  }
                });
              }
            });
          }
        });
        $("body").on('focusout', '#comment', function(event) {
            $("#comment-error").css('display', 'none');
        });
        $("body").on('focusin', '#comment', function(event) {
            $("#comment-error").css('display', 'inline-block');
        });
        $("body").on('click', '.edit-cmt-btn', function(event) {
            var post_id = $(this).attr('id');
            $("#edit_cmt_frm_" + post_id).show();
            $(this).parent().hide();
            $(".cancel-btn").on('click', function(event) {
              $("#edit_cmt_frm_" + post_id).hide();
              $("#post_" + post_id).show();
            });
        });
        $("body").on('click', ".update-cmt-btn", function(event) {
          event.preventDefault();
          var post_id = $(this).attr('id');
          var content = $("#edit_cmt_" + post_id).val();
          var user_id = $('#user_id').val();
          var film_id = $('#film_id').val();
          if (content == '') {
            alert('Please enter your comment !');
            return false;
          } else if (content.length > 200) {
            alert('Comment must not over 200 characters');
            return false;
          } else {
            if (content.length < 3) {
              alert('content must be at least 3 characters');
              return false;
            } else {
              $.ajax({
                method: 'POST',
                url: '/film_hunter/users/updateCmt',
                data: {'content': content, 'user_id': user_id, 'film_id': film_id, 'post_id': post_id},
                dataType: 'json',
                success: function(data) {
                  console.log(data);
                  if (data.error == true) {
                       alert(data.error_msg);
                  } else {
                    $(".update-cmt-msg").css('display', 'block');
                    setTimeout(function() {
                      $(".update-cmt-msg").fadeOut('slow');
                    }, 2000);
                    $("#edit_cmt_frm_" + data['Post'].id).hide();
                    $("#edit_cmt_frm_" + data['Post'].id).replaceWith('<form id="edit_cmt_frm_'+data['Post'].id+'" style="display: none;"><textarea id="edit_cmt_'+data['Post'].id+'" cols="60" rows="3" style="margin-bottom: 10px; background: #e4e4e4;">'+data['Post'].content+'</textarea><div class="clearfix"></div><button type="button" class="btn btn-danger btn-sm cancel-btn"><span class="fa fa-remove"></span> Cancel</button> <button type="button" id="'+data['Post'].id+'" class="btn btn-success btn-sm update-cmt-btn"><span class="fa fa-refresh"></span> Update</button></form>');
                    $("#post_" + data['Post'].id).replaceWith('<p id="post_'+data['Post'].id+'">'+data['Post'].content+'<span class="fa fa-pencil pull-right edit-cmt-btn" id="'+data['Post'].id+'" style="cursor:pointer;"></span></p>');
                    $("#updated_post_" + data['Post'].id).replaceWith('<i class="updated-time pull-right" id="updated_post_'+ data['Post'].id +'">Last updated: ' + data['Post'].updated_at + '</i>');
                  }
                }
              });
            }
          }
       });

      $("video").one("play", function (e) {
        var views = Number($("#views").val()) + 1;
        var film_id = $("#film_id").val();
        $.ajax({
            method: 'POST',
            url: '/film_hunter/films/view',
            data: {film_id: film_id, views: views},
            dataType: 'json'
            }).done(function(data){
              console.log(data);
              });
      });
      
  });
</script>
