<?php
	App::uses('AppController', 'Controller');
	class UsersController extends AppController{
		public $name = 'Users';
		public $uses = array('User','Post', 'Film', 'Request', 'Category', 'Favourite');
		public $helpers = array('Form', 'Html');

		public function beforeFilter() {
		    parent::beforeFilter();
		    $this->Auth->allow('login', 'register');
		}
        public function profile(){
			$this->layout = 'master';
			$this->set('new_films', $this->Film->find('all', array(
						"fields" => array("Film.id, Film.name"),
			        	"order" => array("Film.created_at" => "desc"),
			        	"limit" => 4,
						'recursive' => -1
					)
				)
			);
			$this->set('categoriess', array_chunk($this->Category->find('all'),4));
			$this->set('yearss', array_chunk($this->Film->query("SELECT DISTINCT release_year FROM films ORDER BY release_year desc"),4));
			$id    = AuthComponent::user('id');
			$user =  $this->User->find('first', array(
		       'conditions' => array('User.id' => $id)
		   	));
		   	$user_pass = $user['User']['password'];

		   	$this->set('user', $user);
		   	if ($this->request->is('post')){
				$this->User->read(null, $id);
				$uploadPathAvatar = WWW_ROOT . 'img/user_avatar/';
				if(!empty($this->request->data['User']['user_avatar']['name'])){
					$fileNameAvatar = time()."_".$this->request->data['User']['user_avatar']['name'];
	                $uploadFileAvatar = $uploadPathAvatar.$fileNameAvatar;
					move_uploaded_file($this->request->data['User']['user_avatar']['tmp_name'], $uploadFileAvatar);
					if (file_exists($uploadFileAvatar) && $user['User']['user_avatar'] != 'default-user.png') {
	                	unlink($uploadPathAvatar.$user['User']['user_avatar']);
	                }
		        } else {
		        	$fileNameAvatar = $user['User']['user_avatar'];
		        }
	            $user_avatar = $fileNameAvatar;
	          	$updated_profile = $this->User->find("first", array(
                		'conditions' => array(
                			'User.id' => $id
                		),
                	)
                );
                $this->User->read(null, $id);
                $passwordHasher = new BlowfishPasswordHasher();
                $old_pass = $this->request->data('old_pass');
                $new_pass = $passwordHasher->hash($this->request->data('new_pass'));
                $chk_pass = $passwordHasher->check($old_pass, $user_pass);
                $is_checked = $this->request->data('chk_change_pwd');
                if ($is_checked == true && $new_pass != '' && $old_pass != '') {
	                if ($chk_pass == 1) {
	                	$this->User->set(array(
		                		'user_avatar' => $user_avatar, 
								'name' => $this->request->data['User']['name'],
								'age' => $this->request->data['User']['age'],
								'gender' => $this->request->data['User']['gender'],
								'password' => $new_pass,
								'updated_at' => date("Y-m-d H:i:s"),
		                	)
		                );
	                } else {
	                	$this->Flash->danger('Password did not match with current password', array(
						    'key' => 'pass_warning_msg',
						));	
	                	$this->redirect('/users/profile');
	                }
	            } else {
	                $this->User->set(array(
	                		'user_avatar' => $user_avatar, 
							'name' => $this->request->data['User']['name'],
							'age' => $this->request->data['User']['age'],
							'gender' => $this->request->data['User']['gender'],
							'updated_at' => date("Y-m-d H:i:s"),
	                	)
	                );
	            }
                $this->User->save();
                
                $user = $this->User->find('first', array(
        				'conditions' => array('User.id' => $id),
        			)
        		);
	   			$this->set('user', $user);
	   			$this->Flash->success('Updated account successfully !', array(
				    'key' => 'success_msg',
				));	
			}
		}
		public function favourites()
		{
			$this->set('categoriess', array_chunk($this->Category->find('all'),4));
			$this->set('yearss', array_chunk($this->Film->query("SELECT DISTINCT release_year FROM films"),4));
			$this->set('new_films', $this->Film->find('all', array(
						"fields" => array("Film.id, Film.name"),
			        	"order" => array("Film.created_at" => "desc"),
			        	"limit" => 4,
						'recursive' => -1
					)
				)
			);
			$this->layout = 'master';
			$this->paginate = array(
		        'conditions' => array(
		        	'Favourite.user_id' => AuthComponent::user('id'),
					'Favourite.favourite' => 1
		        ),
		        'limit' => 5,
		    );
		    $favourites = $this->paginate('Favourite');
		    $this->set('favourites', $favourites);

		}
		public function posts()
		{
			$this->set('categoriess', array_chunk($this->Category->find('all'),4));
			$this->set('yearss', array_chunk($this->Film->query("SELECT DISTINCT release_year FROM films"),4));
			$this->set('new_films', $this->Film->find('all', array(
						"fields" => array("Film.id, Film.name"),
			        	"order" => array("Film.created_at" => "desc"),
			        	"limit" => 4,
						'recursive' => -1
					)
				)
			);
			$this->layout = 'master';
			$this->paginate = array(
		        'conditions' => array(
		        	'Post.user_id' => AuthComponent::user('id'),
		        ),
		        'limit' => 10,
		    );
		    $posts = $this->paginate('Post');
		    $this->set('posts', $posts);

		}
		public function delete_favourite($id) {
		    if ($this->request->is('get')) {
		        throw new MethodNotAllowedException();
		    }

		    if ($this->Favourite->delete($id)) {
		        $this->Flash->success('Remove favourite film successfully !', array(
				    'key' => 'success_msg',
				));
		    } else {
		        $this->Flash->error(
		            __('The favourite film with id: %s could not be deleted.', h($id))
		        );
		    }
		    return $this->redirect(array('action' => 'favourites'));
		}
		public function register(){
			$this->layout = 'master';
			$this->set('categoriess', array_chunk($this->Category->find('all'),4));
			$this->set('yearss', array_chunk($this->Film->query("SELECT DISTINCT release_year FROM films"),4));
			$this->set('new_films', $this->Film->find('all', array(
						"fields" => array("Film.id, Film.name"),
			        	"order" => array("Film.created_at" => "desc"),
			        	"limit" => 4,
						'recursive' => -1
					)
				)
			);
			if(AuthComponent::user()){
				$this->redirect('/pages/index');
			}
			$this->User->set($this->request->data);
			if ($this->request->is('post')){
				if($this->User->valid_register() == false)
			        $this->set('errorss', $this->User->validationErrors); 
			    else{
			    	if ($this->request->data('password') != $this->request->data('re-password')) {
						$this->Flash->set('Confirm password wrong, please check !');
					}
					else{
						$this->User->create();
						$passwordHasher = new BlowfishPasswordHasher();
						$this->User->set(array(
								'name' => $this->request->data('name'),
								'age' => $this->request->data('age'),
								'email' => $this->request->data('email'),
								'gender' => $this->request->data('gender'),
								'role' => 0,
								'password' => $passwordHasher->hash($this->request->data('password')),
							)
						);
						if ($this->User->save()) {
					        $this->Flash->success('Register successfully!', array(
							    'key' => 'success_msg',
							));
					    }
						$this->redirect('/users/login');
					}
				}
			}
		}

		public function login(){
			$this->layout = 'master';
			$this->set('categoriess', array_chunk($this->Category->find('all'),4));
			$this->set('yearss', array_chunk($this->Film->query("SELECT DISTINCT release_year FROM films"),4));
			$this->set('new_films', $this->Film->find('all', array(
						"fields" => array("Film.id, Film.name"),
			        	"order" => array("Film.created_at" => "desc"),
			        	"limit" => 4,
						'recursive' => -1
					)
				)
			);
			$this->User->set($this->request->data);
			if(AuthComponent::user()){
				$this->redirect('/pages/index');
			}
			if ($this->request->is('post')) {
				if($this->User->valid_login() == false)
			        $this->set('errorss', $this->User->validationErrors);
			    else{
			    	if ($this->Auth->login()) {
        				return $this->redirect($this->Auth->redirectUrl());
            		}
            	$this->Flash->danger('Invalid username or password, login failed!', array(
							    'key' => 'danger_msg',
							));
			    }
    		}
		}
		public function comment(){
        	$this->autoRender = false;
        	if($this->request->is('ajax')){
        		$this->Post->create();
        		$this->Post->set(array(
        			'user_id' => $this->request->data('user_id'),
        			'film_id' => $this->request->data('film_id'),
        			'content' => $this->request->data('content')
        			));
        		$this->Post->save();
        		$post = $this->Post->find('first', array(
        				'conditions' => array('Post.id' => $this->Post->id),
        			)
        		);
        		if ($post) {
        			return json_encode($post);
        		} else {
        			$data = [
	        			'error' => true,
	        			'error_msg' => 'Could not send comment.'
	        		];
        			return json_encode($data);
        		}
        	}
        }

        public function updateCmt(){
        	$this->autoRender = false;
        	if($this->request->is('ajax')){
                $user_id = $this->request->data('user_id');
                $film_id = $this->request->data('film_id');
                $content = $this->request->data('content');
                $post_id = $this->request->data('post_id');
                $now = new DateTime();
                $updated_time = $now->format('Y-m-d H:i:s');
                $update_content = $this->Post->find("first", array(
                		'conditions' => array(
                			'Post.id' => $post_id,
	                		'Post.user_id' => $user_id, 
	                		'Post.film_id' => $film_id
                		),
                	)
                );
                $this->Post->read(null, $post_id);
                $this->Post->set(array(
                    		'content' => $content,
                    		'updated_at' => $updated_time
                    	));
                $this->Post->save();
                $post = $this->Post->find('first', array(
        				'conditions' => array('Post.id' => $post_id),
        			)
        		);
                if ($post) {
        			return json_encode($post);
        		} else {
        			$data = [
	        			'error' => true,
	        			'error_msg' => 'Could not update comment.'
	        		];
        			return json_encode($data);
        		}
            }

			
        }

		public function logout() {
			$this->autoRender = false;
    		return $this->redirect($this->Auth->logout());
		}
		
		public function admin_login()
		{
			$this->page = 'admin_login';
			$this->User->set($this->request->data);
			if ($this->request->is('post')) {
				if($this->User->valid_login() == false)
			        $this->set('errorss', $this->User->validationErrors);
			    else {
			    	if ($this->Auth->login() && (AuthComponent::user('role') == 1)) {
	    				return $this->redirect('/admin/users/show');
	        		}
	        		$this->Flash->danger("Invalid username or password , Or you don't have permission to login this page!", array(
							    'key' => 'danger_msg',
							));
			    }
			}
		}
		public function admin_chkEmailExisted()
		{
			$this->autoRender = false;
        	if($this->request->is('ajax')){
        		$u_email = $this->User->find('first', array(
        				'conditions' => array('User.email' => $this->request->data('u_email')),
        				'recursive' => -1
        			)
        		);
        		if ($u_email) {
        			$data = [
        				'check' => true,
        				'true_msg' => 'Email has been existed !'
        			];
        			return json_encode($data);
        		} else {
        			$data = [
	        			'check' => false,
	        			'false_msg' => 'Available email'
	        		];
        			return json_encode($data);
        		}
        	}
		}
		public function admin_add(){
			$this->layout = 'admin';
			if(AuthComponent::user('role')){
				$this->set('admin', AuthComponent::user());
			}
			if ($this->request->is('post')) {
				$u_email = $this->request->data('u_email');
				$chk_email = $this->User->find('first', array(
						'conditions' => array('User.email' => $u_email)
					)
				);
				if (!$chk_email) {
					$this->User->create();
					$passwordHasher = new BlowfishPasswordHasher();
	                $u_pass = $passwordHasher->hash($this->request->data('u_pass'));
					$data = $this->User->set(array(
		        			'name' => $this->request->data('u_name'),
		        			'email' => $u_email,
		        			'password' => $u_pass,
		        			'age' => $this->request->data('u_age'),
		        			'gender' => $this->request->data('u_gender'),
		        			'role' => $this->request->data('u_role'),
	        			)
		        	);
					if ($this->User->save($data)) {
						$this->redirect(array(
								'controller' => 'users',
								'action' => 'admin_show'
							)
						);
					}
				}
			}
		}
		public function admin_edit(){
			$this->layout = 'admin';
			if(AuthComponent::user('role')){
				$this->set('admin', AuthComponent::user());
			}
			$id = $this->params['pass'][0];
			$user = $this->User->find('first', array(
			       'conditions' => array('User.id' => $id),
			       'recursive' => -1,
			   	)
			);
			$this->set('user', $user);
			if ($this->request->is('post')) {
				$this->User->read(null, $id);
				$this->User->set(array(
						'role' => $this->request->data('role'),
						'updated_at' => date("Y-m-d H:i:s"),
	            	)
            	);
            	$this->User->save();
                $user = $this->User->find('first', array(
        				'conditions' => array('User.id' => $id),
        			)
        		);
        		if ($user) {
        			$this->set('user', $user);
		   			$this->Flash->success('Updated account successfully !', array(
						    'key' => 'success_msg',
						)
			   		);
        		}
			}
		}
		
		public function admin_show(){
			$this->layout = 'admin';
			if(AuthComponent::user('role')){
				$this->set('admin', AuthComponent::user());
			}
		    $this->set('users', $this->User->find('all'));

		}
		public function admin_delete($id){
			$this->User->delete($id);
			$this->redirect(array(
				'controller' => 'users',
				'confirm' => 'Are you sure?',
				'action' => 'admin_show'
			));
		}

		public function accept(){
			$this->autoRender = false;
			$user_id = $this->params['pass'][0];
			$id = $this->params['pass'][1];
			$user = $this->User->find('first', array('conditions' => array('User.id' => $user_id)));
			$gmail = $user['User']['email'];
			
			App::uses('CakeEmail', 'Network/Email');
			$email = new CakeEmail('gmail');
			$email->to($gmail);
			$email->from('huytb@tmh-techlab.vn');
			$email->subject('Film Hunter Notice');
			$email->send('Your request has been accept, we will add that film to our website, thank for your request!');

			$this->Request->delete($id);
			$this->redirect('/admin/films/request');
		}
		public function reject()
		{
			$this->autoRender = false;
			$user_id = $this->params['pass'][0];
			$id = $this->params['pass'][1];
			$user = $this->User->find('first', array('conditions' => array('User.id' => $user_id)));
			$gmail = $user['User']['email'];
			
			App::uses('CakeEmail', 'Network/Email');
			$email = new CakeEmail('gmail');
			$email->to($gmail);
			$email->from('huytb@tmh-techlab.vn');
			$email->subject('Film Hunter Notice');
			$email->send('Your request has been rejected because the movie was exist, please check!');
			$this->Request->delete($id);
			$this->redirect('/admin/films/request');
		}
	}
