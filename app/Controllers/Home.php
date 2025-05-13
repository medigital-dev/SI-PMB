<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('public/homepage', [
            'title' => 'Informasi PPDB SMPN 2 Wonosari 2025',
            'style' => [
                '/plugins/bootstrap/bootstrap.min.css',
                '/plugins/bootstrap-icon/bootstrap-icons.css',
                '/plugins/summernote/summernote-bs4.css',
                '/plugins/fancybox/fancybox.css',
                '/plugins/datatables/datatables.min.css',
                '/assets/css/style.css'
            ],
            'body' => [
                'className' => 'bg-body'
            ],
            'favicon' => [''],
            'data' => [
                'header' => '',
                'on_menu' => [],
                'banner' => [],
                'heroes' => [],
                'jadwal' => [],
                'jalur' => [],
                'dokumen' => [],
                'syarat' => [],
                'tautan' => [],
                'identitas' => [],
            ],
            'script' => [
                './plugins/jquery/jquery.min.js',
                './plugins/bootstrap/bootstrap.bundle.min.js',
                '/plugins/summernote/summernote-bs4.js',
                '/plugins/summernote/summernote-file.js',
                '/plugins/datatables/datatables.min.js',
                './plugins/fancybox/fancybox.umd.js',
                '/plugins/fetchData/fetchData.js',
                '/plugins/simple-toast/toast.js',
                '/assets/js/functions.js',
                '/assets/js/global.js',
                '/assets/js/homepage.js',
                '/assets/js/header-autohide.js'
            ]
        ]);
    }
}
