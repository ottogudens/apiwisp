<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
<link rel="stylesheet" href="<?= $DATA['http_domain'] ?>public/css.general/bootstrap.min.css">
<link rel="stylesheet" href="<?= $DATA['http_domain'] ?>public/css.panel/general.css">

<!-- <link rel="stylesheet" href="<?= $DATA['http_domain'] ?>public/css.panel/table.css"> -->
<link rel="shortcut icon" href="<?= $DATA['http_domain'] ?>public/img/logo1.png?last=<?= $DATA['info']['info_last'] ?? '' ?>" type="image/x-icon">
<title><?= $DATA['title'] ?></title>
<script>
    const http_domain = '<?= $DATA['http_domain'] ?>';
    const SESSION = JSON.parse('<?= json_encode($_SESSION) ?>');
</script>