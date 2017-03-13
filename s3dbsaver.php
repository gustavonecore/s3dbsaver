<?php

define('PATH', __DIR__);

if (!file_exists(PATH . '/tmp/'))
{
	die('Temporal folder is not defined');
}

$opts = getopt('', [
	'db-name:',
	'db-user:',
	'db-pass:',
	's3-bucket:',
]);

$tmpPath = PATH . '/tmp/';

if (!array_key_exists('db-name', $opts))
{
	die("You must define the database name with the option --db-name. \n");
}
if (!array_key_exists('db-user', $opts))
{
	die("You must define the database user with the option --db-user. \n");
}
if (!array_key_exists('db-pass', $opts))
{
	die("You must define the database pass with the option --db-pass. \n");
}
if (!array_key_exists('s3-bucket', $opts))
{
	die("You must define the AWS S3 bucket with the option --s3-bucket. Run [s3cmd --configure] first.\n");
}

$dumpName = $opts['db-name'] . '-' . gmdate('Ymd') . '.sql';

$filename = $tmpPath . $dumpName;

$user = $opts['db-user'];
$pass = $opts['db-pass'];
$name = $opts['db-name'];

$cmd = 'mysqldump -u' . $user . ' -p' . $pass . ' ' . $opts['db-name'] . ' > ' . $filename;

shell_exec($cmd);

error_log('Running dump: ' . $cmd);

$cmdUpload = 's3cmd put ' . $filename . ' s3://' . $opts['s3-bucket'] . '/' . $dumpName;

error_log('Uploading dump to ['. $opts['s3-bucket'] .']: ' . $cmdUpload);

shell_exec($cmdUpload);

unlink($filename);