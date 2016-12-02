<?php
session_start();

// if user is not logged in
if( !$_SESSION['loggedInUser'] ) {
    
    // send them to the login page
    header("Location: index.php");
}

// connect to database
include('includes/connection.php');

// query & result
$query = "SELECT * FROM patients LIMIT 25";
$result = mysqli_query( $conn, $query );

// check for query string
if( isset( $_GET['alert'] ) ) {
    
    // new patient added
    if( $_GET['alert'] == 'success' ) {
        $alertMessage = "<div class='alert alert-success'>New Patient Added! <a class='close' data-dismiss='alert'>&times;</a></div>";
        
    // patient updated
    } elseif( $_GET['alert'] == 'updatesuccess' ) {
        $alertMessage = "<div class='alert alert-success'>Patient Updated! <a class='close' data-dismiss='alert'>&times;</a></div>";
    
    // patient deleted
    } elseif( $_GET['alert'] == 'deleted' ) {
        $alertMessage = "<div class='alert alert-success'>Patient Deleted! <a class='close' data-dismiss='alert'>&times;</a></div>";
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
        <th>ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Age</th>
        <th>Gender</th>
        <th>Contact Number</th>
        <th>Edit</th>
        <th>Add Procedure</th>
    </tr>
    
    <?php
    
    if( mysqli_num_rows($result) > 0 ) {
        
        // we have data!
        // output the data
        
        while( $row = mysqli_fetch_assoc($result) ) {
            echo "<tr>";
            
            echo "<td>" . $row['Patient_ID'] . "</td><td>" . $row['First_Name'] . "</td><td>" . $row['Last_Name'] . "</td><td>" . $row['Age'] . "</td><td>" . $row['Gender'] . "</td><td>" . $row['Contact_Number'] . "</td>";
            
            echo '<td><a href="editpatients.php?Patient_ID=' . $row['Patient_ID'] . '" type="button" class="btn btn-primary btn-sm">
                    <span class="glyphicon glyphicon-edit"></span>
                    </a></td>';
            echo '<td><a href="addprocedure.php?id=' . $row['Procedure_ID'] . '" type="button" class="btn btn-primary btn-sm">
                    <span class="glyphicon glyphicon-plus"></span>

                    </a></td>';
            
            echo "</tr>";
        }
    } else { // if no entries
        echo "<div class='alert alert-warning'>You have no patients!</div>";
    }
    
    mysqli_close($conn);

    ?>

    <tr>
        <td colspan="2"><div class="text-center"><a href="addpatients.php" type="button" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-plus"></span> Add patient</a></div>
        </td>
        <td colspan="2"><div class="text-center"><a href="searchpatients.php" type="button" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-plus"></span> Search patient</a></div>
        </td>  
        <td colspan="2"><div class="text-center"><a href="ascending.php" type="button" class="btn btn-sm btn-success"><span class="glyphicon glyphicon"></span> Ascending</a></div>
        </td>
        <td colspan="2"><div class="text-center"><a href="descending.php" type="button" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-"></span> Descending</a></div>
        </td>
    </tr>
</table>

<?php
include('includes/footer.php');
?>