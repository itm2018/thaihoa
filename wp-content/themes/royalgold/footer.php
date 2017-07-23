<?php
if (is_page_template('template-nocontent.php')) :
	the_content();
else :
    function make_multilanguage_link($lang = 'en', $support_langs = array('en', 'ru')){
        try{
            $link = get_permalink();
            $relative_link = preg_replace( '|https?://[^/]+(/.*)|i', '$1', $link );
            foreach($support_langs as $l){
                $relative_link = str_replace('/'.$l, '', $relative_link);
            }
            return site_url() . (!empty($lang) ? '/' : '') . $lang . $relative_link;
        }catch (Exception $e){
            return '/'. $lang;
        }
    }
	global $smof_data; ?>
	<footer id="footer">
		<div class="right-side">

            <ul class="language-switch">
                <li><?php echo __('Choose your language:', 'royalgold')?></li>
                <li class="menu"><a href="<?php echo make_multilanguage_link('')?>"><?php echo __('Vietnamese', 'royalgold')?></a> </li>
                <li class="menu"><a href="<?php echo make_multilanguage_link('en')?>"><?php echo __('English', 'royalgold')?></a> </li>
                <li class="menu"><a href="<?php echo make_multilanguage_link('ru')?>"><?php echo __('Russian', 'royalgold')?></a> </li>
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