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
				<a id="editlink" href="/countries/edit/<?= $country->id ?>">Edit</a>
				<form method="POST" action="countries/edit/<?= $country->id ?>">
					<input type="submit" class="delete" id="<?= htmlspecialchars($country->id) ?>" value="Delete"/>
					<input type="hidden" name="delete" value="<?= htmlspecialchars($country->id) ?>">
				</form>
			</td>
		</tr>
	<?php endforeach; ?>
</table>

<div id="new-values">
	<p>Enter the new values (Only For Jquery):</p>
		<form method="POST">
			<input type="text" name="new-country" id="new-country" value="">
			<input type="text" name="new-capital" id="new-capital" value="">
			<input type="text" name="new-population" id="new-population" value="">
			<input type="submit" class="done" name="submit-vals">
		</form>
</div>

<form method="POST">
	<hr/>INSERT A NEW RECORD IN THE TABLE:<hr /><br />
	Country:<input type="text" id="add-country" name="name" value=""><br />
	Capital:<input type="text" id="add-capital" name="capital" value=""><br />
	Population:<input type="text" id="add-population" name="population" value=""><br />
	Order:<input type="text" id="add-order" name="order" value=""><br /><hr />
	<input type="submit" name="add" class="submit">
	<input type="reset" name="reset">
</form>


