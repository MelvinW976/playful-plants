<?php
$title = 'tags';

$tag_id = $_GET['id'] ?? NULL;

// query the images with this tag;
if ($tag_id) {
  $records = exec_sql_query(
    $db,
    "SELECT plants.id AS 'plants.id',
    tags.tag_name AS 'tags.tag_name',
    plants.plant_name AS 'plants.plant_name',
    plants.perennial AS 'plants.perennial',
    plants.annual AS 'plants.annual',
    plants.full_sun AS 'plants.full_sun',
    plants.partial_shade AS 'plants.partial_shade',
    plants.full_shade AS 'plants.full_shade',
    plants.file_ext AS 'plants.file_ext'
    FROM tags
    INNER JOIN tags_plants ON (tags.id = tags_plants.tags_id)
    INNER JOIN plants ON (plants.id = tags_plants.plant_id)
    WHERE
    (tags_plants.tags_id= :id);",
    array(':id' => $tag_id)
  )->fetchAll();

  if (count($records) > 0) {
    $tags = $records[0];
    $title = $tags['tags_name'];
  } else {
    $plant = NULL;
    $title = 'Unknown tag';
  }
}


$perennial = $tags['plants.perennial'] == 1 ? 'YES' : 'NO';
$annual = $tags['plants.annual'] == 1 ? 'YES' : 'NO';
$fullsun = $tags['plants.full_sun'] == 1 ? 'YES' : 'NO';
$fullshade = $tags['plants.full_shade'] == 1 ? 'YES' : 'NO';
$partialshade= $tags['plants.partial_shade'] == 1 ? 'YES' : 'NO';

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" type="text/css" href="/public/styles/all.css"     @media print {
         p.bodyText {font-family:georgia, times, serif;}
      } />
  <link rel="stylesheet" media="screen and (max-width: 600px)" href="/public/styles/smallscreen.css">

  <title><?php echo $title; ?> - plaful plants</title>
</head>

<body>
<?php include("includes/header.php") ?>
<div id="wrapper">
  <div class="welcome">
   <p>Entries with a <?php echo $tags['tags.tag_name']; ?> tag:</p>
  </div>

  <div id="tags-image">
  <table>
    <tr>
      <th>Plant Images</th>
      <th>Plant detail information</th>

    </tr>
    <?php foreach ($records as $record) {?>
    <tr>

      <td class="text-center">
      <!-- Source: https://stock.adobe.com/search?k=placeholder -->
        <?php
      $path = "public/uploads/plants/".$record['plants.id']."." .$record['plants.file_ext'];
          if(file_exists($path)){
            echo '<div class= "image">';
                echo '<a href="/image?id='.$record['plants.id'].'"><img src="public/uploads/plants/'.$record['plants.id'].'.'.$record['plants.file_ext'].'" width=200 height=200 alt="plant"/> </a>';
                echo '<p>'.$plant['plants.plant_name'].'</p>';
            echo '</div>';
          } else{
            echo '<div class= "image">';
                echo '<a href="/image?id='.$record['plants.id'].'"><img src="/public/uploads/plants/placeholder.png" width=200 height=200 alt="placehoder"/></a>';
                echo '<p>'.$record['plants.plant_name'].'</p>';
            echo '</div>';
          } ?> </td>
      <td>
      Plant Name: <?php echo htmlspecialchars($record['plants.plant_name']); ?> <br>
      Perennial : <?php echo htmlspecialchars($perennial); ?> <br>
      Annual : <?php echo htmlspecialchars($annual); ?> <br>
      Full Sun :<?php echo htmlspecialchars($fullsun); ?> <br>
      Partial Shade :<?php echo htmlspecialchars($partialshade); ?> <br>
      Full Shade :<?php echo htmlspecialchars($fullshade); ?> <br>
      </td>


    </tr>
    <?php } ?>
  </table>
  </div>
  <div id="back">
      <a href="/">Back to Home </a>
  </div>

</div>


</body>

</html>
