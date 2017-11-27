<html>
  <body>
    <p>
      The below form will create a person in SalesLoft with the provided information, and add them
      to a cadence that you have specified in the environment.
    </p>

    <form action="/handler.php" method="POST">
      <input type="text" name="first_name" placeholder="Sally" value="Sally" required />
      <input type="text" name="last_name" placeholder="Ma" value="Ma" required />
      <input type="email" name="email_address" placeholder="sally@example.com" value="test+<?= time() ?>@test.com" required />

      <input type="submit" value="Submit" />
    </form>

    <?php if (array_key_exists("person_id", $_GET)) { ?>
      <p>
        Person created successfully! See them at <a target="_blank" href="https://app.salesloft.com/app/people/<?= $_GET["person_id"] ?>">app.salesloft.com</a>
      </p>
    <?php } elseif (array_key_exists("err", $_GET)) { ?>
      <p>
        There was an error: <?= $_GET["err"] ?>
      </p>
    <?php } ?>
  </body>
</html>
