use PHPMailer\PHPMailer\PHPMailer;
//Load COmposer's autoload.php
require 'vendor/autoload.php';
$mail = new PHPMailer(true);
//server settings
$mail->SMTPDebug = 2; //Enable verbase debug output
$mail->isSMTP(); //Send using SMTP
$mail->Host ='smtp.gmail.com'; //set the SMTp server to send through
$mail->SMTPAuth = true; //Enable SMTP outhentication
$mail->Username ='user@example.com'; //SMTP username
$mail->Password ='secret'; //SMTP password
$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; //enable implicit TLS encryption
$mail->Port =465;

if(isset($_POST['kirim'])){
//recipients
$mail->setFrom('tutormubatekno@gmail.com', 'Tutorial Muba Teknologi');
$mail->addAddress($_POST['email_penarima']); //pemerima
}




if (isset($_POST['kirim'])) {
if (create_barang($_POST) > 0) {
echo "
<script>
    alert('Data Barang Berhasil Ditambahkan');
    document.location.href = 'index.php'; 
</script>";
} else {
echo "
<script>
    alert('Data Barang Gagal Ditambahkan');
    document.location.href = 'index.php';
</script>";
}
}