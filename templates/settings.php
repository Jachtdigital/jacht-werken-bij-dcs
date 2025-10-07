<?php

    use Recruitee\VacancyTable;
    use Recruitee\Parsedown;
    use Recruitee\Notification;
    use Jacht\Constants;

    $pluginDataSelf = get_plugin_data(REC_PLUGIN);
    $vacancyTable = new VacancyTable();

    // TABS
    $allTabs = [
        'settings'      => __('Instellingen', 'jacht-vacancies'),
        'logs'          => __('Logs', 'jacht-vacancies'),
        'about'         => __('Over', 'jacht-vacancies'),
        'changelog'     => __('Wijzigingslog', 'jacht-vacancies'),
    ];
    $currentTab = (!empty($_GET['tab']) && array_key_exists($_GET['tab'], $allTabs)) ? esc_attr($_GET['tab']) : 'settings';

    // LOGS
    if ($currentTab === 'logs') {
        $logFolder = REC_PLUGIN_DIR . '/logs';
        $logFiles = scandir($logFolder, SCANDIR_SORT_DESCENDING);
        $logFiles = array_filter($logFiles, static function ($logItem) use ($logFolder) {
            return is_file($logFolder . '/' . $logItem);
        });
        if (isset($_POST['log_file'])) {
            $logFile = $logFolder . '/' . $_POST['log_file'];
        } else {
            $logFile = $logFolder . '/' . $logFiles[0];
        }
        $logFileContent = file_get_contents($logFile);
    }


?>

<div class="wrap">
    <h1><?= $pluginDataSelf['Name'] ?></h1>
    <div class="nav-tab-wrapper">
        <?php foreach ($allTabs as $tabSlug => $tabName) { ?>
            <a class="nav-tab<?= (($tabSlug === $currentTab) ? ' nav-tab-active' : '') ?>" href="?post_type=<?= Constants::POST_TYPE ?>&page=recruitee-settings&tab=<?= $tabSlug ?>"><?= $tabName ?></a>
        <?php } ?>
    </div>
</div>

<div class='wrap'>
    <?php if ($currentTab === 'settings') { ?>
        <div class="container">
            <div class="notifications" id="notifications"></div>

            <div class="content-cell">
                <form id="vacancy" method="get" action="">
                    <input type="hidden" name="post_type" value="<?= Constants::POST_TYPE ?>"/>
                    <input type="hidden" name="page" value="recruitee-settings"/>

					<?php
                        $vacancyTable->prepare_items();
                        $vacancyTable->search_box(__('Zoeken', 'jacht-vacancies'), 'search');
                        $vacancyTable->display();
					?>
                </form>
            </div>

            <!-- Sidebar -->
            <div class="content-cell" id="sidebar-container">

                <!-- Plugin status -->
                <div class="card plugin">
                    <h2><?= __('Plugin status', 'jacht-vacancies') ?></h2>
                    <table class="table">
                        <tr>
                            <th><?= __('Vacatures', 'jacht-vacancies') ?>:</th>
                            <td><?= wp_count_posts( Constants::POST_TYPE )->publish; ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Beschikbare talen', 'jacht-vacancies') ?>:</th>
                            <?php if (is_plugin_active('polylang-pro/polylang.php')) { ?>
                                <?php $languages = array_column(pll_the_languages(array('echo' => 0, 'raw' => 1)), 'slug'); ?>
                                <td><?= strtoupper(implode(', ', $languages)) ?></td>
                            <?php } else { ?>
                                <td><?= strtoupper(substr(get_bloginfo("language"), 0, 2)) ?></td>
                            <?php } ?>
                        </tr>
                    </table>
                </div>

                <!-- Required plugins -->
                <div class="card plugin">
                    <h2><?= __('Vereiste plugins', 'jacht-vacancies') ?></h2>
                    <table class="table">
                        <tr>
                            <th><?= __('PHP versie', 'jacht-vacancies') ?>:</th>
                            <td><?= PHP_VERSION ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Plugin versie', 'jacht-vacancies') ?>:</th>
                            <td><?= get_plugin_data(REC_PLUGIN)['Version'] ?? ' - ' ?></td>
                        </tr>
                        <tr>
                            <th><?= __('IP adres', 'jacht-vacancies') ?>:</th>
                            <td><?= $_SERVER['SERVER_ADDR'] ?? __('Niet ingesteld', 'jacht-vacancies') ?></td>
                        </tr>

                        <tr>
                            <th><?= __('WordPress versie', 'jacht-vacancies') ?>:</th>
                            <td><?= get_wp_version() ?></td>
                        </tr>
                        <tr>
                            <th><?= __('ACF', 'jacht-vacancies') ?>:</th>
                            <?php if (is_plugin_active('advanced-custom-fields-pro/acf.php')) { ?>
                                <td><?= __('Ingeschakeld', 'jacht-vacancies') ?> (<?= get_option('acf_version') ?>)</td>
                            <?php } else { ?>
                                <td><?= __('Niet ingeschakeld', 'jacht-vacancies') ?></td>
                            <?php } ?>
                        </tr>
                        <tr>
                            <th><?= __('Polylang', 'jacht-vacancies') ?>:</th>
                            <?php if (is_plugin_active('polylang-pro/polylang.php')) { ?>
                                <td><?= __('Ingeschakeld', 'jacht-vacancies') ?></td>
                            <?php } else { ?>
                                <td><?= __('Niet ingeschakeld', 'jacht-vacancies') ?></td>
                            <?php } ?>
                        </tr>
                        <tr>
                            <th><?= __('Gravity Forms', 'jacht-vacancies') ?>:</th>
                            <?php if (is_plugin_active('gravityforms/gravityforms.php')) { ?>
                                <td><?= __('Ingeschakeld', 'jacht-vacancies') ?></td>
                            <?php } else { ?>
                                <td><?= __('Niet ingeschakeld', 'jacht-vacancies') ?></td>
                            <?php } ?>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    <?php } elseif ($currentTab === 'logs') { ?>
        <div id="log-viewer-select">
            <div class="alignleft">
                <h2><?= $_POST['log_file'] ?? $logFiles[0] ?></h2>
            </div>
            <div class="alignright">
                <form action="" method="POST">
                    <label>
                        <select name="log_file">
                            <?php foreach ($logFiles as $logFile) { ?>
                                <option value="<?= $logFile ?>" <?= isset($_POST['log_file']) && $logFile === $_POST['log_file'] ? 'selected' : '' ?>><?= $logFile ?></option>
                            <?php } ?>
                        </select>
                    </label>
                    <button type="submit" class="button"><?= __('Laden', 'jacht-vacancies') ?></button>
                </form>
            </div>
            <div class="clear">
                <div id="log-viewer">
                    <pre><?= $logFileContent ?></pre>
                </div>
            </div>
        </div>
    <?php } elseif ($currentTab === 'changelog') { ?>
        <div id="log-viewer">
            <?= Parsedown::instance()->text(file_get_contents(REC_PLUGIN_DIR . '/changelog.md')) ?>
        </div>
    <?php } elseif ($currentTab === 'about') { ?>
        <div id="log-viewer">
			<?= Parsedown::instance()->text(file_get_contents(REC_PLUGIN_DIR . '/README.md')) ?>
        </div>
    <?php } ?>
</div>
