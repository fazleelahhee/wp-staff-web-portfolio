<?php
/*
    Staff portfolio plugins for wordpress
    Copyright (C) 2012  Fazle Elahee

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
 * 
 */

get_header(); 
$staff = new Staff();
$so = new StaffOption();
?>

		<section id="primary">
			<div id="content" role="main">

			<?php if ( have_posts() ) : ?>

				<header class="page-header">
					<h1 class="page-title">
                                        <?php echo trim($so->getProperty('list_page_title')) != ''? $so->getProperty('list_page_title'): 'Portfolio'; ?>
					</h1>
				</header>
                            
                                <?php if(trim($so->getProperty('list_page_content'))!= ''): ?>
                                <div class="portfolio-archive-content"> 
                                    <p><?php echo $so->getProperty('list_page_content'); ?></p>
                                </div>    
                                <?php endif; ?>
                            
				<?php twentyeleven_content_nav( 'nav-above' ); ?>

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>
                                        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                                                <header class="entry-header">
                                                        <?php
                                                        global $post;
                                                        $image = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'single-post-thumbnail' );
                                                        $staff->load($post->ID);
                                                        if(image && $so->getProperty('list_thumb_image')== 1): 
                                                        ?>
                                                        <div class="thumb-image">
                                                            <img src="<?php echo $image[0]; ?>" width="<?php echo $so->getProperty('list_thumb_image_width'); ?>" height="<?php echo $so->getProperty('list_thumb_image_height'); ?>" />
                                                        </div>    
                                                        <?php endif; ?>
                                                        <div class="staff-meta">
                                                            <h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'twentyeleven' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
                                                            <?php if(trim($staff->getProperty('position')) != '' && $so->getProperty('list_job_title') == 1): ?>
                                                                <p class="staff-job-title">Job Title: <?php echo $staff->getProperty('position'); ?>
                                                            <?php endif; ?>    
                                                        </div>
                                                        
                                                </header><!-- .entry-header -->


                                                <div class="entry-content">
                                                        <?php the_excerpt(); ?>
                                                        <?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'twentyeleven' ) . '</span>', 'after' => '</div>' ) ); ?>
                                                </div><!-- .entry-content -->


                                                <footer class="entry-meta">
                                                </footer><!-- #entry-meta -->
                                        </article><!-- #post-<?php the_ID(); ?> -->

				<?php endwhile; ?>

				<?php twentyeleven_content_nav( 'nav-below' ); ?>

			<?php else : ?>

				<article id="post-0" class="post no-results not-found">
					<header class="entry-header">
						<h1 class="entry-title"><?php _e( 'Nothing Found', 'twentyeleven' ); ?></h1>
					</header><!-- .entry-header -->

					<div class="entry-content">
						<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'twentyeleven' ); ?></p>
						<?php get_search_form(); ?>
					</div><!-- .entry-content -->
				</article><!-- #post-0 -->

			<?php endif; ?>

			</div><!-- #content -->
		</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>