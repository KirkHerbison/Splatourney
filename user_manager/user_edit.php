<?php require_once '../view/header.php'; ?>
<form method='post' action='user_manager/index.php'>
    <input type="hidden" name="controllerRequest" value="user_save" /> 
    <br><br>
    <div>
        <p>User ID: </p><input type='text' name='ID' value="<?php echo $user->getId(); ?>" readonly = true>
    </div>
    <br>
    <div>
        <p>User Role: </p>
        <select name="roleID">
            <option value="1" >End User</option>
            <option value="2" <?php
            if ($user->getRoleId() == 'Administrator') {
                echo "selected";
            }
            ?>>Admin</option>
        </select>
    </div>

    <br>
    <div>
        <p>First Name: </p><input type='text' name='firstName' value="<?php echo $user->getFirstName(); ?>">    
    </div>
    <br>
    <div>
        <p>Last Name: </p><input type='text' name='lastName' value="<?php echo $user->getLastName(); ?>">
    </div>
    <br>
    <div>
        <p>Email: </p><input type='text' name='email' value="<?php echo $user->getEmail(); ?>">
    </div>
    <br>
    <div>
        <p>Password: </p><input type='text' name='password' value="<?php echo $user->getPassword(); ?>">
    </div>   
    <br>
    <div>
        <p>Address: </p><input type='text' name='address' value="<?php echo $user->getAddress(); ?>">
    </div>
    <br>
    <div>
        <p>city: </p><input type='text' name='city' value="<?php echo $user->getCity(); ?>">
    </div>
    <br>
    <div>
        <p>State: </p><input type='text' name='state' value="<?php echo $user->getState(); ?>">
    </div>
    <br>
    <div>
        <p>Zip Code: </p><input type='text' name='zip' value="<?php echo $user->getZip(); ?>">
    </div>
    <br>
    <div>
        <p>Zip Phone: </p><input type='text' name='phone' value="<?php echo $user->getPhone(); ?>">
    </div>
    <br>
    <div>
        <p>IsActive: </p><input type='checkbox' id='checkBox' name='isActive'
                                <?php
                                if ($user->getIsActive() == 1) {
                                    echo 'checked';
                                }
                                ?>>
    </div>   

    <br>
    <div>
        <p></p><input type='submit' value='Save'>
    </div>
    <br>
</form>
<?php require_once '../view/footer.php'; ?>