<?php
session_start();

// if user is not logged in
if( !$_SESSION['loggedInUser'] ) {
    
    // send them to the login pdate
    header("Location: index.php");
}

// connect to database
include('includes/connection.php');

// include functions file
include('includes/functions.php');

// if add button was submitted
if( isset( $_POST['add'] ) ) {
    
    // set all variables to empty by default
   $patientID = $procedureName = $date = $time = "";
    
    // check to see if inputs are empty
    // create variables with form data
    // wrap the data with our function
    
    if( !$_POST["patientID"] ) {
        $idError = "Please enter the patient id <br>";
    } else {
        $patientID = validateFormData( $_POST["patientID"] );
    }

    if( !$_POST["procedureName"] ) {
        $procedureNameError = "Please enter the procedure <br>";
    } else {
        $procedureName = validateFormData( $_POST["procedureName"] );
    }
    
    $date = validateFormData( $_POST["date"] );
    $time = validateFormData( $_POST["time"] );
   
    
    // if required fields have data
    if( $patientID && $procedureName ) {
        
        // create query
        $query = "INSERT INTO undergoes (Patient_ID, Procedure_Name, Date, Time) VALUES ('$patientID', '$procedureName', '$date', '$time')";
        
        
        $result = mysqli_query( $conn, $query );
        

        
        // if query was successful
        if( $result ) {
            
            // refresh pdate with query string
            header( "Location: procedure.php?alert=success" );
        } else {
            
            // something went wrong
            echo "Error: ". $query ."<br>" . mysqli_error($conn);
        }
        
    }
    
}

// close the mysql connection
mysqli_close($conn);


include('includes/header.php');
?>

<h1>Add procedure</h1>

<form action="<?php echo htmlspecialchars( $_SERVER['PHP_SELF'] ); ?>" method="post" class="row">
    <div class="form-group col-sm-6">
        <label for="patient-id">Patient ID *</label>
        <input type="text" class="form-control input-lg" id="patient-id" name="patientID" value="">
    </div>
    <div class="form-group col-sm-6">
        <label for="procedure-name">Procedure Name *</label>
        <input type="text" class="form-control input-lg" id="procedure-name" name="procedureName" value="">
    </div>
    <div class="form-group col-sm-6">
        <label for="date">date</label>
        <input type="date" class="form-control input-lg" id="date" name="date" value="">
    </div>
    <div class="form-group col-sm-6">
        <label for="time">time</label>
        <input type="time" class="form-control input-lg" id="time" name="time" value="">
    </div>
    <div class="col-sm-12">
            <a href="procedure.php" type="button" class="btn btn-lg btn-default">Cancel</a>
            <button type="submit" class="btn btn-lg btn-success pull-right" name="add">Add procedure</button>
    </div>
</form>

<?php
include('includes/footer.php');
?>