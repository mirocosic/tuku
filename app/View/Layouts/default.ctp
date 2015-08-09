<!DOCTYPE html>
<html>
<head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="apple-mobile-web-app-capable" content="yes">
	<?php echo $this->Html->charset(); ?>
	<title>Tukunga DEV!</title>
	
        <!-- JQuery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    
        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        
        <link rel="apple-touch-icon" sizes="57x57" href="/iconified/apple-icon-57x57.png" />
        <link rel="apple-touch-icon" sizes="72x72" href="/iconified/apple-icon-72x72.png" />
        <link rel="apple-touch-icon" sizes="114x114" href="/iconified/apple-icon-114x114.png" />
        <link rel="apple-touch-icon" sizes="144x144" href="/iconified/apple-icon-144x144.png" />
</head>
<body>
    <div id="container">
        <div id="content">
            
            <?php echo $this->element('Menu');?>
            
            <?php echo $this->fetch('content'); ?>
        </div>
    </div>
</body>
</html>
