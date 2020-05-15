<?php if (count($confirms)>0): ?>
	<div class="confirm">
		<?php foreach ($confirms as $confirm): ?>
			<p><?php echo $confirm;?></p>
	<?php endforeach ?>
	</div>
<?php endif ?>