<?php
return array(
        "'^(\/){1}$'" => "gallery/display",
        "'\/cabinet$'" => "cabinet/dashboard",
        "'^\/\?(image=[1-9]{1}[0-9]{0,4})$'" => "photopage/show",
        "'\/logout$'" => "login/logout",
        "'\/login$'" => "login/signin",
        "'\/signup$'" => "login/signup",
        "'\/editor$'" => "editor/image",
        "'\/photo$'" => "image/view",
        "'\/verify\/([?=A-z0-9;_\%@.&]+)'" => "login/verify",
        "'\/resetpass(\/){0,1}([?=A-z0-9;_\%@.&])*'" => "login/request",
        "'\/setpass'" => "login/set",
        "'\/upload'" => "editor/upload",
        "'\/comment'" => "photopage/addComment");