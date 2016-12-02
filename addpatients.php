<?php
session_start();

// if user is not logged in
if( !$_SESSION['loggedInUser'] ) {
    
    // send them to the login page
    header("Location: index.php");
}

// connect to database
include('includes/connection.php');

// include functions file
include('includes/functions.php');

// if add button was submitted
if( isset( $_POST['add'] ) ) {
    
    // set all variables to empty by default
    $firstName = $lastName = $age = $gender = $contactNumber = "";
    
    // check to see if inputs are empty
    // create variables with form data
    // wrap the data with our function
    
    if( !$_POST["firstName"] ) {
        $firstNameError = "Please enter a first name <br>";
    } else {
        $firstName = validateFormData( $_POST["firstName"] );
    }

    if( !$_POST["lastName"] ) {
        $lastNameError = "Please enter an last name <br>";
    } else {
        $lastName = validateFormData( $_POST["lastName"] );
    }
    
    // these inputs are not required
    // so we'll just store whatever has been entered
    $age    = validateFormData( $_POST["age"] );
    $gender  = validateFormData( $_POST["gender"] );
    $contactNumber  = validateFormData( $_POST["contactNumber"] );
    
    // if required fields have data
    if( $firstName && $lastName ) {
        
        // create query
        $query = "INSERT INTO patients (Patient_ID, First_Name, Last_Name, Age, Gender, Contact_Number) VALUES (NULL, '$firstName', '$lastName', '$age', '$gender', '$contactNumber')";
        
        $result = mysqli_query( $conn, $query );
        
        // if query was successful
        if( $result ) {
            
            // refresh page with query string
            header( "Location: patients.php?alert=success" );
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

<h1>Add patient</h1>

<form action="<?php echo htmlspecialchars( $_SERVER['PHP_SELF'] ); ?>" method="post" class="row">
    <div class="form-group col-sm-6">
        <label for="first-name">First Name *</label>
        <input type="text" class="form-control input-lg" id="first-name" name="firstName" value="">
    </div>
    <div class="form-group col-sm-6">
        <label for="last-name">Last Name *</label>
        <input type="text" class="form-control input-lg" id="last-name" name="lastName" value="">
    </div>
    <div class="form-group col-sm-6">
        <label for="age">Age</label>
        <input type="text" class="form-control input-lg" id="age" name="age" value="">
    </div>
    <div class="form-group col-sm-6">
        <label for="gender">Gender</label>
        <input type="text" class="form-control input-lg" id="gender" name="gender" value="">
    </div>
    <div class="form-group col-sm-6">
        <label for="contact-number">Contact Number</label>
        <input type="text" class="form-control input-lg" id="contact-number" name="contactNumber" value="">
    </div>
    <div class="col-sm-12">
            <a href="patients.php" type="button" class="btn btn-lg btn-default">Cancel</a>
            <button type="submit" class="btn btn-lg btn-success pull-right" name="add">Add patient</button>
    </div>
</form>

<?php
include('includes/footer.php');
?>