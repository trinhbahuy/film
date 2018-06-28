<?php
	class RatesController extends AppController{
		public $name = 'Rates';
		public $uses = array('User','Rate','Film');
		public $helpers = array('Form', 'Html');

		public function test(){
            $this->autoRender = false;
            $film_is_rated = $this->Film->find("first", array('conditions' => array('Film.id' => 1)));
            pr($film_is_rated);
        }

        public function rating(){
        	$this->autoRender = false;
        	if($this->request->is('ajax')){
                $rated = $this->Rate->find("first", array('conditions' => array('Rate.user_id' => $this->request->data('user_id'), 'Rate.film_id' => $this->request->data('film_id'))));
                if($rated['User']['name'] != null){
                    $this->Rate->read(null, $rated['Rate']['id']);
                    $this->Rate->set(array(
                        'point' => $this->request->data('point')
                        ));
                    $this->Rate->save();
                    $film_is_rated = $this->Film->find("first", array('conditions' => array('Film.id' => $this->request->data('film_id'))));
                    $this->Film->read(null, $this->request->data('film_id'));
                    $total = $this->Rate->find('all', array('fields' => array('total_rate'), 'conditions'=>array('Rate.film_id'=> $this->request->data('film_id'))));
                    $this->Film->set(array(
                        'average_rate' => round($total['0']['Rate']['total_rate']/$film_is_rated['Film']['rated'])
                        ));
                    $this->Film->save();

                }
                else{
            		$this->Rate->create();
            		$this->Rate->set(array(
            			'user_id' => $this->request->data('user_id'),
            			'film_id' => $this->request->data('film_id'),
            			'point' => $this->request->data('point')
            			));
            		$this->Rate->save();
            		// luu nguoi dung, phim va diem dc rate
            		$film_is_rated = $this->Film->find("first", array('conditions' => array('Film.id' => $this->request->data('film_id'))));
            		$this->Film->read(null, $this->request->data('film_id')); // lay phim voi id de update
                    $total = $this->Rate->find('all', array('fields' => array('total_rate'), 'conditions'=>array('Rate.film_id'=> $this->request->data('film_id'))));
                    $rated = $film_is_rated['Film']['rated'] + 1;
            		$this->Film->set(array(
            			'rated' => $rated,
                        'average_rate' => round($total['0']['Rate']['total_rate']/$rated)
            			));
            		$this->Film->save();

                    
                    if ($rated) {
                        return $rated;
                    } else {
                        $data = [
                            'error' => true,
                            'error_msg' => 'Could not rate film'
                        ];
                        return json_encode($data);
                    }
            		// dem so lan phim duoc rate
                }
        	}
        }
	}