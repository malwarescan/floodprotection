<?php
function esc($s){return htmlspecialchars($s,ENT_QUOTES,'UTF-8');}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= esc($title ?? 'Flood Protection in Southwest Florida') ?></title>
<meta name="description" content="<?= esc($meta ?? 'Engineered flood protection for Southwest Florida—door plugs, perimeter barriers, slab uplift mitigation, and pump plans.') ?>">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<!-- Tailwind CSS -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- Preline UI CSS -->
<!-- Using unpkg CDN instead of jsdelivr to avoid MIME type issues -->
<link rel="stylesheet" href="https://unpkg.com/preline@2.0.3/dist/preline.min.css" crossorigin="anonymous">

<!-- Custom Tailwind Config -->
<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    primary: {
                        50: '#eef2f8',
                        600: '#153E75',
                        DEFAULT: '#1B365D'
                    },
                    accent: {
                        600: '#d84f23',
                        DEFAULT: '#F05A28'
                    }
                }
            }
        }
    }
</script>

<!-- Custom CSS -->
<link rel="stylesheet" href="/assets/app.css"/>
</head>
<body class="bg-white text-gray-900">
