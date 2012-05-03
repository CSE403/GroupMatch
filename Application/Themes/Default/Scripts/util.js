/*
 * This script is responsible for the behavioral style of the various pages.
 * Each page's section is marked with a heading.
 */
$(function() {
	/***************************************************************************
	 * Auth control scripting
	 **************************************************************************/
	
	
	
	/***************************************************************************
	 * Create poll scripting
	 **************************************************************************/
	
	// universal limit checkbox
	limitAllCheckbox = $('input[name="option_all_limit"]');
	limitAllNumberbox = $('input[name="option_all_limit_amount"]');
	if (limitAllCheckbox != null) {
		// enable/disable input
		limitAllCheckbox.click(function() {
			if ($(this).attr("checked") != null) {
				limitAllNumberbox.removeAttr("disabled");
				limitAllNumberbox.focus();
			}else {
				limitAllNumberbox.attr("disabled", "disabled");
			}
		});
		
		// change all limits that are not uniquely set
		limitAllNumberbox.blur(function() {
			if ($(this).attr("disabled") == null && limitAllCheckbox.attr("checked") != null) {
				optionLimits = $('input[name*="option_limit_amount"][disabled="disabled"]');
				optionLimits.attr("value", $(this).attr("value"));
			}
		});
		
	}
	
	// rate on scale radio
	answerType = $('input[name="answer_type"]');
	maxScale = $('input[name="scale_max"]');
	if (answerType != null) {
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
				if ($(this).attr("checked") != null) {
					$(this).next().removeAttr("disabled").focus();
				}else {
					$(this).next().attr("disabled", "disabled");
				}
			});
		}
	}
	limitCheckboxSetup();
	
	// add more options button
	addButton = $('button[name="add_more_options"]');
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
	
	/***************************************************************************
	 * Poll management scripting
	 **************************************************************************/
	
	deleteButtons = $('button[name="delete_poll"]');
	
});