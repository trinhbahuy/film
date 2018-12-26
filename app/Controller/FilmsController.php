<?php 
	class FilmsController extends AppController
	{
		public function test(){
			$this->autoRender = false;
			$a = $this->Film->find('all');
			//pr($a);
		}
		public $name = 'Films';
		public $components = array('Session');
		public $uses = array('Film','Category','Request', 'Tag');
		public $helpers = array('Form', 'Html', 'Paginator');
		public $paginate = array();

		public function beforeFilter() {
		    parent::beforeFilter();
		    $this->Auth->allow('search', 'category', 'year', 'preview', 'view', 'tag');
		}
		
		public function admin_chkNameExisted()
		{
			$this->autoRender = false;
        	if($this->request->is('ajax')){
        		$film_name = $this->Film->find('first', array(
        				'conditions' => array('Film.name' => $this->request->data('film_name')),
        				'recursive' => -1
        			)
        		);
        		if ($film_name) {
        			$data = [
        				'check' => true,
        				'true_msg' => 'Film name has been existed !'
        			];
        			return json_encode($data);
        		} else {
        			$data = [
	        			'check' => false,
	        			'false_msg' => 'Available name'
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
			else 
				$this->redirect('/pages/index');
			$data = [];
			$uploadData = '';
			$this->set('categories', $this->Category->find('all'));
			$this->set('tags', $this->Tag->find('all'));
			if ($this->request->is('post')) {
				if ($this->Film->validates() == false) {
				    $errors = $this->Film->validationErrors;
				    $this->set('errorss', $errors);
				} else {
					$this->Film->create();
					if(!empty(($this->request->data['Film']['avatar']['name'])&&($this->request->data['Film']['movie']['name']))){
						$fileNameAvatar = $this->request->data['Film']['avatar']['name'];
						$fileNameMovie = $this->request->data['Film']['movie']['name'];
		                $uploadPathAvatar = WWW_ROOT . 'img/film_avatar/';
		                $uploadPathMovie = WWW_ROOT . 'movie/';
		                $uploadFileAvatar = $uploadPathAvatar.$fileNameAvatar;
		                $uploadFileMovie = $uploadPathMovie.$fileNameMovie;
		                if (file_exists($uploadFileAvatar&&$uploadFileMovie)) {
					    	$filenameavatar = $this->request->data['Film']['avatar']['name'];
					    	$filenamemovie = $this->request->data['Film']['movie']['name'];
							$extavatar = strtolower(substr(strrchr($filenameavatar, '.'), 1));
							$extmovie = strtolower(substr(strrchr($filenamemovie, '.'), 1));
							$avatar_name = $filenameavatar . '.' . $extavatar;
							$movie_name = $filenamemovie . '.' . $extmovie;
							$uploadFileAvatar = $uploadPathAvatar.$avatar_name;
							$uploadFileMovie = $uploadPathAvatar.$movie_name;
							move_uploaded_file($this->request->data['Film']['avatar']['tmp_name'], $uploadFileAvatar);
							move_uploaded_file($this->request->data['Film']['movie']['tmp_name'], $uploadFileMovie);
					    }
						else{
							 move_uploaded_file($this->request->data['Film']['avatar']['tmp_name'],$uploadFileAvatar);
			                move_uploaded_file($this->request->data['Film']['movie']['tmp_name'],$uploadFileMovie);
			                $this->set('uploadData', $uploadData);
				         	
			            }
		               
		            }
		            
					else{
		                $this->Flash->error(__('Please choose a file to upload.'));
		            }
		            $data = $this->Film->set(array(
	        			'name' => $this->request->data('name'),
	        			'content' => $this->request->data('content'),
	        			'avatar' => $this->request->data['Film']['avatar']['name'],
	        			'movie' => $this->request->data['Film']['movie']['name'],
	        			'IMDb' => $this->request->data('imdb'),
	        			'release_year' => $this->request->data('release_year')
	        			)
		        	);
		            $data = $this->Film->save($data);
		            $film_id = $data['Film']['id'];
		            $this->loadModel('CategoryFilm');

		            $cate = $this->request->data['categories'];
		            foreach ($cate as $value) {
		            	$this->CategoryFilm->create();
		            	$cates = [
		            			'film_id' => $film_id,
		            			'category_id' => $value
		            		];
		            	 $this->CategoryFilm->save($cates);
		            }
		            $this->loadModel('FilmTag');
		            $tags_input = strtolower($this->request->data['Tag']['tag_name']);
					$tags = explode(',', $tags_input);
					foreach ($tags as $tag) {
						$tag_id = $this->Tag->find('first', array(
					       	'conditions' => array('Tag.tag_name' => $tag)
					   		)
					   	);
						if (count($tag_id) == 0) {
							$this->Tag->create();
							$tag_name = $this->Tag->set(array(
				            		'tag_name' => $tag
				            	)
				            );
				            $this->Tag->save($tag_name);
				            $new_tag = $this->Tag->id;
				            $this->FilmTag->create();
				            $film_tag = [
				            	'film_id' => $film_id,
				            	'tag_id' => $new_tag
				            ];
						} else {
				            $this->FilmTag->create();
				            $film_tag = [
				            	'film_id' => $film_id,
				            	'tag_id' => $tag_id['Tag']['id']
				            ];
						}
			           	$this->FilmTag->save($film_tag);
					}
					
		    	}
		    	$this->redirect('/admin/films/show');      
			}
		}
		public function editavatar(){
			$this->autoRender = false;
			$avatar = $this->request->data['Film']['avatar']['name'];
			$uploadData = '';
						$fileNameAvatar = $this->request->data['Film']['avatar']['name'];
		                $uploadPathAvatar = WWW_ROOT . 'img/film_avatar/';
		                $uploadFileAvatar = $uploadPathAvatar.$fileNameAvatar;
		                if (file_exists($uploadFileAvatar)) {
					    	$filename = $this->request->data['Film']['avatar']['name'];
							$ext = strtolower(substr(strrchr($filename, '.'), 1));
							$image_name = $filename . '.' . $ext;
							$uploadFileAvatar = $uploadPathAvatar.$image_name;
							move_uploaded_file($this->request->data['Film']['avatar']['tmp_name'], $uploadFileAvatar);
					    }
						else{
							 move_uploaded_file($this->request->data['Film']['avatar']['tmp_name'],$uploadFileAvatar);
			                
			            }
		            

		}
		public function editmovie(){
			$this->autoRender = false;
			$movie  = $this->request->data['Film']['movie']['name'];
			$uploadData = '';
						$fileNameMovie = $movie ;
		                $uploadPathMovie = WWW_ROOT . 'movie/';
		                $uploadFileMovie = $uploadPathMovie.$fileNameMovie;
		                if (file_exists($uploadFileMovie)) {
					    	$filename = $this->request->data['Film']['movie']['name'];
							$ext = strtolower(substr(strrchr($filename, '.'), 1));
							$movie_name = $filename . '.' . $ext;
							$uploadFileMovie = $uploadPathMovie.$movie_name;
							move_uploaded_file($this->request->data['Film']['movie']['tmp_name'], $uploadFileMovie);
					    }
						else{
			                move_uploaded_file($this->request->data['Film']['movie']['tmp_name'],$uploadFileMovie);
			                
			            }
		            
		}
		public function admin_chkUniqueName()
		{
			$this->autoRender = false;
        	if($this->request->is('ajax')){
        		$film_id = $this->request->data('film_id');
        		$film_name = $this->Film->find('first', array(
        				'conditions' => array(
        					'Film.name' => $this->request->data('film_name'),
        					'Film.id !=' => $film_id  
        				),
        				'recursive' => -1
        			)
        		);
        		if ($film_name) {
        			$data = [
        				'check' => true,
        				'true_msg' => 'Film name has been existed !'
        			];
        			return json_encode($data);
        		} else {
        			$data = [
	        			'check' => false,
	        			'false_msg' => 'Available name'
	        		];
        			return json_encode($data);
        		}
        	}
		}
		public function admin_edit(){
			$this->layout = 'admin';
			if(AuthComponent::user('role')){
				$this->set('admin', AuthComponent::user());
			} else {
				$this->redirect('/pages/index');
			}
			$id = $this->params['pass'][0];
			$film = $this->Film->find('first', array(
			       'conditions' => array('Film.id' => $id)
			   	)
			);
		   	//set data out view
			$this->set('film', $film);
			$this->set("cates", $film['Category']);
		   	$this->set('categories', $this->Category->find('all'));
		   	$this->set("selected_tags", $film['Tag']);
		   	$this->set('tags', $this->Tag->find('all'));
			//handling form edit
			$data = [];
			$uploadData = '';
			$this->set('categories', $this->Category->find('all'));
			if ($this->request->is('post')) {
				//ghi de du lieu
				$this->Film->read(null, $id);
				$this->Film->create();
				//xu ly file
				$avatar = $this->request->data['Film']['avatar']['name'];
				$movie  = $this->request->data['Film']['movie']['name'];
				$data = $this->Film->set(array(
		            	'id' => $id,
	        			'name' => $this->request->data('name'),
	        			'content' => $this->request->data('content'),
	        			'IMDb' => $this->request->data('imdb'),
		        		'release_year' => $this->request->data('release_year')
		        	)
				);
				if (!empty($avatar)&&empty($movie)) {
					$this->editavatar();
					$data = $this->Film->set(array(
	        		'avatar' => $avatar,
	        	));
				}elseif (empty($avatar)&&!empty($movie)) {
					$this->editmovie();
					$data = $this->Film->set(array(
	        		'movie' => $movie
	        	));
				}elseif (!empty($avatar) && !empty($movie)) {
					$this->editavatar();
					$this->editmovie();
					$data = $this->Film->set(array(
	        		'avatar' => $avatar,
	        		'movie' => $movie
	        	));
				} else {
					$data = $this->Film->set(array(
			            	'id' => $id,
		        			'name' => $this->request->data('name'),
		        			'content' => $this->request->data('content'),
		        			'IMDb' => $this->request->data('imdb'),
			        		'release_year' => $this->request->data('release_year'), 
			        	)
					);
				}
		      	$this->Film->id = $id;
	            $this->Film->save($data);
	            $this->loadModel('CategoryFilm');
				$this->CategoryFilm->deleteAll(array('CategoryFilm.film_id' => $id));
	            $cate = $this->request->data['categories'];
	            foreach ($cate as $value) {
	            	$this->CategoryFilm->create();
	            	$cates = [
	            			'film_id' => $id,
	            			'category_id' => $value
	            		];
	            	 $this->CategoryFilm->save($cates);
	            }
	            $tag = $this->request->data('tags');
	            $this->loadModel('FilmTag');
				$this->FilmTag->deleteAll(array('FilmTag.film_id' => $id));
	            if(count($tag) > 0) {
		            foreach ($tag as $value) {
		            	$this->FilmTag->create();
		            	$tags = [
		            			'film_id' => $id,
		            			'tag_id' => $value
		            		];
		            	$this->FilmTag->save($tags);
		            }
		        }
	    	 	$this->redirect('/admin/films/show');
		    }	
		}

		public function admin_show(){
			$this->layout = 'admin';
			if(AuthComponent::user('role')){
				$this->set('admin', AuthComponent::user());
			}
			else{
				$this->redirect('/pages/index'); 
			}
			$data = $this->Film->find('all', array('order'=>array('Film.id'=>'desc')));
			$this->set('films', $data);
		}
		public function admin_delete($id){
			$this->autoRender = false;
			$this->Film->delete($id);
			$data = $this->loadModel('CategoryFilm');
			$film_id = $data['CategoryFilm']['film_id'];
			$this->CategoryFilm->delete('all', array('conditions' => array('CategoryFilm.film_id' => $film_id)));
			$this->redirect(array(
				'controller' => 'films',
				'action' => 'admin_show'
			));
			
		}

		public function save_request(){
			$this->autoRender = false;
			if($this->request->is('post')){
				$this->Request->create();
				$this->Request->set(
					array(
						'request_name' => $this->request->data('request_name'),
						'user_id' => AuthComponent::user('id')
				));
			if ($this->Request->save()) {
		        $this->Flash->success('Your request has been sent successfully !', array(
				    'key' => 'success_msg',
				));
		    }
		    $this->redirect('/pages/index');
			}
		}
		public function admin_request(){
			$this->layout = 'admin';
			if(AuthComponent::user('role')){
				$this->set('admin', AuthComponent::user());
			}
			else 
				$this->redirect('/pages/index');
			$this->set('requests', $this->Request->find('all'));
		}

		
		public function view(){
			$this->autoRender = false;
			if($this->request->is('ajax')){
				$this->Film->read(null, $this->request->data('film_id'));
				$this->Film->set(array(
					'views' => $this->request->data('views')
				));
				$this->Film->save();
			}
		}


	    public function tag($id = null)
	    {
	    	$this->layout = 'master';
			$this->set('categoriess', array_chunk($this->Category->find('all'),4));
			$this->set('yearss', array_chunk($this->Film->query("SELECT DISTINCT release_year FROM films ORDER BY release_year desc"),4));
			$this->set('new_films', $this->Film->find('all', array(
						"fields" => array("Film.id, Film.name"),
			        	"order" => array("Film.created_at" => "desc"),
			        	"limit" => 4,
						'recursive' => -1
					)
				)
			);
	        if (!$id) {
	            throw new NotFoundException(__('Invalid film'));
	        } 
	        $tag = $this->Tag->findById($id);

			$options['joins'] = array(
			    array('table' => 'film_tag',
			        'alias' => 'FilmTag',
			        'type' => 'inner',
			        'conditions' => array(
			            'Film.id = FilmTag.film_id'
			        )
			    ),
			    array('table' => 'tags',
			        'alias' => 'Tag',
			        'type' => 'inner',
			        'conditions' => array(
			            'FilmTag.tag_id = Tag.id'
			        )
			    )
			);

			$options['conditions'] = array(
			    'Tag.id' => $tag['Tag']['id']
			);

			$films = $this->Film->find('all', $options);
	        $this->set('films', $films);
	        $this->set('tag', $tag);
	    }
	}


 ?>
