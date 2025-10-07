<?php get_header(); ?>

<?php 
    
    // DETAILS
    $vac_company_name       = get_field('vac_company_name');
    $vac_city               = get_field('vac_city');
    $vac_county             = get_field('vac_country');
    $vac_state_code         = get_field('vac_state_code');
    $vac_postal_code        = get_field('vac_zip_code');
    $vac_city               = get_field('vac_city');
    $vac_country_code       = get_field('vac_country_code');

    // CATEGORY
    $vac_category_code      = get_field('vac_category_code');
    $vac_category           = get_vacancy_category_label($vac_category_code);
    
    // REQUIRMENTS
    $vac_requirments        = get_field('vac_requirements');

    // EXPERIENCE
    $vac_experience_code    = get_field('vac_experience_code');
    $vac_experience         = get_vacancy_experience_label($vac_experience_code);

    // EDUCTAION
    $vac_education_code     = get_field('vac_education_code');
    $vac_education          = get_vacancy_education_label($vac_education_code);

    // TYPE
    $vac_employment_code    = get_field('vac_employment_type_code');
    $vac_employment         = get_vacancy_employment_label($vac_employment_code);
    
    // WORKING HOURS
    $vac_min_hours          = get_field('vac_min_hours');
    $vac_max_hours          = get_field('vac_max_hours');
    $vac_working_time       = get_vacancy_working_time($vac_min_hours, $vac_max_hours);

    // SALARY
    $vac_min_salary         = get_field('vac_min_salary');
    $vac_max_salary         = get_field('vac_max_salary');
    $vac_salary             = get_vacancy_salary($vac_min_salary, $vac_max_salary);
    $vac_period_code        = get_field('vac_period');
    $vac_salary_label       = get_vacancy_salary_period_label($vac_period_code);

    // URLS
    $vac_url                = get_field('vac_careers_url');
    $vac_apply_url          = get_field('vac_careers_apply_url');

?>

<main>

    <h1><?= get_the_title() ?></h1>

    <?php if($vac_working_time) { ?>
        <span><?= $vac_working_time ?> Uur</span>
    <?php } ?>

    <?php if($vac_experience) { ?>
        <span><?= $vac_experience ?></span>
    <?php } ?>

    <?php if($vac_city || $vac_county) { ?>
        <span><?= $vac_city ?><?= ($vac_city && $vac_county) ? ', ' : '' ?><?= $vac_county ?></span>
    <?php } ?>

    <?php if($vac_employment) { ?>
        <span><?= $vac_employment ?></span>
    <?php } ?>

    <?php if($vac_education) { ?>
        <span><?= $vac_education ?></span>
    <?php } ?>

    <?php if($vac_category) { ?>
        <span><?= $vac_category ?></span>
    <?php } ?>

    <?php if($vac_salary) { ?>
        <span><?= $vac_salary ?> <?= ($vac_salary_label) ? $vac_salary_label : '' ?></span>
    <?php } ?>

    <?php if(get_the_content()) { ?>
        <p><?= get_the_content() ?></p>
    <?php } ?>

    <?php if($vac_requirments) { ?>
        <p><?= $vac_requirments ?></p>
    <?php } ?>

    <?php if($vac_url) { ?>
        <a href="<?= $vac_url ?>">Link naar Recruitee (Vacature)</a>
    <?php } ?>

    <?php if($vac_apply_url) { ?>
        <a href="<?= $vac_apply_url ?>">Link naar Recruitee (Formulier)</a>
    <?php } ?>

</main>

<?php get_footer(); ?>