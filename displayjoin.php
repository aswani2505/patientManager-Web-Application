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

// if search button was submitted
if( isset( $_GET['search'] ) ) {
    
    $deparmentName = "";
    $departmentName = validateFormData( $_GET['departmentName'])
    
    // if required fields have data
    if( $departmentName ) {
        $query = "SELECT * FROM doctors";        
        $result = mysqli_query( $conn, $query );
    }    
}

// close the mysql connection
mysqli_close($conn);


include('includes/header.php');
?>

<h1>Join</h1>

<?php echo $alertMessdate; ?>

<table class="table table-striped table-bordered">
    
    <tr>
        <th>Employee ID</th>
        <th>Speciality</th>
    </tr>
    
    <?php

      // if query was successful
        if( mysqli_num_rows($result) > 0 ) {
        
        // we have data!
        // output the data
        
        while( $row = mysqli_fetch_assoc($result) ) {
            echo "<tr>";
            
            echo "<td>" . $row['Emp_ID'] . "</td><td>" . $row['Speciality'] . "</td>";
            
            echo "</tr>";
        }
    } else { // if no entries
        echo "<div class='alert alert-warning'>You have no output!</div>";
    }
     mysqli_close($conn);

    ?>
</table>

<?php
include('includes/footer.php');
?>
    