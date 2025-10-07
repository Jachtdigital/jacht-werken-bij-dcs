# Changelog

## [V1.0.3] - 2025-10-07

### Changed
* Renamed main plugin file from `wordpress-recruitee.php` to `wordpress-vacancies.php`

---

## [V1.0.2] - 2025-10-07

### Fixed
* Fixed capability management causing vacancies to go to trash instead of published
* Removed `flush_rewrite_rules()` from running on every page load (performance improvement)
* Removed capability setup from running on every init hook
* Added proper plugin activation hook to set up capabilities once
* Both administrators and editors can now create and publish vacancies

### Changed
* Capabilities are now set up only during plugin activation instead of on every page load
* Improved plugin performance by removing unnecessary operations from init hook

---

## [V1.0.1] - 2025-10-07

### Changed
* **Complete plugin refactor and rebranding**
* Plugin renamed from "Recruitee integration" to "Jacht - Werken bij DCS"
* New ownership: Jacht Digital Marketing (https://jacht.digital)
* Updated text domain from `recruitee-importer` to `jacht-vacancies`
* Plugin folder renamed from `recruitee-koppeling` to `jacht-werken-bij-dcs`

### Removed
* **Removed all Recruitee integration functionality**
* Removed automatic vacancy synchronization from Recruitee API
* Removed Recruitee class and all API calls
* Removed cron job for automated imports
* Removed import/sync functionality from admin interface
* Removed "Recruitee" tab and related fields from vacancy editor (Sollicitatie URL, Vacature URL)
* Removed Recruitee ID column from vacancy table
* Removed raw data tab (Recruitee API data viewer)
* Removed GitLab update checker
* Removed all Recruitee configuration checks and requirements

### Added
* New Constants class (`Jacht\Constants`) for centralized configuration
* Constant `POST_TYPE` to replace hardcoded 'vacancy' strings throughout codebase

### Technical
* Plugin now functions as a standalone vacancy management system
* All vacancy fields retained and functional (location, salary, employment type, etc.)
* Schema.org JobPosting structured data remains active
* ACF field groups maintained for manual vacancy management
* Multi-language support via Polylang still functional
* Gravity Forms integration placeholder available for custom implementations

---

## Previous Versions (Recruitee Integration)

## [V4.0.3]
*   Import vacancies button in upper menu-bar only when on CPT vacancy

## [V4.0.2]
*   Add `readme.txt`

## [V4.0.1]
*   Add Requires Plugins plugin-header for ACF
*   Fix issue where checked on wrong cron

## [V4.0.0]
*   Add wp-cron
*   Added ParseDown
*   Updated README

## [V3.4.0]
*   Add import button in admin bar

## [V3.3.2]
*   Fix issues with language slug on settings page

## [V3.3.1]
*   Fix issues with language slug after WordPress update

## [V3.0.1]
*   Fix issues with Deparments
*   Reorder files

## [V3.0.0]
*   Replaced ContactForm 7 for GravityForms
*   Changed te directory for uploaded files
*   Added Polylang

## [V2.5.0]
*   Added Google jobs structured data
*   Added functionality for offers to switch from draft to published
*   Now offers with status draft get imported

## [V2.4.2]
*   removed js folder
*   Expanded the readme

## [V2.4.1]
*   Fixed cron.php

## [V2.4.0]
*   Add functionality to set CPT slug

## [V2.3.0]
*   Added more post meta to the CPT

## [V2.2.0]
*   Formated to the new layout

## [V2.0.1]
*   Remove "overwrite" checkbox
*   Always update vacancies
*   Better checking on removed items

## [V2.0.0]
*   Fixed bug with remote_cv_url
*   Fixed error in logging
*   Fixed language filter in CRON (duplicate posts)
*   Added raw data tab
*   Added about tab
*   Fixed file uploads
*   Added Raw_data tab
*   Added changelogs
*   Better error handling

## [V1.3.0]
*   Improved error handling
*   Fixed bugs with file upload
*   Cleanup attachments after 7 days

## [V1.2.0]
*   Fixed bug in archive

## [V1.1.0]
*   Remove all translation features
*   Show all vacancies on all languages

## [V1.0.0]
*   Initial version (Recruitee integration)
