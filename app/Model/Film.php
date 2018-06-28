<?php
App::uses('AppModel', 'Model');
class Film extends AppModel {
    public $name = "Film";
    public $hasAndBelongsToMany = array(
        'Category' =>
            array(
                'className' => 'Category',
                'joinTable' => 'category_film',
                'foreignKey' => 'film_id',
                'associationForeignKey' => 'category_id',
                'with' => 'CategoryFilm'
            ),
        'Tag' =>
            array(
                'className' => 'Tag',
                'joinTable' => 'film_tag',
                'foreignKey' => 'film_id',
                'associationForeignKey' => 'tag_id',
                'with' => 'FilmTag'
            )
    );

    public $hasMany = array(
        'Post' => array(
            'className' => 'Post'
                        )
    );

    public $validate = array(
        'name' => array(
            'rule' => 'isUnique',
            'message' => 'This username has already been taken.'
        )
    );
    public function string_limit_words($string, $word_limit)  {
        $words = explode(" ", $string);
        // get 1st word length
        $count = strlen($words[0]);
        $i = 0;
        $arr = array();
        // while total length is less then limit (you can add +$i to count whitespaces too)
        while ($count < $word_limit) {
            // add word to result
            $arr[] = $words[$i];
            $count += strlen($words[$i+1]);
            $i++;
        }
        return implode(" ", $arr)." ...";
    }
}