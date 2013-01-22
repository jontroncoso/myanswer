var hidef = {};
/**
 * calling this will iterate through each of the children attributes and call them by whatever order they were declared.
 */
hidef.onload = function(){
	$.each(hidef.onload, function(i,e){
      if(typeof e === 'function' && i !== 'bind'){ e(); }
  });
}
// doing it this way helps me organize my logic into groups. especially useful when sections are dynamically being created/destroyed in a fully-dynamic webapp.
// Whats more if I forget to put comments, I'm able to glance at the methodName, and see more-or-less what these triggers are regarding.
hidef.onload.contactFormEvents = function(){
	$('#ContactCountryId').change(hidef.countryChange);
	$('#ContactAddForm').submit(hidef.addContact);
	$('#contacts li').click(hidef.getContact);
	$('h1 a').toggle(function(){
		$('#container').addClass('back');
		$(this).html('Form');
		$('#ContactId').val('');
	}, function(){
		if($('#ContactId').val() == '')
		{
			$('#ContactAddForm input[type=text]').val('');
			$('#ContactAddForm #ContactCountryId').val(0).change();
		}
		$('#container').removeClass('back');
		$(this).html('List');
	});
};

/*		onload event
*///	app logic

hidef.getContact = function(){
	var name = $(this).find('h2').html().split(' ');
	var contactInfo = $(this).find('.footer').html().split(' | ');
// <input name="data[Contact][street]" type="text" id="ContactStreet">
// <input name="data[Contact][street2]" type="text" id="ContactStreet2">
// <input name="data[Contact][zip]" type="text" id="ContactZip" required="required">
// <select name="data[Contact][country_id]" id="ContactCountryId">
	$('#ContactId').val($(this).data('id'));
	$('#ContactFirst').val(name[0]);
	$('#ContactLast').val(name[1]);
	$('#ContactPhone').val(contactInfo[1]);
	$('#ContactEmail').val(contactInfo[0]);
	$('#ContactStreet').val($(this).find('.street').html())
	$('#ContactStreet2').val($(this).find('.street2').html())
	$('#ContactZip').val($(this).find('.zip').html())
	$('#ContactCountryId').val($(this).data('country')).change();
	$('h1 a').click();
};
hidef.addContact = function() {
	$.ajax({
		type: "POST",
	  dataType: "json",
	  url: '/contacts/add/',
	  data: $(this).serialize(),
	  success: hidef.addContact.success
	});
	return false;
};
hidef.addContact.success = function(d,r){
	var $contact = $('#ContactId').val() == ''
			? $('<li></li>').data('id', d.contact.Contact.id).click(hidef.getContact)
			: $('#contacts li[data-id=' + $('#ContactId').val() + ']').html('');
	var $address = $('<p class="address"><span class="street">' + d.contact.Contact.street + '</span></p>');
	var address = [];
	
	if(d.contact.Contact.street2 != null)$address.append('<br/><span class="street2">' + d.contact.Contact.street2 + '</span>');
	if(d.contact.City.city != null)address.push('<span class="city">' + d.contact.City.city + '</span>');
	if(d.contact.State.state != null)address.push('<span class="state">' + d.contact.State.state + '</span>');
	if(d.contact.Country.country != null)address.push('<span class="country">' + d.contact.Country.country + '</span>');
	if(address.length != 0)$address.append('<br/>' + address.join(', '));
	if(d.contact.Contact.zip != null)$address.append(' <span class="zip">' + d.contact.Contact.zip + '</span>');
	$contact
		.append('<h2>' + d.contact.Contact.first + ' ' + d.contact.Contact.last + '</h2>')
		.append($address)
		.append('<div class="footer">' + d.contact.Contact.email + ' | ' + d.contact.Contact.phone + '</div>');
	if($('#ContactId').val() == '')$contact.prependTo($('#contacts'));
	$('h1 a').click();
};



hidef.countryChange = function(){
	var id = $(this).val()
	$('#ContactCityId').remove();
	if(id == 0)return $('#ContactStateId').remove();
	
	$.getJSON('/state/' + id, function(d,r){
		var $state = $('#ContactStateId').length == 0 
			? $('<select></select>')
					.attr('id', 'ContactStateId')
					.attr('name', 'data[Contact][state_id]')
					.insertAfter($('#ContactCountryId'))
					.change(hidef.stateChange)
			: $('#ContactStateId');
		
		$state
			.html($('<option></option>').attr('value', 0).html('Please Select a ' + (id == 1 ? 'State' : 'Province')));
		
		$.each(d, function(i,e){
			$('<option></option>')
				.attr('value', e.State.id)
				.html(e.State.state)
				.appendTo($state);
		})
	})
};



hidef.stateChange = function(){
	var id = $(this).val();
	if(id == 0)return $('#ContactCityId').remove();
	$.getJSON('/city/' + id, function(d,r){
		var $city = $('#ContactCityId').length == 0 
			? $('<select></select>')
					.attr('id', 'ContactCityId')
					.attr('name', 'data[Contact][city_id]')
					.insertAfter($('#ContactStateId'))
			: $('#ContactCityId');
		
		$city
			.html($('<option></option>').html('Please Select a City'));
		
		$.each(d, function(i,e){
			$('<option></option>')
				.attr('value', e.City.id)
				.html(e.City.city)
				.appendTo($city);
		})
	})
};



$(hidef.onload);