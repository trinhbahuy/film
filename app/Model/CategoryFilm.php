<?php

App::uses('AppModel', 'Model');

class CategoryFilm extends AppModel {
	public $name = 'CategoryFilm';
	public $useTable = 'category_film';

	public $hasMany = array(
        'Film' => array(
            'className' => 'Film',
            'foreignKey' => 'film_id'
        )
    );
}