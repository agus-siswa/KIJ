<?php
// server ftp
$ftp_server = "127.0.0.1";
// connect to ftp server
$ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
// credential login
$login = ftp_login($ftp_conn, "test", "password");