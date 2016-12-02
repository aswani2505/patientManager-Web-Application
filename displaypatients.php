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

// if search button was submitted
if( isset( $_POST['search'] ) ) {
    
    // set all variables to empty by default
    $firstName = $lastName = $age = $gender = $contactNumber = "";
    
    // check to see if inputs are empty
    // create variables with form data
    // wrap the data with our function
    //we'll just store whatever has been entered
    $firstName = validateFormData( $_POST["firstName"] );
    $lastName = validateFormData( $_POST["lastName"] );
    $age    = validateFormData( $_POST["age"] );
    $gender  = validateFormData( $_POST["gender"] );
    $contactNumber  = validateFormData( $_POST["contactNumber"] );
   
    
    // if required fields have data
    if( $firstName || $lastName || $age || $gender || $contactNumber ) {
        
        // create query
        $query = "SELECT * FROM patients WHERE First_Name LIKE '%".$firstName."%'AND Last_Name LIKE '%".$lastName."%' AND Age LIKE '%".$age."%' AND Gender LIKE '%".$gender."%' AND Contact_Number LIKE '%".$contactNumber."%'";
        
        $result = mysqli_query( $conn, $query );
    }    
}

// close the mysql connection
mysqli_close($conn);


include('includes/header.php');
?>

<h1>Patient List</h1>

<?php echo $alertMessage; ?>

<table class="table table-striped table-bordered">
    
    <tr>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Age</th>
        <th>Gender</th>
        <th>Contact Number</th>
        <th>Edit</th>
    </tr>
    
    <?php

      // if query was successful
        if( mysqli_num_rows($result) > 0 ) {
        
        // we have data!
        // output the data
        
        while( $row = mysqli_fetch_assoc($result) ) {
            echo "<tr>";
            
            echo "<td>" . $row['First_Name'] . "</td><td>" . $row['Last_Name'] . "</td><td>" . $row['Age'] . "</td><td>" . $row['Gender'] . "</td><td>" . $row['Contact_Number'] . "</td>";
            
            echo '<td><a href="editpatients.php?Patient_ID=' . $row['Patient_ID'] . '" type="button" class="btn btn-primary btn-sm">
                    <span class="glyphicon glyphicon-edit"></span>
                    </a></td>';
            
            echo "</tr>";
        }
    } else { // if no entries
        echo "<div class='alert alert-warning'>You have no patients!</div>";
    }
     mysqli_close($conn);

    ?>

    <tr>
        <td colspan="3"><div class="text-center"><a href="addpatients.php" type="button" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-plus"></span> Add patient</a></div>
        </td>
        <td colspan="4"><div class="text-center"><a href="searchpatients.php" type="button" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-plus"></span> Search patient</a></div>
        </td>  
    </tr>
</table>

<?php
include('includes/footer.php');
?>
    