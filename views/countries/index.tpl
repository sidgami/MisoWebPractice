<table id="countries" border="1" cellpadding="10">
	<th>Country</th>
	<th>Capital</th>
	<th>Population</th>
	<th>Order</th>
	<th>Actions</th>
		
	<?php foreach ($countries as $country): ?>
		<tr id="<?= htmlspecialchars($country->id) ?>">	
			<td class="name"><?= htmlspecialchars($country->name) ?></td>
			<td class="capital"><?= htmlspecialchars($country->capital) ?></td>
			<td class="population"><?= htmlspecialchars($country->population) ?></td>
			<td><?= htmlspecialchars($country->order) ?></td>
			<td>
				<form method="POST">
					<input type="submit" value="Up" class="up" id="<?= htmlspecialchars($country->id) ?>"/>
					<input type="hidden" name="up" value="<?= htmlspecialchars($country->id) ?>">
				</form>
				<form method="POST">
					<input type="submit" value="Down" class="down" id="<?= htmlspecialchars($country->id) ?>"/>
					<input type="hidden" name="down" value="<?= htmlspecialchars($country->id) ?>">
				</form>
				<!--<form method="POST">
					<input type="submit" value="Edit" class="edit" id="<?= htmlspecialchars($country->id) ?>"/>
					<input type="hidden" name="edit" value="<?= htmlspecialchars($country->id) ?>">
				</form>-->		
				<a id="editlink" href="/countries/editRecord/<?= $country->id ?>">Edit <?= htmlspecialchars($country->title) ?></a>
				<form method="POST">
					<input type="submit" value="Delete" class="delete" id="<?= htmlspecialchars($country->id) ?>"/>
					<input type="hidden" name="delete" value="<?= htmlspecialchars($country->id) ?>">
				</form>
			</td>
		</tr>
	<?php endforeach; ?>
</table>

<div id="new-values">
	<p>Enter the new values:</p>
		<form method="POST">
			<input type="text" name="new-country" id="new-country" value="">
			<input type="text" name="new-capital" id="new-capital" value="">
			<input type="text" name="new-population" id="new-population" value="">
			<input type="submit" class="done" name="submit-vals" value="Done">
		</form>
</div>

<form method="POST">
	<hr/>INSERT A NEW RECORD IN THE TABLE:<hr /><br />
	Country:<input type="text" id="add-country" name="add-country" value=""><br />
	Capital:<input type="text" id="add-capital" name="add-capital" value=""><br />
	Population:<input type="text" id="add-population" name="add-population" value=""><br />
	Order:<input type="text" id="add-order" name="add-order" value=""><br /><hr />
	<input type="submit" name="add" value="Add" class="submit">
	<input type="reset" name="reset">
</form>


