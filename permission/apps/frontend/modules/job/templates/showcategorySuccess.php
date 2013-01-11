<div id="category_jobs">
	<table class="category_jobs">
		<?php foreach ($jobeet_category_jobs as $i => $job): ?>
		<tr class="<?php echo fmod($i, 2) ? 'even' : 'odd' ?>">
			<td class="location"><a
				href="<?php echo url_for('job/show?id='.$job->getId()) ?>"> <?php echo $job->getDescription() ?>
			</a>
			</td>
			<td class="position"><?php echo $job->getPosition() ?></td>


			<td class="company"><?php echo $job->getCompany() ?>
			</td>
		</tr>
		<?php endforeach ?>
	</table>
</div>
