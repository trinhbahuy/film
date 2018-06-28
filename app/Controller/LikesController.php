<?php

	class LikesController extends AppController{
		public $name = 'Likes';
		public $helpers = array('Form', 'Html');

		public function test(){
            $this->autoRender = false;
            $data = $this->Like->find("all");
            $this->loadModel('Category');
            //$data = $this->Category->find("all");
            pr($data);
        }
	}
?>