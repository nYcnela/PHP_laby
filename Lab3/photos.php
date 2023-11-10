<?php
function printImageLinks() {
    print '<a href="./images/img_' . $_GET['pic'] . '.jpg">Zdjęcie</a><br/>';
    print '<a href="./thumbnails/thb_' . $_GET['pic'] . '.jpg">Miniaturka</a><br/>';
    print '<a href="photos.html">Powrót</a>';
    print '<br>';
}

function processInput() {
    if (isset($_POST["height"]) && ($_POST["height"] != ""))
        $maxHeight = htmlspecialchars(trim($_POST["height"]));
    else
        die("Nie podano wysokości");

    if (isset($_POST["width"]) && ($_POST["width"] != ""))
        $maxWidth = htmlspecialchars(trim($_POST["width"]));
    else
        die("Nie podano szerokości");

    if (!is_uploaded_file($_FILES["image"]["tmp_name"]))
        die("Nie podano pliku");

    if ($_FILES["image"]["type"] !== "image/jpeg")
        header("location:photos.html");

    $imageId = uniqid();
    $imagePath = "./images/" . "img_" . $imageId . ".jpg";
    move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath);

    createThumbnail($maxWidth, $maxHeight, $imageId);

    header('Content-Type: image/jpeg');
    header("location:photos.php?pic=$imageId");

}

function createThumbnail($maxWidth, $maxHeight, $imageId) {
    $imagePath = "./images/" . "img_" . $imageId . ".jpg";

    $scaleX = $scaleY = 1;
    list($width, $height) = getimagesize($imagePath);
    if ($width > $maxWidth)
        $scaleX = $maxWidth / $width;
    if ($height > $maxHeight)
        $scaleY = $maxHeight / $height;
    if ($scaleY <= $scaleX)
        $scale = $scaleY;
    else
        $scale = $scaleX;

    $newHeight = $height * $scale;
    $newWidth = $width * $scale;

    $image = imagecreatefromjpeg($imagePath);
    $thumbnail = imagescale($image, $newWidth, $newHeight);
//    $name = pathinfo($imagePath)["filename"];
    $thumbnailPath = "./thumbnails/" . "thb_" . $imageId . ".jpg";
    imagejpeg($thumbnail, $thumbnailPath, 100);
}

function printGallery() {
    foreach (scandir("./images") as $image) {
        $imageId = pathinfo(substr($image, 4))["filename"];
        $thumbnailPath = "./thumbnails/thb_" . $imageId . ".jpg";
        $photoPath = "./images/img_" . $imageId . ".jpg";
        print "<a href='$photoPath'><img src='$thumbnailPath' alt=''></a>";
    }

    print "<h3>W galerii jest aktualnie " . count(scandir("./images")) . " zdjęć</h3>";
    print '<a href="photos.html">Powrót do formularza dodawania zdjęć</a>';
}

?>

<head>
    <title></title>
</head>
<body>
<?php

if (isset($_GET['pic']) && !empty($_GET['pic']))
    printImageLinks();
elseif (isset($_POST["save"]))
    processInput();

printGallery();
?>
</body>