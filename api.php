<?php 
define("SECRET_KEY", "HALLO DUNIA");

function enkripsiStr($str){
  return openssl_encrypt($str,"AES-128-ECB", SECRET_KEY);
}
function dekripsiStr($str){
  return openssl_decrypt($str,"AES-128-ECB",SECRET_KEY);
}
function bacaFile(){
  include 'cred.php';
  // get "dummy.txt" from server
  $server_file = "dummy.txt";
  // copy the txt field to local client txt
  $local_file = "local.txt";
  // write local file
  $fp = fopen($local_file,"w");
  // download server file and save it to open local file
  if (ftp_fget($ftp_conn, $fp, $server_file, FTP_ASCII, 0)){
    $myfile = fopen("local.txt", "r") or die("Unable to open file!");
    $result =  fread($myfile,filesize("local.txt"));
    fclose($myfile);
    return "Decrypt : <i>".dekripsiStr($result)."</i>";
  }else{
    return "Error downloading $server_file.";
  }
  // close connection
  ftp_close($ftp_conn);
}

function tulisFile($str){
  include 'cred.php';
  // get "dummy.txt" from server
  $server_file = "from_client.txt";
  $myfile = fopen($server_file, "w") or die("Unable to open file!");
  $txt    = enkripsiStr($str);
  fwrite($myfile, $txt);
  fclose($myfile);
  // download server file and save it to open local file
  if (ftp_put($ftp_conn, "dummy.txt", $server_file, FTP_ASCII, 0)){
    return "Encrypt :<i>".$txt."</i><br/>Sending Success.";
  }else{
    return "Error downloading $server_file.";
  }
  // close connection
  ftp_close($ftp_conn);
}


// String to enkripsi
$txt = "Testing";
// kirim ke ftp server
echo tulisFile($txt)."<br/>";
// baca dari ftp server+
echo bacaFile();