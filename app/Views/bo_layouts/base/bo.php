<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
	<meta name="author" content="AdminKit">
	<meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="<?= base_url()?>assets/img/icons/icon-48x48.png" />

	<title><?= $this->renderSection('title') ?></title>

	<link href="<?= base_url()?>assets/css/light.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@3.11.0/dist/tabler-icons.min.css">
  
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

  <?= $this->renderSection('pageCSS') ?>

  <style>
    table.dataTable tbody td.selected, table.dataTable tbody th.selected, table.dataTable tbody tr.selected {
      background: #000 !important;
    }
    .ti-xs {
      font-size: 1rem !important;
    }

    .ti-sm {
      font-size: 1.125rem !important;
    }

    .ti-md {
      font-size: 1.375rem !important;
    }

    .ti-lg {
      font-size: 1.5rem !important;
    }

    .ti-xl {
      font-size: 2.25rem !important;
    }
  </style>
</head>

<body>
	<div class="wrapper">
    <?= $this->include('bo_layouts/base/sidebar'); ?>

		<div class="main">
      <?= $this->include('bo_layouts/base/navbar'); ?>

			<main class="content">
        <?= $this->renderSection('content') ?>
			</main>

			<?= $this->include('bo_layouts/base/footer'); ?>
		</div>
	</div>

	<script src="<?= base_url()?>assets/js/app.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <?= $this->renderSection('pageJS') ?>

</body>

</html>