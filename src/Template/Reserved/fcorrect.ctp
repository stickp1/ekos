<section class='container'>
	<div class='row'>
			<div class="col-sm-12">
				<h1 style="text-align: center">Result from flashcard_userxx tables insertion:</h1>
				<span>Total: number of tables: <?php echo count($status) ?></span>
				
				<table style="width:50%">

					<tr>
						<td>table name</td>
						<td>status</td>
					</tr>
					<?php foreach($status as $statu): ?>
					<tr>
						<td><?= $statu['table_name'] ?></td>
						<td>
							<?php if($statu['entities']): ?> 
								<span style="color: green">copied</span>  
							<?php else: ?>
								<span style="color:red">FAIL</span>
							<?php endif; ?>
						</td>
					</tr>
					<?php endforeach; ?>
				</table>
			</div>
		</div>
</section>