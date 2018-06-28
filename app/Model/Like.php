<?php
App::uses('AppModel', 'Model');
class Like extends AppModel {
    public $name = "Like";
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id'
        ),
        'Post' => array(
            'className' => 'Post',
            'foreignKey' => 'post_id'
        )
    );
}