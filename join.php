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

// close the mysql connection
mysqli_close($conn);


include('includes/header.php');
?>

<h1>Join</h1>

<form action="displayjoin.php" method="get" class="row">
    
    <div class="form-group col-sm-6">
        <label for="department-name">Department Name *</label>
        <input type="text" class="form-control input-lg" id="department-name" name="departmentName" value="">
    </div>
    <div class="col-sm-12">
            <a href="patients.php" type="button" class="btn btn-lg btn-default">Cancel</a>
            <button type="submit" class="btn btn-lg btn-success pull-right" name="search" value="success">Join</button>
    </div>
</form>

<?php
include('includes/footer.php');
?>