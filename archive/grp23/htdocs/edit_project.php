<?php
    ob_start();
    session_start();
    if( isset($_SESSION['userName'])!="" ){
        header("Location: home.php");
    }

    include_once 'dbconnect.php';

    $error = false;

    $id = $_GET['id'];
    if($id){
        $query = 'SELECT "title", "category", "startDate", "endDate", "description", "targetAmount", "imageURL" FROM project WHERE "projectID" = '.$id;
        $result = pg_query($query) or die('Query failed: ' . pg_last_error());
        $row = pg_fetch_object($result);
        $projectTitle = $row->title;
        $category = $row->category;
        $startDate = $row->startDate;
        $endDate = $row->endDate;
        $shortBlurb = $row->description;
        $targetAmt = $row->targetAmount;
        $newfilename = $row->imageURL;
    }

    if (isset($_POST['submit']) ) {

        // clean user inputs to prevent sql injections
        $projectTitle = sanitize($_POST['projectTitle']);
        $shortBlurb = sanitize($_POST['shortBlurb']);
        $startDate = sanitizeDate($_POST['startDate']);
        $endDate = sanitizeDate($_POST['endDate']);
        $targetAmt = sanitize($_POST['targetAmt']);
        $category = $_POST['category'];

        if(isset($_FILES['image'])){
            $errors= array();
            $file_name = $_FILES['image']['name'];
            $file_size =$_FILES['image']['size'];
            $file_tmp =$_FILES['image']['tmp_name'];
            $file_type=$_FILES['image']['type'];
            $file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));

            $expensions= array("jpeg","jpg","png");

            if(in_array($file_ext,$expensions)=== false){
                $errors[]="extension not allowed, please choose a JPEG or PNG file.";
            }

            if($file_size > 2097152){
                $errors[]='File size must be excately 2 MB';
            }


            if(empty($errors)==true){
                $temp = end(explode(".", $file_name));
                $newfilename = $projectID . "." . $temp;
            }else{
                print_r($errors);
            }
        }

        // project title validation
        if (empty($projectTitle)) {
            $error = true;
            $projectTitleError = "Please enter your project title.";
        }

        // project description validation
        if (empty($shortBlurb)) {
            $error = true;
            $shortBlurbError = "Please enter your project description.";
        }

        if (empty($startDate)) {
            $error = true;
            $startDateError = "Please enter your project start date.";
        }
        else if (empty($endDate)) {
            $error = true;
            $endDateError = "Please enter your project end date.";
        }
        else if ($endDate < $startDate || $startDate < date("d/m/Y")) {
            $error = true;
            $endDateError = "Please enter a valid date.";
        }
        

        // project description validation
        if (empty($targetAmt)) {
            $error = true;
            $targetAmtError = "Please enter an amount.";
        }
        else if (!preg_match("/^[1-9][0-9]*$/", $targetAmt)) {
            $error = true;
            $targetAmtError = "Please enter a valid amount";
        }

        // if there's no error, continue to signup
        if( !$error ) {
            $query = "UPDATE \"public\".\"project\" SET title = '$projectTitle', category='$category', \"startDate\"='$startDate', \"endDate\"='$endDate', description='$shortBlurb', \"targetAmount\"='$targetAmt', \"imageURL\" = '$newfilename' WHERE \"projectID\" = '$id'";
            
            $res = pg_query($query) or die('Query failed: ' . pg_last_error() . $projectID);

            if ($res) {
                move_uploaded_file($file_tmp,"./image/".$newfilename);
                header('Location: manage_projects.php');
            } else {
                $errMSG = "Something went wrong, please try again."; 
            } 

        }
    }

    function sanitize($data) {
        $data = trim($data);
        $data = strip_tags($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    function sanitizeDate($data) {
        $data = trim($data);
        $data = strip_tags($data, '/');
        return $data;
    }

?>

<!DOCTYPE html>
<html>
    <head>
    </head>
    <body>
        <h1> Edit Project </h1>
        <form method="post" action="<?php echo $_POST['PHP_SELF']; ?>" enctype="multipart/form-data">
            <fieldset>
                Project Image: 
                <input type="file" name="image" value="<?php echo $newfilename;?>"><br><br>

                Project Title:
                <input type="text" name="projectTitle" value="<?php echo $projectTitle;?>"><span style="color:red";><?php echo $projectTitleError;?></span><br><br>

                Short Blurb:
                <input type="text" name="shortBlurb" value="<?php echo $shortBlurb;?>"><span style="color:red";><?php echo $shortBlurbError;?></span><br><br>

                Category: 
                <select name="category">
                <?php
                    echo "<option name = 'dropdown' value=\"".$category."\">".$category."</option>";
                ?>
                    <option name="dropdown" value="Art">Art</option>
                    <option name="dropdown" value="Comic">Comic</option>
                    <option name="dropdown" value="Crafts">Crafts</option>
                    <option name="dropdown" value="Dance">Dance</option>
                    <option name="dropdown" value="Design">Design</option>
                    <option name="dropdown" value="Fashion">Fashion</option>
                    <option name="dropdown" value="Film&Video">Film and Video</option>
                    <option name="dropdown" value="Food">Food</option>
                    <option name="dropdown" value="Games">Games</option>
                    <option name="dropdown" value="Journalism">Journalism</option>
                    <option name="dropdown" value="Music">Music</option>
                    <option name="dropdown" value="Photography">Photography</option>
                    <option name="dropdown" value="Publishing">Publishing</option>
                    <option name="dropdown" value="Technology">Technology</option>
                    <option name="dropdown" value="Theather">Theather</option>
                </select><br><br>

                Project Start Date: <input type="date" name="startDate" value="<?php echo $startDate;?>"><span style="color:red";><?php echo $startDateError;?></span><br><br>

                Project End Date: <input type="date" name="endDate" value="<?php echo $endDate;?>"><span style="color:red";><?php echo $endDateError;?></span><br><br>

                Targeted Amount: <input type="text" name="targetAmt" value="<?php echo $targetAmt;?>"><span style="color:red";><?php echo $targetAmtError;?></span><br><br>

                <input type="submit" name="submit" value="Submit"><span style="color:red";><?php echo $errMSG;?></span><br>
            </fieldset>    

        </form>

    </body>
</html>