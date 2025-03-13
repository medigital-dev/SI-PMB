<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] !== 'GET')
    die('Aksess Denied!');

header('Content-Type: application/json; charset=utf-8');
include '../core/functions.php';
include '../auth/filter.php';

global $conn;
requireLogin();

$response = [
    'info' => count(query("SELECT * FROM informasi")),
    'berkas' => count(query("SELECT * FROM berkas")) . '/' . count(query("SELECT * FROM berkas WHERE status = 1")),
    'banner' => count(query("SELECT * FROM banner")),
    'event' => count(query("SELECT * FROM event")),
    'tautan' => count(query("SELECT * FROM tautan")) . '/' . count(query("SELECT * FROM tautan WHERE aktif = 1")),
    'forum' => count(query("SELECT * FROM forum")) . '/' . count(query("SELECT * FROM forum WHERE dibaca = 0")),
];

echo json_encode($response, JSON_PRETTY_PRINT);
