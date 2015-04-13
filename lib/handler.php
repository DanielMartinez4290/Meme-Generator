<?php
include("GrabzItClient.class.php");
include("config.php");

//This PHP file handles the GrabzIt callback

$message = $_GET["message"];
$customId = $_GET["customid"];
$id = $_GET["id"];
$filename = $_GET["customid"];
$format = $_GET["format"];

$grabzIt = new GrabzItClient($grabzItApplicationKey, $grabzItApplicationSecret);
$result = $grabzIt->GetResult($id);

if (!$result)
{
   return "jpg failed";
}

file_put_contents("../memes/" . $filename, $result);

?>