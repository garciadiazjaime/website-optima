<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="author" content="Mint IT Media" />
<meta name="viewport" content="width=device-width" />
<meta name="keywords" content="<?=$keywords?>">
<title><?=$title?></title>
<link rel="shortcut icon" type="image/png" href="<?=base_url()?>resources/images/favicon_optima.ico">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>resources/css/screen.css">
<!-- bjqs.css contains the *essential* css needed for the slider to work -->
<link rel="stylesheet" href="<?=base_url()?>resources/css/bjqs.css">
<link rel="stylesheet" href="<?=base_url()?>resources/css/bootstrap.css">

<?php if ($this->agent->browser() == 'Internet Explorer' and $this->agent->version() == 8): ?>    
<link rel="stylesheet" type="text/css" href="<?=base_url()?>resources/css/style_ie.css">
<?php endif; ?>

<script type="text/javascript" src="<?=base_url()?>resources/js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>resources/js/jquery.cycle.all.latest.js"></script>

<script type="text/javascript" src="<?=base_url()?>resources/js/bjqs-1.3.js"></script>
<script type="text/javascript" src="<?=base_url()?>resources/js/functions.js"></script>
<script type="text/javascript" src="<?=base_url()?>resources/js/bootstrap.js"></script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
  ga('create', 'UA-40678433-1', 'optima-os.com');
  ga('send', 'pageview');
</script>
