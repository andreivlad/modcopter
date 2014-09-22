<!DOCTYPE HTML>
<!--
/*
 * jQuery File Upload Plugin Demo 6.5.1
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */
-->
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo $this->pageTitle;?></title>
    <meta name="description" content="File Upload widget with multiple file selection, drag&amp;drop support, progress bar and preview images for jQuery. Supports cross-domain, chunked and resumable file uploads. Works with any server-side platform (Google App Engine, PHP, Python, Ruby on Rails, Java, etc.) that supports standard HTML form file uploads.">
    <meta name="viewport" content="width=device-width">
    <!-- Bootstrap CSS Toolkit styles -->
    <link rel="stylesheet" href="<?php echo $this->getAssetsUrl(); ?>/js/jQueryUpload/css/bootstrap.min.css">
    <!-- Generic page styles -->
    <link rel="stylesheet" href="<?php echo $this->getAssetsUrl(); ?>/css/style.css">

    <!-- Bootstrap CSS fixes for IE6 -->
    <!--[if lt IE 7]><link rel="stylesheet" href="http://blueimp.github.com/cdn/css/bootstrap-ie6.min.css"><![endif]-->

    <!-- Shim to make HTML5 elements usable in older Internet Explorer versions -->
    <!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->

    <script src="<?php echo $this->getAssetsUrl();?>/js/main.js"></script>


    <!-- The Templates plugin is included to render the upload/download listings -->
    <script src="<?php echo $this->getAssetsUrl();?>/js/jQueryUpload/js/tmpl.min.js"></script>
    <!-- The Load Image plugin is included for the preview images and image resizing functionality -->
    <script src="<?php echo $this->getAssetsUrl();?>/js/jQueryUpload/js/load-image.min.js"></script>
    <!-- The Canvas to Blob plugin is included for image resizing functionality -->
    <script src="<?php echo $this->getAssetsUrl();?>/js/jQueryUpload/js/canvas-to-blob.min.js"></script>
    <!-- Bootstrap JS and Bootstrap Image Gallery are not required, but included for the demo -->
    <script src="<?php echo $this->getAssetsUrl();?>/js/jQueryUpload/js/bootstrap.min.js"></script>
    <script src="<?php echo $this->getAssetsUrl();?>/js/jQueryUpload/js/blueimp-gallery.min.js"></script>
    <!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
    <!-- The XDomainRequest Transport is included for cross-domain file deletion for IE8+ -->
    <!--[if gte IE 8]><script src="<?php echo $this->getAssetsUrl();?>/js/jQueryUpload/js/jquery.xdr-transport.js"></script><![endif]-->
</head>
<body>

<div class="container">
    <h1>Mod copter image upload</h1>
    <?php echo $content; ?>
</div>


</body>
</html>
