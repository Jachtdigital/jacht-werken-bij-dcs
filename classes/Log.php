<?php

namespace Recruitee;

use DateTime;
use DirectoryIterator;
use Exception;
use RuntimeException;

class Log extends AbstractLogger
{
	protected $options = [
		'extension'      => 'log',
		'dateFormat'     => 'd-m-Y H:i:s',
		'filename'       => false,
		'flushFrequency' => false,
		'prefix'         => 'recruitee_log_',
		'logFormat'      => false,
		'appendContext'  => true,
	];
	/**
	 * Current minimum logging threshold
	 * @var integer
	 */
	protected $logLevelThreshold = LogLevel::DEBUG;
	/**
	 * Log Levels
	 * @var array
	 */
	protected array $logLevels = [
		LogLevel::EMERGENCY => 0,
		LogLevel::ALERT     => 1,
		LogLevel::CRITICAL  => 2,
		LogLevel::ERROR     => 3,
		LogLevel::WARNING   => 4,
		LogLevel::NOTICE    => 5,
		LogLevel::INFO      => 6,
		LogLevel::DEBUG     => 7,
	];
	/**
	 * Path to the log file
	 * @var string
	 */
	private string $logFilePath;
	/**
	 * The number of lines logged in this instance's lifetime
	 * @var int
	 */
	private int $logLineCount = 0;
	/**
	 * This holds the file handle for this instance's log file
	 * @var resource
	 */
	private $fileHandle;

	/**
	 * This holds the last line logged to the logger
	 *  Used for unit tests
	 * @var string
	 */
	private string $lastLine = '';

	/**
	 * Octal notation for default permissions of the log file
	 * @var integer
	 */
	private int $defaultPermissions = 0777;

	private string $logDirectory;
	/**
	 * @var int
	 */
	private int $retainLogsDays;

	/**
	 * Class constructor
	 *
	 * @param string $logDirectory File path to the logging directory
	 * @param string $logLevelThreshold The LogLevel Threshold
	 * @param int $retainLogDays The amount of logs that are stored.
	 * @param array $options
	 *
	 * @internal param string $logFilePrefix The prefix for the log file name
	 * @internal param string $logFileExt The extension for the log file
	 */
	public function __construct($logDirectory, $logLevelThreshold = LogLevel::DEBUG, $retainLogDays = 7, array $options = [])
	{
		$this->logLevelThreshold = $logLevelThreshold;
		$this->options = array_merge($this->options, $options);
		$this->logDirectory = $logDirectory;
		$this->retainLogsDays = $retainLogDays;

		$logDirectory = rtrim($logDirectory, DIRECTORY_SEPARATOR);


		if (!file_exists($logDirectory) && !mkdir($logDirectory, $this->defaultPermissions, true) && !is_dir($logDirectory)) {
			throw new RuntimeException(sprintf('Directory "%s" was not created', $logDirectory));
		}


		if (strpos($logDirectory, 'php://') === 0) {
			$this->setLogToStdOut($logDirectory);
			$this->setFileHandle('w+');
		} else {
			$this->setLogFilePath($logDirectory);
			if (file_exists($this->logFilePath) && !is_writable($this->logFilePath)) {
				throw new RuntimeException('The file could not be written to. Check that appropriate permissions have been set.');
			}
			$this->setFileHandle('a');
		}

		if (!$this->fileHandle) {
			throw new RuntimeException('The file could not be opened. Check permissions.');
		}
		$this->cleanLogs();
	}

	public function cleanLogs()
	{
		$folder = $this->logDirectory;
		$cleaned_logs = 0;

		if (is_dir($folder)) {
			foreach (new DirectoryIterator($folder) as $fileInfo) {
				if ($fileInfo->isDot()) {
					continue;
				}
				if ($fileInfo->isFile() && time() - $fileInfo->getCTime() >= ($this->retainLogsDays) * 24 * 60 * 60) {
					if ($fileInfo->getExtension() === 'log') {
						$this->info(sprintf("Deleting log file %s", $fileInfo->getFileName()));
						unlink($fileInfo->getRealPath());
						$cleaned_logs++;
					}
				}
			}

			if ($cleaned_logs) {
				$this->info(sprintf('Cleaning up %d logs older than %s days', $cleaned_logs, $this->retainLogsDays));
			}
			return true;
		}

		$this->error(sprintf('Folder %s does not exists.', $folder));

		return false;
	}

	/**
	 * @param string $stdOutPath
	 */
	public function setLogToStdOut($stdOutPath)
	{
		$this->logFilePath = $stdOutPath;
	}

	/**
	 * @param $writeMode
	 *
	 * @internal param resource $fileHandle
	 */
	public function setFileHandle($writeMode)
	{
		$this->fileHandle = fopen($this->logFilePath, $writeMode);
	}

	public static function getLogLevels()
	{
		return [
			LogLevel::EMERGENCY,
			LogLevel::ALERT,
			LogLevel::CRITICAL,
			LogLevel::ERROR,
			LogLevel::WARNING,
			LogLevel::NOTICE,
			LogLevel::INFO,
			LogLevel::DEBUG,
		];

	}

	/**
	 * Class destructor
	 */
	public function __destruct()
	{
		if ($this->fileHandle) {
			fclose($this->fileHandle);
		}
	}

	/**
	 * Sets the date format used by all instances of KLogger
	 *
	 * @param string $dateFormat Valid format string for date()
	 */
	public function setDateFormat($dateFormat)
	{
		$this->options['dateFormat'] = $dateFormat;
	}

	/**
	 * Sets the Log Level Threshold
	 *
	 * @param string $logLevelThreshold The log level threshold
	 */
	public function setLogLevelThreshold($logLevelThreshold)
	{
		$this->logLevelThreshold = $logLevelThreshold;
	}

	/**
	 * Logs with an arbitrary level.
	 *
	 * @param mixed $level
	 * @param string $message
	 * @param array $context
	 * @return null
	 */
	public function log($level, $message, array $context = [])
	{
		if ($this->logLevels[$this->logLevelThreshold] < $this->logLevels[$level]) {
			return;
		}
		$message = $this->formatMessage($level, $message, $context);
		$this->write($message);
	}

	/**
	 * Formats the message for logging.
	 *
	 * @param string $level The Log Level of the message
	 * @param string $message The message to log
	 * @param array $context The context
	 * @return string
	 * @throws Exception
	 * @throws Exception
	 * @throws Exception
	 */
	protected function formatMessage($level, $message, $context)
	{
		if ($this->options['logFormat']) {
			$parts = [
				'date'          => $this->getTimestamp(),
				'level'         => strtoupper($level),
				'level-padding' => str_repeat(' ', 9 - strlen($level)),
				'priority'      => $this->logLevels[$level],
				'message'       => $message,
				'context'       => json_encode($context),
			];
			$message = $this->options['logFormat'];
			foreach ($parts as $part => $value) {
				$message = str_replace('{' . $part . '}', $value, $message);
			}

		} else {
			$message = "[{$this->getTimestamp()}] [{$level}] {$message}";
		}

		if ($this->options['appendContext'] && !empty($context)) {
			$message .= PHP_EOL . $this->indent($this->contextToString($context));
		}

		return $message . PHP_EOL;

	}

	/**
	 * Gets the correctly formatted Date/Time for the log entry.
	 *
	 * PHP DateTime is dump, and you have to resort to trickery to get microseconds
	 * to work correctly, so here it is.
	 *
	 * @return string
	 * @throws Exception
	 * @throws Exception
	 * @throws Exception
	 */
	private function getTimestamp()
	{
		$originalTime = microtime(true);
		$micro = sprintf("%06d", ($originalTime - floor($originalTime)) * 1000000);
		$date = new DateTime(date('Y-m-d H:i:s.' . $micro, $originalTime));

		return $date->format($this->options['dateFormat']);
	}

	/**
	 * Indents the given string with the given indent.
	 *
	 * @param string $string The string to indent
	 * @param string $indent What to use as the indent.
	 * @return string
	 */
	protected function indent($string, $indent = '    ')
	{
		return $indent . str_replace("\n", "\n" . $indent, $string);
	}

	/**
	 * Takes the given context and coverts it to a string.
	 *
	 * @param array $context The Context
	 * @return string
	 */
	protected function contextToString($context)
	{
		$export = '';
		foreach ($context as $key => $value) {
			$export .= "{$key}: ";
			$export .= preg_replace([
				'/=>\s+([a-zA-Z])/im',
				'/array\(\s+\)/im',
				'/^ {2}|\G {2}/m',
			], [
				'=> $1',
				'array()',
				'    ',
			], str_replace('array (', 'array(', var_export($value, true)));
			$export .= PHP_EOL;
		}
		return str_replace(['\\\\', '\\\''], ['\\', '\''], rtrim($export));
	}

	/**
	 * Writes a line to the log without prepending a status or timestamp
	 *
	 * @param string $message Line to write to the log
	 * @return void
	 */
	public function write($message)
	{
		if (null !== $this->fileHandle) {
			if (fwrite($this->fileHandle, $message) === false) {
				throw new RuntimeException('The file could not be written to. Check that appropriate permissions have been set.');
			}

			$this->lastLine = trim($message);
			$this->logLineCount++;

			if ($this->options['flushFrequency'] && $this->logLineCount % $this->options['flushFrequency'] === 0) {
				fflush($this->fileHandle);
			}
		}
	}

	/**
	 * Get the file path that the log is currently writing to
	 *
	 * @return string
	 */
	public function getLogFilePath()
	{
		return $this->logFilePath;
	}

	/**
	 * @param string $logDirectory
	 */
	public function setLogFilePath($logDirectory)
	{
		if ($this->options['filename']) {
			if (strpos($this->options['filename'], '.log') !== false || strpos($this->options['filename'], '.txt') !== false) {
				$this->logFilePath = $logDirectory . DIRECTORY_SEPARATOR . $this->options['filename'];
			} else {
				$this->logFilePath = $logDirectory . DIRECTORY_SEPARATOR . $this->options['filename'] . '.' . $this->options['extension'];
			}
		} else {
			$this->logFilePath = $logDirectory . DIRECTORY_SEPARATOR . $this->options['prefix'] . date('Y-m-d') . '.' . $this->options['extension'];
		}
	}

	/**
	 * Get the last line logged to the log file
	 *
	 * @return string
	 */
	public function getLastLogLine()
	{
		return $this->lastLine;
	}
}