<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <style>
        body{
            background-image: url(https://i.gifer.com/origin/db/db06c14a3148ef1e0764641c2dc1f347.gif);
            background-repeat: repeat;
            color: white;
            text-align: left;
        }
        .form-input{
            margin-bottom: 10px;
        }
        .table {
            border-collapse: collapse;
            color: white;
            width: 100%;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        .table th {
            background-color: transparent;
        }
        .table tr:nth-child(even) {
            background: color 0;
        }
        .table tr:hover {
            background-color: black;
            color: white;
        }
        .delete-link {
            color: red;
        }
        .button {
            background-color: #04AA6D; /* Green */
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
        }

    </style>
</body>
</html>

<?php
session_start();
include('connection_db.php');
include('global.php');
$id = null;
$fname = null;
$email = null;
$phone = null;
$title = null;
$created = null;

if (isset($_GET['action']) && $_GET['action'] === 'delete') {
    $id = $_GET['id'];
    $sql = "DELETE FROM contacts WHERE `id`='$id'";
    $result = $conn->query($sql);
    errorCheck($sql, $conn, $result, "", "");
    header("Location: /yasay/");
}

if (isset($_GET['action']) && $_GET['action'] === 'edit') {

    $fname = $_GET['fname'];
    $email = $_GET['email'];
    $phone = $_GET['phone'];
    $title = $_GET['title'];
    $created = $_GET['created'];
    
    $id = $_GET['id'];
}

if (isset($_POST['fname'])  && ! isset($id)) {
    $fname = $_POST['fname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $title = $_POST['title'];
    $created = $_POST['created'];
  
    $sql = "INSERT INTO contacts (fname, email, phone, title, created) 
    VALUES ('$fname', '$email', '$phone', '$title', '$created')";
    $result = $conn->query($sql);
    errorCheck($sql, $conn, $result, "create", $fname);
    header("Location: /yasay/");

}

if (isset($_POST['fname'])  && isset($id)) {
    $fname = $_POST['fname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $title = $_POST['title'];
    $created = $_POST['created'];
    $id = $_GET['id'];
    $sql = "UPDATE contacts SET fname='$fname',email='$email', phone='$phone', title='$title', created='$created' WHERE id='$id'";
    $result = $conn->query($sql);
    errorCheck($sql, $conn, $result, "update", $fname);
}

?>
<form method="POST" action="">
    <p>Name <input name="fname" value="<?= isset($fname) ? $fname : '' ?>"required> </p>
    <p>E-Mail <input name="email" value="<?= isset($email) ? $email : '' ?>"required> </p>
    <p>Phone <input name="phone" value="<?= isset($phone) ? $phone : '' ?>"required> </p>
    <p>Title <input name="title" value="<?= isset($title) ? $title : '' ?>"required> </p>
    <p>Created <input name="created" type="date" value="<?= isset($created) ? date('Y-m-d',strtotime ($created)) : '' ?>"> </p>
    <br> <br>
    <?php if (isset($id)) { ?>
        <a href="/lomoljo/">Cancel</a>
        <button>Update</button>
    <?php } else { ?>
        <button>Save</button>
    <?php } ?>
</form>

<h1>List Of Users</h1>

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>E-Mail</th>
            <th>Phone</th>
            <th>Title</th>
            <th>Created</th>
            <th>Actions</th>
            
        </tr>
    </thead>

    <tbody>
        <?php
        $sql = "SELECT * FROM contacts";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
        ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['fname']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['phone']; ?></td>
                    <td><?php echo $row['title']; ?></td>
                    <td><?php echo $row['created']; ?></td>
                    <td width="200"> <a style="color: red" href="?action=delete&id=<?= $row['id'] ?>"> DELETE </a>
                    <a href="?action=edit&id=<?= $row['id'] ?>&fname=<?= $row['fname'] ?>&email=<?= $row['email']?>&phone=<?= $row['phone']?>&title=<?= $row['title'] ?>&created=<?= $row['created'] ?>"> EDIT </a>
                    </td>
                </tr>
        <?php }
        } ?>
    </tbody>
</table>