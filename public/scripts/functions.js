$(function() {
	$('#new-values').hide();
	//return true;
	var id;
	
	$('form.down').submit(function() {
		var rowElement = $(this).parents('tr:first');
		var nextRowElement = rowElement.next();
		
		nextRowElement.after(rowElement);
		return false;
	});
	$('form.up').submit(function() {
		var row = $(this).parents('tr:first');
		var numPrevRows = row.prevAll('tr').size();
		var prevRowElement = row.prev('tr');
		
		if(numPrevRows > 1) {
			prevRowElement.before(row);
		}
		return false;
	});
	$('form.delete').submit(function() {
		var rowElement = $(this).parents('tr:first');
		
		rowElement.remove();
		return false;
	});
	$('a.edit_countries').click(function(e) {
		e.preventDefault();
		
		var rowElement = $(this).parents('tr:first');
		var country = $(rowElement).children('.name');
		var capital = $(rowElement).children('.capital');
		var population = $(rowElement).children('.population');
		
		$('#new-country').prop('value', country.html());
		$('#new-capital').prop('value', capital.html());
		$('#new-population').prop('value', population.html());
		$('#new-values').show('slow');
		id=rowElement.prop('id');
		return false;
	});
	$('form.new_values').submit(function() {
		var country = $('#new-country').val();
		var capital = $('#new-capital').val();
		var population = $('#new-population').val();
		var rowElement = $('#'+id);
		
		rowElement.children('.name').html(country);
		rowElement.children('.capital').html(capital);
		rowElement.children('.population').html(population);
		$('#new-values').hide('slow');
		return false;
	});
	$('form.add_record').submit(function() {
		var country = $('#add-country').val();
		var capital = $('#add-capital').val();
		var population = $('#add-population').val();
		var order = $('#add-order').val();
		
		var row = $('<tr></tr>');
		$('<td></td>').text(country).appendTo(row);
		$('<td></td>').text(capital).appendTo(row);
		$('<td></td>').text(population).appendTo(row);
		$('<td></td>').text(order).appendTo(row);
		
		var tableData = $('<td></td>');
		
		var input = $('<input></input>');
		input.prop({'type':'button','value':'Up'});
		input.appendTo(tableData);
		$('<br />').appendTo(tableData);
		
		var input1 = $('<input></input>');
		input1.prop({'type':'button','value':'Down'});
		input1.appendTo(tableData);
		$('<br />').appendTo(tableData);
		
		var link = $('<a>Edit</a>');
		link.appendTo(tableData);
		$('<br />').appendTo(tableData);
		
		var input3 = $('<input /></input>');
		input3.prop({'type':'button','value':'Delete'});
		input3.appendTo(tableData);
		
		tableData.appendTo(row);
		$('table#countries').append(row);
		return false;
	});
});