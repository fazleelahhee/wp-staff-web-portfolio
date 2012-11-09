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
$so = new StaffOption();
?>
		<div id="primary">
			<div id="content" role="main">

				<?php while ( have_posts() ) : the_post(); ?>

					<nav id="nav-single">
						<h3 class="assistive-text"><?php _e( 'Post navigation', 'twentyeleven' ); ?></h3>
						<span class="nav-previous"><?php previous_post_link( '%link', __( '<span class="meta-nav">&larr;</span> Previous', 'twentyeleven' ) ); ?></span>
						<span class="nav-next"><?php next_post_link( '%link', __( 'Next <span class="meta-nav">&rarr;</span>', 'twentyeleven' ) ); ?></span>
					</nav><!-- #nav-single -->

					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                                        <?php
                                        global $post;
                                        $staff = new Staff($post->ID);
                                        $image = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'single-post-thumbnail' );
                                        ?>
                                        <header class="entry-header">
                                                <h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'twentyeleven' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
                                        </header><!-- .entry-header -->


                                        <div class="entry-content">     
                                                <div class="staff-portfolio-meta">

                                                        <div class="staff-meta">
                                                            <?php if(trim($staff->getProperty('position')) != '' && $so->getProperty('show_job_title') == '1' ): ?>
                                                                <span class="staff-job-title"><strong>Job Title: </strong><?php echo $staff->getProperty('position'); ?></span> <br />
                                                            <?php endif; ?>
                                                            <?php if(trim($staff->getProperty('address')) != '' && $so->getProperty('show_address') == '1'): ?>
                                                                <span class="staff-address"><strong>address: </strong><?php echo $staff->getProperty('address'); ?></span><br />
                                                            <?php endif; ?>
                                                            <?php if(trim($staff->getProperty('work_phone')) != '' && $so->getProperty('show_work_phone') == '1'): ?>
                                                                <span class="staff-work-phone"><strong>Work phone:</strong> <?php echo $staff->getProperty('work_phone'); ?> </span> <br />
                                                            <?php endif; ?>
                                                            <?php if(trim($staff->getProperty('mobile')) != '' && $so->getProperty('show_mobile') == '1'): ?>
                                                                <span class="staff-mobile"><strong>Mobile: </strong><?php echo $staff->getProperty('mobile'); ?> </span> <br />
                                                            <?php endif; ?>
                                                            <?php if(trim($staff->getProperty('email')) != '' && $so->getProperty('show_email') == '1'): ?>
                                                                <span class="staff-email"><strong>Email: </strong><?php echo $staff->getProperty('email'); ?></span> <br />
                                                            <?php endif; ?>   
                                                            <?php if(trim($staff->getProperty('website')) != '' && $so->getProperty('show_website') == '1'): ?>
                                                            <span class="staff-website"><strong>Website: </strong><?php echo $staff->getProperty('website'); ?></span>
                                                            <?php endif; ?>        
                                                        </div>        
                                                       
                                                        <?php if(image && $so->getProperty('show_thumb_image')== 1 ): ?>
                                                        <div class="thumb-image">
                                                            <img src="<?php echo $image[0]; ?>" width="<?php echo $so->getProperty('thumb_image_height'); ?>" height="<?php echo $so->getProperty('thumb_image_width'); ?>" />
                                                        </div>
                                                        <?php endif; ?>
                                                </div>
                                                <?php the_content(); ?>
                                                <?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'twentyeleven' ) . '</span>', 'after' => '</div>' ) ); ?>
                                        </div><!-- .entry-content -->

                                        <footer class="entry-meta">
                                                <?php
                                                        /* translators: used between list items, there is a space after the comma */
                                                        $categories_list = get_the_category_list( __( ', ', 'twentyeleven' ) );

                                                        /* translators: used between list items, there is a space after the comma */
                                                        $tag_list = get_the_tag_list( '', __( ', ', 'twentyeleven' ) );
                                                        if ( '' != $tag_list ) {
                                                                $utility_text = __( 'This entry was posted in %1$s and tagged %2$s by <a href="%6$s">%5$s</a>. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'twentyeleven' );
                                                        } elseif ( '' != $categories_list ) {
                                                                $utility_text = __( 'This entry was posted in %1$s by <a href="%6$s">%5$s</a>. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'twentyeleven' );
                                                        } else {
                                                                $utility_text = __( 'This entry was posted by <a href="%6$s">%5$s</a>. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'twentyeleven' );
                                                        }

                                                        printf(
                                                                $utility_text,
                                                                $categories_list,
                                                                $tag_list,
                                                                esc_url( get_permalink() ),
                                                                the_title_attribute( 'echo=0' ),
                                                                get_the_author(),
                                                                esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) )
                                                        );
                                                ?>
                                                <?php edit_post_link( __( 'Edit', 'twentyeleven' ), '<span class="edit-link">', '</span>' ); ?>

                                                <?php if ( get_the_author_meta( 'description' ) && ( ! function_exists( 'is_multi_author' ) || is_multi_author() ) ) : // If a user has filled out their description and this is a multi-author blog, show a bio on their entries ?>
                                                <div id="author-info">
                                                        <div id="author-avatar">
                                                                <?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'twentyeleven_author_bio_avatar_size', 68 ) ); ?>
                                                        </div><!-- #author-avatar -->
                                                        <div id="author-description">
                                                                <h2><?php printf( __( 'About %s', 'twentyeleven' ), get_the_author() ); ?></h2>
                                                                <?php the_author_meta( 'description' ); ?>
                                                                <div id="author-link">
                                                                        <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
                                                                                <?php printf( __( 'View all posts by %s <span class="meta-nav">&rarr;</span>', 'twentyeleven' ), get_the_author() ); ?>
                                                                        </a>
                                                                </div><!-- #author-link	-->
                                                        </div><!-- #author-description -->
                                                </div><!-- #author-info -->
                                                <?php endif; ?>
                                        </footer><!-- .entry-meta -->
                                        </article><!-- #post-<?php the_ID(); ?> -->

					<?php comments_template( '', true ); ?>

				<?php endwhile; // end of the loop. ?>

			</div><!-- #content -->
		</div><!-- #primary -->

<?php get_footer(); ?>