<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

App::uses('AppController', 'Controller');
App::uses('Recommend', 'Vendor');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link https://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $helpers = array('Paginator','Html');
	public $paginate = array(
        'limit' => 4
    	);
	public $uses = array('Category','Film','Rate','Favourite', 'Post', 'User', 'Request','Log');

/**
 * Displays a view
 *
 * @return CakeResponse|null
 * @throws ForbiddenException When a directory traversal attempt.
 * @throws NotFoundException When the view file could not be found
 *   or MissingViewException in debug mode.
 */
	public function display() {
		$path = func_get_args();

		$count = count($path);
		if (!$count) {
			return $this->redirect('/');
		}
		if (in_array('..', $path, true) || in_array('.', $path, true)) {
			throw new ForbiddenException();
		}
		$page = $subpage = $title_for_layout = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title_for_layout = Inflector::humanize($path[$count - 1]);
		}
		$this->set(compact('page', 'subpage', 'title_for_layout'));

		try {
			$this->render(implode('/', $path));
		} catch (MissingViewException $e) {
			if (Configure::read('debug')) {
				throw $e;
			}
			throw new NotFoundException();
		}
	}
	
	public function beforeFilter() {
		    parent::beforeFilter();
		    $this->Auth->allow('index', 'movie', 'topviews');
	}

	public function index(){
		$this->layout = 'master';
		$films = $this->Film;
		$categories = $this->Category;
		$this->set('new_films', $this->Film->find('all', array(
					"fields" => array("Film.id, Film.name"),
		        	"order" => array("Film.created_at" => "desc"),
		        	"limit" => 4,
					'recursive' => -1
				)
			)
		);
		$pagi = $this->paginate('Film');
		$this->set('categoriess', array_chunk($categories->find('all'),4));
		$this->set('films', $pagi);
		$this->set('yearss', array_chunk($films->query("SELECT DISTINCT release_year FROM films ORDER BY release_year desc"),4));
		$this->set('top_views', $films->find('all', array(
					'order' => array('Film.views' => 'desc'), 
					'limit' => 4
				)
			)	
		);
	}

    public function recommend($person){
        $films = array();
        $re = new Recommend();

        //pr($this->Log->find('all', array('conditions' => array('Log.user_name' => 'huy'))));
        $user_names = $this->Log->find('all', array('fields' => array('DISTINCT Log.user_name')));
        foreach ($user_names as $user_name){
            $films[$user_name['Log']['user_name']] = array();
            $cares = $this->Log->find('all', array('conditions' => array('Log.user_name' => $user_name['Log']['user_name'])));
            foreach ($cares as $care){
                $films[$user_name['Log']['user_name']][$care['Log']['film_name']] = $care['Log']['rate'];
            }
        }
        //pr($films);
        $rev1 = $re->getRecommendations($films, $person);
        $re_final = array();
        foreach ($rev1 as $film=>$rate){
            array_push($re_final, $this->Film->find('first', array('conditions' => array('Film.name' => $film))));
        }
        return $re_final;
    }

	public function movie(){
		$this->layout = 'master';
		$id = $this->params['pass'][0];
		$this->set('categoriess', array_chunk($this->Category->find('all'),4));
		$this->set('yearss', array_chunk($this->Film->query("SELECT DISTINCT release_year FROM films ORDER BY release_year desc"),4));
		$this->set('film',$this->Film->find('first', array('conditions' => array('Film.id' => $id))));
		$this->set('top_rates', $this->Film->find('all', array(
					'order' => array('Film.rated' => 'desc'), 
					'limit' => 3
				)
			)
		);
		$this->set('top_views', $this->Film->find('all', array(
					'order' => array('Film.views' => 'desc'), 
					'limit' => 4
				)
			)	
		);
		$this->set('recommands', $this->recommend(AuthComponent::user('name')));
//        $this->set('random_films', $this->Film->find('all', array(
//                'order' => 'rand()',
//                'limit' => 4,
//            )
//        )
//        );
		$this->set('new_films', $this->Film->find('all', array(
					"fields" => array("Film.id, Film.name"),
		        	"order" => array("Film.created_at" => "desc"),
		        	"limit" => 4,
					'recursive' => -1
				)
			)
		);
		$this->set('favourites', $this->Favourite->find('count', array( 
				   'conditions' => array(
				   		'Favourite.film_id' => $id,
				   		'Favourite.favourite <>' => 0 
				   	),
				)
			)
		);

		$this->set('average_rate', $this->Film->find('first', array('conditions' => array('Film.id' => $id))));
		$this->set('favourite', $this->Favourite->find('first', array('conditions' => array('Favourite.film_id' => $id, 'Favourite.user_id' => AuthComponent::user('id')))));
		
		$this->paginate = array(
	        'conditions' => array('Post.film_id =' => $id),
	        'limit' => 5,
	        'order' => array('Post.created_at' => 'desc')
	    );
	    $posts = $this->paginate('Post');
	    // pass the value to our view.ctp
	    $this->set('posts', $posts);
	}	
	
	public function topviews(){
		$this->layout = 'master';
		$this->paginate = array(
	        'limit' => 4,
	        'order' => array('Film.views' => 'desc')
	    );
		$top_views = $this->paginate('Film');
		$this->set('new_films', $this->Film->find('all', array(
					"fields" => array("Film.id, Film.name"),
		        	"order" => array("Film.created_at" => "desc"),
		        	"limit" => 4,
					'recursive' => -1
				)
			)
		);

		$this->set('categoriess', array_chunk($this->Category->find('all'),4));
		$this->set('yearss', array_chunk($this->Film->query("SELECT DISTINCT release_year FROM films ORDER BY release_year desc"),4));
	    $this->set('top_views', $top_views);
	}
    public function search()
    {
        $this->layout = 'master';
        $this->set('new_films', $this->Film->find('all', array(
                "fields" => array("Film.id, Film.name"),
                "order" => array("Film.created_at" => "desc"),
                "limit" => 4,
                'recursive' => -1
            )
        )
        );
        $this->set('categoriess', array_chunk($this->Category->find('all'),4));
        $this->set('yearss', array_chunk($this->Film->query("SELECT DISTINCT release_year FROM films"),4));

        if ($this->request->is('post')) {
            $searchstr = $this->request->data['Film']['search'];
            if ($searchstr != '') {
                $results = $this->Film->find('count', array(
                        'conditions' => array(
                            'or' => array(
                                "Film.name LIKE" => "%$searchstr%",
                                "Film.content LIKE" => "%$searchstr%",
                                "Film.director LIKE" => "%$searchstr%",
                                "Film.release_year LIKE" => "%$searchstr%",
                            )
                        )
                    )
                );
                if ($this->Session->check('searchstr') && $this->Session->check('results')) {
                    $this->Session->delete('searchstr');
                    $this->Session->delete('results');
                    $this->Session->write('searchstr', $searchstr);
                    $this->Session->write('results', $results);
                }
            } else {
                $this->redirect('/pages/index');
            }
        }
        if ($this->Session->check('searchstr') && $this->Session->check('results')) {
            $searchstr = $this->Session->read('searchstr');
            $results = $this->Session->read('results');
        }

        if ($searchstr != '') {
            $this->paginate = array(
                'conditions' => array(
                    'or' => array(
                        "Film.name LIKE" => "%$searchstr%",
                        "Film.content LIKE" => "%$searchstr%",
                        "Film.director LIKE" => "%$searchstr%",
                        "Film.release_year LIKE" => "%$searchstr%",
                    )
                ),
                'limit' => 4
            );
            $this->Session->write('searchstr', $searchstr);
            $this->Session->write('results', $results);

            $films = $this->paginate('Film');
            $this->set('films', $films);
        }
    }
    public function category(){
        $this->layout = 'master';
        $id = $this->params['pass'][0];
        $this->set('new_films', $this->Film->find('all', array(
                "fields" => array("Film.id, Film.name"),
                "order" => array("Film.created_at" => "desc"),
                "limit" => 4,
                'recursive' => -1
            )
        )
        );
        $this->set('categoriess', array_chunk($this->Category->find('all'),4));
        $this->set('yearss', array_chunk($this->Film->query("SELECT DISTINCT release_year FROM films ORDER BY release_year desc"),4));
        $cate = $this->Category->find('all', array('conditions' => array('id' => $id)));
        $this->set('films_with_same_category', $cate[0]['Film']);
        $this->set('categories', $this->Category->find('all'));
    }

    public function year(){
        $this->layout = 'master';
        $year = $this->params['pass'][0];
        $this->set('new_films', $this->Film->find('all', array(
                "fields" => array("Film.id, Film.name"),
                "order" => array("Film.created_at" => "desc"),
                "limit" => 4,
                'recursive' => -1
            )
        )
        );
        $this->set('categoriess', array_chunk($this->Category->find('all'),4));
        $this->set('yearss', array_chunk($this->Film->query("SELECT DISTINCT release_year FROM films ORDER BY release_year desc"),4));
        $this->set('films_with_same_year', $this->Film->find("all", array("conditions" => array('Film.release_year' => $year))));
    }

    public function preview($id = null) {
        $this->layout = 'master';
        $this->set('categoriess', array_chunk($this->Category->find('all'),4));
        $this->set('yearss', array_chunk($this->Film->query("SELECT DISTINCT release_year FROM films ORDER BY release_year desc"),4));
        $this->set('new_films', $this->Film->find('all', array(
                "fields" => array("Film.id, Film.name"),
                "order" => array("Film.created_at" => "desc"),
                "limit" => 4,
                'recursive' => -1
            )
        )
        );
        if (!$id) {
            throw new NotFoundException(__('Invalid film'));
        }
        $film = $this->Film->findById($id);
        $cat_ids = $this->Film->find("all", array(
                "joins" => array(
                    array(
                        "table" => "category_film",
                        "alias" => "CategoryFilm",
                        "conditions" => array(
                            "Film.id = CategoryFilm.film_id"
                        )
                    )
                ),
                "conditions" => array("Film.id" => $id),
                "fields" => array("CategoryFilm.category_id"),
                "recursive" => -1
            )
        );
        foreach ($cat_ids as $item) {
            $ids[] = $item["CategoryFilm"]["category_id"];
        }

        foreach ($ids as $id) {
            $films = $this->Category->find("all", array(
                    "joins" => array(
                        array(
                            "table" => "category_film",
                            "alias" => "CategoryFilm",
                            "conditions" => array(
                                "Category.id = CategoryFilm.category_id"
                            )
                        ),
                        array(
                            "table" => "films",
                            "alias" => "Film",
                            "conditions" => array(
                                "CategoryFilm.film_id = Film.id"
                            )
                        )
                    ),
                    "conditions" => array("Category.id" => $id),
                    "fields" => array("Film.*, Category.*"),
                    "recursive" => -1
                )
            );
            $checkArr = array();
            foreach($films as $item) {
                if ($item['Film']['id'] != $film['Film']['id'] && !in_array($item['Film']['id'], $checkArr)) {
                    array_push($checkArr, $item['Film']['id']);
                }
            }
        }
        $i = 0;
        foreach ($checkArr as $key => $film_id) {
            $filmsList = $this->Film->find("all", array(
                    "conditions" => array("Film.id" => $film_id),
                    "fields" => array("Film.*"),
                    "recursive" => -1,
                    "order" => array("Film.views" => "desc"),
                )
            );

            foreach($filmsList as $item) {
                if($i < 4) {
                    $related_films[] = $item['Film'];
                    $i++;
                }
                else
                    break 2;

            }
        }
        $this->set('related_films', $related_films);
        if (!$film) {
            throw new NotFoundException(__('Invalid film'));
        }
        $this->set('film', $film);
        $this->set('average_rate', $this->Film->find('first', array(
                'conditions' => array('Film.id' => $id)
            )
        )
        );
    }
    public function admin_dashboard()
	{
		$this->layout = 'admin';
		if(AuthComponent::user('role')){
			$this->set('admin', AuthComponent::user());
		}
		else 
			$this->redirect('/pages/index');
	}
	public function admin_statistic()
	{
		$this->layout = 'admin';
		if(AuthComponent::user('role')){
			$this->set('admin', AuthComponent::user());
		}
		else 
				$this->redirect('/pages/index');
	}
}
