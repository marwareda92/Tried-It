<?php require('header.php');

//initialize variables
$id = null;
$firstname = null;
$lastname = null;
$email = null;
$birthday = null;
$profession = null;

//check if the user is editing
if (!empty($_GET['id']) && (is_numeric($_GET['id']))) {
    //grab id and store in a variable
    $id = filter_input(INPUT_GET, 'id');
    //connects to DB
    require('connect.php');
    //set up query
    $sql = "SELECT * FROM users WHERE user_id = :user_id;";
    //prepare
    $statement = dbo()->prepare($sql);
    //bind
    $statement->bindParam(':user_id', $id);
    //execute
    $statement->execute();
    //use fetchAll to store
    $records = $statement->fetchAll();
    foreach($records as $record) :
        $firstname = $record['first_name'];
        $lastname = $record['last_name'];
        $email = $record['email'];
        $birthday = $record['birthday'];
        $profession = $record['profession'];
    endforeach;
    $statement->closeCursor();
}
?>
    <main>
        <form action="process.php" method="post">
            <!--add hidden input to include the id without the user seeing-->
            <input type="hidden" name="user_id" value="<?php echo $id; ?>">
            <div class="form-group">
                <input type="text" name="firstname" placeholder="First Name" class="form-control"
                       value="<?php echo $firstname; ?>">
            </div>
            <div class="form-group">
                <input type="text" name="lastname" placeholder="Last Name" class="form-control"
                       value="<?php echo $lastname; ?>">
            </div>
            <div class="form-group">
                <input type="email" name="email" placeholder="Email" class="form-control"
                       value="<?php echo $email; ?>">
            </div>
            <div class="form-group">
                <label for="birthday">Date of Birth:</label>
                <input type="date" id="birthday" name="birthday" class="form-control"
                       value="<?php echo $birthday; ?>">
            </div>
            <div class="form-group">
                <input type="text" name="profession" placeholder="Profession" class="form-control"
                       value="<?php echo $profession; ?>">
            </div>
            <input type="submit" value="submit" name="submit" class="btn btn-primary">
        </form>
    </main>
<?php
require('footer.php');
?>