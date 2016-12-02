<?php
session_start();

// if user is not logged in
if( !$_SESSION['loggedInUser'] ) {
    
    // send them to the login page
    header("Location: index.php");
}

// get ID sent by GET collection
$patientID = $_GET['Patient_ID'];

// connect to database
include('includes/connection.php');

// include functions file
include('includes/functions.php');

// query the database with patient ID
$query = "SELECT * FROM patients WHERE Patient_ID='$patientID'";
$result = mysqli_query( $conn, $query );

// if result is returned
if( mysqli_num_rows($result) > 0 ) {
    
    // we have data!
    // set some variables
    while( $row = mysqli_fetch_assoc($result) ) {
        $firstName      = $row['First_Name'];
        $lastName       = $row['Last_Name'];
        $age            = $row['Age'];
        $gender         = $row['Gender'];
        $contactNumber  = $row['Contact_Number'];
    }
} else { // no results returned
    $alertMessage = "<div class='alert alert-warning'>Nothing to see here. <a href='patients.php'>Head back</a>.</div>";
}

// if update button was submitted
if( isset($_POST['update']) ) {
    
    // set variables
    $firstName      = validateFormData( $_POST["firstName"] );
    $lastName       = validateFormData( $_POST["lastName"] );
    $age            = validateFormData( $_POST["age"] );
    $gender         = validateFormData( $_POST["gender"] );
    $contactNumber  = validateFormData( $_POST["contactNumber"] );
    
    
    // new database query & result
    $query = "UPDATE patients
            SET First_Name='$firstName',
            Last_Name='$lastName',
            Age='$age',
            Gender='$gender',
            Contact_Number='$contactNumber'
            WHERE Patient_ID='$patientID'";
    
    $result = mysqli_query( $conn, $query );
    
    if( $result ) {
        
        // redirect to patient page with query string
        header("Location: patients.php?alert=updatesuccess");
    } else {
        echo "Error updating record: " . mysqli_error($conn); 
    }
}

// if delete button was submitted
if( isset($_POST['delete']) ) {
    
    $alertMessage = "<div class='alert alert-danger'>
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
        
        // redirect to patient page with query string
        header("Location: patients.php?alert=deleted");
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
    
}

// close the mysql connection
mysqli_close($conn);

include('includes/header.php');
?>

<h1>Edit patient</h1>

<?php echo $alertMessage; ?>

<form action="<?php echo htmlspecialchars( $_SERVER['PHP_SELF'] ); ?>?Patient_ID=<?php echo $patientID; ?>" method="post" class="row">
    <div class="form-group col-sm-6">
        <label for="first-name">First Name</label>
        <input type="text" class="form-control input-lg" id="first-name" name="firstName" value="<?php echo $firstName; ?>">
    </div>
    <div class="form-group col-sm-6">
        <label for="last-name">Last Name</label>
        <input type="text" class="form-control input-lg" id="last-name" name="lastName" value="<?php echo $lastName; ?>">
    </div>
    <div class="form-group col-sm-6">
        <label for="age">Age</label>
        <input type="text" class="form-control input-lg" id="age" name="age" value="<?php echo $age; ?>">
    </div>
    <div class="form-group col-sm-6">
        <label for="gender">Gender</label>
        <input type="text" class="form-control input-lg" id="gender" name="gender" value="<?php echo $gender; ?>">
    </div>
    <div class="form-group col-sm-6">
        <label for="contact-number">Contact Number</label>
        <input type="text" class="form-control input-lg" id="contact-number" name="contactNumber" value="<?php echo $contactNumber; ?>">
    </div>
    <div class="col-sm-12">
        <hr>
        <button type="submit" class="btn btn-lg btn-danger pull-left" name="delete">Delete</button>
        <div class="pull-right">
            <a href="patients.php" type="button" class="btn btn-lg btn-default">Cancel</a>
            <button type="submit" class="btn btn-lg btn-success" name="update">Update</button>
        </div>
    </div>
</form>

<?php
include('includes/footer.php');
?>