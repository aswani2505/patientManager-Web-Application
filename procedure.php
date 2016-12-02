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
$query = "SELECT * FROM undergoes LIMIT 25";
$result = mysqli_query( $conn, $query );

// check for query string
if( isset( $_GET['alert'] ) ) {
    
    // new patient added
    if( $_GET['alert'] == 'success' ) {
        $alertMessage = "<div class='alert alert-success'>New Procedure Added! <a class='close' data-dismiss='alert'>&times;</a></div>";
        
    // patient updated
    } elseif( $_GET['alert'] == 'updatesuccess' ) {
        $alertMessage = "<div class='alert alert-success'>Procedure Updated! <a class='close' data-dismiss='alert'>&times;</a></div>";
    
    // patient deleted
    } elseif( $_GET['alert'] == 'deleted' ) {
        $alertMessage = "<div class='alert alert-success'>Procedure Deleted! <a class='close' data-dismiss='alert'>&times;</a></div>";
    }      
}

// close the mysql connection
mysqli_close($conn);

include('includes/header.php');
?>

<h1>Procedure List</h1>

<?php echo $alertMessage; ?>

<table class="table table-striped table-bordered">
    
    <tr>
        <th>Patient ID</th>
        <th>Procedure Name</th>
        <th>Date</th>
        <th>Time</th>
        <th>Edit</th>
        
    </tr>
    
    <?php
    
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
        <td colspan="4"><div class="text-center"><a href="addprocedures.php" type="button" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-plus"></span> Add procedure</a></div>
        </td>
        <td colspan="4"><div class="text-center"><a href="searchprocedures.php" type="button" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-plus"></span> Search procedure</a></div>
        </td>  
    </tr>
</table>

<?php
include('includes/footer.php');
?>