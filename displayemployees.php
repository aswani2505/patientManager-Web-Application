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

// if search button was submitted
if( isset( $_POST['search'] ) ) {
    
    // set all variables to empty by default
    $firstName = $lastName = $salary = $contactNumber = "";
    
    // check to see if inputs are empty
    // create variables with form data
    // wrap the data with our function
    //we'll just store whatever has been entered
    $firstName = validateFormData( $_POST["firstName"] );
    $lastName = validateFormData( $_POST["lastName"] );
    $salary    = validateFormData( $_POST["salary"] );
    $contactNumber  = validateFormData( $_POST["contactNumber"] );
    
    if($firstName){
        $query = "SELECT * FROM Employees WHERE First_Name LIKE '%".$firstName."%'";
    }elseif($lastName){
        $query = "SELECT * FROM Employees WHERE Last_Name LIKE '%".$lastName."%'";
    }elseif($salary){
        $query = "SELECT * FROM Employees WHERE Salary = $salary";
    }elseif($contactNumber){
        $query = "SELECT * FROM Employees WHERE Contact_Number = $contactNumber";
    }
    $result = mysqli_query($conn, $query);
   
    
//    // if required fields have data
//    if( $firstName || $lastName || $salary || $contactNumber ) {
//        
//        // create query
//        $query = "SELECT * FROM Employees WHERE First_Name LIKE '%".$firstName."%'AND Last_Name LIKE '%".$lastName."%' AND Salary LIKE '%".$salary."%' AND Contact_Number LIKE '%".$contactNumber."%'";
//        
//        $result = mysqli_query( $conn, $query );
//    }    
}

// close the mysql connection
mysqli_close($conn);


include('includes/header.php');
?>

<h1>Employee List</h1>

<?php echo $alertMesssalary; ?>

<table class="table table-striped table-bordered">
    
    <tr>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Salary</th>
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
            
            echo "<td>" . $row['First_Name'] . "</td><td>" . $row['Last_Name'] . "</td><td>" . $row['Salary'] . "</td><td>" . $row['Contact_Number'] . "</td>";
            
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
        <td colspan="3"><div class="text-center"><a href="addemployees.php" type="button" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-plus"></span> Add employee</a></div>
        </td>
        <td colspan="4"><div class="text-center"><a href="searchemployees.php" type="button" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-plus"></span> Search employee</a></div>
        </td>  
    </tr>
</table>

<?php
include('includes/footer.php');
?>
    