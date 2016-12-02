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

<h1>Search procedure</h1>

<form action="displayprocedure.php" method="get" class="row">
    <div class="form-group col-sm-6">
        <label for="patient-id">Patient ID *</label>
        <input type="text" class="form-control input-lg" id="patient-id" name="patientID" value="">
    </div>
    <div class="form-group col-sm-6">
        <label for="procedure-name">Procedure Name</label>
        <input type="text" class="form-control input-lg" id="procedure-name" name="procedureName" value="">
    </div>
<!--
    </div>
    <div class="form-group col-sm-6">
        <label for="date">Date</label>
        <input type="text" class="form-control input-lg" id="date" name="date" value="">
    </div>
    <div class="form-group col-sm-6">
        <label for="time">Time</label>
        <input type="text" class="form-control input-lg" id="time" name="time" value="">
    </div>
-->
    <div class="col-sm-12">
            <a href="procedure.php" type="button" class="btn btn-lg btn-default">Cancel</a>
            <button type="submit" class="btn btn-lg btn-success pull-right" name="search">Search patient</button>
    </div>
</form>

<?php
include('includes/footer.php');
?>