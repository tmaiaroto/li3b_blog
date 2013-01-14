<?php
namespace li3b_blog\models;

use lithium\core\Libraries;

class Post extends \li3b_core\models\BaseModel {

	protected $_meta = array(
		'locked' => true,
		'connection' => 'li3b_mongodb',
		'source' => 'li3b_blog.posts'
	);

	protected $_schema = array(
		'_id' => array('type' => 'id'),
		'title' => array('type' => 'string'),
		'_authorId' => array('type' => 'string'),
		'authorAlias' => array('type' => 'string'),
		'body' => array('type' => 'string'),
		'url' => array('type' => 'string'),
		'labels' => array('type' => 'array'),
		'options' => array('type' => 'object'),
		'published' => array('type' => 'boolean'),
		'modified' => array('type' => 'date'),
		'created' => array('type' => 'date')
	);

	public $url_field = 'title';

	public $url_separator = '-';

	public $search_schema = array(
		'title' => array(
			'weight' => 1
		),
		'body' => array(
			'weight' => 1
		)
	);

	public $validates = array(
		'title' => array(
			array('notEmpty', 'message' => 'Ttile cannot be empty.')
		),
		'body' => array(
			array('notEmpty', 'message' => 'Body cannot be empty.')
		)
	);

	public $defaultOptions = array(
		'rainbowTheme' => 'blackboard',
		'codeLineNumberes' => true,
		'highlightTheme' => 'solarized_dark',
	);

	/**
	 * Returns all installed themes for Rainbow syntax highlighter.
	 * Users can put their own themes in the main app's
	 * webroot/css/rainbow-themes directory.
	 *
	 * @return array The available themes for Rainbow
	 */
	public static function getRainbowThemes() {
		$themes = array();
		$li3bCore = Libraries::get('li3b_core');
		$appConfig = Libraries::get(true);

		foreach(scandir($li3bCore['path'] . '/webroot/css/rainbow-themes') as $theme) {
			if(substr($theme, -3) == 'css') {
				$themes['/li3b_core/css/rainbow-themes/' . $theme] = substr($theme, 0, -4);
			}
		}

		if(file_exists($appConfig['path'] . '/webroot/css/rainbow-themes')) {
			foreach(scandir($appConfig['path'] . '/webroot/css/rainbow-themes') as $theme) {
				if(substr($theme, -3) == 'css') {
					$themes['/css/rainbow-themes/' . $theme] = substr($theme, 0, -4);
				}
			}
		}

		return $themes;
	}

	/**
	 * Returns all installed themes for Highlight.js syntax highlighter.
	 * Users can put their own themes in the main app's
	 * webroot/css/highlight-themes directory.
	 *
	 * @return array The available themes for Highlight.js
	 */
	public static function getHighlightThemes() {
		$themes = array();
		$li3bCore = Libraries::get('li3b_core');
		$appConfig = Libraries::get(true);

		foreach(scandir($li3bCore['path'] . '/webroot/css/highlight-themes') as $theme) {
			if(substr($theme, -3) == 'css') {
				$themes['/li3b_core/css/highlight-themes/' . $theme] = substr($theme, 0, -4);
			}
		}

		if(file_exists($appConfig['path'] . '/webroot/css/highlight-themes')) {
			foreach(scandir($appConfig['path'] . '/webroot/css/highlight-themes') as $theme) {
				if(substr($theme, -3) == 'css') {
					$themes['/css/highlight-themes/' . $theme] = substr($theme, 0, -4);
				}
			}
		}

		return $themes;
	}

}
?>