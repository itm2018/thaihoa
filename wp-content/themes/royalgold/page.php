<?php
get_header();
the_post();
?>

	<section id="main">
		<div class="wrapper">
			<h2><?php the_title(); ?></h2>

			<?php the_content(); ?>

            <div class="row social-links">
                <!--FB like and share-->
                <div class="fb-like" data-href="<?php the_permalink() ;?>" data-layout="button_count" data-action="like" data-size="large" data-show-faces="true" data-share="true"></div>
                <!--Twitter like-->
                <a class="twitter-share-button" href="https://twitter.com/intent/tweet?text=<?php the_title() ?> <?php the_permalink();?>" data-size="large" ><button type="button" class="btn btn-primary btn-tweet"><i class="fa fa-twitter"> </i><span style="text-transform: capitalize;">Tweet</span></button> </a>
            </div>

			<?php if ( comments_open() ) : ?>
			<div class="sep"><span></span></div>
			<?php comments_template( '', true ); ?>
			<?php endif; ?>
		</div>
	</section>

<?php get_footer(); ?>

<!--FB-->
<div id="fb-root"></div>
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.10";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
<!--/End FB-->
