<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <!-- Mobile Specific Metas
–––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- FONT
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">

    <!-- CSS
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <link rel="stylesheet" href="assets/css/normalize.css">
    <link rel="stylesheet" href="assets/css/skeleton.css">
    <link rel="stylesheet" href="assets/css/app.css">

</head>
<body>
<div class="container">
    <div class="row">
        <h1>Digital Vernisage Backend</h1>
        <?php if(key_exists('page', $_GET) && $_GET['page'] == "entry"): ?>
            <a href="/">Go back</a>
        <?php endif ?>
    </div>

