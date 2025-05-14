<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] !== 'GET')
    die('Aksess Denied!');

header('Content-Type: application/json; charset=utf-8');

require_once '../config.php';
require_once '../auth/filter.php';
require_once '../core/DBBuilder.php';

requireLogin();
$db = new DBBuilder();

$response = [
    'info' => $db->table('informasi')->countAll(),
    'berkas' => $db->table('berkas')->countAll(),
    'banner' => $db->table('banner')->countAll(),
    'event' => $db->table('event')->countAll(),
    'tautan' => $db->table('tautan')->countAll(),
    'forum' => $db->table('forum')->countAll(),
];

echo json_encode($response, JSON_PRETTY_PRINT);
