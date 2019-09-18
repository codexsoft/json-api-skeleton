<?php

use CodexSoft\Code\Constants;
use RequirementsApp\WebServer;
use Symfony\Component\Debug\Debug;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\HttpFoundation\Request;

require __DIR__.'/../vendor/autoload.php';

//if(isset($_SERVER['HTTP_XHPROF']) && $_SERVER['HTTP_XHPROF'] == 1 && extension_loaded('xhprof')) {
//    xhprof_enable(XHPROF_FLAGS_MEMORY | XHPROF_FLAGS_CPU);
//
//    $xhprof_namespace = 'vezubr-producer';
//    $xhprof_run_id = uniqid();
//    $profiler_url = 'https://xhprof.vezubr.com/index.php?run=' . $xhprof_run_id . '&source=' . $xhprof_namespace;
//    header('xhprof: ' . $profiler_url);
//
//    register_shutdown_function(function ($xhprof_namespace, $xhprof_run_id) {
//        $filePath = sys_get_temp_dir() . '/xhprof/' . $xhprof_run_id . '.' . $xhprof_namespace . '.xhprof';
//        $data = serialize(xhprof_disable());
//        file_put_contents($filePath, $data);
//
//    }, $xhprof_namespace, $xhprof_run_id);
//}

// The check is to ensure we don't use .env in production
//if (!isset($_SERVER['APP_ENV'])) {
//    if (!class_exists(Dotenv::class)) {
//        throw new \RuntimeException('APP_ENV environment variable is not defined. You need to define environment variables for configuration or add "symfony/dotenv" as a Composer dependency to load variables from a .env file.');
//    }
//    (new Dotenv)->load(\dirname(__DIR__).'/.env');
//}

$env = $_SERVER['APP_ENV'] ?? 'dev';
$isDebug = (bool) ($_SERVER['APP_DEBUG'] ?? ('prod' !== $env));

if ($isDebug) {
    umask(0000);
    /** @noinspection ForgottenDebugOutputInspection */
    Debug::enable();
}

if ($trustedProxies = $_SERVER['TRUSTED_PROXIES'] ?? false) {
    Request::setTrustedProxies(explode(',', $trustedProxies), Request::HEADER_X_FORWARDED_ALL ^ Request::HEADER_X_FORWARDED_HOST);
}

if ($trustedHosts = $_SERVER['TRUSTED_HOSTS'] ?? false) {
    Request::setTrustedHosts(explode(',', $trustedHosts));
}

$logger = new \Psr\Log\NullLogger;

$kernel = new WebServer($env, $isDebug);
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
