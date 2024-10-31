var omigoLoadedOnce = false;
jQuery(document).ready(function() {
    jQuery('.wepay-ifr').click(function(e) {
        e.preventDefault();
        var typeDonation = ((jQuery(this).data("amount")) ? 'recurring' : 'onetime');

        if (jQuery('#one-time-donation-recurring').is(':checked')) {
            typeDonation = 'recurring';
        }
        var wpnonce = jQuery('#omigowpnonce').val();

        br_iframe(((jQuery(this).data("amount")) ? jQuery(this).data("amount") : jQuery('#one-time-donation-amount').val()), typeDonation, false, wpnonce);
    });

    jQuery('#lightbox-close').click(function(e) {
        jQuery('#custom-lightbox').hide();
        jQuery('#custom-lightbox-text-wrapper').hide();
        location.reload(true);
    });

    jQuery( "body" ).on( "blur", ".sweet-alert > fieldset > input", function() {
        setTimeout(function() {
          window.scrollTo(0, 10);
          if ( jQuery.isFunction(jQuery.fn.scrollTo) ) {
            jQuery( '.sweet-overlay' ).scrollTo( 5 );
          }
        }, 200);
    });

    jQuery(window).bind('hashchange', function() {
        console.log(location.hash);
        if (location.hash == "donate" || location.hash == "#donate") {
            var nonce = omigoAjax.donateNonce;
            omigo_open_amount_swal(nonce);
        }
    });

});

jQuery(window).load(function() {

    jQuery('.omigo-donate-button').click(function(e) {
        e.preventDefault();

        if (!jQuery(this).data("amount") || jQuery(this).data("amount") == "") {
            omigo_open_amount_swal(jQuery(this).data("nonce"));
        }
        else {
            br_iframe(((jQuery(this).data("amount")) ? jQuery(this).data("amount") : 20), 'onetime', true, jQuery(this).data("nonce"));
        }
    });

    jQuery('#mvalidate-form').submit(function(e) {
        var nonce = jQuery(this).attr("data-nonce");
        var mcid = jQuery('#input_siwp_captcha_id_0').val();
        var mcpr = jQuery('#mcpr').val();
        var memail = jQuery('#memail').val();
        var mbrug = new Array();
        var mgodkendt = jQuery('#mgodkendt').is(':checked');

        if (!jQuery('#mfornavn').val() || !jQuery('#mefternavn').val() || !jQuery('#mvej').val() || !jQuery('#mpostnr').val() || !jQuery('#mby').val() || !jQuery('#mtelefon').val() || !memail) {
            custom_error('Alle felter skal udfyldes.');
            return false;
        }

        if (!mgodkendt) {
            custom_error('Du skal læse og acceptere betingelserne');
            return false;
        }


        jQuery('input[name="mbrug"]:checked').each(function() {
            mbrug.push(jQuery(this).val());
        });

        var dataObj = {
            action: "mvalidate",
            nonce: nonce,
            mfornavn : jQuery('#mfornavn').val(),
            mefternavn : jQuery('#mefternavn').val(),
            mvej : jQuery('#mvej').val(),
            mpostnr : jQuery('#mpostnr').val(),
            mby : jQuery('#mby').val(),
            memail : memail,
            mtelefon : jQuery('#mtelefon').val(),
            mcpr : encodeURIComponent(encrypted),
            mrejsekort : jQuery('#mrejsekort').val(),
            mbrug : mbrug,
            mcid : mcid,
            mkode : jQuery('#siwp_captcha_value_0').val(),
            mplace : jQuery('#mplace').val()
        };

        jQuery.ajax({
          type : "post",
          dataType : "json",
          url : myAjax.ajaxurl,
          data : dataObj,
          success: function(response) {
            if (response.error) {
                custom_error(response.error_msg);
                return false;
            }
            else {
                swal('Ansøgning sendt!', response.success_msg, 'success')
                jQuery('#mvalidate-form').hide();
            }
          }
        });
        
        e.preventDefault();
        return false;
    });

    var hash = window.location.hash;
    if (hash && hash != "" && !omigoLoadedOnce) {
        omigoLoadedOnce = true;
        setTimeout(function() {
            jQuery(hash).click();
        }, 500);
    }
});

function omigo_open_amount_swal(nonce) {

    swal({
        imageUrl: omigoAjax.pluginsUrl + "/omigo/img/omigo_cc_logo.png",
        title: "Enter your donation amount:",
        imageSize: "164x76",
        type: "input",
        showCancelButton: true,
        closeOnConfirm: false,
        inputPlaceholder: "25"
    },
    function(inputValue){
        if (inputValue === false)
          return false;

      if (isNaN(inputValue)) {
        swal('Please provide a valid amount');
      }
      else {
        br_iframe(inputValue, 'onetime', true, nonce);
        swal.close();
      }
    });

    jQuery('.sweet-alert button.cancel').click(function(e) {
        e.preventDefault();
        history.pushState("", document.title, window.location.pathname);
    });
}

function br_iframe(amount, type, dynamicType, wpnonce) {

    if (type == "onetime") {
        if (!parseInt(amount) || isNaN(amount)) {
            alert('Please provide a valid amount.');
            jQuery('#one-time-donation-amount').val('');
            return;
        }
    }

    var formid = "brcustom";
    var dataObj = {
        action: 'get_client_token',
        amount: amount,
        validator: Math.floor(Date.now() / 1000),
        nonce: wpnonce
    };

    jQuery.ajax({
        type : "post",
        dataType : "json",
        url : omigoPortal.ajaxurl,
        data : dataObj,
        success: function(response) {

            if (response.error) {
                alert('Error occured when trying to connect with omigo server. Please contact the system administrator.');
            }

            var captchaData = {
                action: 'get_captcha'
            };
            jQuery.ajax({
                type : "post",
                //dataType : "json",
                url : omigoAjax.ajaxurl,
                data : captchaData,
                success: function(responseimg) {
                    console.log(responseimg);

                    appendModal(amount, dynamicType, responseimg);
                    jQuery('#cancel-payment').click(function(e) {
                        window.location.href = window.location.pathname;
                    });
                    jQuery('.rafscaptcha-renew-link').click(function(e) {
                        e.preventDefault();

                        var captchaData = {
                            action: 'get_captcha'
                        };
                        jQuery.ajax({
                            type : "post",
                            //dataType : "json",
                            url : omigoAjax.ajaxurl,
                            data : captchaData,
                            success: function(responseimg) {
                                console.log('new');
                                console.log(responseimg);
                                jQuery('#captcha-wrapper').html(responseimg);
                            }
                        });
                    });
                    //jQuery('#custom-lightbox-text-wrapper').show();

                    var colorTransition = "border 160ms linear";
                    braintree.setup(response.clientToken, "custom", {
                        id: formid,
                        hostedFields: {
                            styles: {
                                // Style all elements
                                "input": {
                                    "font-size": "13px",
                                    "color": "#222222",
                                    "height": "27px",
                                    "transition": colorTransition,
                                    "-webkit-transition": colorTransition
                                },
                                ".number": {
                                    //"font-family": "monospace"
                                    "height": "27px"
                                }
                            },
                            number: {
                                selector: "#card-number"
                            },
                            cvv: {
                                selector: "#cvv"
                            },
                            expirationMonth: {
                                selector: "#expiration-month"
                            },
                            expirationYear: {
                                selector: "#expiration-year"
                            },
                            postalCode: {
                                selector: "#postal-code",
                                placeholder: "XXXXX"
                            },
                        },
                        onError : function(response) {
                            alert(response.message);
                        },
                        onPaymentMethodReceived: function(r) {
                            jQuery('.lightbox-submit').val('Please wait...');
                            //jQuery('.lightbox-submit').attr('disabled', 'disabled');
                            jQuery('.lightbox-submit').prop('disabled', true);

                            if (jQuery('#omigo_recurring_checkbox').length) {
                                if (jQuery('#omigo_recurring_checkbox').is(':checked')) {
                                    type = 'recurring';
                                }
                            }

                            var nonce = r.nonce;
                            var cctype = r.type;
                            var cardType = r.details.cardType;
                            var lastTwo = r.details.lastTwo;
                            var firstname = jQuery('#firstname').val();
                            var lastname = jQuery('#lastname').val();
                            var email = jQuery('#email').val();
                            var captcha = jQuery('#rafscaptcha').val();

                            // now that we received the data, create the customer then
                            createSalesCustomer(nonce, cctype, cardType, lastTwo, firstname, lastname, email, amount, type, wpnonce, captcha);
                        }
                    });
                }
            });
        }
    });
}

function createSalesCustomer(nonce, cctype, cardType, lastTwo, firstname, lastname, email, amount, type, wpnonce, captcha) {
    var dataObj = {
        action: "create_sales_customer",
        cnonce: nonce,
        camount: amount,
        ctype: cctype,
        ccardType: cardType,
        clastTwo: lastTwo,
        cfirstname: firstname,
        clastname: lastname,
        cemail: email,
        ptype: type,
        wpnonce: wpnonce,
        rafscaptcha: captcha
    };

    jQuery.ajax({
        type : "post",
        dataType : "json",
        url : omigoAjax.ajaxurl,
        data : dataObj,
        success: function(response) {
            if (response.error) {
                alert(response.error_msg);
                jQuery('.lightbox-submit').val('Pay');
                jQuery('.lightbox-submit').prop('disabled', false);
            }
            else {
                jQuery('#custom-lightbox-text-wrapper').html('<h2>Thank you!</h2><br>Your donation has been processed. In a few moments, you will receive a confirmation email which will contain all the information that you will need for tax deduction purposes.  Please remember to store it in a safe location. <img class="empowered_by_omigo" src="https://portal.omigo.org/images/omigo_cc_logo.png">');

                setTimeout(function() {
                    //location.reload(true);
                    window.location = window.location.pathname;
                }, 3000);
            }
        }
    });
}

function appendModal(amount, dynamicType, responseimg) {
    jQuery('body').append('<div id="omigo-modal" style="text-align: center;"></div>');

    var recurringHTML = '';
    if (dynamicType) {
        recurringHTML = '<br style="clear:both;"><span class="omigo-recurring-checkbox-wrapper"><input type="checkbox" name="omigo_recurring" id="omigo_recurring_checkbox"> Make this a recurring payment</span>';
    }
    var captcha = '<br style="clear:both;"><span class="omigo-recurring-checkbox-wrapper">Fill out the CAPTCHA, by writing the letters, numbers and/or special chars you see in the box<br><input type="text" value="" placeholder="Write captcha" name="rafscaptcha" id="rafscaptcha" class="rafscaptcha"><span id="captcha-wrapper">' + responseimg +
        '</span><br><span class="omigo-smaller-font"><a href="#" class="rafscaptcha-renew-link"><img src="https://portal.omigo.org/images/omigo_renew_captcha.png" alt="renew" class="rafscaptcha-renew-image"></a> <a href="#" class="rafscaptcha-renew-link">Show another CAPTCHA</a></span>' +
        '</span><input type="hidden" name="rafscheck" value="" id="rafscheck">';

    jQuery('#omigo-modal').html('<div id="custom-lightbox-text-wrapper"><form id="brcustom">We appreciate your donation of <b>$<span class="br-amount">' + amount + '</span></b>. Once your transaction is complete, you will be emailed a tax receipt for this donation. The tax receipt will contain all the information necessary for tax deduction purposes. Please retain all tax receipts in a secure location.<span class="only-monthly-text">Note that recurring payments are not charged right away.</span><br><br>' +
        '<b>Please fill out your credit card information.</b><br><i class="fa fa-lock"></i> &nbsp;All data is transferred through encrypted SSL connection. <br><br><span class="inline-block padding-right float-left"><label for="firstname">First name:</label><br><input type="text" name="firstname" id="firstname"></span>&nbsp;&nbsp;<span class="inline-block padding-right float-left"><label for="lastname">Last name:</label><br><input type="text" name="lastname" id="lastname"></span><br style="clear:both;">' +
        '<span class="inline-block padding-right float-left"><label for="card-number">Card Number:</label><br><div id="card-number"></div></span>&nbsp;&nbsp;<span class="inline-block padding-right float-left"><label for="expiration-month">Expiration Date MM / YYYY:</label><br><div id="expiration-month"></div><div id="expiration-year"></div></span><br style="clear:both;"><span class="inline-block padding-right float-left"><label for="email">E-mail:</label><br><input type="email" name="email" id="email"></span>&nbsp;&nbsp;<span class="inline-block padding-right float-left"><label for="cvv">CVV:</label><br>' +
        '<div id="cvv"></div></span>&nbsp;&nbsp;<span class="inline-block padding-right float-left"><label for="postal-code">Postal code:</label><br><div id="postal-code"></div></span>' + captcha + recurringHTML + '<input type="submit" value="Pay" class="lightbox-submit btn btn-success"><button type="button" id="cancel-payment" class="btn btn-danger">Cancel payment</button></form><img alt="Powered by OMIGO" class="empowered_by_omigo" src="https://portal.omigo.org/images/omigo_cc_logo.png"></div>');
    jQuery('#omigo-modal').show();
}