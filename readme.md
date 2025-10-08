# Jacht - Werken bij DCS

**Job vacancies management plugin for WordPress.**

This WordPress plugin, developed by [Jacht Digital Marketing](https://jacht.digital/), provides a comprehensive system for managing job vacancies on WordPress websites with advanced features including multi-language support, Schema.org structured data, and complete customization options.

----------

## Description

### Vacancies Management

This plugin provides a comprehensive job vacancy management system for WordPress. Vacancies can be created and managed directly within WordPress, with support for multiple languages through Polylang integration.

### Rich Snippets / Schema.org Structured Data

Built-in JobPosting structured data based on Schema.org specifications for better SEO and Google Jobs integration. The structured data includes:

- Job title, description, and requirements
- Location information (city, province, country)
- Employment type (full-time, part-time, internship, freelance)
- Salary information (min/max with currency and period)
- Remote work options
- Education and experience requirements
- Company information

The structured data can be customized or supplemented using the `rec_structured_data` filter.

----------

## Features

- **Vacancy custom post type**: Dedicated post type for managing job vacancies
- **Advanced Custom Fields**: Extensive meta fields for vacancy details (location, salary, employment type, etc.)
- **Duplicate functionality**: Easily duplicate vacancies with all fields and metadata
- **Multi-language support**: Full integration with Polylang for multilingual vacancy sites (Dutch and English included)
- **Schema.org JobPosting**: Automatic structured data for better SEO and Google Jobs
- **Department taxonomy**: Organize vacancies by department
- **Logs and debugging**: Detailed logs for troubleshooting
- **Frontend templates**: Example templates for displaying vacancies (requires theme customization)
- **Gravity Forms integration**: Placeholder for custom application form implementation

----------

## Installation

1. **Download the plugin**:
    - Download the latest release ZIP from [GitHub Releases](https://github.com/Jachtdigital/jacht-werken-bij-dcs/releases)

2. **Install via WordPress**:
    - Go to WordPress Admin → Plugins → Add New → Upload Plugin
    - Select the downloaded ZIP file
    - Click "Install Now" and then "Activate"

3. **Manual installation**:
    - Upload the plugin files to the `/wp-content/plugins/jacht-werken-bij-dcs` directory
    - Activate the plugin through the 'Plugins' screen in WordPress

4. **Post-activation**:
    - Go to Settings → Permalinks and click "Save Changes" to flush rewrite rules
    - Ensure Advanced Custom Fields Pro is installed and activated

----------

## Requirements

- **WordPress**: Minimum 6.2 (tested up to 6.5)
- **PHP**: Minimum 8.1 (tested up to 8.3)
- **Advanced Custom Fields Pro**: Required for meta field management
- **Polylang Pro**: Optional, for multilingual sites
- **Gravity Forms**: Optional, for application forms (minimum 2.5)

----------

## Configuration

### Dashboard Settings

Access plugin settings via **Vacancies → Settings** in WordPress admin.

**Available tabs**:
- **Instellingen** (Settings): Vacancy overview and management
- **Logs**: Debug logs for troubleshooting
- **Over** (About): Plugin information and documentation
- **Wijzigingslog** (Changelog): Version history and updates

### Customization Options

#### Labels and Slug

Customize post type labels using WordPress filters:

- **Plural/title**: `rec_cpt_title` (default: "Vacatures")
- **Singular**: `rec_cpt_single` (default: "Vacature")
- **URL slug**: `rec_cpt_slug` (default: "jobs")

Example:
```php
add_filter('rec_cpt_slug', function() {
    return 'careers';
});
```

#### Structured Data

Customize Schema.org structured data:

```php
add_filter('rec_structured_data', function($data) {
    // Modify $data array
    return $data;
});
```

----------

## Frontend Integration

### Template Files

The plugin includes example templates in the `examples/` folder:

1. **archive-vacancy.php**: Vacancy listing page template
2. **single-vacancy.php**: Individual vacancy detail page template
3. **functions.php**: Helper functions for extracting and displaying vacancy data

### Using the Templates

1. Copy the example files from `examples/` to your theme directory
2. Customize the templates to match your theme's design
3. Use the helper functions to display vacancy information

----------

## Language Support

The plugin supports multiple languages:

- **Dutch (nl_NL)**: Default language
- **English (en_US)**: Available as translation

To switch languages:
1. Go to **Settings → General**
2. Change **Site Language** to your preferred language
3. Save changes

----------

## Troubleshooting

### Common Issues

**Vacancies not appearing**:
- Go to Settings → Permalinks and click "Save Changes"
- Ensure the plugin is activated
- Check that ACF Pro is installed and activated

**404 errors on vacancy pages**:
- Flush permalinks: Settings → Permalinks → Save Changes

**Vacancies going to trash when created**:
- Deactivate and reactivate the plugin to refresh capabilities

**Translation not working**:
- Verify your WordPress site language is set correctly
- Check that translation files exist in `languages/` folder

----------

## Support

For support, please reach out to [Jacht Digital Marketing](https://jacht.digital):

- **Email**: [info@jacht.digital](mailto:info@jacht.digital)
- **Website**: [https://jacht.digital](https://jacht.digital)
- **GitHub Issues**: [Report a bug](https://github.com/Jachtdigital/jacht-werken-bij-dcs/issues)

----------

## License

This plugin is available under a licensing agreement with Jacht Digital Marketing.

----------

## Changelog

See the [CHANGELOG.md](changelog.md) file for detailed version history and updates.

----------

## Credits

Developed by [Jacht Digital Marketing](https://jacht.digital/)

**Tags**: vacancies, vacatures, jobs, recruitment, schema.org, jobposting
