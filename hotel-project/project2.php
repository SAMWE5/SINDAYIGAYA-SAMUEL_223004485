<?php
$conn = new mysqli("localhost", "root", "", "project_db");

if(isset($_POST['submit'])){
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $dob = $_POST['day']."-".$_POST['month']."-".$_POST['year'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $pincode = $_POST['pincode'];
    $state = $_POST['state'];
    $country = $_POST['country'];

    $hobbies = "";
    if(isset($_POST['hobbies'])){
        $hobbies = implode(",", $_POST['hobbies']);
    }

    $sql = "INSERT INTO students(fname,lname,dob,email,mobile,gender,address,pincode,state,country,hobbies)
    VALUES('$fname','$lname','$dob','$email','$mobile','$gender','$address','$pincode','$state','$country','$hobbies')";

    $conn->query($sql);
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Student Registration Form</title>

<style>
body{
    font-family: Arial;
}

table{
    margin: auto;
}

td{
    padding: 8px;
}

input, select, textarea{
    padding: 5px;
}
</style>

</head>

<body>

<h2 align="center">STUDENT REGISTRATION FORM</h2>

<form method="POST">

<table>

<tr>
<td>FIRST NAME</td>
<td><input type="text" name="fname"></td>
</tr>

<tr>
<td>LAST NAME</td>
<td><input type="text" name="lname"></td>
</tr>

<tr>
<td>DATE OF BIRTH</td>
<td>
<select name="day">
<?php for($i=1;$i<=31;$i++) echo "<option>$i</option>"; ?>
</select>

<select name="month">
<option>Jan</option><option>Feb</option><option>Mar</option>
<option>Apr</option><option>May</option><option>Jun</option>
<option>Jul</option><option>Aug</option><option>Sep</option>
<option>Oct</option><option>Nov</option><option>Dec</option>
</select>

<select name="year">
<?php for($i=1980;$i<=2025;$i++) echo "<option>$i</option>"; ?>
</select>
</td>
</tr>

<tr>
<td>EMAIL ID</td>
<td><input type="email" name="email"></td>
</tr>

<tr>
<td>MOBILE NUMBER</td>
<td><input type="text" name="mobile"></td>
</tr>

<tr>
<td>GENDER</td>
<td>
<input type="radio" name="gender" value="Male"> Male
<input type="radio" name="gender" value="Female"> Female
</td>
</tr>

<tr>
<td>ADDRESS</td>
<td><textarea name="address"></textarea></td>
</tr>

<tr>
<td>PINCODE</td>
<td><input type="text" name="pincode"></td>
</tr>

<tr>
<td>STATE</td>
<td><input type="text" name="state"></td>
</tr>

<tr>
<td>COUNTRY</td>
<td>
<select name="country">
<option>Afghanistan</option>
<option>Albania</option>
<option>Algeria</option>
<option>Argentina</option>
<option>Australia</option>
<option>Brazil</option>
<option>Canada</option>
<option>China</option>
<option>France</option>
<option>Germany</option>
<option>India</option>
<option>Kenya</option>
<option>Rwanda</option>
<option>South Africa</option>
<option>United Kingdom</option>
<option>United States</option>
</select>
</td>
</tr>

<tr>
<td>HOBBIES</td>
<td>
<input type="checkbox" name="hobbies[]" value="Drawing"> Drawing
<input type="checkbox" name="hobbies[]" value="Singing"> Singing
<input type="checkbox" name="hobbies[]" value="Dancing"> Dancing
<input type="checkbox" name="hobbies[]" value="Sketching"> Sketching
<br>
Others <input type="text" name="hobbies[]">
</td>
</tr>

<!-- QUALIFICATION -->
<tr>
<td>QUALIFICATION</td>
<td>
<table border="1">
<tr>
<th>Sl.No</th>
<th>Examination</th>
<th>Board</th>
<th>Percentage</th>
<th>Year of Passing</th>
</tr>

<tr>
<td>1</td>
<td>Class X</td>
<td><input type="text" name="board1"></td>
<td><input type="text" name="per1"></td>
<td><input type="text" name="year1"></td>
</tr>

<tr>
<td>2</td>
<td>Class XII</td>
<td><input type="text" name="board2"></td>
<td><input type="text" name="per2"></td>
<td><input type="text" name="year2"></td>
</tr>

<tr>
<td>3</td>
<td>Graduation</td>
<td><input type="text" name="board3"></td>
<td><input type="text" name="per3"></td>
<td><input type="text" name="year3"></td>
</tr>

<tr>
<td>4</td>
<td>Masters</td>
<td><input type="text" name="board4"></td>
<td><input type="text" name="per4"></td>
<td><input type="text" name="year4"></td>
</tr>

</table>
</td>
</tr>

<tr>
<td>COURSES APPLIED FOR</td>
<td>
<input type="radio" name="course" value="BCA"> BCA
<input type="radio" name="course" value="B.Com"> B.Com
<input type="radio" name="course" value="B.Sc"> B.Sc
<input type="radio" name="course" value="B.A"> B.A
</td>
</tr>

<tr>
<td></td>
<td>
<button type="submit" name="submit">Submit</button>
<button type="reset">Reset</button>
</td>
</tr>

</table>

</form>

</body>
</html>