<?php get_header(); ?>

    <div class="container  margin-top--lg">
        <div class="row">
            <div class="col-md-8">
                <section id="content" role="main">
                    <header class="header">
                        <?php the_post(); ?>
                        <h1 class="entry-title author"><?php _e('Author Archives', 'thomascoward'); ?>
                            : <?php the_author_link(); ?></h1>
                        <?php if ('' != get_the_author_meta('user_description')) echo apply_filters('archive_meta', '<div class="archive-meta">' . get_the_author_meta('user_description') . '</div>'); ?>
                        <?php rewind_posts(); ?>
                    </header>
                    <?php while (have_posts()) : the_post(); ?>
                        <?php get_template_part('entry'); ?>
                    <?php endwhile; ?>
                    <?php get_template_part('nav', 'below'); ?>
                </section>
            </div>

            <div class="col-md-4">
                <?php get_sidebar(); ?>
            </div>
        </div>
    </div>
<?php get_footer(); ?>