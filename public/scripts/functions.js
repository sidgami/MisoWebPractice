$(function() {
	return true;
	var id;
	$('#new-values').hide();
	$('input.down').parents('form').submit(function() {
		var rowElement = $(this).parents('tr:first');
		var nextRowElement = rowElement.next();
		
		nextRowElement.after(rowElement);
		return false;
	});
	$('input.up').parents('form').submit(function() {
		var row = $(this).parents('tr:first');
		var allPrevRowElement = row.prevAll('tr');
		var prevRowElement = row.prev('tr');
		
		if(allPrevRowElement.length > 1){
			prevRowElement.before(row);
		}
		return false;
	});
	$('input.delete').parents('form').submit(function() {
		var rowElement = $(this).parents('tr:first');
		
		rowElement.remove();
		return false;
	});
	$('a').click(function(e) {
		e.preventDefault();
		var rowElement = $(this).parents('tr:first');
		var country = $(rowElement).children('.name');
		var capital = $(rowElement).children('.capital');
		var population = $(rowElement).children('.population');
		
		$('#new-country').attr('value',country.html());
		$('#new-capital').attr('value',capital.html());
		$('#new-population').attr('value',population.html());
		
		$('#new-values').show('slow');
		id=rowElement.attr('id');
		return false;
	});
	$('input.done').parents('form').submit(function() {
		var country = $('#new-country').attr('value');
		var capital = $('#new-capital').attr('value');
		var population = $('#new-population').attr('value');

		id='#'+id;
		var rowElement = $(id);
		
		rowElement.children('.name').html(country);
		rowElement.children('.capital').html(capital);
		rowElement.children('.population').html(population);
		$('#new-values').hide('slow');
		return false;
	});
	$('input.submit').parents('form').submit(function() {
		var country = $('#add-country').attr('value');
		var capital = $('#add-capital').attr('value');
		var population = $('#add-population').attr('value');
		var order = $('#add-order').attr('value');
		
		var randomNum = Math.floor(Math.random())%100;

		var rowElement = 
		'<tr>'+
			'<td>'+country+'</td>'+
			'<td>'+capital+'</td>'+
			'<td>'+population+'</td>'+
			'<td>'+order+'</td>'+
			'<td>'+
			'<form method="POST">'+
				'<input type="submit" value="Up" class="up" id="'+randomNum+'"/>'+
				'<input type="hidden" name="up" value="'+randomNum+'">'+
			'</form>'+
			'<form method="POST">'+
				'<input type="submit" value="Down" class="down" id="'+randomNum+'"/>'+
				'<input type="hidden" name="down" value="'+randomNum+'">'+
			'</form>'+
			'<form method="POST">'+
				'<input type="submit" value="Edit" class="edit" id="'+randomNum+'"/>'+
				'<input type="hidden" name="edit" value="'+randomNum+'">'+
			'</form>'+
			'<form method="POST">'+
				'<input type="submit" value="Delete" class="delete" id="'+randomNum+'"/>'
				'<input type="hidden" name="delete" value="'+randomNum+'">'
			'</form>'+
			'</td>'+
		'</tr>';
		$('table#countries').append(rowElement);
		return false;
	});
});