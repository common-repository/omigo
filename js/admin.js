var omigo_client_submitted = false;
var omigo_client_form;

jQuery(document).ready(function() {
	var omiAjax = omigo_wp_obj.omigo_ajax_admin_url;
	jQuery(".wrap.omiraf form").submit(function() {
		var terms_checked = jQuery("#omi_accept_terms").is(":checked");
		if (!terms_checked) {
			alert("You need to read and accept the terms in order to use OMIGO services.");
			return false;
		}
		var budget = jQuery("#monthly_budget").val();
		if (isNaN(budget)) {
			alert("Please provide a valid budget.");
			return false;
		}

		var omi_client_set = parseInt(jQuery("#omi_client_set").val());
		if (!omigo_client_submitted && !omi_client_set) {
			var ok = confirm("Are you sure this information is correct?");
			if(ok) {
				omigo_client_form = this;
				ajax_omigo_merchant();
			}
			return false;
		}
		else {
			return true;
		}
	});

	function ajax_omigo_merchant() {
		var datas = jQuery(omigo_client_form).serialize();
		datas = datas + "&action=activate_token&host=" + omigo_wp_obj.omigo_host;

		jQuery.ajax({
			type: "POST",
			dataType : "json",
			url: omigo_wp_obj.omigo_portal_url,
			data: datas,
			success: function(response) {
				if (response.error) {
				  alert(response.error_msg);
				}
				else {
					omigo_client_submitted = true;
					setTimeout(function() {

						var dataObj = {
							action: "set_omi_client_id",
							omi_client_id: response.omi_client_id,
							business_name: response.business_name,
							ein: response.ein,
							nonce: jQuery("#omigo_options_nonce").val()
						};

						jQuery.ajax({
							type : "post",
							dataType : "json",
							url : omiAjax,
							data : dataObj,
							success: function(response) {
								console.log(response);
								if (response.error) {
									alert(response.msg);
								}
								else {
									jQuery("#submit").click();
								}
							}
						});
					}, 60);
				}
			}
		});
	}
});
