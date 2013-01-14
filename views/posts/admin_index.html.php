<div class="row">
	<div class="span9">
		<h2 id="page-heading">Blog Posts</h2>
		
		<table class="table table-striped">
			<thead>
				<tr>
					<th class="left">Title</th>
					<th>Created</th>
					<th class="right">Actions</th>
				</tr>
			</thead>
			<?php foreach($documents as $document) { ?>
			<tr>
				<td>
					<?php $active = ($document->active) ? 'active':'inactive'; ?>
					<?=$this->html->link($document->title, array('library' => 'li3b_blog', 'controller' => 'posts', 'action' => 'view', 'admin' => null, 'args' => array($document->url)), array('target' => '_blank')); ?>
				</td>
				<td>
					<?=$this->html->date($document->created->sec); ?>
				</td>
				<td>
					<?=$this->html->link('Edit', array('library' => 'li3b_blog', 'controller' => 'posts', 'action' => 'update', 'admin' => true, 'args' => array($document->_id))); ?> |
					<?=$this->html->link('Delete', array('library' => 'li3b_blog', 'controller' => 'posts', 'action' => 'delete', 'admin' => true, 'args' => array($document->_id)), array('onClick' => 'return confirm(\'Are you sure you want to delete ' . $document->title . '?\')')); ?>
				</td>
			</tr>
			<?php } ?>
		</table>

		<?=$this->BootstrapPaginator->paginate(); ?>
		<em>Showing page <?=$page; ?> of <?=$totalPages; ?>. <?=$total; ?> total record<?php echo ((int) $total > 1 || (int) $total == 0) ? 's':''; ?>.</em>
	</div>

	<div class="span3">
		<div class="well" style="padding: 8px 0;">
			<div style="padding: 8px;">
				<h3>Search for Posts</h3>
				<?=$this->html->queryForm(); ?>
			</div>
			
			<ul class="nav nav-list">
				<li class="nav-header">Actions</li>
				<li class="active"><?=$this->html->link('List All Posts', array('library' => 'li3b_blog', 'controller' => 'posts', 'action' => 'index', 'admin' => true)); ?></li>
				<li class=""><?=$this->html->link('Create New Post', array('library' => 'li3b_blog', 'controller' => 'posts', 'action' => 'create', 'admin' => true)); ?></li>
			</ul>

		</div>
	</div>

</div>
<script type="text/javascript">
	$('.user-info').tooltip();
</script>