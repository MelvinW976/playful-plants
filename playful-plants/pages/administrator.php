<?php
 $title = 'Administrator';


// initial state
$show_form = true;
$show_confirmation = false;


// --- search/filter/sort the records

$sql_select_part = 'SELECT * FROM plants';
$sql_where_part = '';
$sql_order_part = '';


$sql_search_expression = NULL;
$sql_filter_expression = NULL;
$sql_filter_expressions= array();
$sql_search_expressions = array();
$sql_param_markers = array();


// --- search ---



// feedback classes
$search_name_feedback = 'hidden';

// insert value
$search_name = '';


// sticky values
$sticky_search_name = '';




// form validation

if(isset($_GET['search'])){
  $search_name = strtolower(trim($_GET['name']));
  $search_form_valid = true;

  if(empty($search_name)){
    $search_form_valid = false;
    $search_name_feedback = '';
  }

  if($search_form_valid){
    $sql_search_expression= "(plant_name LIKE '%' || :search || '%')";
    $sql_param_markers[':search'] = $search_name;
    $sticky_search_name = $search_name;
  }
}




// --- Filter ---

$filter_feedback = 'hidden';

$sticky_filter_constructive = '';
$sticky_filter_sensory = '';
$sticky_filter_physical = '';
$sticky_filter_imaginative = '';
$sticky_filter_restorative = '';
$sticky_filter_expressive = '';
$sticky_filter_rules = '';
$sticky_filter_bio = '';

if(isset($_GET['submit_filter'])){

  $play1 = (bool)($_GET['play1'] ?? NULL);
  $play2 = (bool)($_GET['play2'] ?? NULL);
  $play3 = (bool)($_GET['play3'] ?? NULL);
  $play4 = (bool)($_GET['play4'] ?? NULL);
  $play5 = (bool)($_GET['play5'] ?? NULL);
  $play6 = (bool)($_GET['play6'] ?? NULL);
  $play7 = (bool)($_GET['play7'] ?? NULL);
  $play8 = (bool)($_GET['play8'] ?? NULL);

  $filter_form_valid = true;

  if((!$play1)&&(!$play2)&&(!$play3)&&(!$play4)&&(!$play5)&&(!$play6)&&(!$play7)&&(!$play8)){

    $filter_form_valid = false;
    $filter_feedback = '';
  }

  if($filter_form_valid){
    // fiter the result according to the play types
    $sticky_filter_constructive = ($play1 ? "checked" : '');
    $sticky_filter_sensory = ($play2 ? "checked" : '');
    $sticky_filter_physical = ($play3 ? "checked" : '');
    $sticky_filter_imaginative = ($play4 ? "checked" : '');
    $sticky_filter_restorative = ($play5 ? "checked" : '');
    $sticky_filter_expressive = ($play6 ? "checked" : '');
    $sticky_filter_rules = ($play7 ? "checked" : '');
    $sticky_filter_bio = ($play8 ? "checked" : '');

  }


  if ($play1) {
    array_push($sql_filter_expressions, "(Constructive_Play = 1)");
  }

  if ($play2) {
    array_push($sql_filter_expressions, "(Exploratory_Sensory_Play = 1)");
  }

  if ($play3) {
    array_push($sql_filter_expressions, "(Physical_Play = 1)");
  }

  if ($play4) {
    array_push($sql_filter_expressions, "(Imaginative_Play = 1)");
  }

  if ($play5) {
    array_push($sql_filter_expressions, "(Restorative_Play = 1)");
  }
  if ($play6) {
    array_push($sql_filter_expressions, "(Expressive_Play = 1)");
  }
  if ($play7) {
    array_push($sql_filter_expressions, "(Play_Rules = 1)");
  }
  if ($play8) {
    array_push($sql_filter_expressions, "(Bio_Play = 1)");
  }

}

if (count($sql_filter_expressions) > 0) {
  $sql_filter_expression = '('. implode(' AND ', $sql_filter_expressions).')';
}

if($sql_search_expression && $sql_filter_expression){
  $sql_where_part= ' WHERE ' . $sql_search_expression . 'AND' . $sql_filter_expression;
} else if($sql_search_expression && !$sql_filter_expression){
  $sql_where_part= ' WHERE ' . $sql_search_expression;
} else if(!$sql_search_expression && $sql_filter_expression){
  $sql_where_part= ' WHERE ' . $sql_filter_expression;
}

// sort

$sort= $_GET['sort'] ?? NULL;
$order= $_GET['order'] ?? NULL;
$order_next_url = 'asc';

if($order == 'asc'){
  $sql_order = 'ASC';
  $next_order = 'desc';
}else if($order == 'desc'){
  $sql_order = 'DESC';
  $next_order = NULL;
}else{
  $order ==NULL;
}

if($order){
  $sql_order_part=' ORDER BY plant_name ' . $sql_order;
  $order_next_url = $order_next;
}

// final query
$sql_query = $sql_select_part . $sql_where_part . $sql_order_part . ';';

$records= exec_sql_query($db, $sql_query, $sql_param_markers) -> fetchAll();



// --- Insert entries ---

$plant_inserted= false;



define("MAX_FILE_SIZE", 1000000);

$add_name_feedback = 'hidden';
$add_play_feedback = 'hidden';
$add_file_feedback = 'hidden';
$add_id_feedback = 'hidden';
$add_garden_feedback = 'hidden';

$sticky_add_name = '';
$sticky_add_id = '';
$sticky_add_ext  ='';
$sticky_add_constructive = '';
$sticky_add_sensory = '';
$sticky_add_physical = '';
$sticky_add_imaginative = '';
$sticky_add_restorative = '';
$sticky_add_expressive = '';
$sticky_add_rules = '';
$sticky_add_bio = '';
$sticky_garden1 = '';
$sticky_garden2 = '';
$sticky_garden3 = '';
$sticky_garden4 = '';
$sticky_garden5 = '';

if(isset($_POST['add'])){
  $add_name = trim($_POST['plant_name']);
  $add_id = trim($_POST['plant_id']);
  $add_play1 = $_POST['add_play1'];
  $add_play2 = $_POST['add_play2'];
  $add_play3 = $_POST['add_play3'];
  $add_play4 = $_POST['add_play4'];
  $add_play5 = $_POST['add_play5'];
  $add_play6 = $_POST['add_play6'];
  $add_play7 = $_POST['add_play7'];
  $add_play8 = $_POST['add_play8'];
  $garden1 = $_POST['add_garden1'];
  $garden2 = $_POST['add_garden2'];
  $garden3 = $_POST['add_garden3'];
  $garden4 = $_POST['add_garden4'];
  $garden5 = $_POST['add_garden5'];

  $add_form_valid = true;
  $upload = $_FILES['file'];

  if($upload['error']== UPLOAD_ERR_OK){
    $upload_filename = basename($upload['name']);
    $upload_ext = strtolower(pathinfo($upload_filename, PATHINFO_EXTENSION));

    if (!in_array($upload_ext, array('jpg','jpeg','png'))) {
      $add_form_valid = False;
      $add_file_feedback='';
    }
  }else{
    $add_form_valid=false;
    $add_file_feedback='';
  }


  if(empty($add_name)){
    $add_form_valid = false;
    $add_name_feedback='';
  }
  if(empty($add_id)){
    $add_form_valid = false;
    $add_id_feedback='';
  }

  if(empty($add_play1)&&empty($add_play2)&&empty($add_play3)&&empty($add_play4)&&empty($add_play5)&&empty($add_play6)&&empty($add_play7)&&empty($add_play8)){

    $add_form_valid = false;
    $add_play_feedback = '';
  }
  if(empty($garden1)&&empty($garden2)&&empty($garden3)&&empty($garden4)&&empty($garden5)){
    $add_garden_feedback='';
    $add_form_valid=false;
  }

  if($upload['error'] == UPLOAD_ERR_OK){
    $upload_filename = basename($upload['name']);
    $upload_ext = strtolower(pathinfo($upload_filename, PATHINFO_EXTENSION));
    if (!in_array($upload_ext, array('jpg','jpeg','png'))) {
    $form_valid = False;
    }
  }else{
    $add_form_valid=false;
    $add_file_feedback='';
  }

  if($add_form_valid){
    // fiter the result according to the play types
    $add_play1 = empty($add_play1) ? 0 : 1;
    $add_play2 = empty($add_play2) ? 0 : 1;
    $add_play3 = empty($add_play3) ? 0 : 1;
    $add_play4 = empty($add_play4) ? 0 : 1;
    $add_play5 = empty($add_play5) ? 0 : 1;
    $add_play6 = empty($add_play6) ? 0 : 1;
    $add_play7 = empty($add_play7) ? 0 : 1;
    $add_play8 = empty($add_play8) ? 0 : 1;
    $garden1 = empty($garden1) ? 0 : 1;
    $garden2 = empty($garden2) ? 0 : 1;
    $garden3 = empty($garden3) ? 0 : 1;
    $garden4 = empty($garden4) ? 0 : 1;
    $garden5 = empty($garden5) ? 0 : 1;

    $result = exec_sql_query(
      $db,
      "INSERT INTO plants (plant_name, plant_id, Constructive_play, Exploratory_Sensory_Play, Physical_Play, Imaginative_Play, Restorative_Play, Expressive_Play, Play_Rules, Bio_Play, Perennial, Annual, Full_sun, Partial_shade, Full_shade, file_ext) VALUES (:name, :plant_id, :play1, :play2, :play3, :play4, :play5, :play6, :play7, :play8, :garden1, :garden2, :garden3, :garden4, :garden5, :file_ext)",
      array(
        ':name' => $add_name,
        ':plant_id' => $add_id,
        ':play1' => $add_play1,
        ':play2' => $add_play2,
        ':play3' => $add_play3,
        ':play4' => $add_play4,
        ':play5' => $add_play5,
        ':play6' => $add_play6,
        ':play7' => $add_play7,
        ':play8' => $add_play8,
        ':garden1' => $garden1,
        ':garden2' => $garden2,
        ':garden3' => $garden3,
        ':garden4' => $garden4,
        ':garden5' => $garden5,
        ':file_ext' => $upload_ext
      )
    );

  }else{
    $add_file_feedback='';
    $sticky_add_name = $add_name;
    $sticky_add_id= $add_id;
    $sticky_add_constructive = ($add_play1 == "constructive" ? "checked" : '');
    $sticky_add_sensory = ($add_play2 == "sensory" ? "checked" : '');
    $sticky_add_physical = ($add_play3 == "physical" ? "checked" : '');
    $sticky_add_imaginative = ($add_play4 == "imaginative" ? "checked" : '');
    $sticky_add_restorative = ($add_play5 == "restorative" ? "checked" : '');
    $sticky_add_expressive = ($add_play6 == "expressive" ? "checked" : '');
    $sticky_add_rules = ($add_play7 == "rules" ? "checked" : '');
    $sticky_add_bio = ($add_play8 == "bio" ? "checked" : '');
    $sticky_garden1 = ($garden1 == "garden1" ? "checked" : '');
    $sticky_garden2 = ($garden2 == "garden2" ? "checked" : '');
    $sticky_garden3 = ($garden3 == "garden3" ? "checked" : '');
    $sticky_garden4 = ($garden4 == "garden4" ? "checked" : '');
    $sticky_garden5 = ($garden5 == "garden5" ? "checked" : '');
  }

  if($result){
    $show_confirmation = true;
    $record_id = $db->lastInsertId('id');

    $id_file = 'public/uploads/plants/' . $record_id . '.' . $upload_ext;
    move_uploaded_file($upload["tmp_name"], $id_file);
  }
}


// ---insert tags (can only one at a time) ---
$insert_name_feedback = 'hidden';
$insert_tag_feedback= 'hidden';
$insert_tag_sucess = false;
$tag_form_valid=true;
$tag_exit=false;

$sticky_insert_name='';
$sticky_insert_tag='';

if(isset($_POST['add_tag'])){
  $insert_name = trim($_POST['insert_name']);
  $insert_tag = trim($_POST['insert_tag']);
  if(empty($insert_name)){
    $insert_name_feedback = '';
    $sticky_insert_name=$insert_name;
    $tag_form_valid=false;
  }else{
    $db_name = exec_sql_query(
      $db,
      "SELECT *
      FROM plants
      WHERE (plant_name = :name);",
      array(
        ':name' => $insert_name
      )
    )->fetchAll();
    $name_id = $db_name[0];
    $name_id = $name_id['id'];
    if(empty($name_id)){
      $insert_name_feedback = '';
      $sticky_insert_name=$insert_name;
      $tag_form_valid=false;
    }
  }
  if(empty($insert_tag)){
    $tag_form_valid=false;
    $sticky_insert_tag=$insert_tag;
    $insert_tag_feedback='';
  }else{
    $db_tag = exec_sql_query(
      $db,
        "SELECT *
        FROM tags
        WHERE (tag_name = :name);",
        array(
          ':name' => $insert_tag
        )
      )->fetchAll();

    if(empty($db_tag)){
      $tag = exec_sql_query(
        $db,
          "INSERT INTO
          tags (tag_name)
          VALUES (:name);",
          array(
            ':name' => $insert_tag
          )
        )->fetchAll();
        $tag_id=$db->lastInsertId('id');
    }else{
      $tag_id = $db_tag[0];
      $tag_id = $tag_id['id'];
    }
  }
  $tag_check = exec_sql_query(
    $db,
    "SELECT *
    FROM tags_plants
    WHERE
    (plant_id= :name_id AND
    tags_id= :tag_id);",
    array(':name_id' => $name_id,
    ':tag_id'=> $tag_id)
  )->fetchAll();
  if(count($tag_check)>0){
    $tag_exit=true;
    $sticky_insert_tag=$insert_tag;
    $sticky_insert_name=$insert_name;
  }
  if($tag_form_valid && !$tag_exit){
      $result = exec_sql_query(
        $db,
        "INSERT INTO tags_plants (plant_id, tags_id) VALUES (:name_id, :tag_id)",
        array(
          ':name_id' => $name_id,
          ':tag_id' => $tag_id
        )
      );

      if($result){
        $insert_tag_sucess = true;
      }else{
        $sticky_insert_tag=$insert_tag;
        $insert_tag_feedback='';
      }
  }


}

// logout

if(isset($_POST['logout'])){
  logout($db, $session);
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

  <title><?php echo $title; ?> - <?php echo $current_user['name'] ?></title>
</head>

<body>
<?php include("includes/header.php") ?>


<?php if($show_confirmation) {?>

  <section>
    <div id= "confirmation">
      <center><h3>Add Plants Confirmation</h3></center>
      <p>You have successfully add a new plant information to the dataset, which name is <?php echo htmlspecialchars($add_name); ?>. And it supports->  <?php echo htmlspecialchars($add_play1 ? 'constructive' : ''); ?> <?php echo htmlspecialchars($add_play2 ? 'sensory' : ''); ?> <?php echo htmlspecialchars($add_play3 ? 'physical' : ''); ?> <?php echo htmlspecialchars($add_play4 ? 'imaginative' : ''); ?> <?php echo htmlspecialchars($add_play5 ? 'restorative' : ''); ?> <?php echo htmlspecialchars($add_play6 ? 'expressive' : '');?> <?php echo htmlspecialchars($add_play7 ? 'rules' : ''); ?> <?php echo htmlspecialchars($add_play8 ? 'bio' : ''); ?>   <- play types</p>

      <p><a href="/administrator">Back to home</a></p>
    </div>

    </section>

<?php } else if(is_user_logged_in()) { ?>



  <div id="wrapper">
    <div class="welcome">
      <?php if($insert_tag_sucess) { ?>
        <p>  <center> You have succesfully insert a tag !</center></p>
      <?php }  else if($tag_exit)  { ?>
        <p>  <center> Sorry! Insert tag goes wrong, the tag already exist.</center></p>
      <?php }  else if(is_user_logged_in()){?>
        <p>  <center> Successfully login ! Welcome  <?php echo $current_user['name'] ?> !</center></p>
        <form action="/" method="post">
          <button name="logout" class="logout" type="submit" > Sign Out</button>
        </form>
        <?php }?>
    </div>

    <div id="filter-image">
      <form class="filter-form" action="/administrator" method="GET" novalidate>
        <div id="feedback-search" class="feedback <?php echo $search_name_feedback; ?>">Please enter a plant name.</div>
        <div class="subtitle">Search by plant name:</div>
        <div id = "search-filter">

          <div id ="search-box">
            <label>
              Plant name:
              <input type="text" name="name" class="textbox" maxlength="50" value = "<?php echo $sticky_search_name; ?>"/>
            </label>

          </div>

          <div id ="search">
            <button class = "search-button" name = "search" onclick="toggleSearch()">
              Search
            </button>
          </div>
        </div>

        <div id="feedback-classes" class="feedback <?php echo $filter_feedback; ?>">Please select one class.</div>

        <div class="subtitle">Filter by play types:</div>

        <div id ="filter">

          <label>
            <input type="checkbox" id="filter_play" name="play1" <?php echo $sticky_filter_constructive ?> value = "constructive">
            Constructive Play<br>
          </label>

          <label>
            <input type="checkbox" id="filter_play" name="play2" <?php echo $sticky_filter_sensory ?> value = "sensory">
            Sensory Play<br>
          </label>

          <label>
            <input type="checkbox" id="filter_play" name="play3" <?php echo $sticky_filter_physical ?> value = "physical">
            Physical Play<br>
          </label>

          <label>
            <input type="checkbox" id="filter_play" name="play4" <?php echo $sticky_filter_imaginative ?> value = "imaginative">
            Imaginative Play<br>
          </label>

          <label>
            <input type="checkbox" id="filter_play" name="play5" <?php echo $sticky_filter_restorative ?> value = "restorative">
            Restorative Play<br>
          </label>

          <label>
           <input type="checkbox" id="filter_play" name="play6" <?php echo $sticky_filter_expressive ?> value = "expressive">
            Expressive Play<br>
          </label>


          <label>
            <input type="checkbox" id="filter_play" name="play7" <?php echo $sticky_filter_rules ?> value = "rules">
            Play with Rules<br>
          </label>

          <label>
            <input type="checkbox" id="filter_play" name="play8" <?php echo $sticky_filter_bio ?> value = "bio">
            Bio Play<br>
          </label>
          <button type="submit" name="submit_filter" id="submit-button">Filter</button>
        </div>
      </form>
    </div>

    <div id="main-content">
    <table>
      <tr>
        <th>
          <a href="/administrator?sort=plant_name&order=<?php echo $order_next_url?>">
          Plant Name

          <!-- Source: https://www.veryicon.com/icons/system/wukon-shopkeeper-business-background/sort-30.html -->
          <img class="icon"  src="/public/img/order.png" width="20" height="20" alt="sort">  </img></a>
        </th>
        <th>Constructive Play</th>
        <th>Sensory Play</th>
        <th>Physical Play</th>
        <th>Imaginative Play</th>
        <th>Restorative Play</th>
        <th>Expressive Play</th>
        <th>Play with Rules</th>
        <th>Bio Play</th>
        <th>
          Edit
        </th>
      </tr>
      <tr>
      <?php
      foreach ($records as $record) { ?>
        <tr>
          <td><?php echo htmlspecialchars($record["plant_name"]); ?></td>
          <td class="text-center"><?php echo htmlspecialchars($record["Constructive_play"]==1?'YES':'NO');?></td>
          <td class="text-center"><?php echo htmlspecialchars($record["Exploratory_Sensory_Play"]==1?'YES':'NO');?></td>
          <td class="text-center"><?php echo htmlspecialchars($record["Physical_Play"]==1?'YES':'NO');?></td>
          <td class="text-center"><?php echo htmlspecialchars($record["Imaginative_Play"]==1?'YES':'NO');?></td>
          <td class="text-center"><?php echo htmlspecialchars($record["Restorative_Play"]==1?'YES':'NO');?></td>
          <td class="text-center"><?php echo htmlspecialchars($record["Expressive_Play"]==1?'YES':'NO');?></td>
          <td class="text-center"><?php echo htmlspecialchars($record["Play_Rules"]==1?'YES':'NO');?></td>
          <td class="text-center"><?php echo htmlspecialchars($record["Bio_Play"]==1?'YES':'NO');?></td>
          <td>
            <form action="/administrator/edit" method="get">
              <input type="hidden" name="plant" value="<?php echo htmlspecialchars($record["plant_name"])?>">
              <!-- Source: https://icons8.com/icons/set/edit -->
              <button class="edit-button" type="submit">
                <img src="/public/img/edit.png" alt="edit">
              </button>
            </form>
          </td>

        </tr>
      <?php } ?>
      </tr>
    </table>
    </div>
    <div id ="add-content">
      <div class="subtitle">Add a plant: <br></div>
      <form class="add-form" action="/administrator" method="POST" enctype="multipart/form-data" novalidate>
        <input type="hidden" name="MAX_FILE_SIZE" value = "<?php echo MAX_FILE_SIZE ?>">
      <div class="feedback <?php echo $add_file_feedback; ?>">
        Please upload a valid file!
      </div>

          <label> Please upload a jpg/jpeg/png file

          <input type="file" name="file">
          </label>


      <div id ="add-box">
        <label>
          <div id="feedback-add" class="feedback <?php echo $add_name_feedback; ?>">Please enter a valid plant name.</div>
          Plant Name: <input type="text" name="plant_name" class="textbox" maxlength="50" value="<?php echo htmlspecialchars($sticky_add_name); ?>"><br>
        </label>
        <label>
          <div class="feedback <?php echo $add_id_feedback; ?>">
          Please enter a valid plant ID.
          </div>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Plant ID:
          <input type="text" name="plant_id" class="textbox" maxlength="50" value="<?php echo htmlspecialchars($sticky_add_id); ?>"><br>
        </label>
        </div>



      <p> Please select the play types that the plants support:</p>
      <div id = "add">
          <div id="feedback-classes" class="feedback <?php echo $add_play_feedback; ?>">Please select at least one play type
      </div>

          <label>
           <input type="checkbox" id="add_play" name="add_play1" <?php echo $sticky_add_constructive ?> value = "constructive">
            Constructive Play
          </label>

          <label>
            <input type="checkbox" id="add_play" name="add_play2" <?php echo $sticky_add_sensory ?> value = "sensory">
            Sensory Play
          </label>

          <label>
            <input type="checkbox" id="add_play" name="add_play3" <?php echo $sticky_add_physical ?> value = "physical">
            Physical Play
          </label>

          <label>
            <input type="checkbox" id="add_play" name="add_play4" <?php echo $sticky_add_imaginative ?> value = "imaginative">
            Imaginative Play <br>
          </label>

          <label>
            <input type="checkbox" id="add_play" name="add_play5" <?php echo $sticky_add_restorative ?> value = "restorative">
            Restorative Play
          </label>

          <label>
            <input type="checkbox" id="add_play" name="add_play6" <?php echo $sticky_add_expressive ?> value = "expressive">
            Expressive Play
          </label>

          <label>
            <input type="checkbox" id="add_play" name="add_play7" <?php echo $sticky_add_rules ?> value = "rules">
            Play with Rules
          </label>

          <label>
           <input type="checkbox" id="add_play" name="add_play8" <?php echo $sticky_add_bio ?> value = "bio">
            Bio Play
          </label>





        <p>Please select the gardening infos of the plant:</p>
        <div id="feedback-classes" class="feedback <?php echo $add_garden_feedback; ?>">Please select at least one garden info
      </div>
        <label>
            <input type="checkbox" id="add_play" name="add_garden1" <?php echo $sticky_garden1 ?> value = "garden1">
            Perennial
        </label>
        <label>
            <input type="checkbox" id="add_play" name="add_garden2" <?php echo $sticky_garden2 ?> value = "garden2">
            Annual
        </label>
        <label>
            <input type="checkbox" id="add_play" name="add_garden3" <?php echo $sticky_garden3 ?> value = "garden3">
            Full Sun
        </label>
        <label>
            <input type="checkbox" id="add_play" name="add_garden4" <?php echo $sticky_garden4 ?> value = "garden4">
            Full shade
        </label>
        <label>
            <input type="checkbox" id="add_play" name="add_garden5" <?php echo $sticky_garden5 ?> value = "garden5">
            Partial Shade
        </label>

        <div class = "align-right">
            <button type="submit" name="add" id="add-button" >Add item</button>
        </div>
      </div>
      </form>
  </div>

  <div class="add_tag">
        <div class="subtitle"> Insert a tag for a plant: <br> </div>
        <form class="add-tag" action="/administrator" method="POST">

        <div class="tag-box">

            <div id="feedback-add" class="feedback <?php echo $insert_name_feedback ?>">Please enter a valid plant name</div>
          <label>
          Plant Name:
          <input type="text" name="insert_name" id="insert_tag" maxlength="50" value="<?php echo htmlspecialchars($sticky_insert_name); ?>"><br>
          </label>

        <div id="feedback-add" class="feedback <?php echo $insert_tag_feedback?>">
          Please enter a valid tag name:
        </div>
        <label>
        Tag Name:

        <input type="text" name="insert_tag" id="insert_tag" maxlength="50" value="<?php echo htmlspecialchars($sticky_insert_tag); ?>">
        </label>

        <div class = "align-right">
            <button type="submit" name="add_tag" id="add-button" >insert tag</button>
        </div>
        </div>
        </div>
      </form>
  </div>
</div>


<?php } else {?>
  <p style="font-size: 100px;">  <center>
   <strong> Something goes wrong with login! Please back to home.</strong></center></p>
  <p><a href="/">Back to home</a></p>
<?php }?>


<?php include("includes/footer.php"); ?>
</body>

</html>
