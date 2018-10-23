<?php

class LogsController extends AppController{
    public $name = 'Logs';
    public $uses = array('Log','User','Rate','Film');
    public $helpers = array('Form', 'Html');

    public function write(){
        $this->autoRender = false;
        $user_id = $this->request->data('user_id');
        $film_id = $this->request->data('film_id');
        $user_name = $this->User->findById($user_id)['User']['name'];
        $film_name = $this->Film->findById($film_id)['Film']['name'];
        $seen = $this->Log->find("first", array('conditions' => array('Log.user_id' => $user_id, 'Log.film_id' => $film_id)));
        if($user_id) {
            if($seen){
//                pr($seen);
//                exit;
                $this->Log->read(null, $seen['Log']['id']);
                $this->Log->set(array(
                    'rate' => $this->request->data('point'),
                    'play' => $this->request->data('play')?1:0,
                ));
                $this->Log->save();
            }
            else {
                $rate = $this->Rate->find("first", array('conditions' => array('Rate.user_id' => $user_id, 'Rate.film_id' => $film_id)))['Rate']['point'];
                $play = $this->request->data('play')?1:0;
                $this->Log->create();
                $this->Log->set(array(
                        'user_id' => $user_id,
                        'user_name' => $user_name,
                        'film_id' => $film_id,
                        'film_name' => $film_name,
                        'rate' => $rate,
                        'play' => $play,
                        'date' => date("Y-m-d"),
                    )
                );
                $this->Log->save();
            }
        }
    }
}
?>