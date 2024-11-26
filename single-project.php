<?php get_header(); ?>

<main class="site-main">
    <div class="container">
        <?php while (have_posts()): the_post(); ?>
            <article id="project-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="project-header">
                    <?php the_title('<h1 class="project-title">', '</h1>'); ?>
                </header>

                <?php if (has_post_thumbnail()): ?>
                    <div class="project-featured-image">
                        <?php the_post_thumbnail('full'); ?>
                    </div>
                <?php endif; ?>

                <div class="project-content">
                    <?php the_content(); ?>
                </div>

                <footer class="project-footer">
                    <?php
                    // Add custom project meta here
                    $project_url = get_post_meta(get_the_ID(), 'project_url', true);
                    if ($project_url): ?>
                        <div class="project-link">
                            <a href="<?php echo esc_url($project_url); ?>" target="_blank">View Project</a>
                        </div>
                    <?php endif; ?>
                </footer>
            </article>
        <?php endwhile; ?>
    </div>
</main>

<?php get_footer(); ?>