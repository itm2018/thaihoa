/*!
 * 360 Panoramic Viewer - 1.1
 * Liviu Cerchez (http://codecanyon.net/user/liviu_cerchez/)
 */

(function($) {
	$.fn.panorama360 = function(options) {
		return this.each(function() {
			var settings = {
				start_position: 0, // initial start position for the view
				image_width: 0,
				image_height: 0,
				mouse_wheel_active: 1,
				mouse_wheel_multiplier: 10,
				bind_resize: true, // determine if window resize affects panorama viewport
				is360: true, // glue left and right and make it scrollable
				sliding_controls: true, // determine if UI controls for sliding are created
				sliding_direction: 0, // determines the automatic sliding direction: 0 - no automatic slide effect, 1 - right side effect, -1 - left side effect
				sliding_interval: 8, // determines the interval in miliseconds of the sliding timer
				block_contextmenu: 0 // determines if the context menu is blocked (right click)
			};
			if (options) $.extend(settings, options);
			var viewport = $(this);
			var panoramaContainer = viewport.children('.panorama-container');
			var panoramaContainerObj = panoramaContainer.get(0);
			var viewportImage = panoramaContainer.children('img:first-child');
			if (settings.image_width <= 0 && settings.image_height <= 0) {
				settings.image_width = parseInt(viewportImage.data("width"));
				settings.image_height = parseInt(viewportImage.data("height"));
				if (!(settings.image_width) || !(settings.image_height)) return;
			}
			var image_ratio = settings.image_height / settings.image_width;
			var elem_height = parseInt(viewport.height());
			var elem_width = parseInt(elem_height / image_ratio);
			var image_map = viewportImage.attr('usemap');
			var image_areas;
			var isDragged = false;
			var mouseXprev = 0;
			var scrollDelta = 0;
			var resize_binded = false;
			if (settings.is360) viewportImage.removeAttr("usemap").css("left", 0).clone().css("left", elem_width + "px").insertAfter(viewportImage);
			panoramaContainer.css({
				'margin-left': '-' + settings.start_position + 'px',
				'width': (elem_width * 2) + 'px',
				'height': (elem_height) + 'px'
			});
			if (settings.block_contextmenu) panoramaContainer.addClass('no-contextmenu');
			if (settings.is360) {
				setInterval(function() {
					if (isDragged) return false;
					if (scrollDelta < -2 || 2 < scrollDelta)
						scrollDelta *= 0.97;
					else
						scrollDelta = -settings.sliding_direction * 2;
					if (scrollDelta) scrollView360(panoramaContainerObj, elem_width, scrollDelta, settings);
				}, settings.sliding_interval);
			} else {
				setInterval(function() {
					if (isDragged) return false;
					if (scrollDelta < -2 || 2 < scrollDelta)
						scrollDelta *= 0.98;
					else
						scrollDelta = -settings.sliding_direction * 2;
					if (scrollDelta) scrollView180(panoramaContainer, elem_width, scrollDelta, settings);
				}, settings.sliding_interval);
			}
			
			viewport.unbind('mousedown mouseup mousemove mouseout mousewheel contextmenu touchmove touchend');
			viewport.mousedown(function(e) {
				if (isDragged) return false;
				$(this).addClass("grab");
				isDragged = true;
				mouseXprev = e.clientX;
				scrollOffset = 0;
				return false;
			}).mouseup(function() {
				$(this).removeClass("grab");
				isDragged = false;
				if (settings.sliding_direction) settings.sliding_direction = scrollDelta > 0 ? -1 : 1;
				scrollDelta = scrollDelta * 0.45;
				settings.sliding_direction = 0;
				return false;
			}).mousemove(function(e) {
				if (!isDragged) return false;
				scrollDelta = parseInt((e.clientX - mouseXprev));
				mouseXprev = e.clientX;
				if (settings.is360)
					scrollView360(panoramaContainerObj, elem_width, scrollDelta, settings);
				else
					scrollView180(panoramaContainer, elem_width, scrollDelta, settings);
				return false;
			}).mouseout(function(e) {
				isDragged = false;
			}).bind("mousewheel", function(e, distance) {
				if (!settings.mouse_wheel_active) return;
				var delta = Math.ceil(Math.sqrt(Math.abs(distance)));
				if (settings.sliding_direction != 0) {
					settings.sliding_direction = distance < 0 ? 1 : -1;
				}
				delta = distance < 0 ? -delta : delta;
				scrollDelta = scrollDelta + delta * 5;
				if (settings.is360)
					scrollView360(panoramaContainerObj, elem_width, delta * settings.mouse_wheel_multiplier, settings);
				else
					scrollView180(panoramaContainer, elem_width, delta * settings.mouse_wheel_multiplier, settings);
				settings.sliding_direction = 0;
				return false;
			}).bind('contextmenu', function (e) {
				if (settings.block_contextmenu) {
					e.preventDefault();
					return false;
				}
			}).bind('touchstart', function(e) {
				if (isDragged) return false;
				isDragged = true;
				mouseXprev = e.originalEvent.touches[0].pageX;
				scrollOffset = 0;
			}).bind('touchmove', function(e) {
				if (!isDragged) return false;
				var touch_x = e.originalEvent.touches[0].pageX;
				scrollDelta = parseInt((touch_x - mouseXprev));
				mouseXprev = touch_x;
				if (settings.is360)
					scrollView360(panoramaContainerObj, elem_width, scrollDelta, settings);
				else
					scrollView180(panoramaContainer, elem_width, scrollDelta, settings);
			}).bind('touchend', function(e) {
				isDragged = false;
				if (settings.sliding_direction) settings.sliding_direction = scrollDelta > 0 ? -1 : 1;
				scrollDelta = scrollDelta * 0.45;
				settings.sliding_direction = 0;
			});
			if (image_map) {
				if (image_map.indexOf("#") < 0) image_map = '#' + image_map;
				new_area = $("a").addClass("area");
				$('map' + image_map,panoramaContainer).children('area').each(function() {
					switch ($(this).attr("shape").toLowerCase()) {
						case 'rect':
							var area_coord = $(this).attr("coords").split(",");
							var new_area = $(document.createElement('a')).addClass("area");
							new_area.attr("href", $(this).attr("href"));
							new_area.attr("title", $(this).attr("alt"));
							new_area.attr("target", $(this).attr("target"));
							if ($(this).attr("rel")) new_area.attr("rel", $(this).attr("rel"));
							new_area.addClass($(this).attr("class"));
							panoramaContainer.append(new_area.data("stitch", 1).data("coords", area_coord));
							if (settings.is360) panoramaContainer.append(new_area.clone().data("stitch", 2).data("coords", area_coord));
							break;
					}
				});
				$('map' + image_map,panoramaContainer).remove();
				image_areas = panoramaContainer.children(".area");
				image_areas.mouseup(stopEvent).mousemove(stopEvent).mousedown(stopEvent);
				repositionHotspots(image_areas, settings.image_height, elem_height, elem_width);
			}
			if (settings.sliding_controls) {
				var controls = viewport.parent().find('.controls');
				if (controls.length == 0) {
					var controls = $('<div class="controls"></div>').insertAfter(viewport);
					$('<a class="prev"><span>&#9664;</span></a>').click(function(ev) {
						settings.sliding_direction = -1;
						scrollDelta = 0;
						ev.preventDefault();
					}).appendTo(controls);
					$('<a class="stop"><span>&#8718</span></a>').click(function(ev) {
						settings.sliding_direction = 0;
						scrollDelta = 0;
						ev.preventDefault();
					}).appendTo(controls);
					$('<a class="next"><span>&#9654;</span></a>').click(function(ev) {
						settings.sliding_direction = 1;
						scrollDelta = 0;
						ev.preventDefault();
					}).appendTo(controls);
				}
			}
			if (settings.bind_resize && !resize_binded) {
				resize_binded = true;
				$(window).resize(function() {
					$parent = viewport.parent();
					elem_height = parseInt($parent.height());
					elem_width = parseInt(elem_height / image_ratio);
					panoramaContainer.css({
						'width': (elem_width * 2) + 'px',
						'height': (elem_height) + 'px'
					});
					viewportImage.css("left", 0).next().css("left", elem_width + "px");
					if (image_map) repositionHotspots(image_areas, settings.image_height, elem_height, elem_width);
				});
			}
		});
		function stopEvent(e) {
			e.preventDefault();
			return false;
		}
		function scrollView180(panoramaContainer, elem_width, delta, settings) {
			var newMarginLeft = parseInt(panoramaContainer.css('marginLeft')) + delta;
			var right = -(elem_width - panoramaContainer.parent().width());
			if (newMarginLeft > 0) {
				newMarginLeft = 0;
				if (settings.sliding_direction) settings.sliding_direction *= -1;
			}
			if (newMarginLeft < right) {
				newMarginLeft = right;
				if (settings.sliding_direction) settings.sliding_direction *= -1;
			}
			panoramaContainer.css('marginLeft', newMarginLeft + 'px');
		}
		function scrollView360(panoramaContainerObj, elem_width, delta, settings) {
			var newMarginLeft = parseInt(panoramaContainerObj.style.marginLeft) + delta;
			if (newMarginLeft > 0) newMarginLeft = -elem_width;
			if (newMarginLeft < -elem_width) newMarginLeft = 0;
			panoramaContainerObj.style.marginLeft = newMarginLeft + 'px';
		}
		function repositionHotspots(areas, image_height, elem_height, elem_width) {
			var percent = elem_height / image_height;
			areas.each(function() {
				area_coord = $(this).data("coords");
				stitch = $(this).data("stitch");
				switch (stitch) {
					case 1:
						$(this).css({
							'left': (area_coord[0] * percent) + "px",
							'top': (area_coord[1] * percent) + "px",
							'width': ((area_coord[2] - area_coord[0]) * percent) + "px",
							'height': ((area_coord[3] - area_coord[1]) * percent) + "px"
						});
						break;
					case 2:
						$(this).css({
							'left': (elem_width + parseInt(area_coord[0]) * percent) + "px",
							'top': (area_coord[1] * percent) + "px",
							'width': ((area_coord[2] - area_coord[0]) * percent) + "px",
							'height': ((area_coord[3] - area_coord[1]) * percent) + "px"
						});
						break;
				}
			});
		}
	}

})(jQuery);

function triggerPanoramaInit(target) {
	jQuery('.panorama-view:not(.panorama-view-init)', target).each(function() {
		$this = jQuery(this);
		if ($this.hasClass('panorama-view-init')) return;

		$this.addClass('panorama-view-init');
		var $defaults = {};
		if (typeof $this.data('start-position') !== 'undefined') {
			jQuery.extend( $defaults, { start_position : $this.data('start-position') } );
		}
		if (typeof $this.data('mousewheel-multiplier') !== 'undefined') {
			jQuery.extend( $defaults, { mouse_wheel_multiplier : $this.data('mousewheel-multiplier') } );
		}
		if (typeof $this.data('mousewheel') !== 'undefined') {
			jQuery.extend( $defaults, { mouse_wheel_active : $this.data('mousewheel') } );
		}
		if (typeof $this.data('bind-resize') !== 'undefined') {
			jQuery.extend( $defaults, { bind_resize : $this.data('bind-resize') } );
		}
		if (typeof $this.data('is360') !== 'undefined') {
			jQuery.extend( $defaults, { is360 : $this.data('is360') } );
		}
		if (typeof $this.data('sliding-controls') !== 'undefined') {
			jQuery.extend( $defaults, { sliding_controls : $this.data('sliding-controls') } );
		}
		if (typeof $this.data('sliding-direction') !== 'undefined') {
			jQuery.extend( $defaults, { sliding_direction : $this.data('sliding-direction') } );
		}
		if (typeof $this.data('sliding-interval') !== 'undefined') {
			jQuery.extend( $defaults, { sliding_interval : $this.data('sliding-interval') } );
		}
		if (typeof $this.data('block-contextmenu') !== 'undefined') {
			jQuery.extend( $defaults, { block_contextmenu : $this.data('block-contextmenu') } );
		}
		$this.panorama360($defaults);
	});
}

jQuery(function() {
	triggerPanoramaInit(document.body);
});

jQuery(document).on("cerchezWidgetUpdate", function(e){
	triggerPanoramaInit(e.target);
});