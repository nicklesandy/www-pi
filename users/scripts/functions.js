
var settingsForm = false;

$().ready(function(){
	
	settingsForm = $('.settings-form').length > 0;
	
	if(settingsForm){
		$('.settings-form input[type=text]').focusout(function() {
			updateSetting(this, $(this).val());
		});
		$('.settings-form input[type=checkbox]').change(function() {
			updateSetting(this, ($(this).is(":checked") ? 1 : 0));
		});
		$('.settings-form select').change(function() {
			updateSetting(this, $(this).find('option:selected').val());
		});
		
	}
	
});

function updateSetting(el, val){
	var 
		id_app = $(el).parents('.tab-pane').attr('id').replace('app', ''),
		code = $(el).data('code'),
		edittype = $(el).data('edittype')
	;
	$.ajax({
		url: 'index.php?action=do_setsetting' + 
				'&id_app=' + id_app + 
				'&code=' + code + 
				'&value=' + val + 
				'&edittype=' + edittype + 
			'',
		type: 'GET',
		cache: false,
		dataType: 'json',
		error: function(xhr, status, error) {
			//location.href = ...
		},
		success: function(data, textStatus, jqXHR){
			
		}
	});
}