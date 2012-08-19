<?php
namespace li3b_blog\controllers;

use li3b_blog\models\Post;
use li3b_blog\models\Label;
use li3b_core\util\Util;
use li3_flash_message\extensions\storage\FlashMessage;
use lithium\security\validation\RequestToken;
use lithium\util\Inflector;
use \MongoDate;
use \MongoId;

class PostsController extends \lithium\action\Controller {

	public function admin_index() {
		$this->_render['layout'] = 'admin';
		
		$conditions = array();
		// If a search query was provided, search all "searchable" fields (any field in the model's $search_schema property)
		// NOTE: the values within this array for "search" include things like "weight" etc. and are not yet fully implemented...But will become more robust and useful.
		// Possible integration with Solr/Lucene, etc.
		if((isset($this->request->query['q'])) && (!empty($this->request->query['q']))) {
			$search_schema = User::searchSchema();
			$search_conditions = array();
			// For each searchable field, adjust the conditions to include a regex
			foreach($search_schema as $k => $v) {
				$field = (is_string($k)) ? $k:$v;
				$search_regex = new \MongoRegex('/' . $this->request->query['q'] . '/i');
				$conditions['$or'][] = array($field => $search_regex);
			}
		}
		
		$limit = $this->request->limit ?: 25;
		$page = $this->request->page ?: 1;
		$order = array('created' => 'desc');
		$total = Post::count(compact('conditions'));
		$documents = Post::all(compact('conditions','order','limit','page'));
		
		$page_number = (int)$page;
		$total_pages = ((int)$limit > 0) ? ceil($total / $limit):0;
		
		// Set data for the view template
		return compact('documents', 'total', 'page', 'limit', 'total_pages');
	}
	
	public function admin_create() {
		$this->_render['layout'] = 'admin';
		
		$document = Post::create();
		$rainbowThemes = Post::getRainbowThemes();
		
		// If data was passed, set some more data and save
		if ($this->request->data) {
			// CSRF
			if(!RequestToken::check($this->request)) {
				RequestToken::get(array('regenerate' => true));
			} else {
				$now = new MongoDate();
				$this->request->data['created'] = $now;
				$this->request->data['modified'] = $now;
				
				// Set the pretty URL that gets used by a lot of front-end actions.
				$this->request->data['url'] = $this->_generateUrl();
				
				// Save
				if($document->save($this->request->data)) {
					FlashMessage::write('The post has been created successfully.', array(), 'default');
					$this->redirect(array('library' => 'li3b_blog', 'controller' => 'posts', 'action' => 'index', 'admin' => true));
				} else {
					FlashMessage::write('The post could not be created, please try again.', array(), 'default');
				}
			}
		}
		
		$this->set(compact('document', 'rainbowThemes'));
	}
	
	/**
	 * Allows admins to update blog posts.
	 * 
	 * @param string $id The post id
	 */
	public function admin_update($id=null) { 
		if(empty($id)) {
			FlashMessage::write('You must provide a blog post id to update.', array(), 'default');
			return $this->redirect(array('admin' => true, 'library' => 'li3b_blog', 'controller' => 'posts', 'action' => 'index'));
		}
		$this->_render['layout'] = 'admin';
		
		$rainbowThemes = Post::getRainbowThemes();
		
		$document = Post::find('first', array('conditions' => array('_id' => $id)));
		if(!empty($this->request->data)) {
			// IMPORTANT: Use MongoDate() when inside an array/object because $_schema isn't deep
			$now = new MongoDate();
			
			$this->request->data['modified'] = $now;
			
			// Set the pretty URL that gets used by a lot of front-end actions.
			// Pass the document _id so that it doesn't change the pretty URL on an update.
			$this->request->data['url'] = $this->_generateUrl($document->_id);

			if($document->save($this->request->data)) {
				FlashMessage::write('The blog post has been successfully updated.', array(), 'default');
				return $this->redirect(array('admin' => true, 'library' => 'li3b_blog', 'controller' => 'posts', 'action' => 'index'));
			} else {
				FlashMessage::write('There was a problem updating the blog post, please try again.', array(), 'default');
			}
			
		}
		
		$this->set(compact('document', 'rainbowThemes'));
	}
	
	/**
	 * Allows admins to delete blog posts.
	 * 
	 * @param string $id The post id
	*/
	public function admin_delete($id=null) {
		$this->_render['layout'] = 'admin';
		
		// Get the document from the db to edit
		$conditions = array('_id' => $id);
		$document = Post::find('first', array('conditions' => $conditions));
		
		// Redirect if invalid post
		if(empty($document)) {
			FlashMessage::write('That blog post was not found.', array(), 'default');
			return $this->redirect(array('library' => 'li3b_blog', 'controller' => 'posts', 'action' => 'index', 'admin' => true));
		}
		
		if($document->delete()) {
			FlashMessage::write('The post has been deleted.', array(), 'default');
		}
		
		return $this->redirect(array('library' => 'li3b_blog', 'controller' => 'posts', 'action' => 'index', 'admin' => true));
	}
	
	/**
	 * Public view method.
	 * 
	 * The id can be either a pretty URL or a MongoId.
	 * 
	 * @param type $id
	 */
	public function view($id=null) {
		if(empty($id)) {
			return $this->redirect('/');
		}
		
		if(preg_match('/[0-9a-f]{24}/', $id)) {
			$field = '_id';
		} else {
			$field = 'url';
		}
		
		$isAdmin = (isset($this->request->user['role']) && $this->request->user['role'] == 'administrator') ? true:false;
		$conditions = $isAdmin ? array($field => $id):array($field => $id, 'published' => true);
		$document = Post::find('first', array('conditions' => $conditions));
		
		if(empty($document)) {
			FlashMessage::write('Sorry, that blog post does not exist or is not published.', array(), 'default');
			return $this->redirect('/');
		}
		
		$options = $document->options ? $document->options->data():Post::$defaultOptions;
		$labels = false;
		if($document->labels) {
			$labels = Label::find('all', array('conditions' => array('_id' => $document->labels->data())));
		}
		
		$this->set(compact('document', 'options', 'labels'));
	}
	
	/**
	 * Generates a pretty URL for the blog post document.
	 * 
	 * @return string
	 */
	private function _generateUrl($id=null) {
		$url = '';
		$url_field = Post::urlField();
		$url_separator = Post::urlSeparator();
		if($url_field != '_id' && !empty($url_field)) {
			if(is_array($url_field)) {
				foreach($url_field as $field) {
					if(isset($this->request->data[$field]) && $field != '_id') {
						$url .= $this->request->data[$field] . ' ';
					}
				}
				$url = Inflector::slug(trim($url), $url_separator);
			} else {
				$url = Inflector::slug($this->request->data[$url_field], $url_separator);
			}
		}

		// Last check for the URL...if it's empty for some reason set it to "user"
		if(empty($url)) {
			$url = 'post';
		}

		// Then get a unique URL from the desired URL (numbers will be appended if URL is duplicate) this also ensures the URLs are lowercase
		$options = array(
			'url' => $url,
			'model' => 'li3b_blog\models\Post'
		);
		// If an id was passed, this will ensure a document can use its own pretty URL on update instead of getting a new one.
		if(!empty($id)) {
			$options['id'] = $id;
		}
		return Util::uniqueUrl($options);
	}
	
}
?>