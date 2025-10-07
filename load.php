<?php

require_once(REC_PLUGIN_DIR . '/helpers.php');

require_once(REC_PLUGIN_DIR . '/includes/constants.php');

require_once(REC_PLUGIN_DIR . '/classes/Notification.php');
require_once(REC_PLUGIN_DIR . '/classes/LoggerInterface.php');
require_once(REC_PLUGIN_DIR . '/classes/AbstractLogger.php');
require_once(REC_PLUGIN_DIR . '/classes/LogLevel.php');
require_once(REC_PLUGIN_DIR . '/classes/Log.php');
require_once(REC_PLUGIN_DIR . '/classes/Parsedown.php');

require_once(REC_PLUGIN_DIR . '/classes/VacancyTable.php');

require_once(REC_PLUGIN_DIR . '/cpt/vacancy.php');
require_once(REC_PLUGIN_DIR . '/cpt/capabilities.php');

require_once(REC_PLUGIN_DIR . '/acf/acf.php');

require_once(REC_PLUGIN_DIR . '/form/gravity.php');

require_once(REC_PLUGIN_DIR . '/includes/googleJobsStructuredData.php');

require_once(REC_PLUGIN_DIR . '/functions.php');

// Plugin update checker removed - no longer using GitLab updates