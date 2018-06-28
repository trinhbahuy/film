<?php

App::uses('AppModel', 'Model');

class Category extends AppModel {
    public $name = "Category";

    public $hasAndBelongsToMany = array(
        'Film' =>
            array(
                'className' => 'Film',
                'joinTable' => 'category_film',
                'foreignKey' => 'category_id',
                'associationForeignKey' => 'film_id',
            )
    );
    public $validate = array(
        'category_name' => array(
            'rule' => 'notBlank'
        )
    );
}