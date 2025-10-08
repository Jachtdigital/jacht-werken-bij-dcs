# Changelog

## [V1.0.5] - 2025-10-07

### Added
* English translation support (en_US)
* Plugin now supports multiple languages via WordPress language settings

### Changed
* Renamed translation files to match `jacht-vacancies` text domain
* Dutch remains the default language, English available as translation

---

## [V1.0.4] - 2025-10-07

### Added
* Added duplicate functionality to vacancy list with "Dupliceren" action link
* Duplicated vacancies include all ACF fields, metadata, and taxonomy terms
* Duplicates are created as drafts with " (kopie)" appended to title

---

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
