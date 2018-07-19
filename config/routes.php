<?php
return array(
        "'^(\/){1}$'" => "gallery/display",
        "'\/cabinet'" => "cabinet/dashboard",
        "'\/login'" => "login/signin",
        "'\/signup'" => "login/signup",
        "'\/editor'" => "editor/image",
        "'\/photo'" => "image/view",
        "'\/verify\/([?=A-z0-9;_\%@.&]+)'" => "login/verify",
        "'\/resetpass(\/){0,1}([?=A-z0-9;_\%@.&])*'" => "login/request",
        "'\/setpass'" => "login/set");