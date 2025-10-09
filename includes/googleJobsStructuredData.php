<?php

/* GOOGLE JOBS | Add structured data
=================================================== */
add_action('wp_footer', 'rec_add_google_jobs_structered_data_to_vacancy', 0);
function rec_add_google_jobs_structered_data_to_vacancy() {
    if (is_singular('vacancy')) {

        // Company information
        $vac_company_name   = get_field('vac_company_name');

        // Location information
        $vac_postal_code    = get_field('vac_zip_code');
        $vac_city           = get_field('vac_city');
        $vac_state_name     = get_field('vac_state_name');
        $vac_country        = get_field('vac_country');
        $vac_country_code   = get_field('vac_country_code');

        // Employment type
        $vac_employment     = get_field('vac_employment_type_code');
        $vac_employment_val = 'FULL_TIME'; // Default value
        if ($vac_employment == 'fulltime' || $vac_employment == 'fulltime_fixed_term') {
            $vac_employment_val = 'FULL_TIME';
        } elseif ($vac_employment == 'parttime' || $vac_employment == 'parttime_fixed_term') {
            $vac_employment_val = 'PART_TIME';
        } elseif ($vac_employment == 'internship') {
            $vac_employment_val = 'INTERN';
        } elseif ($vac_employment == 'freelance') {
            $vac_employment_val = 'CONTRACTOR';
        }

        // Remote work
        $vac_remote = get_field('vac_remote');
        $job_location_type = [];
        if ($vac_remote == 'yes') {
            $job_location_type = ['TELECOMMUTE'];
        }

        // Salary information
        $vac_min_salary     = get_field('vac_min_salary');
        $vac_max_salary     = get_field('vac_max_salary');
        $vac_currency       = get_field('vac_currency_salary') ?: 'EUR';
        $vac_period         = get_field('vac_period');

        // Map period to Schema.org unitText
        $unit_text = '';
        switch($vac_period) {
            case 'hour':
                $unit_text = 'HOUR';
                break;
            case 'day':
                $unit_text = 'DAY';
                break;
            case 'week':
                $unit_text = 'WEEK';
                break;
            case 'month':
                $unit_text = 'MONTH';
                break;
            case 'year':
                $unit_text = 'YEAR';
                break;
        }

        // Education and experience requirements
        $vac_education      = get_field('vac_education_code');
        $vac_experience     = get_field('vac_experience_code');

        // Map education levels
        $education_credential_category = '';
        $education_level = '';
        switch($vac_education) {
            case 'vmbo':
                $education_credential_category = 'diploma';
                $education_level = 'VMBO';
                break;
            case 'mbo':
                $education_credential_category = 'diploma';
                $education_level = 'MBO';
                break;
            case 'havo_vwo':
                $education_credential_category = 'diploma';
                $education_level = 'HAVO/VWO';
                break;
            case 'bachelor_degree':
                $education_credential_category = 'degree';
                $education_level = 'HBO Bachelor';
                break;
            case 'master_degree':
                $education_credential_category = 'degree';
                $education_level = 'WO Master';
                break;
            case 'vocational':
                $education_credential_category = 'certificate';
                $education_level = 'Beroepsopleiding';
                break;
        }

        // Map experience levels to text
        $experience_requirements = '';
        switch($vac_experience) {
            case 'entry_level':
                $experience_requirements = 'Starter / geen ervaring vereist';
                break;
            case 'mid_level':
                $experience_requirements = 'Medior / enige ervaring vereist';
                break;
            case 'experienced':
                $experience_requirements = 'Senior / uitgebreide ervaring vereist';
                break;
            case 'student_school':
                $experience_requirements = 'Student / Stagiair';
                break;
        }

        // Requirements/description
        $vac_requirements    = get_field('vac_requirements');

        // Dates
        $vac_post_date = date_i18n('Y-m-d', get_post_time());
		$vac_valid_through = date_i18n('Y-m-d', strtotime($vac_post_date . ' + 1 year'));

        // Build structured data
        $structuredData = [
            "@context"              => "https://schema.org",
            "@type"                 => "JobPosting",
            "title"                 => get_the_title(),
            "datePosted"            => $vac_post_date,
            "validThrough"          => $vac_valid_through,
            "description"           => get_the_content(null, false, null) . ($vac_requirements ? "\n\n" . $vac_requirements : ''),
            "hiringOrganization"    => [
                "@type"                 => "Organization",
                "name"                  => $vac_company_name ?: get_bloginfo('name'),
                "sameAs"                => get_bloginfo('url'),
                "logo"                  => get_site_icon_url() ?: get_template_directory_uri() . '/images/logo.svg',
            ],
            "jobLocation"           => [
                "@type"                 => "Place",
                "address"               => [
                    "@type"                 => "PostalAddress",
                    "streetAddress"         => '',
                    "addressLocality"       => $vac_city,
                    "addressRegion"         => $vac_state_name,
                    "postalCode"            => $vac_postal_code,
                    "addressCountry"        => $vac_country_code ?: 'NL'
                ]
            ],
            "identifier"            => [
                "@type"                 => "PropertyValue",
                "name"                  => $vac_company_name ?: get_bloginfo('name'),
                "value"                 => "vacancy-" . get_the_ID()
            ]
        ];

        // Add employment type (always required)
        $structuredData['employmentType'] = $vac_employment_val;

        // Add job location type (remote) if applicable
        if (!empty($job_location_type)) {
            $structuredData['jobLocationType'] = $job_location_type;
        }

        // Add salary information if available
        if (!empty($vac_min_salary) || !empty($vac_max_salary)) {
            $salary_data = [
                "@type" => "MonetaryAmount",
                "currency" => $vac_currency,
            ];

            // Add value based on what's available
            if (!empty($vac_min_salary) && !empty($vac_max_salary)) {
                // Both min and max available - use minValue and maxValue
                $salary_data['value'] = [
                    "@type" => "QuantitativeValue",
                    "minValue" => floatval($vac_min_salary),
                    "maxValue" => floatval($vac_max_salary),
                    "unitText" => $unit_text
                ];
            } elseif (!empty($vac_min_salary)) {
                // Only min available - use it as single value
                $salary_data['value'] = [
                    "@type" => "QuantitativeValue",
                    "value" => floatval($vac_min_salary),
                    "unitText" => $unit_text
                ];
            } elseif (!empty($vac_max_salary)) {
                // Only max available - use it as single value
                $salary_data['value'] = [
                    "@type" => "QuantitativeValue",
                    "value" => floatval($vac_max_salary),
                    "unitText" => $unit_text
                ];
            }

            $structuredData['baseSalary'] = $salary_data;
        }

        // Add education requirements if available
        if (!empty($education_credential_category)) {
            $structuredData['educationRequirements'] = [
                "@type" => "EducationalOccupationalCredential",
                "credentialCategory" => $education_credential_category,
                "educationalLevel" => $education_level
            ];
        }

        // Add experience requirements if available
        if (!empty($experience_requirements)) {
            $structuredData['experienceRequirements'] = [
                "@type" => "OccupationalExperienceRequirements",
                "monthsOfExperience" => $vac_experience == 'entry_level' ? 0 : ($vac_experience == 'mid_level' ? 24 : 60)
            ];
        }

        // Apply filter to allow customization
        $structuredData = apply_filters('rec_structured_data', $structuredData);
        ?>

        <script type="application/ld+json">
            <?= json_encode($structuredData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) ?>
        </script>
    <?php }
}
