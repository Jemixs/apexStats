<?php
include 'inc/system.php';

if (isset($_POST['ajax']) && isset($_POST['name']) && !empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['message']) && !empty($_POST['site'])) {
	$autName = htmlspecialchars($_POST['name']);
	$autMail = htmlspecialchars($_POST['email']);
	$autMessage = htmlspecialchars($_POST['message']);
	$selSite = htmlspecialchars($_POST['site']);

	$to      = CONTACT_MAIL;
	$subject = 'ApexStats.ru - Contact '.$autName;
	$message = 'hello';
	$headers = 'From: admin@apexstats.ru' . "\r\n" .
	'Reply-To:'.$autMail . "\r\n" .
	'X-Mailer: PHP/' . phpversion();

	if (mail($to, $subject, $autMessage.'</br> Sender addres - '.$autMail, $headers)) {
		die('{"type":"send"}');
	}else{
		die('{"type":"error"}');
	}
}

include 'inc/header.php';
?>

<div class="leaderPageBack w-100"></div>
<div class="container">
	<div class="row">
		<div class="col-12">
			<div class="feedbackForm">
				<div class="title">
					<h3>Форма обратной связи</h3>
				</div>
				<div class="desc">
					Нашли недоработку/баг? Есть предложения, жалобы или хотите сотрудничать? Напишите нам!
				</div>
				<form method="POST" action="/contact" class="formFeed">
					<div class="row">
						<div class="col-12 col-sm-12 col-lg-9 col-xl-9 col-md-12">
							<input type="text" name="name" class="uName" id="" required placeholder="Имя">
							<input type="text" name="email" class="uMail" id="" required placeholder="Email отправителя">
							<select name="site" id="">
								<option value="apexstats.ru" select>APEXSTATS.RU</option>
							</select>
							<textarea name="message" id="" cols="30" rows="10" placeholder="Текст сообщения" required></textarea>
							<input type="submit" name="sendContact" id="sendFormCont">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>	

<?
include 'inc/footer.php';
?>