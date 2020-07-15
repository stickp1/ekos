
<h2 style='margin-top:40px; margin-bottom:5px'>MÓDULO: <?= $group['course']['name']?></h2>
<h3 style='margin-top:0; color: #999'> <?= $group['name']?></h3>
	<br>
<table style='width: 100%; text-align:center' cellspacing='0' cellpadding='5px'>
	<tr style='background-color:#152335;'>
		<td style='color: white'><b>Data</b></td>
		<td style='color: white'><b>Nível</b></td>
		<td style='color: white'><b>Tema</b></td>
		<td style='color: white'><b>Formador</b></td>
		<td style='color: white'><b>Local</b></td>
	</tr>
	<?php foreach ($group['lectures'] as $key => $value): ?>
        <?php $themes_ = explode(',', $value['themes']); ?>
        <?php if($value['themes'] != ''):
            $n = count($themes_);
            foreach ($themes_ as $key2 => $value2): ?>
            	<tr>
        			<?= $key2 == 0 ? "<td rowspan='".$n."' valign='middle' style='border-bottom: 1px solid #152335;'> ".$value['datetime']->i18nFormat('dd/MM HH:mm')." </td>" : ""?>
        			<td <?= $key2 == $n - 1 ? "style='border-bottom: 1px solid #152335;'":""?> class="<?php if($themes[$value2]['relevance'] == 'A*') echo "green2"; elseif ($themes[$value2]['relevance'] == 'A') echo "green"; elseif ($themes[$value2]['relevance'] == 'B') echo "yellow"; elseif ($themes[$value2]['relevance'] == 'C') echo "red"; ?>" > <?= $themes[$value2]['relevance']?></td>
        			<td class='name' <?= $key2 == $n - 1 ? "style='border-bottom: 1px solid #152335;'":""?> > <?= $themes[$value2]['name']?></td>
        			<?= $key2 == 0 ? "<td rowspan='".$n."' valign='middle' style='border-bottom: 1px solid #152335;'> ".$value['user']['first_name']." ".$value['user']['last_name']." </td>" : ""?>
        			<?= $key2 == 0 ? "<td rowspan='".$n."' valign='middle' style='border-bottom: 1px solid #152335;'> ".$value['place']." </td>" : ""?>
        		</tr>
            <?php endforeach ?>
        <?php else: ?>
    		<tr>
    			<td valign='middle' style='border-bottom: 1px solid #152335;'> <?= $value['datetime']->i18nFormat('dd/MM HH:mm') ?> </td>
    			<td style='border-bottom: 1px solid #152335'></td>
    			<td class='name' style='border-bottom: 1px solid #152335'> <?= $value['description']?></td>
    			<td valign='middle' style='border-bottom: 1px solid #152335;'> <?= $value['user']['first_name']." ".$value['user']['last_name'] ?> </td>
    			<td valign='middle' style='border-bottom: 1px solid #152335;'> <?= $value['place'] ?></td>
    		</tr>

		<?php endif ?>
    <?php endforeach ?>
</table>


<style>
td.name{
    text-align: left
}
.green2{
	background-color: rgb(153, 216, 97);
}
.green{
	background-color: rgb(202,223,183);
}
.yellow{
	background-color: rgb(251,229,163);
}
.red{
	background-color: rgb(234,178,138);
}
</style>
