<?php require_once '../view/header.php'; ?> 


<h1>Register</h1>
<span style='color: red'><?php echo $error_message ?></span>
<form action="user_manager/index.php" method="post">
    <input type="hidden" name="controllerRequest" value="user_register_confirmation" /> 
    <br>
    <div>
        <p>First Name: </p>
        <input type="text" name="firstName" value="John"><p class ="requiredField">*</p>
    </div>
    <br>
    <div>
        <p>Last Name: </p>
        <input type="text" name="lastName" value="Doe"><p class ="requiredField">*</p>
    </div>
    <br>
    <div>
        <p>Show Name On Profile: </p>
        <input type="checkbox" name="showName">
    </div>
    <br>
    <div>
        <p>Email: </p>
        <input type='text' name='emailAddress' value="test@test.com"><p class ="requiredField">*</p>
    </div>
    <br>
    <div>
        <p>username: </p>
        <input type='text' name='username' value="taco"><p class ="requiredField">*</p>
    </div>
    <br>
    <div>
        <p>Password: </p>
        <input type='password' name='password' value="test"><p class ="requiredField">*</p>
    </div>
    <br>
    <div>
        <p>Switch Friend Code: </p>
        <input type='text' name='friendCode' value="SW-1111-2222-3333">
    </div>
    <br>
    <div>
        <p>Switch Username: </p>
        <input type='text' name='switchUsername' value="TacoTruck">
    </div>
    <br>
    <div>
        <p>Splashtag: </p>
        <input type='text' name='splashtag' value="TacoTruck#1234">
    </div>
    <br>
    <div>
        <p>Discord Username: </p>
        <input type='text' name='discordUsername' value="Taco#1234">
    </div>
    <br>
    <div>
        <p></p><input type='submit' value='Register'>
    </div>
    <br>
</form>






<?php require_once '../view/footer.php'; ?>