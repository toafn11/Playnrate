<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <style>
        body,
        html {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            background-color: #000;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .error-image {
            width: 100vw;
            object-fit: contain;
            aspect-ratio: 2 / 1;
        }
    </style>
</head>

<body>

    <a href="index.php" title="Back" style="display: block; width: 100%; height: 100%;">
        <img src="images/404.png" alt="404" class="error-image">
    </a>

</body>

</html>