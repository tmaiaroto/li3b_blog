<?php
// No longer using Rainbow by default, but it has been left in in case you want to use it.
// echo $this->html->script('/li3b_core/js/full-rainbow.min.js', array('inline' => false));
/*
if(isset($options['codeLineNumbers']) && (bool)$options['codeLineNumbers']) {
	echo $this->html->script('/li3b_core/js/rainbow.linenumbers.min.js', array('inline' => false));
	echo '<style type="text/css">pre, code { word-wrap:normal; } </style>';
}
*/
//var_dump($options);
// To switch back to Rainbow, simply include: $options['rainbowTheme'] below instead.
?>
<?=$this->html->script('/li3b_core/js/highlight.pack.js', array('inline' => false)); ?>
<?=$this->html->style(array($options['highlightTheme'], '/li3b_core/css/code-styles.css'), array('inline' => false)); ?>
<div class="row">
	<div class="span12">
		<h1 id="page-heading"><?=$document->title; ?></h1>
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
		<?php
		// Since CKEditor is now used instead of TinyMCE, this should no longer be needed.
		// Note: If you switch back to TinyMCE, this helper method will unescape things that TinyMCE escaped for safety.
		// echo $this->html->containsSyntax($document->body);
		echo $document->body;
		?>
	</div>
</div>