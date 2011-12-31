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
		
		if(allPrevRowElement.length > 1) {
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
		
		$('#new-country').prop('value',country.html());
		$('#new-capital').prop('value',capital.html());
		$('#new-population').prop('value',population.html());
		
		$('#new-values').show('slow');
		id=rowElement.prop('id');
		return false;
	});
	$('input.done').parents('form').submit(function() {
		var country = $('#new-country').val();
		var capital = $('#new-capital').val();
		var population = $('#new-population').val();

		id='#'+id;
		var rowElement = $(id);
		
		rowElement.children('.name').html(country);
		rowElement.children('.capital').html(capital);
		rowElement.children('.population').html(population);
		$('#new-values').hide('slow');
		return false;
	});
	$('input.submit').parents('form').submit(function() {
		var country = $('#add-country').val();
		var capital = $('#add-capital').val();
		var population = $('#add-population').val();
		var order = $('#add-order').val();
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
			'<a id="editlink" href="/countries/edit/'+randomNum+'">Edit</a>'+
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