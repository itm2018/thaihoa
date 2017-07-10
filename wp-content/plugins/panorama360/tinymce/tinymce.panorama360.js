(function() {
	tinymce.create('tinymce.plugins.panorama360', {
		init : function(ed, url) {
			ed.addButton('panorama360', {
				title : ed.getLang('panorama360.buttonTitle'),
				tooltip: ed.getLang('panorama360.buttonTitle'),
				icon: 'panorama360',
				onclick : function() {
					panorama360_plugin_popup(ed);
				}
			});
		}
	});
	tinymce.PluginManager.add('panorama360', tinymce.plugins.panorama360);
})();

function panorama360_plugin_popup_close() {
	jQuery('.panorama360-shortcodes-modal, .panorama360-shortcodes-modal-backdrop').remove();
}

jQuery(document).on('click','#panorama360-shortcodes-modal .panorama360-popup-cancel-button', function(ev) {
	ev.preventDefault();
	panorama360_plugin_popup_close();
});

function panorama360_plugin_popup(ed) {
	var $modal = jQuery('<div class="media-modal panorama360-shortcodes-modal" id="panorama360-shortcodes-modal"><a class="media-modal-close" href="#"><span class="media-modal-icon"></span></a><div class="media-modal-content"><div class="media-frame wp-core-ui"><div class="media-frame-title"><h1>' + ed.getLang('panorama360.buttonTitle') + '</h1></div><div class="media-frame-content"><div class="media-frame-content-inner">' +
		'<div class="option-line option-line-image"><label for="panorama360_prop_image" class="option-title mandatory">' + ed.getLang('panorama360.image') + '</label><div class="option-content"><input type="text" class="widefat upload-file" name="panorama360_prop_image" id="panorama360_prop_image" value="" required="required" /><div class="uploads_actions"><span class="button upload-image">' + ed.getLang('panorama360.imageUpload') + '</span><span class="button remove-image hide">' + ed.getLang('panorama360.imageRemove') + '</span></div><div class="screenshot"></div><div class="popup-col first"><label for="panorama360_prop_image_width" class="option-title mandatory">' + ed.getLang('panorama360.imageWidth') + '</label><input type="text" class="widefat width" name="panorama360_prop_image_width" id="panorama360_prop_image_width" required="required" /></div><div class="popup-col last"><label for="panorama360_prop_image_height" class="option-title mandatory">' + ed.getLang('panorama360.imageHeight') + '</label><input type="text" class="widefat height" name="panorama360_prop_image_height" id="panorama360_prop_image_height" required="required" /></div><div class="clear"></div><label for="panorama360_prop_image_alt_text" class="option-title">' + ed.getLang('panorama360.imageAlt') + '</label><input type="text" class="widefat alt-text" name="panorama360_prop_image_alt_text" id="panorama360_prop_image_alt_text" /></div></div>' +
		'<div class="option-line option-line-select"><label for="panorama360_prop_type" class="option-title">' + ed.getLang('panorama360.imageType') + '</label><div class="option-content"><select name="panorama360_prop_type" id="panorama360_prop_type" class="widefat"><option value="180">180&deg;</option><option value="" selected="selected">360&deg;</option></select><div class="option-field-description">' + ed.getLang('panorama360.imageTypeDescription') + '</div></div></div>' +
		'<div class="option-line option-line-text"><label for="panorama360_prop_style" class="option-title">' + ed.getLang('panorama360.cssStyle') + '</label><div class="option-content"><input type="text" class="widefat" name="panorama360_prop_style" id="panorama360_prop_style" value="height: 350px; margin-bottom: 20px;"><div class="option-field-description">' + ed.getLang('panorama360.cssStyleDescription') + '</div></div></div>' +
		'<div class="option-line option-line-text"><label for="panorama360_prop_title" class="option-title">' + ed.getLang('panorama360.title') + '</label><div class="option-content"><input type="text" class="widefat" name="panorama360_prop_title" id="panorama360_prop_title" value="" /></div></div>' +
		'<div class="option-line option-line-text"><label for="panorama360_prop_title_link" class="option-title">' + ed.getLang('panorama360.titleLink') + '</label><div class="option-content"><input type="text" class="widefat" name="panorama360_prop_title_link" id="panorama360_prop_title_link" value="" /></div></div>' +
		'<div class="option-line option-line-select"><label for="panorama360_prop_title_link_target" class="option-title">' + ed.getLang('panorama360.titleLinkTarget') + '</label><div class="option-content"><select name="panorama360_prop_title_link_target" id="panorama360_prop_title_link_target" class="widefat"><option value="" selected="selected">' + ed.getLang('panorama360.titleLinkTargetSame') + '</option><option value="blank">' + ed.getLang('panorama360.titleLinkTargetNew') + '</option></select></div></div>' +
		'<div class="option-line option-line-checkbox"><label for="panorama360_prop_mousewheel" class="option-title">' + ed.getLang('panorama360.mouseWheel') + '</label><div class="option-content"><input type="checkbox" name="panorama360_prop_mousewheel" id="panorama360_prop_mousewheel" /><div class="option-field-description">' + ed.getLang('panorama360.mouseWheelDescription') + '</div></div></div>' +
		'<div class="option-line option-line-text"><label for="panorama360_prop_mousewheel_multiplier" class="option-title">' + ed.getLang('panorama360.mouseWheelMultiplier') + '</label><div class="option-content"><input type="text" class="widefat" name="panorama360_prop_mousewheel_multiplier" id="panorama360_prop_mousewheel_multiplier" value="10" /><div class="option-field-description">' + ed.getLang('panorama360.mouseWheelMultiplierDescription') + '</div></div></div>' +
		'<div class="option-line option-line-checkbox"><label for="panorama360_prop_sliding_controls" class="option-title">' + ed.getLang('panorama360.slidingControls') + '</label><div class="option-content"><input type="checkbox" name="panorama360_prop_sliding_controls" id="panorama360_prop_sliding_controls" checked="checked" /><div class="option-field-description">' + ed.getLang('panorama360.slidingControlsDescription') + '</div></div></div>' +
		'<div class="option-line option-line-select"><label for="panorama360_prop_sliding_direction" class="option-title">' + ed.getLang('panorama360.slidingDirection') + '</label><div class="option-content"><select name="panorama360_prop_sliding_direction" id="panorama360_prop_sliding_direction" class="widefat"><option value="0" selected="selected">' + ed.getLang('panorama360.slidingDirectionNo') + '</option><option value="-1">' + ed.getLang('panorama360.slidingDirectionLeft') + '</option><option value="1">' + ed.getLang('panorama360.slidingDirectionRight') + '</option></select></div></div>' +
		'<div class="option-line option-line-text"><label for="panorama360_prop_sliding_interval" class="option-title">' + ed.getLang('panorama360.slidingInterval') + '</label><div class="option-content"><input type="text" class="widefat" name="panorama360_prop_sliding_interval" id="panorama360_prop_sliding_interval" value="8" /><div class="option-field-description">' + ed.getLang('panorama360.slidingIntervalDescription') + '</div></div></div>' +
		'<div class="option-line option-line-text"><label for="panorama360_prop_start_pos" class="option-title">' + ed.getLang('panorama360.startPosition') + '</label><div class="option-content"><input type="text" class="widefat" name="panorama360_prop_start_pos" id="panorama360_prop_start_pos" value="0"><div class="option-field-description">' + ed.getLang('panorama360.startPositionDescription') + '</div></div></div>' +
		'<div class="option-line option-line-checkbox"><label for="panorama360_prop_block_context_menu" class="option-title">' + ed.getLang('panorama360.blockContextMenu') + '</label><div class="option-content"><input type="checkbox" name="panorama360_prop_block_context_menu" id="panorama360_prop_block_context_menu" /><div class="option-field-description">' + ed.getLang('panorama360.blockContextMenuDescription') + '</div></div></div>' +
		'<div class="option-line option-line-info">' + ed.getLang('panorama360.popupDescription') + '</div>' +
		'</div></div><div class="media-frame-toolbar"><div class="media-toolbar"><div class="media-toolbar-primary"><a href="#" class="panorama360-popup-submit-button button media-button button-primary button-large media-button-insert">' + ed.getLang('panorama360.submitButton') + '</a></div><div class="media-toolbar-secondary"><a href="#" class="panorama360-popup-cancel-button button media-button button-large media-button-cancel">' + ed.getLang('panorama360.cancelButton') + '</a></div></div></div></div></div></div>');
	var $backdrop = jQuery('<div class="media-modal-backdrop panorama360-shortcodes-modal-backdrop" />');
	$modal.appendTo('body');
	$backdrop.appendTo('body');

	jQuery('#panorama360-shortcodes-modal .media-modal-close, .panorama360-shortcodes-modal-backdrop').click(function(ev) {
		ev.preventDefault();
		panorama360_plugin_popup_close();
	});

	$modal.data('close-function', panorama360_plugin_popup_close);

	jQuery('.panorama360-popup-submit-button').click(function(ev) {
		ev.preventDefault();
		var shortcode_atts = '';
		var pano_type = jQuery('#panorama360_prop_type').val();
		if (pano_type != '') {
			shortcode_atts = shortcode_atts + ' is360="false"';
		}
		var image = jQuery('#panorama360_prop_image').val();
		if (image != '') {
			shortcode_atts = shortcode_atts + ' src="' + image + '"';
			var image_width = jQuery('#panorama360_prop_image_width').val();
			if (image_width != '') {
				shortcode_atts = shortcode_atts + ' src_width="' + image_width + '"';
			}
			var image_height = jQuery('#panorama360_prop_image_height').val();
			if (image_height != '') {
				shortcode_atts = shortcode_atts + ' src_height="' + image_height + '"';
			}
			var image_alt = jQuery('#panorama360_prop_image_alt_text').val();
			if (image_alt != '') {
				shortcode_atts = shortcode_atts + ' src_alt="' + image_alt + '"';
			}
		}
		var title = jQuery('#panorama360_prop_title').val();
		if (title != '') {
			shortcode_atts = shortcode_atts + ' title="' + panorama360_attr_esc(title) + '"';
			var title_link = jQuery('#panorama360_prop_title_link').val();
			if (title_link != '') {
				shortcode_atts = shortcode_atts + ' title_link="' + title_link + '"';
			}
			var title_link_target = jQuery('#panorama360_prop_title_link_target').val();
			if (title_link_target != '') {
				shortcode_atts = shortcode_atts + ' title_link_target="' + title_link_target + '"';
			}
		}
		var pano_style = jQuery('#panorama360_prop_style').val();
		if (pano_style != '') {
			shortcode_atts = shortcode_atts + ' style="' + panorama360_attr_esc(pano_style) + '"';
		}
		if ( jQuery('#panorama360_prop_mousewheel').is(':checked') ) {
			shortcode_atts = shortcode_atts + ' mousewheel="true"';
		}
		var mousewheel_multiplier = jQuery('#panorama360_prop_mousewheel_multiplier').val();
		if (mousewheel_multiplier != '' && mousewheel_multiplier != '10') {
			shortcode_atts = shortcode_atts + ' mousewheel_multiplier="' + mousewheel_multiplier + '"';
		}
		var start_position = jQuery('#panorama360_prop_start_pos').val();
		if (start_position != '' && start_position != '0') {
			shortcode_atts = shortcode_atts + ' start_position="' + start_position + '"';
		}
		if ( ! jQuery('#panorama360_prop_sliding_controls').is(':checked') ) {
			shortcode_atts = shortcode_atts + ' sliding_controls="false"';
		}
		var sliding_direction = jQuery('#panorama360_prop_sliding_direction').val();
		if (sliding_direction != '' && sliding_direction != '0') {
			shortcode_atts = shortcode_atts + ' sliding_direction="' + sliding_direction + '"';
		}
		var sliding_interval = jQuery('#panorama360_prop_sliding_interval').val();
		if (sliding_interval != '' && sliding_interval != '0' && sliding_interval != '8') {
			shortcode_atts = shortcode_atts + ' sliding_interval="' + sliding_interval + '"';
		}
		if ( jQuery('#panorama360_prop_block_context_menu').is(':checked') ) {
			shortcode_atts = shortcode_atts + ' block_contextmenu="true"';
		}

		var code_before = '[panorama360' + shortcode_atts + ']';
		console.log(window.tinymce.activeEditor);
		var code_after = '[/panorama360]';
		if (typeof window.tinymce.activeEditor.insertContent == 'function') {
			window.tinymce.activeEditor.insertContent(code_before + window.tinymce.activeEditor.selection.getContent() + code_after);
		} else {
			window.tinyMCE.activeEditor.selection.setContent(code_before + code_after);
		}
		jQuery('#panorama360-shortcodes-modal').data('close-function')();
	});
}

function cerchez_add_file(event, selector) {
	var upload = jQuery(".uploaded-file"), frame;
	var $el = jQuery(this);
	event.preventDefault();
	if ( frame ) {
		frame.open();
		return;
	}

	frame = wp.media({
		title: $el.data('choose'),
		button: {
			text: $el.data('update'),
			close: false
		}
	});
	frame.on('select', function() {
		var attachment = frame.state().get('selection').first();
		frame.close();
		selector.find('.upload-file').val(attachment.attributes.url);
		if ( attachment.attributes.type == 'image' ) {
			selector.find('.screenshot').hide().html('<img src="' + attachment.attributes.url + '">').slideDown('fast');
			selector.find('.alt-text').val(attachment.attributes.alt);
			selector.find('.width').val(attachment.attributes.width);
			selector.find('.height').val(attachment.attributes.height);
		}
		selector.find('.remove-image').removeClass('hide');
	});
	frame.open();
}

jQuery(document).on('click','#panorama360-shortcodes-modal .upload-image', function(ev) {
	cerchez_add_file(ev, jQuery(this).closest('.option-content'));
});

jQuery(document).on('click','#panorama360-shortcodes-modal .remove-image', function() {
	el = jQuery(this).closest('.option-content');
	el.find('.remove-image').addClass('hide');
	el.find('.upload-file, .alt-text, .width, .height').val('');
	el.find('.screenshot img').remove();
});

function panorama360_attr_esc(str) {
	if (typeof str === "undefined") return '';
	return str.replace(/"/g,'\\"');
}