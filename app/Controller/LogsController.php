<?php

class LogsController extends AppController{
    public $name = 'Logs';
    public $uses = array('Log','User','Rate','Film');
    public $helpers = array('Form', 'Html');

    public function write(){
        $this->autoRender = false;
        $user_id = $this->request->data('user_id');
        $user_name = $this->User->findById($user_id)['User']['name'];
        $film_id = $this->request->data('film_id');
        $film_name = $this->Film->findById($film_id)['Film']['name'];
        $rate = $this->Rate->find("first", array('conditions' => array('Rate.user_id' => $user_id, 'Rate.film_id' => $film_id)))['Rate']['point'];
        $this->Log->create();
        $this->Log->set(array(
                'user_id' => $user_id,
                'user_name' => $user_name,
                'film_id' => $film_id,
                'film_name' => $film_name,
                'rate' => $rate,
                'date' => date("Y-m-d"),
            )
        );
        $this->Log->save();
    }
}
?>