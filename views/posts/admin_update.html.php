<?=$this->html->script(array('/li3b_core/js/jquery/colorpicker', '/li3b_blog/js/manageBlog.js'), array('inline' => false)); ?>
<?=$this->html->style(array('/li3b_core/css/jquery/colorpicker', '/li3b_blog/css/admin.css'), array('inline' => false)); ?>
<div class="row">
	<div class="span9">
		<h2 id="page-heading">Update Blog Post</h2>
		<br />
		<?=$this->form->create($document, array('class' => 'form-horizontal')); ?>
			<fieldset>
			<?=$this->security->requestToken(); ?>
				<div class="control-group">
					<?=$this->form->label('PostTitle', 'Title', array('class' => 'control-label')); ?>
					<div class="controls">
						<?=$this->form->field('title', array('label' => false, 'class' => 'input-xlarge'));?>
					</div>
				</div>
				<div class="control-group">
					<?=$this->form->label('PostAuthorAlias', 'Author', array('class' => 'control-label')); ?>
					<div class="controls">
						<?=$this->form->field('authorAlias', array('label' => false, 'class' => 'input-xlarge'));?>
					</div>
				</div>
				<div class="control-group">
					<?=$this->form->label('PostBody', 'Body', array('class' => 'control-label')); ?>
					<div class="controls">
						<?=$this->form->textarea('body', array('label' => false, 'class' => 'editor editor-html'));?>
					</div>
				</div>
				<div class="control-group">
					<label for="PostPublished" class="control-label">Published</label>
					<div class="controls">
						<label class="checkbox">
							<?=$this->form->field('published', array('label' => false, 'type' => 'checkbox'));?>If checked, this post will be visible on the front-end of the site.
						</label>
					</div>
				</div>
				<div id="PostLabelsInputs">
					<?php
					if($document->labels) {
						foreach($document->labels as $labelId) {
							echo '<input type="hidden" name="labels[]" value="' . $labelId . '" id="PostLabel' . $labelId . '" class="applied-post-label" />';
						}
					}
					?>
				</div>

				<div class="form-actions">
					<?=$this->form->submit('Save', array('class' => 'btn btn-primary')); ?> <?=$this->html->link('Cancel', array('library' => 'li3b_blog', 'admin' => true, 'controller' => 'posts', 'action' => 'index'), array('class' => 'btn')); ?>
				</div>

			</fieldset>
	</div>

	<div class="span3">
		<div class="well" style="padding: 8px 0;">
			<div style="padding: 0 8px 0 16px;">
				<h6>Options</h6>
				<div class="control-group">
					<?=$this->form->label('PostOptionsHighlightTheme', 'Code Highlighting Theme'); ?>
					<div class="controls">
						<?=$this->form->select('options.highlightTheme', $highlightThemes); ?>
					</div>
				</div>
				<!--
				<div class="control-group">
					<?=$this->form->label('PostOptionsRainbowTheme', 'Code Highlighting Theme'); ?>
					<div class="controls">
						<?=$this->form->select('options.rainbowTheme', $rainbowThemes); ?>
					</div>
				</div>
				-->
				<!--
				<div class="control-group">
					<div class="controls">
						<label class="checkbox">
						<?=$this->form->field('options.codeLineNumbers', array('label' => false, 'type' => 'checkbox')); ?>Line Numbers in Code Blocks
						</label>
					</div>
				</div>
				-->

				<?=$this->form->end(); ?>
			</div>

			<div style="padding: 0 8px 0 16px;">
				<h6>Tags <a href="#" rel="tooltip" data-original-title="Labels">[?]</a></h6>
				<div id="current-labels-wrapper">
					<div id="current-labels"></div>
				</div>
				<div style="clear: left;"></div>
				<div id="labels-mode"><a href="#" id="manage-existing-labels">manage existing labels</a></div>

				<?=$this->form->create(null, array('id' => 'create-new-label', 'onSubmit' => 'saveNewLabel(); return false;')); ?>
				<div class="control-group">
					<div class="controls">
						<?=$this->form->field('name', array('label' => false, 'id' => 'new-label-name', 'maxlength' => '40', 'placeholder' => 'New label name', 'autocomplete' => 'off')); ?>
						<div class="label-colors" style="display:none;">
							<div class="label-color-input">
								<div id="label-color" class="colorSelector"><div id="label-chosen-color" style="background-color: #ffffff;"></div></div>
								<input type="hidden" value="#ffffff" name="color" id="label-color-input" />
							</div>
							<div class="label-color-input">
								<div id="label-bg-color" class="colorSelector"><div id="label-chosen-bg-color" style="background-color: #0000ff;"></div></div>
								<input type="hidden" value="#0000ff" name="bgColor" id="label-bg-color-input" />
							</div>
							<span id="label-preview" class="label" style="background-color: #0000ff;">Label Preview</span>
							<br style="clear: left;" />
							<?=$this->form->submit('Save Label', array('class' => 'btn', 'id' => 'create-new-label-button')); ?>
							<br />
						</div>
					</div>
				</div>
				<?=$this->form->end(); ?>
			</div>

			<div style="clear: left; display: block; padding: 0 8px 0 16px;"></div>
			<br />

			<!--
			<ul class="nav nav-list">
				<li class="nav-header">Actions</li>
				<li class=""><?=$this->html->link('List All Posts', array('library' => 'li3b_blog', 'controller' => 'posts', 'action' => 'index', 'admin' => true)); ?></li>
				<li class="active"><?=$this->html->link('Create New Post', array('library' => 'li3b_blog', 'controller' => 'posts', 'action' => 'create', 'admin' => true)); ?></li>
			</ul>
			-->
		</div>
	</div>
</div>