<footer>
    <p class="copyright">
        <?php if($userLogedin ->getUsername() != ''){echo 'Logged in user: '.$userLogedin->getUsername();}?>
    </p>
    <p class="copyright">
        &copy; <?php echo date("Y"); ?> Splatourney
    </p>
</footer>
</main>
</body>
</html>