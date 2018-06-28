<?php
	class FavouriteController extends AppController{
		public $name = 'Favourite';
		public $helpers = array('Form', 'Html');

		public function test(){
            $this->autoRender = false;
            $data = $this->Favourite->find("all");
            pr($data);
            //////////
        }

        public function like(){
            $this->autoRender = false;
            if($this->request->is('ajax')){
                $user_id = $this->request->data('user_id');
                $film_id = $this->request->data('film_id');
                $this->Favourite->create();
                $this->Favourite->set(array(
                    'user_id' => $user_id,
                    'film_id' => $film_id,
                    'favourite' => 1
                    )
                );
                $this->Favourite->save();
                $favourite_id = $this->Favourite->id;
                if ($favourite_id) {
                    return favourite_id;
                } else {
                    $data = [
                        'error' => true,
                        'error_msg' => 'Could not rate film'
                    ];
                    return json_encode($data);
                }
            }
        }
        public function dislike(){
        	$this->autoRender = false;
        	if($this->request->is('ajax')){
                $user_id = $this->request->data('user_id');
                $film_id = $this->request->data('film_id');
                $film_is_disliked = $this->Favourite->find("first", array('conditions' => array('Favourite.user_id' => $user_id, 'Favourite.film_id' => $film_id)));
                $this->Favourite->read(null, $film_is_disliked['Favourite']['id']); // lay phim voi id de update
                $this->Favourite->set(array(
                    'favourite' => 0
                    ));
                $this->Favourite->save();
                if ($film_is_disliked) {
                    return film_is_disliked;
                } else {
                    $data = [
                        'error' => true,
                        'error_msg' => 'Could not rate film'
                    ];
                    return json_encode($data);
                }
        	}
        	
        }

        public function like_again(){
            $this->autoRender = false;
            if($this->request->is('ajax')){
                $user_id = $this->request->data('user_id');
                $film_id = $this->request->data('film_id');
                $film_is_liked = $this->Favourite->find("first", array('conditions' => array('Favourite.user_id' => $user_id, 'Favourite.film_id' => $film_id)));
                $this->Favourite->read(null, $film_is_liked['Favourite']['id']); // lay phim voi id de update
                $this->Favourite->set(array(
                    'favourite' => 1
                    ));
                $this->Favourite->save();

                $like_again_id = $this->Favourite->id;
                if ($like_again_id) {
                    return like_again_id;
                } else {
                    $data = [
                        'error' => true,
                        'error_msg' => 'Could not rate film'
                    ];
                    return json_encode($data);
                }
            }
        }

        public function remove(){
            $this->autoRender = false;
        }
	}