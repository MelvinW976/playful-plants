
<?php
$title = 'Edit - Playful Plant';


$edit_successfull= False;
$record = NULL;
$delete_seccessfull=false;

$add_name_feedback = 'hidden';
$add_play_feedback = 'hidden';
$add_id_feedback = 'hidden';
$add_garden_feedback = 'hidden';

$sticky_add_name = '';
$sticky_add_id = '';
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


$edit_id = $_POST['edit_id']??NULL;

$plant = $_GET['plant'] ?? NULL;

if($edit_id){
    $records = exec_sql_query(
        $db,
        "SELECT * FROM plants WHERE (id=:id)",
        array(
            ':id' => $edit_id
        )
    )->fetchAll();

    if(count($records)>0){
        $record=$records[0];
    }
} else if($plant){
    $plant = trim($plant);
    $records = exec_sql_query(
        $db,
        "SELECT * FROM plants WHERE (plant_name=:plant_name)",
        array(
            ':plant_name' => $plant
        )
    )->fetchAll();

    if(count($records)>0){
        $record=$records[0];
    }
}



if($record){
    $id=$record['id'];
    $plant_name = $record['plant_name'];
    $plant_id = $record['plant_id'];
    $add_play1= $record['Constructive_play'];
    $add_play2= $record['Exploratory_Sensory_Play'];
    $add_play3= $record['Physical_Play'];
    $add_play4= $record['Imaginative_Play'];
    $add_play5= $record['Restorative_Play'];
    $add_play6= $record['Expressive_Play'];
    $add_play7= $record['Play_Rules'];
    $add_play8= $record['Bio_Play'];
    $garden1  = $record['Perennial'];
    $garden2  = $record['Annual'];
    $garden3  = $record['Full_sun'];
    $garden4  = $record['Partial_shade'];
    $garden5  = $record['Full_shade'];

    $sticky_add_name = $plant_name;
    $sticky_add_id= $plant_id;

    $sticky_add_constructive = ($add_play1 == 1 ? "checked" : '');
    $sticky_add_sensory = ($add_play2 == 1 ? "checked" : '');
    $sticky_add_physical = ($add_play3 == 1 ? "checked" : '');
    $sticky_add_imaginative = ($add_play4 == 1 ? "checked" : '');
    $sticky_add_restorative = ($add_play5 == 1 ? "checked" : '');
    $sticky_add_expressive = ($add_play6 == 1 ? "checked" : '');
    $sticky_add_rules = ($add_play7 == 1 ? "checked" : '');
    $sticky_add_bio = ($add_play8 == 1 ? "checked" : '');
    $sticky_garden1 = ($garden1 == 1 ? "checked" : '');
    $sticky_garden2 = ($garden2 == 1 ? "checked" : '');
    $sticky_garden3 = ($garden3 == 1 ? "checked" : '');
    $sticky_garden4 = ($garden4 == 1 ? "checked" : '');
    $sticky_garden5 = ($garden5 == 1 ? "checked" : '');

    if($edit_id){
        $form_valid=true;
        $add_name = trim($_POST['add_name']);
        $add_id = trim($_POST['plant_id']);
        $add_play1 = $_POST['add_play1'] == 'constructive' ? 1 : 0;
        $add_play2 = $_POST['add_play2'] == 'sensory' ? 1 : 0;
        $add_play3 = $_POST['add_play3'] == 'physical' ? 1 : 0;
        $add_play4 = $_POST['add_play4'] == 'imaginative' ? 1 : 0;
        $add_play5 = $_POST['add_play5'] == 'restorative' ? 1 : 0;
        $add_play6 = $_POST['add_play6'] == 'expressive' ? 1 : 0;
        $add_play7 = $_POST['add_play7'] == 'rules' ? 1 : 0;
        $add_play8 = $_POST['add_play8'] == 'bio' ? 1 : 0;
        $garden1 = $_POST['add_garden1'] == 'garden1' ? 1 : 0;
        $garden2 = $_POST['add_garden2'] == 'garden2' ? 1 : 0;
        $garden3 = $_POST['add_garden3'] == 'garden3' ? 1 : 0;
        $garden4 = $_POST['add_garden4'] == 'garden4' ? 1 : 0;
        $garden5 = $_POST['add_garden5'] == 'garden5' ? 1 : 0;

        if(empty($add_name)){
            $form_valid=false;
            $add_name_feedback='';
        }
        if(empty($add_id)){
            $form_valid=false;
            $add_id_feedback='';
        }
        if(empty($add_play1)&&empty($add_play2)&&empty($add_play3)&&empty($add_play4)&&empty($add_play5)&&empty($add_play6)&&empty($add_play7)&&empty($add_play8)){
            $form_valid=false;
            $add_play_feedback='';
        }
        if(empty($garden1)&&empty($garden2)&&empty($garden3)&&empty($garden4)&&empty($garden5)){
            $form_valid=false;
            $add_garden_feedback='';
        }

        if($form_valid){
            $result = exec_sql_query(
                $db,
                "UPDATE plants SET
                plant_name = :name,
                plant_id = :plant_id,
                Constructive_play = :play1,
                Exploratory_Sensory_Play= :play2,
                Physical_Play= :play3,
                Imaginative_Play= :play4,
                Restorative_Play= :play5,
                Expressive_Play= :play6,
                Play_Rules= :play7,
                Bio_Play= :play8,
                Perennial= :garden1,
                Annual= :garden2,
                Full_sun= :garden3,
                Partial_shade= :garden4,
                Full_shade=:garden5
                WHERE (id=:id)",
                array(
                    'id' => $id,
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
                  ':garden5' => $garden5
                )
            );
            if($result){
                $edit_successfull=true;
            }
        }else{
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
    }
}

if(isset($_POST['delete'])){
    $delete_1 = exec_sql_query(
        $db,
        "DELETE FROM plants WHERE (id=:id)",
        array(
            ':id' => $id
        )
    );
    $delete_2 = exec_sql_query(
        $db,
        "DELETE FROM tags_plants WHERE (plant_id=:id)",
        array(
            ':id' => $id
        )

    );
    $path='/public/uploads/plants'.$record['id'] . '.' . $record['file_ext'];
    unlink($path);
    if($delete_1 && $delete_2){
        $delete_seccessfull=true;
        $edit_successfull=false;
    }

}


?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/public/styles/all.css"     @media print {
         p.bodyText {font-family:georgia, times, serif;}
      } />
    <title><?php echo $title; ?></title>
</head>
<body>
<?php include("includes/header.php") ?>

<div id ="edit-content">
      <div class="subtitle">Edit a plant: <br></div>
      <form class="edit-form" action="/administrator/edit" method="POST">

      <?php if($edit_successfull) { ?>
            <p>You have successfully edit the plant!</p>
        <?php }else if($delete_seccessfull) { ?>
            <p>You have successfully delete the plant!</p>
            <?php } ?>
      <div id ="edit-box">
        <label>
          <div id="feedback-add" class="feedback <?php echo $add_name_feedback; ?>">Please enter a valid plant name.</div>
          Plant Name: <input type="text" name="add_name" class="textbox" maxlength="50" value="<?php echo htmlspecialchars($sticky_add_name); ?>"><br>
        </label>
        <label>
            <div class="feedback <?php echo $add_id_feedback; ?>">
            Please enter a valid plant ID.
            </div>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Plant ID:
            <input type="text" name="plant_id" class="textbox" maxlength="50" value="<?php echo htmlspecialchars($sticky_add_id); ?>"><br>
        </label>

      </div>
      <div id = "add">
        <div id="feedback-classes" class="feedback <?php echo $add_play_feedback; ?>">Please select at least one play type
      </div>

      <p> Please select the play types that the plants support:</p>

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
        <input type="hidden" name="edit_id" value="<?php echo htmlspecialchars($id) ?>">

        <div class = "align-right">
            <button type="submit" id="edit-button" name="edit" >Edit item</button>
        </div>
        <div class = "align-right">
            <button type="submit" id="delete-button"  name="delete">Delete item</button>
        </div>
      </div>
   </form>
  </div>
  <p><a href="/administrator">Back to administrator page</a></p>


</body>
</html>
