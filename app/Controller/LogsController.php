<?php
App::uses('Recommend', 'Vendor');
class LogsController extends AppController{
    public $name = 'Logs';
    public $uses = array('Log','User','Rate','Film');
    public $helpers = array('Form', 'Html');

    public function test(){
        $this->autoRender = false;
        $films = array();
        $re = new Recommend();

        //pr($this->Log->find('all', array('conditions' => array('Log.user_name' => 'huy'))));
        $user_names = $this->Log->find('all', array('fields' => array('DISTINCT Log.user_name')));
        foreach ($user_names as $user_name){
            $films[$user_name['Log']['user_name']] = array();
            $cares = $this->Log->find('all', array('conditions' => array('Log.user_name' => $user_name['Log']['user_name'])));
            foreach ($cares as $care){
                $films[$user_name['Log']['user_name']][$care['Log']['film_name']] = $care['Log']['rate'];
            }
        }
        pr($films);
        pr($re->getRecommendations($films, "new user 24"));
    }
    public function write(){
        $this->autoRender = false;
        $user_id = $this->request->data('user_id');
        $film_id = $this->request->data('film_id');
        $user_name = $this->User->findById($user_id)['User']['name'];
        $film_name = $this->Film->findById($film_id)['Film']['name'];
        $seen = $this->Log->find("first", array('conditions' => array('Log.user_id' => $user_id, 'Log.film_id' => $film_id)));
        $rate = $this->request->data('point')?$this->request->data('point'):$this->Rate->find("first", array('conditions' => array('Rate.user_id' => $user_id, 'Rate.film_id' => $film_id)))['Rate']['point'];
        $play = $this->request->data('play')?1:'';
        if($user_id) {
            if($seen){
//                pr($seen);
//                exit;
                $this->Log->read(null, $seen['Log']['id']);
                if($seen['Log']['play'])
                    $this->Log->set(array(
                        'rate' => $rate,
                    ));
                else
                    $this->Log->set(array(
                        'rate' => $rate,
                        'play' => $play,
                    ));
                $this->Log->save();
            }
            else {
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