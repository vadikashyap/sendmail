//Stap :- 1 (Create .php file)

//Stap :- 2 (code copy and past)

//PHP CODE
<?php 
if (isset($_REQUEST['MAIL'])) {

$to=$_POST['RECIVER'];;
$subject=$_POST['SUBJECT'];; 
$message=$_POST['MASSAGE'];
$header="From:" . $_POST['SENDER'];

if (mail($to,$subject,$message,$header)) {
	# code...
	echo "Mail send";
}
else{
	echo "Mail Not Send";
}

}

 ?>
 
 
 
 //HTML FORM CODE
 
 
 
 
 <form  name="MAIL" method="POST" >
 	SENDER MALI :- <input type="email" name="SENDER">
  RECIVER MAIL :- <input type="email" name="RECIVER">
  Subject :- <input type="text" name="SUBJECT">
  Massage :- <textarea  name="MASSAGE" rows="7" cols="50"></textarea>
  <button type="SUBMIT" name="MAIL" value="login"> SEND MAIL </button> 		
  </form>
