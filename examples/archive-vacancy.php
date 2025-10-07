<?php get_header(); ?>

<main>

    <h1><?php post_type_archive_title(); ?></h1>
    <?php if (have_posts()) { ?>

        <div class="row g-3">
            <?php while (have_posts()) { ?>
                <?php the_post(); ?>

                <?php
                    // DETAILS
                    $vac_city               = get_field('vac_city');
                    $vac_county             = get_field('vac_country');

                    // EXPERIENCE
                    $vac_experience_code    = get_field('vac_experience_code');
                    $vac_experience         = get_vacancy_experience_label($vac_experience_code);

                    // WORKING HOURS
                    $vac_min_hours          = get_field('vac_min_hours');
                    $vac_max_hours          = get_field('vac_max_hours');
                    $vac_working_time       = get_vacancy_working_time($vac_min_hours, $vac_max_hours);
                ?>

                <h2><?= get_the_title() ?></h2>

                <?php if($vac_working_time) { ?>
                    <span><?= $vac_working_time ?> Uur</span>
                <?php } ?>

                <?php if($vac_experience) { ?>
                    <span><?= $vac_experience ?></span>
                <?php } ?>

                <?php if($vac_city || $vac_county) { ?>
                    <span><?= $vac_city ?><?= ($vac_city && $vac_county) ? ', ' : '' ?><?= $vac_county ?></span>
                <?php } ?>

                <a href="<?= get_the_permalink() ?>">Bekijk vacature</a>

            <?php } ?>
            <?= paginate_links() ?>
        </div>
    <?php } ?>
    <?php wp_reset_query(); ?>

</main>

<?php get_footer(); ?>