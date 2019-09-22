<?php
if (isset($_FILES) && (bool) $_FILES) {

    $allowedExtensions = array("pdf", "doc", "docx", "gif", "jpeg", "jpg", "png","ppt","mp4");

    $files = array();
    foreach ($_FILES as $name => $file) {
        $file_name = $file['name'];
        $temp_name = $file['tmp_name'];
        $file_type = $file['type'];
        $path_parts = pathinfo($file_name);
        $ext = $path_parts['extension'];
        if (!in_array($ext, $allowedExtensions)) {
            die("File $file_name has the extensions $ext which is not allowed");
        }
        array_push($files, $file);
    }

    // email fields: to, from, subject, and so on
    $to = $_POST['email'];
    $from = $_POST['sender'];
    $subject = "This Mail Send Kashyap-Vadi Website";
    $message = $_POST['message'];
    $headers = "From: $from";

    // boundary 
    $semi_rand = md5(time());
    $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";

    // headers for attachment 
    $headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\"";

    // multipart boundary 
    $message = "This is a multi-part message in MIME format.\n\n" . "--{$mime_boundary}\n" . "Content-Type: text/plain; charset=\"iso-8859-1\"\n" . "Content-Transfer-Encoding: 7bit\n\n" . $message . "\n\n";
    $message .= "--{$mime_boundary}\n";

    // preparing attachments
    for ($x = 0; $x < count($files); $x++) {
        $file = fopen($files[$x]['tmp_name'], "rb");
        $data = fread($file, filesize($files[$x]['tmp_name']));
        fclose($file);
        $data = chunk_split(base64_encode($data));
        $name = $files[$x]['name'];
        $message .= "Content-Type: {\"application/octet-stream\"};\n" . " name=\"$name\"\n" .
                "Content-Disposition: attachment;\n" . " filename=\"$name\"\n" .
                "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
        $message .= "--{$mime_boundary}\n";
    }
    // send

    $ok = mail($to, $subject, $message, $headers);
    if ($ok) {
        echo "<p>mail sent to $to!</p>";
    } else {
        echo "<p>mail could not be sent!</p>";
    }
}
?>

<html>
<head>
    <title>Send Mail Website</title>
     <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" type="text/css" href="main.css">
</head>
    <body>
        <!-- <h2>Send Mail</h2>
        <form method="post" action="" enctype="multipart/form-data">
            <input type="text" name="email" placeholder="email"><br>
            <input type="text" name="sub" placeholder="Subject"><br>
            <textarea name="msg" placeholder="Write email message"></textarea><br>

            Attach file:<br>
            <input type="file" name="attach1"/><br><br>
            <input type="submit" value="Send Mail"/>
        </form> -->






        <div class="container-fluid">
            <div class="container" >
                <div class="formBox">
                    <form method="post" action="" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-sm-12">
                                <h1>Mail Send Form</h1>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="inputBox ">

                                    <input type="text" name="sender" class="input" placeholder="Sender Email">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="inputBox">

                                    <input type="text" name="email" class="input" placeholder="Reciver Email">
                                </div>
                            </div>
                        </div>

                       <!--  <div class="row">
                            <div class="col-sm-6">
                                <div class="inputBox">

                                    <input type="text" name="email" class="input" placeholder="Email">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="inputBox">

                                    <input type="number" name="mobile" class="input" placeholder="Mobile" mix="10">
                                </div>
                            </div>
                        </div> -->

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="inputBox">

                                    <textarea class="input" name="message" placeholder="Message"></textarea>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="inputBox">
                                    <br><br>
                                    
                                    <input type="file" name="attach1" class="input" >
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <input type="submit" name="submit" class="button" value="Send Message">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>