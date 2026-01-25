<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <link rel="stylesheet" href="/library-management-system/public/css/admin.css">
</head>
<body>

<div class="admin-wrapper">

    <div class="sidebar">
        <h2>ADMIN</h2>
        <a href="index.php?action=admin-dashboard">Dashboard</a>
        <a href="index.php?action=admin-books">Book Management</a>
        <a href="index.php?action=categories">Categories Management</a>
        <a href="index.php?action=borrowings">Order books to borrow</a>
        <a href="index.php?action=users">User Management</a>
    </div>

    <div class="main-content">
        <?php
if (isset($viewFile) && file_exists($viewFile)) {
    include $viewFile;
} else {
    echo "<div style='padding:20px;color:red'>View file not found!</div>";
}
?>

    

</body>
</html>
