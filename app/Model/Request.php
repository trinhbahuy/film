<?php
App::uses('AppModel', 'Model');
class Request extends AppModel {
    public $name = "Request";
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id'
        )
    );
}