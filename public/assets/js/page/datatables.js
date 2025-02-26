"use strict";

if($("[data-checkboxes]"))
{
	$("[data-checkboxes]").each(function() {
	  var me = $(this),
		group = me.data('checkboxes'),
		role = me.data('checkbox-role');
	
	  me.change(function() {
		var all = $('[data-checkboxes="' + group + '"]:not([data-checkbox-role="dad"])'),
		  checked = $('[data-checkboxes="' + group + '"]:not([data-checkbox-role="dad"]):checked'),
		  dad = $('[data-checkboxes="' + group + '"][data-checkbox-role="dad"]'),
		  total = all.length,
		  checked_length = checked.length;
	
		if(role == 'dad') {
		  if(me.is(':checked')) {
			all.prop('checked', true);
		  }else{
			all.prop('checked', false);
		  }
		}else{
		  if(checked_length >= total) {
			dad.prop('checked', true);
		  }else{
			dad.prop('checked', false);
		  }
		}
	  });
	});
}

if($("#mydata-table"))
{
	/*$("#mydata-table").dataTable({
		buttons: [
			'copy', 'excel', 'pdf'
		],
		"columnDefs": [
			{ "sortable": false, "targets": [0,2] }
		],
		order: [[ 1, "asc" ]] //column indexes is zero based  
	});*/
}


if($("#table-1"))
{
	$("#table-1").dataTable({
		"columnDefs": [
			{ "sortable": false, "targets": [2,3] }
		]
	});
}

if($("#table-2"))
{
	$("#table-2").dataTable({
		"columnDefs": [
			{ "sortable": false, "targets": [0,2] }
		],
		order: [[ 1, "asc" ]] //column indexes is zero based  
	});
}

if($("#save-stage"))
{
	$('#save-stage').DataTable({
		"scrollX": true,
		stateSave: true
	});
}

if($("#tableExport"))
{
	$('#tableExport').DataTable({
		dom: 'Bfrtip',
		buttons: [
			'copy', 'csv', 'excel', 'pdf', 'print'
		]
	});
}