<?php
$title = 'Home';


$tags = exec_sql_query(
  $db,
  "SELECT * FROM tags",
  array(
  )
)->fetchAll();

$sql_select_part = 'SELECT * FROM plants';
$sql_where_part = '';
$sql_order_part = '';

$sql_search_expression = array();
$sql_filter_expression = NULL;
$sql_filter_expressions = array();
$sql_param_markers = array();

// --- search ---
$search_name_feedback = 'hidden';

if(isset($_GET['s'])){
  $search_form_valid=true;
  $search_terms = trim($_GET['s'] ?? NULL);
  if($search_terms==null){
    $search_name_feedback = '';
    $search_form_valid=false;
  }

  $sticky_search = $search_terms;

  if($search_form_valid){
    $sql_search_expression= "(plant_name LIKE '%' || :search || '%')";
    $sql_param_markers[':search'] = $search_terms;

  }


}



// --- filter ---
$filter_feedback='hidden';


if(isset($_GET['submit_filter'])){
  $filter_form_valid = true;
  $filter_annual = (bool)($_GET['annual'] ?? NULL);
  $filter_perennial = (bool)($_GET['perennial'] ?? NULL);
  $filter_fullsun = (bool)($_GET['full_sun'] ?? NULL);
  $filter_partialshade = (bool)($_GET['partial_shade'] ?? NULL);
  $filter_fullshade = (bool)($_GET['full_shade'] ?? NULL);

  if(!$filter_annual&& !$filter_perennial&& !$filter_fullsun&&!$filter_partialshade &&!$filter_fullshade){
    $filter_form_valid=false;
    $filter_feedback='';
  }


  if($filter_form_valid){
    if ($filter_annual) {
      array_push($sql_filter_expressions, "(annual = 1)");
    }

    if ($filter_perennial) {
      array_push($sql_filter_expressions, "(perennial = 1)");
    }

    if ($filter_fullsun) {
      array_push($sql_filter_expressions, "(full_sun = 1)");
    }

    if ($filter_partialshade) {
      array_push($sql_filter_expressions, "(partial_shade= 1)");
    }

    if ($filter_fullshade) {
      array_push($sql_filter_expressions, "(full_shade = 1)");
    }

    if (count($sql_filter_expressions) > 0) {
      $sql_filter_expression = '(' . implode(' AND ', $sql_filter_expressions) . ')';
    }

    $sticky_filter_annual = ($filter_annual ? 'checked' : '');
    $sticky_filter_perennial = ($filter_perennial ? 'checked' : '');
    $sticky_filter_fullsun = ($filter_fullsun ? 'checked' : '');
    $sticky_filter_partialshade = ($filter_partialshade ? 'checked' : '');
    $sticky_filter_fullshade = ($filter_fullshade ? 'checked' : '');
  }



}


if ($sql_search_expression && $sql_filter_expression) {
  $sql_where_part = ' WHERE ' . $sql_search_expression . ' AND ' . $sql_filter_expression;
} else if ($sql_search_expression && !$sql_filter_expression) {
  $sql_where_part = ' WHERE ' . $sql_search_expression;
} else if (!$sql_search_expression && $sql_filter_expression) {
  $sql_where_part = ' WHERE ' . $sql_filter_expression;
}

// final query
$sql_query = $sql_select_part . $sql_where_part . $sql_order_part . ';';

// query plants table with built query
$records = exec_sql_query($db, $sql_query, $sql_param_markers)->fetchAll();



?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" type="text/css"  href="/public/styles/all.css"   @media print {
         p.bodyText {font-family:georgia, times, serif;}
      } />
      <link rel="stylesheet" media="screen and (max-width: 600px)" href="/public/styles/smallscreen.css">



  <title><?php echo $title; ?> - plaful plants</title>
</head>

<body>
<?php include("includes/header.php") ?>



<div id="wrapper">
  <div class="welcome">
   <p>  <center> Welcome to playful plant!</center></p>
  </div>

  <?php echo_login_form('/administrator', $session_messages); ?>



  <div id="filter-image">
    <form class="filter-form" action="/" method="GET" novalidate>
      <div class="subtitle">
          Search by Plant Name:
      </div>
      <div id = "search-filter">
        <div id="feedback-search" class="feedback <?php echo $search_name_feedback ?>">Please enter a plant name.</div>
        <div id ="search-box">
          <label>
            Plant name:
            <input type="text" name="s" class="textbox" maxlength="50" value = "<?php echo htmlspecialchars($sticky_search); ?>"/>
          </label>

        </div>

        <div id ="search">
          <button class = "search-button" onclick="toggleSearch()">
            Search
          </button>
        </div>
      </div>
    </form>



      <div class="subtitle">Filter by plants care: </div>

      <form class="filter-form" action="/" method="GET" novalidate>
      <div id ="filter">
      <div id="feedback-classes" class="feedback <?php echo     $filter_feedback ?>">Please select at least one</div>

        <label>
          <input type="checkbox" id="filter_play" name="annual" <?php echo $sticky_filter_annual ?> value = "annual">
          Annual<br>
        </label>

        <label>
          <input type="checkbox" id="filter_play" name="perennial" <?php echo $sticky_filter_perennial ?> value = "perennial">
          Perennial<br>
        </label>

        <label>
          <input type="checkbox" id="filter_play" name="full_sun" <?php echo $sticky_filter_fullsun ?> value = "full_sun">
          Full Sun<br>
        </label>

        <label>
          <input type="checkbox" id="filter_play" name="partial_shade" <?php echo $sticky_filter_partialshade ?> value = "partial_shade">
          Partial Shade<br>
        </label>

        <label>
          <input type="checkbox" id="filter_play" name="full_shade" <?php echo $sticky_filter_fullshade ?> value = "full_shade">
          Full shade<br>
        </label>
        <button type="submit" name="submit_filter" id="submit-button">Filter</button>
      </div>
    </form>
  <div id="all-catagories">
    <div class= "subtitle">
      <p>All Catagories:</p>
    </div>

    <div id= "tags">
    <?php
        foreach ($tags as $tag) { ?>
      <a href="/tags?<?php echo http_build_query(array('id' => $tag['id'])); ?>"> <?php echo $tag['tag_name'] ?></a><br>
      <?php
      } ?>
    </div>


  </div>
  </div>



  <div id="image-content">
          <!-- Source: https://stock.adobe.com/search?k=placeholder -->
      <?php
        foreach($records as $record){
          // for each plants, show the image by id fields, if the image does not exit show the placeholder
          $path = "public/uploads/plants/" . $record['id'] .'.' . $record['file_ext'] ;
          if(file_exists($path)){
            echo '<div class= "image">';
                echo '<a href="/image?id='.$record['id'].'"><img src="/public/uploads/plants/'.$record['id'].'.'.$record['file_ext'].'" width=200 height=200 alt="plant"/> </a>';
                echo '<p>'.$record['plant_name'].'</p>';
            echo '</div>';
          } else{
            echo '<div class= "image">';
                echo '<a href="/image?id='.$record['id'].'"><img src="/public/uploads/plants/placeholder.png " width=200 height=200 alt="placehoder" /></a>';
                echo '<p>'.$record['plant_name'].'</p>';
            echo '</div>';
          }
        }
      ?>






  </div>







</div>

</body>

</html>
