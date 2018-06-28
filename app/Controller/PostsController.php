<?php
	class PostsController extends AppController{
		public $name = 'Posts';
		public $uses = array('User','Post', 'Film');
		public $helpers = array('Form', 'Html');

		public function test(){
            $this->autoRender = false;
            $data = $this->Post->find("all");
            pr($data);
        }
		
		
		
		public function admin_index(){
			$this->layout = 'admin';
			$data = $this->Post->find('all');
			if(AuthComponent::user('role')){
				$this->set('admin', AuthComponent::user());
			}
			else 
				$this->redirect('/pages/index');
		    $this->set('posts',$data);
		}
		public function admin_delete($id){
			$this->Post->delete($id);
			if(AuthComponent::user('role')){
				$this->set('admin', AuthComponent::user());
			}
			$this->redirect(array(
				'controller' => 'posts',
				'confirm' => 'Are you sure to delete this post?',
				'action' => 'admin_index'
			));
		}
	}