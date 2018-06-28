<?php

App::uses('AppModel', 'Model');

class Tag extends AppModel {

    public $name = "Tag";
    public $hasAndBelongsToMany = array(
        'Film' =>
            array(
                'className' => 'Film',
                'joinTable' => 'film_tag',
                'foreignKey' => 'tag_id',
                'associationForeignKey' => 'film_id',
            )
    );
}