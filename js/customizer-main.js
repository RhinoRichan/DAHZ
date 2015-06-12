jQuery(function($) {

	/*=== Tooltip ===*/ 
	$( '.tooltip' ).popup({
		className   : {
					  popup       : 'ui popup small'
					}
	});
    

    /*=== Custom CSS ===*/ 
	var previewDiv = $('#customize-preview');

    $('.wp-full-overlay-header').append('<div id="df-customizer-tools"></div>');

    var dfTools = $('#df-customizer-tools');

    dfTools.append('<button id="trigger-overlay" class="button">Custom CSS</button>');
    previewDiv.prepend('<div id="overlay-customcss"><form><textarea id="csstextarea"></textarea></form></div>');

    var cssWindow = $('#customize-preview #overlay-customcss');
    var cssText = $('#customize-preview #overlay-customcss form textarea');
    var ogText = $("li#customize-control-df_options-custom_styles").children().children('textarea');

    // click
    $('#trigger-overlay').click(function(e) {

        e.preventDefault();

        // turn off
        if ($(this).hasClass('btn-active')) {

            $(this).removeClass('btn-active');

            cssWindow.fadeToggle('fast');

            ogText.val(cssText.val()).keyup();

            // turn on
        } else {

            $(this).addClass('btn-active');

            // fade in
            cssWindow.fadeToggle('fast');

            // empty
            cssText.val('');

            // focus
            cssText.focus();

            // fill
            cssText.val(ogText.val());

        }

    });

    // Support CSS textarea

    HTMLTextAreaElement.prototype.getCaretPosition = function() { //return the caret position of the textarea
        return this.selectionStart;
    };
    HTMLTextAreaElement.prototype.setCaretPosition = function(position) { //change the caret position of the textarea
        this.selectionStart = position;
        this.selectionEnd = position;
        this.focus();
    };
    HTMLTextAreaElement.prototype.hasSelection = function() { //if the textarea has selection then return true
        if (this.selectionStart == this.selectionEnd) {
            return false;
        } else {
            return true;
        }
    };
    HTMLTextAreaElement.prototype.getSelectedText = function() { //return the selection text
        return this.value.substring(this.selectionStart, this.selectionEnd);
    };
    HTMLTextAreaElement.prototype.setSelection = function(start, end) { //change the selection area of the textarea
        this.selectionStart = start;
        this.selectionEnd = end;
        this.focus();
    };

    var textarea = document.getElementById('csstextarea');

    textarea.onkeydown = function(event) {

        //support tab on textarea
        if (event.keyCode == 9) { //tab was pressed
            var newCaretPosition;
            newCaretPosition = textarea.getCaretPosition() + "    ".length;
            textarea.value = textarea.value.substring(0, textarea.getCaretPosition()) + "    " + textarea.value.substring(textarea.getCaretPosition(), textarea.value.length);
            textarea.setCaretPosition(newCaretPosition);
            return false;
        }
        if (event.keyCode == 8) { //backspace
            if (textarea.value.substring(textarea.getCaretPosition() - 4, textarea.getCaretPosition()) == "    ") { //it's a tab space
                var newCaretPosition;
                newCaretPosition = textarea.getCaretPosition() - 3;
                textarea.value = textarea.value.substring(0, textarea.getCaretPosition() - 3) + textarea.value.substring(textarea.getCaretPosition(), textarea.value.length);
                textarea.setCaretPosition(newCaretPosition);
            }
        }
        if (event.keyCode == 37) { //left arrow
            var newCaretPosition;
            if (textarea.value.substring(textarea.getCaretPosition() - 4, textarea.getCaretPosition()) == "    ") { //it's a tab space
                newCaretPosition = textarea.getCaretPosition() - 3;
                textarea.setCaretPosition(newCaretPosition);
            }
        }
        if (event.keyCode == 39) { //right arrow
            var newCaretPosition;
            if (textarea.value.substring(textarea.getCaretPosition() + 4, textarea.getCaretPosition()) == "    ") { //it's a tab space
                newCaretPosition = textarea.getCaretPosition() + 3;
                textarea.setCaretPosition(newCaretPosition);
            }
        }
    }


});