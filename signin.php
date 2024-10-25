<?php
    include "head.php";
?>
    <div id="container">
        <h2>Sign In</h2>
        <form action="process.php" method="post">
            <input type="text" name="username" placeholder="Username">
            <input type="password" name="password" placeholder="Password">
            <button type="submit">Sign In</button>
        </form>
    </div>

<?php
    include "footer.php";
?>
