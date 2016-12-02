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
    
    // set all variables to empty by default
    $patientID = $procedureName = $date = $time = "";
    
    // check to see if inputs are empty
    // create variables with form data
    // wrap the data with our function
    //we'll just store whatever has been entered
    $patientID = validateFormData( $_GET["patientID"] );
    $procedureName = validateFormData( $_GET["procedureName"] );
//    $date    = validateFormData( $_GET["date"] );
//    $time  = validateFormData( $_GET["time"] );
    
//   $query = "SELECT * FROM Undergoes";
//    $result = mysqli_query( $conn, $query );
//    
    // if required fields have data
    if( $patientID)  {
        
        // create query
       $query = "SELECT * FROM Undergoes WHERE Patient_ID = $patientID" ;
    }elseif($procedureName){
        $query = "SELECT * FROM Undergoes WHERE Procedure_Name LIKE '%".$procedureName."%'";
    }
    
        
        
        $result = mysqli_query( $conn, $query );
       
}

// close the mysql connection
mysqli_close($conn);


include('includes/header.php');
?>

<h1>Procedure List</h1>

<?php echo $alertMessdate; ?>

<table class="table table-striped table-bordered">
    
    <tr>
        <th>Patient ID</th>
        <th>Procedure Name</th>
        <th>Date</th>
        <th>Time</th>
        <th>Edit</th>
    </tr>
    
    <?php

      // if query was successful
        if( mysqli_num_rows($result) > 0 ) {
        
        // we have data!
        // output the data
        
        while( $row = mysqli_fetch_assoc($result) ) {
            echo "<tr>";
            
            echo "<td>" . $row['Patient_ID'] . "</td><td>" . $row['Procedure_Name'] . "</td><td>" . $row['Date'] . "</td><td>" . $row['Time'] . "</td>";
            
            echo '<td><a href="editprocedures.php?Patient_ID=' . $row['Patient_ID'] . '" type="button" class="btn btn-primary btn-sm">
                    <span class="glyphicon glyphicon-edit"></span>
                    </a></td>';
            
            echo "</tr>";
        }
    } else { // if no entries
        echo "<div class='alert alert-warning'>You have no procedures!</div>";
    }
     mysqli_close($conn);

    ?>

    <tr>
        <td colspan="3"><div class="text-center"><a href="addprocedures.php" type="button" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-plus"></span> Add procedure</a></div>
        </td>
        <td colspan="4"><div class="text-center"><a href="searchprocedures.php" type="button" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-plus"></span> Search procedure</a></div>
        </td>  
    </tr>
</table>

<?php
include('includes/footer.php');
?>
    