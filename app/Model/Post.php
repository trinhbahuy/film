<?php
App::uses('AppModel', 'Model');
class Post extends AppModel {
    public $name = "Post";
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id'
        ),
        'Film' => array(
            'className' => 'Film',
            'foreignKey' => 'film_id'
        )
    );
    public $hasMany = array(
        'Like' => array(
            'className' => 'Like'
        )
    );
}