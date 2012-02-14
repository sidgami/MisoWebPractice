<table id="countries" border="1" cellpadding="10">
	<th>Country</th>
	<th>Capital</th>
	<th>Population</th>
	<th>Order</th>
	<th>Actions</th>
		
	<?php foreach ($countries as $country): ?>
		<tr id="Country<?= htmlspecialchars($country->id) ?>" class=>	
			<td class="name"><?= htmlspecialchars($country->name) ?></td>
			<td class="capital"><?= htmlspecialchars($country->capital) ?></td>
			<td class="population"><?= htmlspecialchars($country->population) ?></td>
			<td><?= htmlspecialchars($country->order) ?></td>
			<td>
				<form method="POST" class="up">
					<input type="submit" value="Up"/>
					<input type="hidden" name="up" value="<?= htmlspecialchars($country->id) ?>">
				</form>
				<form method="POST" class="down">
					<input type="submit" value="Down"/>
					<input type="hidden" name="down" value="<?= htmlspecialchars($country->id) ?>">
				</form>
				<a href="<?= Paraglide::url('countries', 'edit', $country->id) ?>" class="edit_countries">Edit</a>
				<form method="POST" action="<?= Paraglide::url('countries', 'edit', $country->id) ?>" class="delete">
					<input type="submit" value="Delete"/>
					<input type="hidden" name="delete" value="<?= htmlspecialchars($country->id) ?>">
				</form>
			</td>
		</tr>
	<?php endforeach; ?>
</table>

<form method="POST" class="new_values">
	<div id="new-values" class="add_values">
		<p class="add_header">Enter the new values (Only For Jquery):</p>
		<input type="text" name="new-country" id="new-country" value="">
		<input type="text" name="new-capital" id="new-capital" value="">
		<input type="text" name="new-population" id="new-population" value="">
		<input type="submit">
	</div>
</form>

<form method="POST" class="add_record">
	<div id="add-values" class="add_values">
		<h4 class="add_header">INSERT A NEW RECORD IN THE TABLE:</h4>
		<label for="country">Country:</label>
		<input type="text" id="add-country" name="name" value=""><br />
		<label for="capital">Capital:</label>
		<input type="text" id="add-capital" name="capital" value=""><br />
		<label for="population">Population:</label>
		<input type="text" id="add-population" name="population" value=""><br />
		<label for="population">Order:</label>
		<input type="text" id="add-order" name="order" value=""><br />
		<input type="submit">
		<input type="hidden" name="add" value="new_Country">
		<input type="reset">
	</div>
</form>
