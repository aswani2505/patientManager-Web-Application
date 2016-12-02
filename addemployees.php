<?php
session_start();

// if user is not logged in
if( !$_SESSION['loggedInUser'] ) {
    
    // send them to the login psalary
    header("Location: index.php");
}

// connect to database
include('includes/connection.php');

// include functions file
include('includes/functions.php');

// if add button was submitted
if( isset( $_POST['add'] ) ) {
    
    // set all variables to empty by default
    $firstName = $lastName = $salary = $contactNumber = "";
    
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
    $salary    = validateFormData( $_POST["salary"] );
    $contactNumber  = validateFormData( $_POST["contactNumber"] );
    
    // if required fields have data
    if( $firstName && $lastName ) {
        
        // create query
        $query = "INSERT INTO employees (Emp_ID, First_Name, Last_Name, Salary, Contact_Number) VALUES (NULL, '$firstName', '$lastName', '$salary', '$contactNumber')";
        
        $result = mysqli_query( $conn, $query );
        
        // if query was successful
        if( $result ) {
            
            // refresh psalary with query string
            header( "Location: employees.php?alert=success" );
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

<h1>Add employee</h1>

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
        <label for="salary">salary</label>
        <input type="text" class="form-control input-lg" id="salary" name="salary" value="">
    </div>
    <div class="form-group col-sm-6">
        <label for="contact-number">Contact Number</label>
        <input type="text" class="form-control input-lg" id="contact-number" name="contactNumber" value="">
    </div>
    <div class="col-sm-12">
            <a href="employees.php" type="button" class="btn btn-lg btn-default">Cancel</a>
            <button type="submit" class="btn btn-lg btn-success pull-right" name="add">Add employee</button>
    </div>
</form>

<?php
include('includes/footer.php');
?>