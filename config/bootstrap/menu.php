<?php
use li3b_core\models\BootstrapMenu as Menu;

Menu::applyFilter('staticMenu',  function($self, $params, $chain) {
	if($params['name'] == 'admin') {
		$self::$staticMenus['admin']['blog'] = array(
			'title' => 'Blog <b class="caret"></b>',
			'url' => '#',
			'activeIf' => array('library' => 'li3b_blog', 'controller' => 'posts'),
			'options' => array('escape' => false),
			'subItems' => array(
				array(
					'title' => 'All Posts',
					'url' => array('library' => 'li3b_blog', 'admin' => true, 'controller' => 'posts', 'action' => 'index')
				),
				array(
					'title' => 'Create New',
					'url' => array('library' => 'li3b_blog', 'admin' => true, 'controller' => 'posts', 'action' => 'create')
				)
			)
		);
	}
	
	return $chain->next($self, $params, $chain);
});
?>