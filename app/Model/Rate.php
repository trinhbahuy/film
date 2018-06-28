<?php
App::uses('AppModel', 'Model');
class Rate extends AppModel {
    public $name = "Rate";
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

    public $virtualFields = array(
        'total_rate' => 'SUM(Rate.point)'
    );
}