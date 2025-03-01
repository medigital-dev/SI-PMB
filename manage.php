<?php
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

include 'functions.php';

$data['user'] = query("SELECT * FROM admin");

$nama = $data['user'] ? $data['user'][0]['name'] : '';
$username = $data['user'] ? $data['user'][0]['username'] : '';

if (isset($_POST['saveProfil'])) {
    $result = updateProfil($_POST);
    if ($result == 1) {
        echo "
			<script>
				alert('Data profil berhasil diperbaharui.');
				document.location.href = 'manage.php';
			</script>
		";
    } else {
        echo '
			<script>
				alert("' . $result . '");
			</script>
			';
    }
}

?>

<!doctype html>
<html lang="en" data-bs-theme="auto">

<head>
    <script src="./assets/js/color-modes.js"></script>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors" />
    <meta name="generator" content="Hugo 0.112.5" />
    <title>Dashboard</title>

    <!-- Global Style -->
    <link href="./assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="./assets/css/bootstrap-icons.css" rel="stylesheet" />
    <link href="./assets/css/fancybox.css" rel="stylesheet" />
    <link href="./assets/css/datatables.min.css" rel="stylesheet" />
    <link href="./assets/css/summernote-bs4.css" rel="stylesheet" />
    <link href="./assets/css/style.css" rel="stylesheet" />
    <!-- Custom Style -->
    <link href="./assets/css/admin.css" rel="stylesheet" />

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="./assets/images/smp2wonosari-shadow_black.png" sizes="180x180" />
    <link rel="icon" href="./assets/images/smp2wonosari-shadow_black.png" sizes="32x32" type="image/png" />
    <link rel="icon" href="./assets/images/smp2wonosari-shadow_black.png" sizes="16x16" type="image/png" />
    <link rel="manifest" href="./assets/manifest.json" />
    <link rel="icon" href="./assets/images/smp2wonosari-shadow_black.png" />
    <meta name="theme-color" content="#712cf9" />
</head>

<body class="bg-body-tertiary">
    <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
        <symbol id="check2" viewBox="0 0 16 16">
            <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z" />
        </symbol>
        <symbol id="circle-half" viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z" />
        </symbol>
        <symbol id="moon-stars-fill" viewBox="0 0 16 16">
            <path d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z" />
            <path d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.734 1.734 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.734 1.734 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.734 1.734 0 0 0 1.097-1.097l.387-1.162zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L13.863.1z" />
        </symbol>
        <symbol id="sun-fill" viewBox="0 0 16 16">
            <path d="M8 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z" />
        </symbol>
    </svg>

    <div class="dropdown position-fixed bottom-0 end-0 mb-3 me-3 bd-mode-toggle">
        <button class="btn btn-bd-primary py-2 dropdown-toggle d-flex align-items-center" id="bd-theme" type="button" aria-expanded="false" data-bs-toggle="dropdown" aria-label="Toggle theme (auto)">
            <svg class="bi my-1 theme-icon-active" width="1em" height="1em">
                <use href="#circle-half"></use>
            </svg>
            <span class="visually-hidden" id="bd-theme-text">Toggle theme</span>
        </button>
        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bd-theme-text">
            <li>
                <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="light" aria-pressed="false">
                    <svg class="bi me-2 opacity-50" width="1em" height="1em">
                        <use href="#sun-fill"></use>
                    </svg>
                    Light
                    <svg class="bi ms-auto d-none" width="1em" height="1em">
                        <use href="#check2"></use>
                    </svg>
                </button>
            </li>
            <li>
                <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark" aria-pressed="false">
                    <svg class="bi me-2 opacity-50" width="1em" height="1em">
                        <use href="#moon-stars-fill"></use>
                    </svg>
                    Dark
                    <svg class="bi ms-auto d-none" width="1em" height="1em">
                        <use href="#check2"></use>
                    </svg>
                </button>
            </li>
            <li>
                <button type="button" class="dropdown-item d-flex align-items-center active" data-bs-theme-value="auto" aria-pressed="true">
                    <svg class="bi me-2 opacity-50" width="1em" height="1em">
                        <use href="#circle-half"></use>
                    </svg>
                    Auto
                    <svg class="bi ms-auto d-none" width="1em" height="1em">
                        <use href="#check2"></use>
                    </svg>
                </button>
            </li>
        </ul>
    </div>


    <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
        <symbol id="calendar3" viewBox="0 0 16 16">
            <path d="M14 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zM1 3.857C1 3.384 1.448 3 2 3h12c.552 0 1 .384 1 .857v10.286c0 .473-.448.857-1 .857H2c-.552 0-1-.384-1-.857V3.857z" />
            <path d="M6.5 7a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
        </symbol>
        <symbol id="cart" viewBox="0 0 16 16">
            <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .49.598l-1 5a.5.5 0 0 1-.465.401l-9.397.472L4.415 11H13a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l.84 4.479 9.144-.459L13.89 4H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
        </symbol>
        <symbol id="chevron-right" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z" />
        </symbol>
        <symbol id="door-closed" viewBox="0 0 16 16">
            <path d="M3 2a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v13h1.5a.5.5 0 0 1 0 1h-13a.5.5 0 0 1 0-1H3V2zm1 13h8V2H4v13z" />
            <path d="M9 9a1 1 0 1 0 2 0 1 1 0 0 0-2 0z" />
        </symbol>
        <symbol id="file-earmark" viewBox="0 0 16 16">
            <path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h-2z" />
        </symbol>
        <symbol id="file-earmark-text" viewBox="0 0 16 16">
            <path d="M5.5 7a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5zM5 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5z" />
            <path d="M9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.5L9.5 0zm0 1v2A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z" />
        </symbol>
        <symbol id="gear-wide-connected" viewBox="0 0 16 16">
            <path d="M7.068.727c.243-.97 1.62-.97 1.864 0l.071.286a.96.96 0 0 0 1.622.434l.205-.211c.695-.719 1.888-.03 1.613.931l-.08.284a.96.96 0 0 0 1.187 1.187l.283-.081c.96-.275 1.65.918.931 1.613l-.211.205a.96.96 0 0 0 .434 1.622l.286.071c.97.243.97 1.62 0 1.864l-.286.071a.96.96 0 0 0-.434 1.622l.211.205c.719.695.03 1.888-.931 1.613l-.284-.08a.96.96 0 0 0-1.187 1.187l.081.283c.275.96-.918 1.65-1.613.931l-.205-.211a.96.96 0 0 0-1.622.434l-.071.286c-.243.97-1.62.97-1.864 0l-.071-.286a.96.96 0 0 0-1.622-.434l-.205.211c-.695.719-1.888.03-1.613-.931l.08-.284a.96.96 0 0 0-1.186-1.187l-.284.081c-.96.275-1.65-.918-.931-1.613l.211-.205a.96.96 0 0 0-.434-1.622l-.286-.071c-.97-.243-.97-1.62 0-1.864l.286-.071a.96.96 0 0 0 .434-1.622l-.211-.205c-.719-.695-.03-1.888.931-1.613l.284.08a.96.96 0 0 0 1.187-1.186l-.081-.284c-.275-.96.918-1.65 1.613-.931l.205.211a.96.96 0 0 0 1.622-.434l.071-.286zM12.973 8.5H8.25l-2.834 3.779A4.998 4.998 0 0 0 12.973 8.5zm0-1a4.998 4.998 0 0 0-7.557-3.779l2.834 3.78h4.723zM5.048 3.967c-.03.021-.058.043-.087.065l.087-.065zm-.431.355A4.984 4.984 0 0 0 3.002 8c0 1.455.622 2.765 1.615 3.678L7.375 8 4.617 4.322zm.344 7.646.087.065-.087-.065z" />
        </symbol>
        <symbol id="graph-up" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M0 0h1v15h15v1H0V0Zm14.817 3.113a.5.5 0 0 1 .07.704l-4.5 5.5a.5.5 0 0 1-.74.037L7.06 6.767l-3.656 5.027a.5.5 0 0 1-.808-.588l4-5.5a.5.5 0 0 1 .758-.06l2.609 2.61 4.15-5.073a.5.5 0 0 1 .704-.07Z" />
        </symbol>
        <symbol id="house-fill" viewBox="0 0 16 16">
            <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L8 2.207l6.646 6.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.707 1.5Z" />
            <path d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293l6-6Z" />
        </symbol>
        <symbol id="list" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" />
        </symbol>
        <symbol id="people" viewBox="0 0 16 16">
            <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8Zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022ZM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816ZM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0Zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4Z" />
        </symbol>
        <symbol id="plus-circle" viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
        </symbol>
        <symbol id="puzzle" viewBox="0 0 16 16">
            <path d="M3.112 3.645A1.5 1.5 0 0 1 4.605 2H7a.5.5 0 0 1 .5.5v.382c0 .696-.497 1.182-.872 1.469a.459.459 0 0 0-.115.118.113.113 0 0 0-.012.025L6.5 4.5v.003l.003.01c.004.01.014.028.036.053a.86.86 0 0 0 .27.194C7.09 4.9 7.51 5 8 5c.492 0 .912-.1 1.19-.24a.86.86 0 0 0 .271-.194.213.213 0 0 0 .039-.063v-.009a.112.112 0 0 0-.012-.025.459.459 0 0 0-.115-.118c-.375-.287-.872-.773-.872-1.469V2.5A.5.5 0 0 1 9 2h2.395a1.5 1.5 0 0 1 1.493 1.645L12.645 6.5h.237c.195 0 .42-.147.675-.48.21-.274.528-.52.943-.52.568 0 .947.447 1.154.862C15.877 6.807 16 7.387 16 8s-.123 1.193-.346 1.638c-.207.415-.586.862-1.154.862-.415 0-.733-.246-.943-.52-.255-.333-.48-.48-.675-.48h-.237l.243 2.855A1.5 1.5 0 0 1 11.395 14H9a.5.5 0 0 1-.5-.5v-.382c0-.696.497-1.182.872-1.469a.459.459 0 0 0 .115-.118.113.113 0 0 0 .012-.025L9.5 11.5v-.003a.214.214 0 0 0-.039-.064.859.859 0 0 0-.27-.193C8.91 11.1 8.49 11 8 11c-.491 0-.912.1-1.19.24a.859.859 0 0 0-.271.194.214.214 0 0 0-.039.063v.003l.001.006a.113.113 0 0 0 .012.025c.016.027.05.068.115.118.375.287.872.773.872 1.469v.382a.5.5 0 0 1-.5.5H4.605a1.5 1.5 0 0 1-1.493-1.645L3.356 9.5h-.238c-.195 0-.42.147-.675.48-.21.274-.528.52-.943.52-.568 0-.947-.447-1.154-.862C.123 9.193 0 8.613 0 8s.123-1.193.346-1.638C.553 5.947.932 5.5 1.5 5.5c.415 0 .733.246.943.52.255.333.48.48.675.48h.238l-.244-2.855zM4.605 3a.5.5 0 0 0-.498.55l.001.007.29 3.4A.5.5 0 0 1 3.9 7.5h-.782c-.696 0-1.182-.497-1.469-.872a.459.459 0 0 0-.118-.115.112.112 0 0 0-.025-.012L1.5 6.5h-.003a.213.213 0 0 0-.064.039.86.86 0 0 0-.193.27C1.1 7.09 1 7.51 1 8c0 .491.1.912.24 1.19.07.14.14.225.194.271a.213.213 0 0 0 .063.039H1.5l.006-.001a.112.112 0 0 0 .025-.012.459.459 0 0 0 .118-.115c.287-.375.773-.872 1.469-.872H3.9a.5.5 0 0 1 .498.542l-.29 3.408a.5.5 0 0 0 .497.55h1.878c-.048-.166-.195-.352-.463-.557-.274-.21-.52-.528-.52-.943 0-.568.447-.947.862-1.154C6.807 10.123 7.387 10 8 10s1.193.123 1.638.346c.415.207.862.586.862 1.154 0 .415-.246.733-.52.943-.268.205-.415.39-.463.557h1.878a.5.5 0 0 0 .498-.55l-.001-.007-.29-3.4A.5.5 0 0 1 12.1 8.5h.782c.696 0 1.182.497 1.469.872.05.065.091.099.118.115.013.008.021.01.025.012a.02.02 0 0 0 .006.001h.003a.214.214 0 0 0 .064-.039.86.86 0 0 0 .193-.27c.14-.28.24-.7.24-1.191 0-.492-.1-.912-.24-1.19a.86.86 0 0 0-.194-.271.215.215 0 0 0-.063-.039H14.5l-.006.001a.113.113 0 0 0-.025.012.459.459 0 0 0-.118.115c-.287.375-.773.872-1.469.872H12.1a.5.5 0 0 1-.498-.543l.29-3.407a.5.5 0 0 0-.497-.55H9.517c.048.166.195.352.463.557.274.21.52.528.52.943 0 .568-.447.947-.862 1.154C9.193 5.877 8.613 6 8 6s-1.193-.123-1.638-.346C5.947 5.447 5.5 5.068 5.5 4.5c0-.415.246-.733.52-.943.268-.205.415-.39.463-.557H4.605z" />
        </symbol>
        <symbol id="search" viewBox="0 0 16 16">
            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
        </symbol>
    </svg>

    <nav class="navbar navbar-expand-lg bg-body-tertiary sticky-top">
        <div class="container">
            <a class="navbar-brand" href="./manage.php">CMS-Info PPDB</a>
            <div class="btn-group">
                <a href="./index.php" class="btn btn-outline-primary" target="_blank" title="Homepage"><i class="bi bi-box-arrow-up-right"></i></a>
                <div class="btn-group btn-group-sm">
                    <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#modalProfil">Profil</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="./logout.php">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <section>
        <div class="container bg-body">
            <div class="row row-cols-2 row-cols-md-4 g-4 mb-4">
                <div class="col">
                    <div class="card card-body shadow text-bg-primary bg-gradient">
                        <h6 class="card-title">Total Informasi</h6>
                        <div class="d-flex justify-content-between">
                            <span class="h1 fs-1 m-0" id="totalInfo">0</span>
                            <i class="fa-solid fa-users text-opacity-25 text-white fa-3x"></i>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card card-body shadow text-bg-danger bg-gradient">
                        <h6 class="card-title">Jumlah Banner</h6>
                        <div class="d-flex justify-content-between">
                            <span class="h1 fs-1 m-0" id="totalPd">0</span>
                            <i class="fa-solid fa-users text-opacity-25 text-white fa-3x"></i>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card card-body shadow text-bg-warning bg-gradient">
                        <h6 class="card-title">Event</h6>
                        <div class="d-flex justify-content-between">
                            <span class="h1 fs-1 m-0" id="totalPd">0</span>
                            <i class="fa-solid fa-users text-opacity-25 text-white fa-3x"></i>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card card-body shadow text-bg-success bg-gradient">
                        <h6 class="card-title">Total Berkas</h6>
                        <div class="d-flex justify-content-between">
                            <span class="h1 fs-1 m-0" id="totalBerkas">0</span>
                            <i class="fa-solid fa-users text-opacity-25 text-white fa-3x"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-block d-lg-flex align-items-start">
                <div class="card shadow mb-4 me-lg-4">
                    <div class="card-header text-bg-primary">Menu</div>
                    <div class="card-body p-2">
                        <div class="nav flex-lg-column nav-pills justify-content-center pe-lg-4" role="tablist" aria-orientation="vertical">
                            <button class="nav-link text-start active" id="v-pills-info-tab" data-bs-toggle="pill" data-bs-target="#v-pills-info" type="button" role="tab" aria-controls="v-pills-info" aria-selected="true">Informasi</button>
                            <button class="nav-link text-start" id="v-pills-banner-tab" data-bs-toggle="pill" data-bs-target="#v-pills-banner" type="button" role="tab" aria-controls="v-pills-banner" aria-selected="true">Banner</button>
                            <button class="nav-link text-start" id="v-pills-event-tab" data-bs-toggle="pill" data-bs-target="#v-pills-event" type="button" role="tab" aria-controls="v-pills-event" aria-selected="true">Event</button>
                            <button class="nav-link text-start" id="v-pills-berkas-tab" data-bs-toggle="pill" data-bs-target="#v-pills-berkas" type="button" role="tab" aria-controls="v-pills-berkas" aria-selected="true">Berkas</button>
                        </div>
                    </div>
                </div>
                <div class="tab-content w-100">
                    <div class="tab-pane fade show active" id="v-pills-info" role="tabpanel" aria-labelledby="v-pills-info-tab" tabindex="0">
                        <div class="card shadow mb-4">
                            <div class="card-header text-bg-primary">Data Informasi</div>
                            <div class="card-body">
                                <div class="sticky-top  bg-body">
                                    <div class="btn-toolbar justify-content-between py-2">
                                        <div class="btn-group btn-group-sm">
                                            <button type="button" class="btn btn-primary" title="Reload Tabel" id="btnReloadTabelInformasi"><i class="bi bi-arrow-repeat"></i></button>
                                            <button type="button" class="btn btn-primary" title="Tambah Informasi" id="btnTambahInformasi" data-bs-toggle="modal" data-bs-target="#modalTambahInformasi"><i class="bi bi-plus-circle"></i></button>
                                        </div>
                                        <div class="input-group input-group-sm">
                                            <input type="text" class="form-control" id="searchTabelInformasi" placeholder="Cari Informasi">
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover w-100" id="tabelInformasi">
                                        <thead>
                                            <tr>
                                                <th class="text-bg-primary text-center align-middle">Informasi</th>
                                                <th class="text-bg-primary text-center align-middle">Aksi</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-berkas" role="tabpanel" aria-labelledby="v-pills-berkas-tab" tabindex="0">
                        <div class="card shadow mb-4">
                            <div class="card-header text-bg-primary">Data Unduhan</div>
                            <div class="card-body">
                                <div class="btn-toolbar justify-content-between mb-4">
                                    <div class="btn-group btn-group-sm">
                                        <button type="button" class="btn btn-primary" title="Reload Tabel" id="btnReloadTabelBerkas"><i class="bi bi-arrow-repeat"></i></button>
                                        <button type="button" class="btn btn-primary" title="Tambah Berkas" id="btnTambahBerkas" data-bs-toggle="modal" data-bs-target="#modalTambahBerkas"><i class="bi bi-plus-circle"></i></button>
                                    </div>
                                    <div class="input-group input-group-sm">
                                        <input type="text" class="form-control" id="searchTabelBerkas" placeholder="Cari Berkas">
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered w-100" id="tabelBerkas">
                                        <thead>
                                            <tr>
                                                <th class="text-bg-primary text-center align-middle" style="width: 10px;">No</th>
                                                <th class="text-bg-primary text-center align-middle">Tanggal</th>
                                                <th class="text-bg-primary text-center align-middle">Nama File</th>
                                                <th class="text-bg-primary text-center align-middle">Aksi</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-banner" role="tabpanel" aria-labelledby="v-pills-banner-tab" tabindex="0">
                        <div class="card shadow mb-4">
                            <div class="card-header text-bg-primary">Data Banner Hero</div>
                            <div class="card-body">
                                <div class="btn-toolbar justify-content-between mb-4">
                                    <div class="btn-group btn-group-sm">
                                        <button type="button" class="btn btn-primary" title="Reload Tabel" id="btnReloadTabelBanner"><i class="bi bi-arrow-repeat"></i></button>
                                        <button type="button" class="btn btn-primary" title="Tambah Banner" id="btnTambahBanner" data-bs-toggle="modal" data-bs-target="#modalTambahBanner"><i class="bi bi-plus-circle"></i></button>
                                    </div>
                                    <div class="input-group input-group-sm">
                                        <input type="text" class="form-control" id="searchTabelBanner" placeholder="Cari Banner">
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered w-100" id="tabelBanner">
                                        <thead>
                                            <tr>
                                                <th class="text-bg-primary text-center align-middle" style="width: 10px;">Urut</th>
                                                <th class="text-bg-primary text-center align-middle">Preview</th>
                                                <th class="text-bg-primary text-center align-middle">Nama File</th>
                                                <th class="text-bg-primary text-center align-middle">Aksi</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="modalTambahInformasi" tabindex="-1" aria-labelledby="modalTambahInformasiLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalTambahInformasiLabel">Tambah Informasi</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="idInformasi">
                    <div class="mb-3">
                        <label class="form-label" for="judul">Judul</label>
                        <input type="text" class="form-control" name="judul" id="judul">
                        <div class="invalid-feedback">Input ini diperlukan!</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="isi">Isi</label>
                        <textarea name="isi" id="isi" rows="10" class="form-control"></textarea>
                        <div class="invalid-feedback">Input ini diperlukan!</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="btnSaveInfo">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="modalProfil" tabindex="-1" aria-labelledby="modalProfilLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <form action="" method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalProfilLabel">Tambah Informasi</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama User</label>
                            <input type="text" class="form-control" name="nama" id="nama" value="<?= $nama; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" name="username" id="username" value="<?= $username; ?>">
                        </div>
                        <hr>
                        <div class="mb-3">
                            <label for="oldPassword" class="form-label">Password Lama</label>
                            <input type="password" class="form-control password" name="oldPassword" id="oldPassword">
                            <div class="form-text">Input password lama jika ingin mengganti password.</div>
                        </div>
                        <div class="row row-cols-2">
                            <div class="col-12 col-md-6 mb-3">
                                <label for="newPassword" class="form-label">Password Baru</label>
                                <input type="password" class="form-control password" name="newPassword" id="newPassword">
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label for="newPassword2" class="form-label">Konfirmasi Password</label>
                                <input type="password" class="form-control password" name="newPassword2" id="newPassword2">
                            </div>
                        </div>
                        <div class="form-check text-start mb-3">
                            <input class="form-check-input" type="checkbox" id="showPass">
                            <label class="form-check-label" for="showPass">
                                Lihat Password
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-start">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary" name="saveProfil" id="btnSaveProfil">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="modalTambahBerkas" tabindex="-1" aria-labelledby="modalTambahBerkasLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalTambahBerkasLabel">Tambah Berkas Unduhan</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="titleFile" class="form-label">Judul File</label>
                        <input type="text" class="form-control" name="title" id="titleFile">
                        <div class="invalid-feedback">Wajib.</div>
                    </div>
                    <div class="mb-3">
                        <label for="fileBerkas" class="form-label">Pilih file</label>
                        <input class="form-control" type="file" id="fileBerkas">
                        <div class="invalid-feedback">Wajib.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="btnSaveBerkas">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="modalTambahBanner" tabindex="-1" aria-labelledby="modalTambahBannerLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalTambahBannerLabel">Tambah Banner Hero</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="titleFileBanner" class="form-label">Judul File</label>
                        <input type="text" class="form-control" name="title" id="titleFileBanner">
                        <div class="invalid-feedback">Wajib.</div>
                    </div>
                    <div class="mb-3">
                        <label for="fileBanner" class="form-label">Pilih file</label>
                        <input class="form-control" type="file" id="fileBanner" accept="image/*">
                        <div class="form-text">Gambar dengan perbandingan dimensi panjang : lebar = 3 : 1</div>
                        <div class="invalid-feedback">Wajib.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="btnSaveBanner">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <script src="./assets/js/jquery.min.js"></script>
    <script src="./assets/js/bootstrap.bundle.min.js"></script>
    <script src="./assets/js/datatables.min.js"></script>
    <script src="./assets/js/fancybox.umd.js"></script>
    <script src="./assets/js/summernote-bs4.js"></script>
    <script src="./assets/js/summernote-file.js"></script>
    <script src="./assets/js/fetchData.js"></script>
    <script src="./assets/js/simple-notif.js"></script>
    <script>
        Fancybox.bind("[data-fancybox]");

        function reloadWidget() {
            $.post('./api/widget.php', res => {
                $('#totalInfo').text(res.info);
                $('#totalBerkas').text(res.berkas);
            })
        }

        function uploadMedia(file) {
            let data = new FormData();
            data.append('title', file.name);
            data.append('type', 'info');
            data.append("file", file);
            $.ajax({
                data: data,
                type: "POST",
                url: "./api/berkas.php", //Your own back-end uploader
                cache: false,
                contentType: false,
                processData: false,
                xhr: function() {
                    //Handle progress upload
                    let myXhr = $.ajaxSettings.xhr();
                    if (myXhr.upload)
                        myXhr.upload.addEventListener(
                            "progress",
                            progressHandlingFunction,
                            false
                        );
                    return myXhr;
                },
                success: function(reponse) {
                    if (reponse.status === true) {
                        let listMimeImg = [
                            "image/png",
                            "image/jpeg",
                            "image/webp",
                            "image/gif",
                            "image/svg",
                        ];
                        let listMimeAudio = ["audio/mpeg", "audio/ogg"];
                        let listMimeVideo = ["video/mpeg", "video/mp4", "video/webm"];
                        let elem;
                        let childElem;
                        let elemFancy;

                        if (listMimeImg.indexOf(file.type) > -1) {
                            //Picture
                            elem = document.createElement("a");
                            elem.setAttribute("href", reponse.src);
                            elem.setAttribute("data-fancybox", '');
                            childElem = document.createElement("img");
                            childElem.setAttribute("class", "img-thumbnail");
                            childElem.setAttribute("src", reponse.src);
                            childElem.style.width = "240px";
                            childElem.style.height = "180px";
                            childElem.style.objectFit = "cover";
                            elem.appendChild(childElem);
                            $("textarea#isi").summernote("insertNode", elem);
                        } else if (listMimeAudio.indexOf(file.type) > -1) {
                            //Audio
                            elem = document.createElement("audio");
                            elem.setAttribute("src", reponse.src);
                            elem.setAttribute("controls", "controls");
                            elem.setAttribute("preload", "metadata");
                            $("textarea#isi").summernote("insertNode", elem);
                        } else if (listMimeVideo.indexOf(file.type) > -1) {
                            //Video
                            elemFancy = document.createElement("a");
                            elemFancy.setAttribute("href", reponse.src);
                            elemFancy.setAttribute("data-fancybox", "");
                            elem = document.createElement("video");
                            elem.setAttribute("src", reponse.src);
                            elem.setAttribute("controls", "controls");
                            elem.setAttribute("preload", "metadata");
                            elem.setAttribute("class", "img-thumbnail");
                            elem.setAttribute("width", 480);
                            elemFancy.appendChild(elem);
                            $("textarea#isi").summernote("insertNode", elemFancy);
                        } else {
                            //Other file type
                            elem = document.createElement("a");
                            let linkText = document.createTextNode(file.name);
                            elem.appendChild(linkText);
                            elem.title = file.name;
                            elem.href = reponse.src;
                            elem.target = "_blank";
                            $("textarea#isi").summernote("insertNode", elem);
                        }
                    }
                },
            });
        }

        function progressHandlingFunction(e) {
            if (e.lengthComputable) {
                if (e.total > 2097152) {
                    const current = Math.round((e.loaded / e.total) * 100);
                    $("#loadingModal").modal("show");
                    $("#currentPercent").text(current);

                    //Reset progress on complete
                    if (e.loaded === e.total) {
                        $("#loadingModal").modal("hide");
                        toast("success", "Upload selesai!");
                    }
                }
            }
        }

        function deleteMedia(file) {
            const id = file.dataset.id_unik;
            $.post(
                "/cms-admin/files/delete/" + id,
                (r) => {
                    toast("success", r.messages);
                    var content = $("textarea#isi");
                    var temp = document.createElement("div");
                    temp.innerHTML = content.summernote("code");
                    var elm = temp.querySelectorAll('a[data-id_unik="' + id + '"]');
                    elm.forEach((e) => e.parentNode.removeChild(e));
                    content.summernote("code", temp.innerHTML);
                },
                "json"
            ).fail((rf) => toast("error", rf.responseJSON.message));
        }

        function getFileExtension(filename) {
            const parts = filename.split(".");
            if (parts.length === 1 || (parts[0] === "" && parts.length === 2)) {
                return "";
            }
            return parts.pop().toLowerCase();
        }

        function getFileIcon(extension) {
            const iconMappings = {
                pdf: "fa-file-pdf",
                doc: "fa-file-word",
                docx: "fa-file-word",
                xls: "fa-file-excel",
                xlsx: "fa-file-excel",
                ppt: "fa-file-powerpoint",
                pptx: "fa-file-powerpoint",
                txt: "fa-file-alt",
                jpg: "fa-file-image",
                jpeg: "fa-file-image",
                png: "fa-file-image",
                gif: "fa-file-image",
                zip: "fa-file-archive",
                tar: "fa-file-archive",
                rar: "fa-file-archive",
                mp4: "fa-file-video",
                avi: "fa-file-video",
                mkv: "fa-file-video",
                default: "fa-file",
            };

            const iconClass =
                iconMappings[extension.toLowerCase()] || iconMappings["default"];
            return `<i class="fas ${iconClass}"></i>`;
        }
    </script>
    <script>
        $(document).ready(function() {
            $('#showPass').on('click', function() {
                if ($(this).is(':checked')) $('.password').attr('type', 'text');
                else $('.password').attr('type', 'password');
            });

            $('#isi').summernote({
                dialogsInBody: true,
                height: 200,
                toolbar: [
                    ['misc', ['undo', 'redo']],
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link', 'table', 'file']],
                    ['view', ['fullscreen', 'codeview', 'help']],
                ],
                callbacks: {
                    onFileUpload: (file) => {
                        for (let i = 0; i < file.length; i++) {
                            uploadMedia(file[i]);
                        }
                    },
                    onMediaDelete: (file) => deleteMedia(file[0]),
                },
            });

            const tabelInformasi = $('#tabelInformasi').DataTable({
                dom: '<"mb-2"t><"d-flex justify-content-between"ip>',
                responsive: true,
                ordering: false,
                processing: true,
                ajax: {
                    url: './api/info.php',
                    dataSrc: '',
                },
                columns: [{
                    data: 'judul',
                    render: (data, type, rows, meta) => {
                        return ('<a class="text-decoration-none" role="button" data-bs-toggle="collapse" href="#collapse-' + rows.id + '"><h6 class="m-0">' + data + '</h6></a>' +
                            '<span class="text-muted small">' + rows.tanggal + '</span>' +
                            '<div class="collapse" id="collapse-' + rows.id + '"><hr class="my-2">' + rows.isi + '</div>');
                    }
                }, {
                    data: 'id',
                    className: 'text-center',
                    width: '70px',
                    render: (data, type, rows, meta) => {
                        return ('<div class="btn-group btn-group-sm">' +
                            '<button type="button" class="btn btn-primary btnEditInfo" data-id="' + data +
                            '"><i class="bi bi-pencil-square"></i></button>' +
                            '<button type="button" class="btn btn-danger btnHapusInfo" data-id="' + data +
                            '"><i class="bi bi-trash-fill"></i></button>' +
                            '</div>');
                    }
                }]
            });

            tabelInformasi.on('draw', () => {
                reloadWidget();

                $('.btnEditInfo').on('click', async function() {
                    const id = $(this).data('id');
                    const res = await fetchData('./api/info.php?id=' + id);
                    if (!res) return toast('Informasi dengan id <strong>' + id + '</strong> tidak ditemukan.', 'error');

                    $('#idInformasi').val(res.id)
                    $('#judul').val(res.judul);
                    $('#isi').summernote('code', res.isi);
                    $('#modalTambahInformasi').modal('show');
                });

                $('.btnHapusInfo').on('click', async function() {
                    const id = $(this).data('id');
                    const data = await fetchData('./api/info.php?id=' + id);
                    if (!data) return toast('Informasi dengan id <strong>' + id + '</strong> tidak ditemukan.', 'error');
                    const action = confirm('Informasi: ' + data.judul + ' akan dihapus permanen. Yakin?');
                    if (action) {
                        const res = await fetchData({
                            url: './api/info.php?id=' + id,
                            type: 'DELETE'
                        });
                        if (!res) return toast('Informasi: <strong>' + data.judul + '</strong> gagal dihapus.');
                        toast({
                            message: 'Informasi: <strong>' + data.judul + '</strong> berhasil dihapus.',
                            delay: 5000,
                            icon: 'success'
                        });
                        tabelInformasi.ajax.reload(null, false);
                    } else {
                        toast('Informasi: <strong>' + data.judul + '</strong> batal dihapus permanen.')
                    }
                });
            });

            const tabelBerkas = $('#tabelBerkas').DataTable({
                dom: '<"mb-2"t><"d-flex justify-content-between"ip>',
                responsive: true,
                ordering: false,
                ajax: {
                    url: './api/berkas.php',
                    method: 'POST',
                    dataSrc: '',
                    data: {
                        getTable: true,
                        type: 'unduhan'
                    }
                },
                columns: [{
                    data: 'no',
                    className: 'text-center'
                }, {
                    data: 'tanggal',
                    className: 'text-center'
                }, {
                    data: 'judul'
                }, {
                    data: 'aksi',
                    className: 'text-center'
                }]
            });

            tabelBerkas.on('draw', () => {
                $('.btnHapusBerkas').on('click', function() {
                    const id = $(this).data('id');
                    const data = {
                        delete: true
                    }
                    const action = confirm('Informasi akan dihapus permanen. Yakin?');
                    if (action)
                        $.post('./api/berkas.php?id=' + id, data, res => {
                            console.log(res);
                            alert(res.message);
                            tabelBerkas.ajax.reload(null, false);
                            reloadWidget()
                        }).fail(err => console.log(err));
                });
                reloadWidget();
            });

            $('#btnReloadTabelInformasi').on('click', () => tabelInformasi.ajax.reload(null, false));

            $('#btnSaveInfo').on('click', async function() {
                const btnElm = $(this);
                const judulElm = $('#judul');
                const isiElm = $('#isi');
                const id = $('#idInformasi');

                if (judulElm.val() == '' || isiElm.val() == '') {
                    if (judulElm.val() == '') judulElm.addClass('is-invalid');
                    else judulElm.removeClass('is-invalid');
                    if (isiElm.val() == '') isiElm.addClass('is-invalid');
                    else isiElm.removeClass('is-invalid');
                    toast('Lengkapi form.', 'info');
                    return
                }

                $('.is-invalid').removeClass('is-invalid');
                btnElm.html('<div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div>').prop('disabled', true);
                const idVal = id.val();
                let data = new FormData();
                data.append('judul', judulElm.val());
                data.append('isi', isiElm.val());
                const res = await fetchData({
                    url: './api/info.php?id=' + id.val(),
                    data: data,
                    type: 'POST'
                });
                if (!res) return toast('Informasi dengan judul: <strong>' + judulElm.val() + '</strong> gagal disimpan.');
                toast({
                    message: 'Informasi dengan judul: <strong>' + judulElm.val() + '</strong> berhasil disimpan.',
                    icon: 'success',
                    delay: 5000,
                });
                tabelInformasi.ajax.reload(null, false);
                btnElm.text('Simpan').prop('disabled', false);
                $('#modalTambahInformasi').modal('hide');
            });

            $('#modalTambahInformasi').on('hide.bs.modal', function() {
                $('#judul,#idInformasi').val('');
                $('#isi').summernote('code', '');
            });

            $('#searchTabelInformasi').on('keyup', e => {
                const keyword = e.target.value;
                if (keyword !== '') {
                    $('.collapse').collapse('show');
                    tabelInformasi.search(keyword).draw();
                } else
                    $('.collapse').collapse('hide');
            });

            $('#searchTabelBerkas').on('keyup', e => tabelBerkas.columns(2).search(e.target.value).draw());

            $('#btnSaveBerkas').on('click', function() {
                const btnElm = $(this);
                const fileElm = $('#fileBerkas');
                const titleElm = $('#titleFile');

                if (fileElm.val() == '' || titleElm.val() == '') {
                    if (fileElm.val() == '') fileElm.addClass('is-invalid');
                    else fileElm.removeClass('is-invalid');
                    if (titleElm.val() == '') titleElm.addClass('is-invalid');
                    else titleElm.removeClass('is-invalid');
                    return;
                }
                $('is-invalid').removeClass('is-invalid');
                btnElm.html('<div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div>').prop('disabled', true);
                const file = fileElm.prop('files');
                let data = new FormData();
                data.append('title', titleElm.val());
                data.append('file', file[0]);
                data.append('type', 'unduhan');
                $.ajax({
                    data: data,
                    type: "POST",
                    url: "./api/berkas.php", //Your own back-end uploader
                    cache: false,
                    contentType: false,
                    processData: false,
                    xhr: function() {
                        //Handle progress upload
                        let myXhr = $.ajaxSettings.xhr();
                        if (myXhr.upload)
                            myXhr.upload.addEventListener(
                                "progress",
                                progressHandlingFunction,
                                false
                            );
                        return myXhr;
                    },
                    success: res => {
                        alert(res.message);
                        btnElm.text('Simpan').prop('disabled', false);
                        fileElm.val('');
                        titleElm.val('');
                        $('#modalTambahBerkas').modal('hide');
                        tabelBerkas.ajax.reload(null, false);
                    },
                    error: err => {
                        console.log(err);
                        btnElm.text('Simpan').prop('disabled', false);
                    }
                });
            });

            $('#btnSaveBanner').on('click', function() {
                const btnElm = $(this);
                const fileElm = $('#fileBanner');
                const titleElm = $('#titleFileBanner');

                if (fileElm.val() == '' || titleElm.val() == '') {
                    if (fileElm.val() == '') fileElm.addClass('is-invalid');
                    else fileElm.removeClass('is-invalid');
                    if (titleElm.val() == '') titleElm.addClass('is-invalid');
                    else titleElm.removeClass('is-invalid');
                    return;
                }

                const file = fileElm.prop('files')[0];
                const img = new Image();

                img.onload = function() {
                    const width = img.width;
                    const height = img.height;
                    const aspectRatio = width / height;
                    const tolerance = 0.1;
                    const targetRatio = 3;
                    console.log(aspectRatio);
                    if (Math.abs(aspectRatio - targetRatio) > tolerance) {
                        fileElm.parent().append('<div class="invalid-feedback">Aspek rasio pada gambar yang diupload harus 3:1.</div>');
                        fileElm.addClass('is-invalid');
                        return;
                    }
                    $('is-invalid').removeClass('is-invalid');
                    btnElm.html('<div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div>').prop('disabled', true);
                    let data = new FormData();
                    data.append('title', titleElm.val());
                    data.append('file', file);
                    data.append('type', 'banner');
                    $.ajax({
                        data: data,
                        type: "POST",
                        url: "./api/berkas.php", //Your own back-end uploader
                        cache: false,
                        contentType: false,
                        processData: false,
                        xhr: function() {
                            //Handle progress upload
                            let myXhr = $.ajaxSettings.xhr();
                            if (myXhr.upload)
                                myXhr.upload.addEventListener(
                                    "progress",
                                    progressHandlingFunction,
                                    false
                                );
                            return myXhr;
                        },
                        success: res => {
                            btnElm.text('Simpan').prop('disabled', false);
                            fileElm.val('');
                            titleElm.val('');
                            $('#modalTambahBanner').modal('hide');
                            tabelBanner.ajax.reload(null, false);
                            alert(res.message);
                        },
                        error: err => {
                            console.log(err);
                            btnElm.text('Simpan').prop('disabled', false);
                        }
                    });
                }
                img.src = URL.createObjectURL(file);
            });

            const tabelBanner = $('#tabelBanner').DataTable({
                dom: '<"mb-2"t><"d-flex justify-content-between"ip>',
                responsive: true,
                ordering: false,
                ajax: {
                    url: './api/berkas.php',
                    method: 'POST',
                    dataSrc: '',
                    data: {
                        getTable: true,
                        type: 'banner'
                    }
                },
                columns: [{
                    data: 'no',
                    className: 'text-center'
                }, {
                    data: 'preview',
                    className: 'text-center'
                }, {
                    data: 'filename'
                }, {
                    data: 'aksi',
                    className: 'text-center'
                }]
            });

            tabelBanner.on('draw', () => {
                $('.btnHapusBerkas').on('click', function() {
                    const id = $(this).data('id');
                    const data = {
                        delete: true
                    }
                    const action = confirm('Informasi akan dihapus permanen. Yakin?');
                    if (action)
                        $.post('./api/berkas.php?id=' + id, data, res => {
                            console.log(res);
                            alert(res.message);
                            tabelBanner.ajax.reload(null, false);
                            reloadWidget()
                        }).fail(err => console.log(err));
                });
                reloadWidget();
            });
        });
    </script>
</body>

</html>