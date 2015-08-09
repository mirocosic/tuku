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
        
        <link rel="apple-touch-icon" sizes="57x57" href="/iconified/apple-touch-icon-57x57.png" />
        <link rel="apple-touch-icon" sizes="72x72" href="/iconified/apple-touch-icon-72x72.png" />
        <link rel="apple-touch-icon" sizes="76x76" href="/iconified/apple-touch-icon-76x76.png" />
        <link rel="apple-touch-icon" sizes="114x114" href="/iconified/apple-touch-icon-114x114.png" />
        <link rel="apple-touch-icon" sizes="120x120" href="/iconified/apple-touch-icon-120x120.png" />
        <link rel="apple-touch-icon" sizes="144x144" href="/iconified/apple-touch-icon-144x144.png" />
        <link rel="apple-touch-icon" sizes="152x152" href="/iconified/apple-touch-icon-152x152.png" />
        <link rel="apple-touch-icon" sizes="180x180" href="/iconified/apple-touch-icon-180x180.png" />
        
        <!-- custom CSS -->
        <link rel="stylesheet" href="/css/default.css">
        <style>
            html { height: 100% }
            body { height: 100%; margin: 0px; padding: 0px }
            #container{width:100%; height:100%}
            #content{width: 100%; height: 100%}
            .navbar {margin-bottom: 0;}
        </style>
        
        <script src="http://maps.googleapis.com/maps/api/js?libraries=places&sensor=false"></script>
        
        
        
</head>
<body>
    <div id="container">
        <div id="content">
            <?php echo $this->fetch('content'); ?>
        </div>
    </div>
</body>
</html>
