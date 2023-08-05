<?php

namespace CPM_Plugin;

class Login
{
    public function __construct()
    {
        add_action('login_enqueue_scripts', [$this, 'style']);
    }

    function style()
    {
        echo '<style type="text/css">
        *{
        }

        .login{
            background-image:linear-gradient(0deg, rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)), url(https://images.unsplash.com/photo-1446018944197-6dcd4ccf2711?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1770&q=80);
            background-size: cover;
            background-position: 0% 50%;

        }
        .login > *, .login form {
            margin: 0;
            padding: 0;
        }

        #loginform{
            background: rgba(255,255,255,.1);
            box-shadow: 0 0 1rem rgba(0,0,0,.2);
            border: none;
            border-radius: .5rem;
            padding: 1rem;
            color: #fff;
        }

        .login form .input, .login input[type=password], .login input[type=text]{
            border: none;
            outline: none;
            font-size: auto; 
            background: rgba(0,0,0,.5) !important;
        }

    </style>';
    }
}
