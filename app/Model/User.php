<?php
	App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');
	class User extends AppModel{
		public $name = 'User';

        public $hasMany = array(
        'Like' => array(
            'className' => 'Like'
                        ),
        'Post' => array(
            'className' => 'Post'
                        ),
        'Rate' => array(
            'className' => 'Rate'
                        ),
        'Favourite' => array(
            'className' => 'Favourite'
                        ),
        'Request' => array(
            'className' => 'Request'
                        )
                               );

		
        // public function beforeSave($options = array()){
        //     if (isset($this->data[$this->alias]['password'])) {
        //         $passwordHasher = new BlowfishPasswordHasher();
        //         $this->data[$this->alias]['password'] = $passwordHasher->hash(
        //         $this->data[$this->alias]['password']
        //                                                                      );
        //     }
        //     return true;
        // }

        public $validate = array();

        function valid_login(){
            $this->validate = array(
                'email' => array(
                    'email-rule1' => array(
                        'required' => true,
                        'rule' => array('email', true),
                        'message' => 'Please supply a valid email address.'
                    )
                ),
                'password' => array(
                        'required' => true,
                        'rule' => array('minLength', 6),
                        'message' => 'Password is minimum length of 6 characters'
                ),
            );
            if($this->validates($this->validate))
                return true;
            else
                return false;
        }

        function valid_register(){
            $this->validate = array(
                'name' => array(
                    'rule1' => array(
                        'required' => true,
                        'rule' => 'alphaNumeric',
                        'message' => 'Only alphabets and numbers allowed'
                    )
                ),
                'email' => array(
                    'rule1' => array(
                        'required' => true,
                        'rule' => array('email', true),
                        'message' => 'Please supply a valid email address.'
                    ),
                    'rule2' => array(
                        'required' => true,
                        'rule' => 'isUnique',
                        'message' => 'This email has already been taken.'
                    )
                ),
                'password' => array(
                        'rule1' => array(
                            'required' => true,
                            'rule' => array('minLength', 6),
                            'message' => 'Password is minimum length of 6 characters'
                        )
                    ),
                'age' => array(
                    'rule-1' => array(
                        'required' => true,
                        'rule' => array('comparison', '>=', 18),
                        'message' => 'Must be at least 18 years old to qualify.'
                    ),
                    'rule-2' => array(
                        'required' => true,
                        'rule' => 'numeric',
                        'message' => 'Only fill in number'
                    )
                ),
            );
            if($this->validates($this->validate))
                return true;
            else
                return false;
        }
    }