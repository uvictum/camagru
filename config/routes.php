<?php
return array(
        "'^(\/){1}$'" => "gallery/display",
        "'^\/cabinet$'" => "cabinet/dashboard",
        "'^\/update$'" => "cabinet/update",
        "'^\/\?(image=[1-9]{1}[0-9]{0,4})$'" => "photopage/show",
        "'^\/logout$'" => "login/logout",
        "'^\/login$'" => "login/signin",
        "'^\/signup$'" => "registration/signup",
        "'^\/editor$'" => "editor/image",
        "'^\/verify\/([?=A-z0-9;_\%@.&]+)'" => "registration/verify",
        "'^\/resetpass(\/){0,1}([?=A-z0-9;_\%@.&])*'" => "login/request",
        "'^\/setpass$'" => "login/set",
        "'^\/comment$'" => "photopage/addComment",
        "'^\/delete_comment$'" => "photopage/removeComment",
        "'^\/delete$'" => "photopage/removePhoto",
        "'^\/like$'" => "photopage/addLike",
        "'^\/unlike$'" => "photopage/removeLike",
        "'^\/auth$'" => "login/checkAuth");