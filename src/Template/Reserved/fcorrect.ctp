<section class='container'>
	<form method='post' action='<?= $this->Url->build(["action" => 'fcorrect', 'a'], true) ?>'>
	<div class='row'>
			<input type='text' style="display:none" value="<?php echo $a ?>" name="iteration">
			<div class="col-sm-12">
				<h1 style="text-align: center">Values from table <?= $table_name ?>:</h1>
				<button style="float: center" type=submit>Load next table</button>
				<p style="text-align: center">Next table: <?= $next_table ?> and iteration <?= $a ?></p>
				<ul style="text-align: center"> 
				<div class="row">
							<div class="col-sm-3">
								<h2>flashcard_id</h2>
							</div>
							<div class="col-sm-3">
								<h2>user_id</h2>
							</div>
							<div class="col-sm-3">
								<h2>correct</h2>
							</div>
							<div class="col-sm-3">
								<h2>last_time</h2>
							</div>
					</div>	
					<?php foreach($values as $value): ?>

						<div class="row">
							<div class="col-sm-3">
								<h2><?=$value['flashcard_id']?></h2>
							</div>
							<div class="col-sm-3">
								<h2><?=$value['user_id']?></h2>
							</div>
							<div class="col-sm-3">
								<h2><?=$value['correct']?></h2>
							</div>
							<div class="col-sm-3">
								<h2><?=$value['last_time']?></h2>
							</div>
						</div>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</form>
</section>