<?php /* Template Name: 15Zine Blank Page*/ ?>
<div id="cb-content" class="wrap clearfix">
  
    <div id="main" class="cb-main cb-module-block cb-about-page clearfix" role="main">
		<?php 	while ( have_posts() ) : the_post(); the_content(); endwhile; ?>
    </div> <!-- end #main -->

</div> <!-- end #cb-inner-content -->