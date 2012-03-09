function populateElement(selector, defvalue) {
    if($.trim($(selector).val()) == "") {
        $(selector).val(defvalue);
    }
    $(selector).focus(function() {
        if($(selector).val() == defvalue) {
            $(selector).val("");
        }
    });
    $(selector).blur(function() {
        if($.trim($(selector).val()) == "") {
            $(selector).val(defvalue);
        }
    });
 }

$(document).ready(function(){
	// give the search box some fancy stuff
	//populateElement('#search-box input.form-text, #search-block-form input.form-text', 'search...');
	populateElement('#search-box input.form-text, #search-block-form input.form-text', 'Søg...');
	// define sliders for the admin page for theme-settings.php
});
