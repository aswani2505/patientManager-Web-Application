<?php
session_start();

// if user is not logged in
if( !$_SESSION['loggedInUser'] ) {
    
    // send them to the login pdate
    header("Location: index.php");
}

// get ID sent by GET collection
$patientID = $_GET['Patient_ID'];

// connect to database
include('includes/connection.php');

// include functions file
include('includes/functions.php');

// query the database with patient ID
$query = "SELECT * FROM undergoes WHERE Patient_ID='$patientID'";
$result = mysqli_query( $conn, $query );

// if result is returned
if( mysqli_num_rows($result) > 0 ) {
    
    // we have data!
    // set some variables
    while( $row = mysqli_fetch_assoc($result) ) {
        $patientID      = $row['Patient_ID'];
        $procedureName       = $row['Procedure_Name'];
        $date            = $row['Date'];
        $time         = $row['Time'];
    }
} else { // no results returned
    $alertMessdate = "<div class='alert alert-warning'>Nothing to see here. <a href='procedure.php'>Head back</a>.</div>";
}

// if update button was submitted
if( isset($_POST['update']) ) {
    
    // set variables
    $patientID      = validateFormData( $_POST["patientID"] );
    $procedureName       = validateFormData( $_POST["procedureName"] );
    $date            = validateFormData( $_POST["date"] );
    $time         = validateFormData( $_POST["time"] );
    
    
    
    // new database query & result
    $query = "UPDATE undergoes
            SET Patient_ID='$patientID',
            Procedure_Name='$procedureName',
            Date='$date',
            Time='$time'
            WHERE Patient_ID='$patientID'";
    
    $result = mysqli_query( $conn, $query );
    
    if( $result ) {
        
        // redirect to patient pdate with query string
        header("Location: procedure.php?alert=updatesuccess");
    } else {
        echo "Error updating record: " . mysqli_error($conn); 
    }
}

// if delete button was submitted
if( isset($_POST['delete']) ) {
    
    $alertMessdate = "<div class='alert alert-danger'>
                        <p>Are you sure you want to delete this patient? No take backs!</p><br>
                        <form action='". htmlspecialchars( $_SERVER["PHP_SELF"] ) ."?Patient_ID=$patientID' method='post'>
                            <input type='submit' class='btn btn-danger btn-sm' name='confirm-delete' value='Yes, delete!'>
                            <a type='button' class='btn btn-default btn-sm' data-dismiss='alert'>Oops, no thanks!</a>
                        </form>
                    </div>";
    
}

// if confirm delete button was submitted
if( isset($_POST['confirm-delete']) ) {
    
    // new database query & result
    $query = "DELETE FROM patients WHERE Patient_ID='$patientID'";
    $result = mysqli_query( $conn, $query );
    
    if( $result ) {
        
        // redirect to patient pdate with query string
        header("Location: procedure.php?alert=deleted");
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
    
}

// close the mysql connection
mysqli_close($conn);

include('includes/header.php');
?>

<h1>Edit procedure</h1>

<?php echo $alertMessdate; ?>

<form action="<?php echo htmlspecialchars( $_SERVER['PHP_SELF'] ); ?>?Patient_ID=<?php echo $patientID; ?>" method="post" class="row">
    <div class="form-group col-sm-6">
        <label for="patient-id">Patient ID</label>
        <input type="text" class="form-control input-lg" id="patient-id" name="patientID" value="<?php echo $patientID; ?>">
    </div>
    <div class="form-group col-sm-6">
        <label for="procedure-name">Procedure Name</label>
        <input type="text" class="form-control input-lg" id="procdure-name" name="procedureName" value="<?php echo $procedureName; ?>">
    </div>
    <div class="form-group col-sm-6">
        <label for="date">date</label>
        <input type="date" class="form-control input-lg" id="date" name="date" value="<?php echo $date; ?>">
    </div>
    <div class="form-group col-sm-6">
        <label for="time">time</label>
        <input type="time" class="form-control input-lg" id="time" name="time" value="<?php echo $time; ?>">
    </div>
    <div class="col-sm-12">
        <hr>
        <button type="submit" class="btn btn-lg btn-danger pull-left" name="delete">Delete</button>
        <div class="pull-right">
            <a href="procedure.php" type="button" class="btn btn-lg btn-default">Cancel</a>
            <button type="submit" class="btn btn-lg btn-success" name="update">Update</button>
        </div>
    </div>
</form>

<?php
include('includes/footer.php');
?>