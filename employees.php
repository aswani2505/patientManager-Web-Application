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
$query = "SELECT * FROM Employees LIMIT 25";
$result = mysqli_query( $conn, $query );

// check for query string
if( isset( $_GET['alert'] ) ) {
    
    // new patient added
    if( $_GET['alert'] == 'success' ) {
        $alertMessage = "<div class='alert alert-success'>New Employeee Added! <a class='close' data-dismiss='alert'>&times;</a></div>";
        
    // patient updated
    } elseif( $_GET['alert'] == 'updatesuccess' ) {
        $alertMessage = "<div class='alert alert-success'>Employee Updated! <a class='close' data-dismiss='alert'>&times;</a></div>";
    
    // patient deleted
    } elseif( $_GET['alert'] == 'deleted' ) {
        $alertMessage = "<div class='alert alert-success'>Employee Deleted! <a class='close' data-dismiss='alert'>&times;</a></div>";
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
        <th>Employee ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Salary</th>
        <th>Contact Number</th>
        <th>Edit</th>
    </tr>
    
    <?php
    
    if( mysqli_num_rows($result) > 0 ) {
        
        // we have data!
        // output the data
        
        while( $row = mysqli_fetch_assoc($result) ) {
            echo "<tr>";
            
            echo "<td>" . $row['Emp_ID'] . "</td><td>" . $row['First_Name'] . "</td><td>" . $row['Last_Name'] . "</td><td>" . $row['Salary'] . "</td><td>" . $row['Contact_Number'] . "</td>";
            
            echo '<td><a href="editemployees.php?Employee_ID=' . $row['Emp_ID'] . '" type="button" class="btn btn-primary btn-sm">
                    <span class="glyphicon glyphicon-edit"></span>
                    </a></td>';
            
            echo "</tr>";
        }
    } else { // if no entries
        echo "<div class='alert alert-warning'>You have no employees!</div>";
    }
    
    mysqli_close($conn);

    ?>

    <tr>
        <td colspan="4"><div class="text-center"><a href="addemployee.php" type="button" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-plus"></span> Add employee</a></div>
        </td>
        <td colspan="4"><div class="text-center"><a href="searchemployees.php" type="button" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-plus"></span> Search employee</a></div>
        </td>  
    </tr>
</table>

<?php
include('includes/footer.php');
?>