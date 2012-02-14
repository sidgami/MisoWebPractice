<div id="add-values" class="add_values">
	<h4 class="add_header"> Edit Page for <?= htmlspecialchars($country->name) ?></h4>
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
    	<input type="submit" value="Done"/>
	</form>    

	<form method="POST">
    	<input type="submit" value="Delete"/>
    	<input type="hidden" name="delete" value="delete"/>	
	</form>
</div>