<!DOCTYPE html>
<html>
<head>
    <title>School Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body style="font-family:Arial">

<h2>School Management System</h2>

<hr>

<div style="display:flex">

    <div style="width:220px">

        <h3>Menu</h3>

        <ul>
            <li><a href="/admin/dashboard">Dashboard</a></li>
            <li><a href="/admin/students">Students</a></li>
            <li><a href="/admin/classes">Classes</a></li>
            <li><a href="/admin/subjects">Subjects</a></li>
            <li><a href="/admin/results">Results</a></li>
            <li><a href="/admin/users">Users</a></li>
        </ul>

    </div>

    <div style="flex:1">

        @yield('content')

    </div>

</div>

</body>
</html>