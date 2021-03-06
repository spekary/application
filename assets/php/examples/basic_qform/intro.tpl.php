<?php
// This is the HTML template include file for intro.php (View Layer)
// Here is where you specify any HTML that you want rendered in the form, and here
// is where you can specify which controls you want rendered and where.
?>
<?php require('../includes/header.inc.php'); ?>
<?php $this->renderBegin(); ?>

<div id="instructions">
	<h1>Learning the Basics</h1>

	<p>Welcome to your first <strong>\QCubed\Project\Control\FormBase</strong>!  This example shows how you can create a few
		<strong>QControl</strong> objects (in this case, a <strong>\QCubed\Control\Label</strong> and a <strong>\QCubed\Project\Jqui\Button</strong>) and set their text
		inside.  It also assigns a <strong>\QCubed\Event\Click</strong> on the button to a <strong>\QCubed\Action\Server</strong>.  
		This server action (which is a PHP method) will simply modify the label to say
		"Hello, World!".</p>

	<p>All <strong>\QCubed\Project\Control\FormBase</strong> objects use an HTML include file -- in thise case, we define the HTML in
		the <strong>intro.tpl.php</strong> file.  Note that there are <strong>RenderBegin()</strong> and <strong>RenderEnd()</strong>
		methods which are required to be called within the template in order to output the
		appropriate &lt;form&gt; tags, and also outputs any additional HTML and JavaScript
		that makes the <strong>\QCubed\Project\Control\FormBase</strong> work. (QCubed will in fact throw an exception
		if either <strong>RenderBegin</strong> and <strong>RenderEnd</strong> are not called.)</p>

	<p>Click on the "View Source" link below to view the <strong>intro.php</strong> and <strong>intro.tpl.php</strong> code,
		which together define this <strong>\QCubed\Project\Control\FormBase</strong> you are seeing.</p>
</div>

<div id="demoZone">
	<h2>Hello World Example</h2>

	<p><?php $this->lblMessage->Render(); ?></p>
	<p><?php $this->btnButton->Render(); ?></p>
</div>

<?php $this->renderEnd(); ?>
<?php require('../includes/footer.inc.php'); ?>