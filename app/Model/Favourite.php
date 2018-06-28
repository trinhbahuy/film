<?php

App::uses('AppModel', 'Model');

class Favourite extends AppModel {
    public $name = "Favourite";
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

}