<?php
get_header(); ?>

<div class="container">
    <h1 class="archive-title"><?php post_type_archive_title(); ?></h1>

    <?php

    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $args = array(
        'post_type' => 'projects',
        'posts_per_page' => 1,
        'paged' => $paged
    );
    $projects_query = new WP_Query($args);
    
    if ($projects_query->have_posts()) : ?>

        <div class="projects-archive">
            <?php while ($projects_query->have_posts()) : $projects_query->the_post(); ?>
                <div class="project-item">
                    <h2 class="project-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <div class="project-excerpt"><?php the_excerpt(); ?></div>
                </div>
            <?php endwhile; ?>
        </div>

        <div class="pagination">
            <div class="prev"><?php previous_posts_link('&laquo; Previous'); ?></div>
            <div class="next"><?php next_posts_link('Next &raquo;', $projects_query->max_num_pages); ?></div>
        </div>

        <?php wp_reset_postdata(); ?>
    
    <?php else : ?>
        <p><?php _e('No projects found.', 'textdomain'); ?></p>
    <?php endif; ?>
</div>

<?php get_footer(); ?>
