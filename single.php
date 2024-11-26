<?php get_header(); ?>

<main class="site-main">
    <div class="container">
        <?php while (have_posts()): the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
                    <div class="entry-meta">
                        <?php echo get_the_date(); ?> by <?php the_author(); ?>
                    </div>
                </header>

                <?php if (has_post_thumbnail()): ?>
                    <div class="featured-image">
                        <?php the_post_thumbnail('large'); ?>
                    </div>
                <?php endif; ?>

                <div class="entry-content">
                    <?php the_content(); ?>
                </div>

                <footer class="entry-footer">
                    <?php
                    $categories = get_the_category();
                    if ($categories): ?>
                        <div class="entry-categories">
                            <?php foreach ($categories as $category): ?>
                                <a href="<?php echo get_category_link($category->term_id); ?>"><?php echo $category->name; ?></a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </footer>
            </article>
        <?php endwhile; ?>
    </div>
</main>

<?php get_footer(); ?>