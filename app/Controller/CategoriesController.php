<?php
class CategoriesController extends AppController{
    public $helpers = array('Html', 'Form', 'Flash');
    public function admin_index(){
    	$this->layout = 'admin';
    	if(AuthComponent::user('role')){
			$this->set('admin', AuthComponent::user());
		}
    	$this->set('categories', $this->Category->find('all')); 
    }

    public function admin_add()
    {
    	$this->layout = 'admin';
    	if(AuthComponent::user('role')){
			$this->set('admin', AuthComponent::user());
		}
    	if ($this->request->is('post')) {
            $this->Category->create();
            if ($this->Category->save($this->request->data)) {
                $this->Flash->success(__('Your category has been saved.'));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Flash->error(__('Unable to add your category.'));
        }
    }
    public function admin_edit($id = null) {
    	$this->layout = 'admin';
    	if(AuthComponent::user('role')){
			$this->set('admin', AuthComponent::user());
		}
	    if (!$id) {
	        throw new NotFoundException(__('Invalid category'));
	    }

	    $cat = $this->Category->findById($id);
	    if (!$cat) {
	        throw new NotFoundException(__('Invalid category'));
	    }

	    if ($this->request->is(array('post', 'put'))) {
	        $this->Category->id = $id;
	        if ($this->Category->save($this->request->data)) {
	            $this->Flash->success(__('Your category has been updated.'));
	            return $this->redirect(array('action' => 'admin_index'));
	        }
	        $this->Flash->error(__('Unable to update your category.'));
	    }

	    if (!$this->request->data) {
	        $this->request->data = $cat;
	    }
	}
    
    public function admin_delete($id) {
    	if(AuthComponent::user('role')){
			$this->set('admin', AuthComponent::user());
		}
	    if ($this->request->is('get')) {
	        throw new MethodNotAllowedException();
	    }

	    if ($this->Category->delete($id)) {
	        $this->Flash->success(
	            __('The category with id: %s has been deleted.', h($id))
	        );
	    } else {
	        $this->Flash->error(
	            __('The category with id: %s could not be deleted.', h($id))
	        );
	    }

	    return $this->redirect(array('action' => 'admin_index'));
	}
}
