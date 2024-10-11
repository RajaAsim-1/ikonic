<style type="text/css">
.projects-list {
display: flex;
flex-wrap: wrap;
gap: 20px;
}

.project-item {
    width: 30%;
    border: 1px solid #ddd;
    padding: 10px;
}

.project-thumbnail img {
    max-width: 100%;
    height: auto;
}

.pagination {
    margin-top: 20px;
    text-align: center;
}

</style>
<?php
get_header();

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

// Custom query for projects
$args = array(
    'post_type' => 'projects',
    'posts_per_page' => 6,
    'paged' => $paged
);

$projects_query = new WP_Query($args);

if ($projects_query->have_posts()) : ?>
    <div class="projects-archive">
        <h1><?php post_type_archive_title(); ?></h1>
        
        <div class="projects-list">
            <?php while ($projects_query->have_posts()) : $projects_query->the_post(); ?>
                <div class="project-item">
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="project-thumbnail">
                            <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('medium'); ?></a>
                        </div>
                    <?php endif; ?>
                    <div class="project-content">
                        <?php the_excerpt(); ?>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
        
        <!-- Pagination -->
        <div class="pagination">
            <?php
            previous_posts_link('&laquo; Previous');
            next_posts_link('Next &raquo;', $projects_query->max_num_pages);
            ?>
        </div>
    </div>

    <?php wp_reset_postdata(); ?>

<?php else : ?>
    <p><?php _e('Sorry, no projects found.'); ?></p>
<?php endif; ?>

<?php get_footer(); ?>
