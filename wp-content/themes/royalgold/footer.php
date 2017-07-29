<?php
if (is_page_template('template-nocontent.php')) :
	the_content();
else :
	global $smof_data; ?>
	<footer id="footer">
		<div class="right-side">

            <ul class="language-switch">
                <li><?php echo __('Choose your language:', 'royalgold')?></li>
                <li class="menu"><a href="<?php echo make_multilanguage_link('')?>"><?php echo __('Tiếng Việt', 'royalgold')?></a> </li>
                <li class="menu"><a href="<?php echo make_multilanguage_link('en')?>"><?php echo __('English', 'royalgold')?></a> </li>
                <li class="menu"><a href="<?php echo make_multilanguage_link('ru')?>"><?php echo __('Pусский', 'royalgold')?></a> </li>
                <li class="menu"><a href="<?php echo make_multilanguage_link('zh')?>"><?php echo __('中文', 'royalgold')?></a> </li>
            </ul>
            <?php
			if(!empty($smof_data['footer_right_side']))
					echo wp_kses_post(do_shortcode($smof_data['footer_right_side']));
				else
					echo do_shortcode( __('&copy; [the-year] [blog-title]. All Rights Reserved.', 'royalgold') ); ?></div>
		<div class="left-side"><?php
			if( ! empty($smof_data['footer_left_side'])) {
				echo wp_kses_post(do_shortcode($smof_data['footer_left_side']));
			}
		?>

        </div>
		<div class="clear"></div>
	</footer>

<?php
	get_template_part('part-background');
endif; // if full template

wp_footer(); ?>
</body>
</html>