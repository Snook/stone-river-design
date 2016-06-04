<footer class="py-4 bg-light">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 text-center copyright">
				<p>Copyright &copy; <?php echo date('Y'); ?> <strong>Linda Holcomb-Bryant</strong>
				<p><a class="btn btn-info" href="/policy">Policies</a> <a class="btn btn-warning" href="https://www.etsy.com/conversations/new?with_id=12060104">Etsy Contact</a></p>
			</div>
		</div>
	</div>
</footer>

<div class="scroll-top d-none d-md-none">
	<a class="btn btn-info page-scroll" href="#page-top">
		<i class="fa fa-chevron-up mt-2"></i>
	</a>
</div>

<script>
	//<![CDATA[
	user = { id: <?php echo (!empty($this->user->id)) ? $this->user->id : 0; ?> }
	//]]>
</script>
<?php
if(isset($this->head_script))
{
	foreach ($this->head_script as $script)
	{
		echo '<script src="' . $script . '"></script>' . "\n";
	}
}
?>
<script>
	//<![CDATA[
	$(document).ready(function() {
		<?php if ($msg = $this->getErrorMsg()) { ?>
		site_message({
			title: 'Error',
			message: '<?php echo $msg; ?>',
			div_id: 'themer_ErrorMessage'
		});
		<?php } ?>
		<?php if ($msg = $this->getStatusMsg()) { ?>
		site_message({
			title: 'Status',
			message: '<?php echo $msg; ?>',
			div_id: 'themer_StatusMessage'
		});
		<?php } ?>
		<?php
		if (!empty($this->head_script_var))
		{
			foreach ($this->head_script_var as $script_var)
			{
				echo "\t\t\t" . $script_var . "\n";
			}
		}
		if (!empty($this->head_onload))
		{
			foreach ($this->head_onload as $onload)
			{
				echo "\t\t\t" . $onload . "\n";
			}
		}
		?>
	});
	//]]>
</script>
<?php if (ENABLE_ANALYTICS) { ?>
<script>
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	ga('create', 'UA-33707240-1', 'auto');
	ga('send', 'pageview');
</script>
<?php } ?>

</body>
</html>