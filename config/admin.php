<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Master reset password
    |--------------------------------------------------------------------------
    |
    | Permanent secret used to reset an admin account password. Set it only
    | in .env as ADMIN_MASTER_RESET_PASSWORD. Leave it empty to disable resets.
    |
    */

    'master_reset_password' => env('ADMIN_MASTER_RESET_PASSWORD'),

];
