<?php
// display the image that user clicked on and its detailed information
$plant_id = $_GET['id'] ?? NULL;

// JIONT query to get the plant and all the tags about this image
if ($plant_id) {
  $records = exec_sql_query(
    $db,
    "SELECT tags.tag_name AS 'tags.tag_name',
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
    (tags_plants.plant_id= :id);",
    array(':id' => $plant_id)
  )->fetchAll();

  if (count($records) > 0) {
    $plant = $records[0];
    $plant_name= $plant['plants.plant_name'];
    $file_ext= $plant['plants.file_ext'];
    $title = $plant['plants.plant_name'] . ' - information';
    $perennial = $plant['plants.perennial'] == 1 ? 'YES' : 'NO';
    $annual = $plant['plants.annual'] == 1 ? 'YES' : 'NO';
    $fullsun = $plant['plants.full_sun'] == 1 ? 'YES' : 'NO';
    $fullshade = $plant['plants.full_shade'] == 1 ? 'YES' : 'NO';
    $partialshade= $plant['plants.partial_shade'] == 1 ? 'YES' : 'NO';

  } else { // there is no tag for the plant
    $records=exec_sql_query(
      $db,
      "SELECT * FROM plants WHERE (id=:id)",
      array(':id' => $plant_id)
    )->fetchALL();

    if(count($records)>0){
      $plant=$records[0];
      $plant_name=$plant['plant_name'];
      $file_ext= $plant['file_ext'];
      $perennial = $plant['Perennial'] == 1 ? 'YES' : 'NO';
      $annual = $plant['Annual'] == 1 ? 'YES' : 'NO';
      $fullsun = $plant['Full_sun'] == 1 ? 'YES' : 'NO';
      $fullshade = $plant['Full_shade'] == 1 ? 'YES' : 'NO';
      $partialshade= $plant['Partial_shade'] == 1 ? 'YES' : 'NO';
    }
  }
}




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

  <title><?php echo $plant['plants.plant_name']; ?> - plaful plants</title>
</head>

<body>
<?php include("includes/header.php") ?>
<div id="wrapper">
  <div class="welcome">
   <p>Details about <?php echo $plant_name; ?>:</p>
  </div>

  <div id="tags-image">
  <table class="detail-image">
    <tr>
      <th>Plant Images</th>
      <th>Plant detail information</th>

    </tr>
    <tr>
      <tr>
      <td class="text-center">
        <!-- Source: https://stock.adobe.com/search?k=placeholder -->
        <?php
      $path = "public/uploads/plants/".$plant_id."." . $file_ext;
          if(file_exists($path)){
            echo '<div class= "image-d">';
                echo '<a href="/image?id='.$plant_id.'"><img src="/public/uploads/plants/'.$plant_id.'.'.$file_ext.'" width=200 height=200 alt="plant"/> </a>';
                echo '<p>'.$plant_name.'</p>';
            echo '</div>';
          } else{
            echo '<div class= "image-d">';
                echo '<a href="/image?id='.$plant_id.'"><img src="/public/uploads/plants/placeholder.png" width=200 height=200 alt="placehoder"/></a>';
                echo '<p>'.$plant_name.'</p>';
            echo '</div>';
          } ?> </td>
      <td>Plant Name: <?php echo htmlspecialchars($plant_name); ?> <br>
      Tags: <?php foreach ($records as $record) { ?> <?php echo htmlspecialchars($record['tags.tag_name'] . '/'); ?> <?php } ?> <br>
      Perennial : <?php echo htmlspecialchars($perennial); ?> <br>
      Annual : <?php echo htmlspecialchars($annual); ?> <br>
      Full Sun :<?php echo htmlspecialchars($fullsun); ?> <br>
      Partial Shade :<?php echo htmlspecialchars($partialshade); ?> <br>
      Full Shade :<?php echo htmlspecialchars($fullshade); ?> <br>

      </tr>
    </tr>
  </table>
  </div>

  <div id="back">
      <a href="/">Back to Home </a>
  </div>


</div>

</body>

</html>
