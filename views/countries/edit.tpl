<h1> Edit Page for <?= htmlspecialchars($country->name) ?></h1>
<form method="POST">
	<table border="1" cellpadding="10">
		<th>Field Names</th>
		<th>New Values</th>
		<tr>
			<td>Country</td>
			<td><input type="text" name="name" value="<?= htmlspecialchars($country->name) ?>"></td>
		</tr>
		<tr>
			<td>Capital</td>
			<td><input type="text" name="capital" value="<?= htmlspecialchars($country->capital) ?>"></td>
		</tr>
		<tr>
			<td>Population</td>
			<td><input type="text" name="population" value="<?= htmlspecialchars($country->population) ?>"></td>
		</tr>
		<tr>
			<td>Order</td>
			<td><input type="text" name="order" value="<?= htmlspecialchars($country->order) ?>"></td>
		</tr>
	</table>
	<input type="hidden" name="id" value="<?= htmlspecialchars($country->id) ?>">
    <input type="submit" name="submit" />
    <input type="submit" name="delete" value="Delete"/>
</form>