<?=$this->html->script('/li3b_core/js/full-rainbow.min.js', array('inline' => false)); ?>
<?php
/*
if(isset($options['codeLineNumbers']) && (bool)$options['codeLineNumbers']) {
	echo $this->html->script('/li3b_core/js/rainbow.linenumbers.min.js', array('inline' => false));
	echo '<style type="text/css">pre, code { word-wrap:normal; } </style>';
}
 */
?>
<style type="text/css">pre { overflow: auto; word-wrap: normal; white-space: pre; } code { overflow:auto; } </style>
<?php //var_dump($options); ?>
<?=$this->html->style($options['rainbowTheme'], array('inline' => false)); ?>
<div class="row">
	<div class="span12">
		<h2 id="page-heading"><?=$document->title; ?></h2>
		<p><em>Posted <?=$this->time->to('words', $document->created); ?><?php echo $document->authorAlias ? ' by ' . $document->authorAlias:''; ?>.</em>
		<?php
		if($labels) {
			echo '<br />Labels: ';
			foreach($labels as $label) {
				echo $this->html->link('<span class="label" style="color: ' . $label['color'] . '; background-color: ' . $label['bgColor'] . '">' . $label['name'] . '</span>', array('library' => 'li3b_blog', 'action' => 'index', 'args' => array(urlencode($label['name']))), array('style' => 'text-decoration: none;', 'escape' => false));
			}
		}
		?>
		</p>
		<?php echo $this->html->containsSyntax($document->body); ?>
	</div>
</div>


