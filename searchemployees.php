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

// close the mysql connection
mysqli_close($conn);


include('includes/header.php');
?>

<h1>Search employee</h1>

<form action="displayemployees.php" method="post" class="row">
    <div class="form-group col-sm-6">
        <label for="first-name">First Name *</label>
        <input type="text" class="form-control input-lg" id="first-name" name="firstName" value="">
    </div>
    <div class="form-group col-sm-6">
        <label for="last-name">Last Name</label>
        <input type="text" class="form-control input-lg" id="last-name" name="lastNamel" value="">
    </div>
    <div class="form-group col-sm-6">
        <label for="salary">Salary</label>
        <input type="text" class="form-control input-lg" id="salary" name="salary" value="">
    </div>
    <div class="form-group col-sm-6">
        <label for="contact-number">Contact Number</label>
        <input type="text" class="form-control input-lg" id="contact-number" name="contactNumber" value="">
    </div>
    <div class="col-sm-12">
            <a href="employees.php" type="button" class="btn btn-lg btn-default">Cancel</a>
            <button type="submit" class="btn btn-lg btn-success pull-right" name="search">Search employee</button>
    </div>
</form>

<?php
include('includes/footer.php');
?>