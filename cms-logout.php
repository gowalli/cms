<?php

setcookie('sid', '', time() - 1);
header("Location: /cms-login.php?action=logout");
