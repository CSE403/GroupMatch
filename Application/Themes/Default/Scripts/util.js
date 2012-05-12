/*
 * This script is responsible for the behavioral style of the various pages.
 * Each page's section is marked with a heading.
 */
$(function() {
	/***************************************************************************
	 * Create poll scripting
	 **************************************************************************/
	
	// universal limit checkbox
	limitAllCheckbox = $('input[name="option_all_limit"]');
	limitAllNumberbox = $('input[name="option_all_limit_amount"]');
	if (limitAllCheckbox) {
		// enable/disable input
		limitAllCheckbox.click(function() {
			if ($(this).attr("checked")) {
				limitAllNumberbox.removeAttr("disabled");
				limitAllNumberbox.focus();
			}else {
				limitAllNumberbox.attr("disabled", "disabled");
			}
		});
		
		// change all limits that are not uniquely set
		limitAllNumberbox.blur(function() {
			if (!$(this).attr("disabled") && limitAllCheckbox.attr("checked")) {
				optionLimits = $('input[name*="option_limit_amount"][disabled="disabled"]');
				optionLimits.attr("value", $(this).attr("value"));
			}
		});
		
	}
	
	// rate on scale radio
	answerType = $('input[name="answer_type"]');
	maxScale = $('input[name="scale_max"]');
	if (answerType) {
		answerType.change(function() {
			if ($(this).attr("value") == 4) {
				maxScale.removeAttr("disabled");
				maxScale.focus();
			}else {
				maxScale.attr("disabled", "disabled");
			}
		});
	}
	
	// option limit checkbox
	limitCheckboxSetup = function() {
		limitCheckboxes = $('input[name*="option_limit"]');
		if (limitCheckboxes != null) {
			limitCheckboxes.click(function() {
				if ($(this).attr("checked")) {
					$(this).next().removeAttr("disabled").focus();
				}else {
					$(this).next().attr("disabled", "disabled");
				}
			});
		}
	};
	limitCheckboxSetup();
	
	// add more options button
	addButton = $('button[name="add_more_options"]');
	if (addButton) {
		addButton.click(function(e) {
			e.preventDefault();
			count = $('input[name*="option_limit_amount"]').last().attr("name").split("_")[3];
			optionList = $('#option_list');
			for (var i = 0; i < 5; i++) {
				count++;
				optionList.append('<li>' + 
									  '<input name="option_' + count + '" type="text" placeholder="Option" />' + 
									  '<input name="option_limit_' + count + '" type="checkbox" />'+ 
									  '<input name="option_limit_amount_' + count + '" type="number" placeholder="10" min="1" disabled="disabled" />' +
								  '</li>')
				
			}
			limitCheckboxSetup();
			$('html, body').animate({scrollTop: $(document).height()}, 'slow');
		});
	}
	
	/***************************************************************************
	 * Poll management scripting
	 **************************************************************************/
	
	deleteButtons = $('button[name="delete_poll"]');
	if (deleteButtons) {
		deleteButtons.click(function() {
			var li = $(this).closest('li')
			li.animate({
			    opacity: 0,
			    height: 'toggle',
			    padding: 'toggle',
			    margin: 'toggle'
			  }, 200, function() {
			    li.detach();
			    
			    // show empty list message
			    if (!$('#poll_list').children().is('li')) {
			    	$('#no_polls_message').animate({
					    opacity: 1,
					    height: 'toggle',
					    padding: 'toggle',
					    margin: 'toggle'
					  }, 100, function(){}
					 );
			    }
			    
			    //TODO make call to remove poll here 
			  });
		});
	}
});