<?php
include 'inc/system.php';

if (!$authorization)
	header('Location: /');

$title = 'Редактор статьи';


if (isset($_POST['creat']) && isset($_POST['postTitle']) && !empty($_POST['postTitle']) && isset($_POST['postContnet']) && !empty($_POST['postContnet']) && isset($_POST['postDesc']) && !empty($_POST['postDesc']) && isset($_POST['postImg']) && !empty($_POST['postImg'])) {

	$postTitle = htmlspecialchars($_POST['postTitle']);
	$postContnet = htmlspecialchars($_POST['postContnet']);
	$postDesc = htmlspecialchars($_POST['postDesc']);
	$postImg = htmlspecialchars($_POST['postImg']);

	$newPost = R::dispense('news');
	$newPost->title = trim($postTitle);
	$newPost->description = $postDesc;
	$newPost->img = $postImg;
	$newPost->content = $postContnet;
	$newPost->date_created = time();
	$newPost->visible = 0;

	if (R::store($newPost)) {
		die('{"type":"ok"}');
	}else{
		die('{"type":"error"}');
	}
}elseif (isset($_POST['update']) && isset($_POST['postTitle']) && !empty($_POST['postTitle']) && isset($_POST['postContnet']) && !empty($_POST['postContnet']) && isset($_POST['postDesc']) && !empty($_POST['postDesc']) && isset($_POST['postImg']) && !empty($_POST['postImg'])) {

	$postTitle = htmlspecialchars($_POST['postTitle']);
	$postContnet = htmlspecialchars($_POST['postContnet']);
	$postDesc = htmlspecialchars($_POST['postDesc']);
	$postImg = htmlspecialchars($_POST['postImg']);

	$newPost = R::findOne('news','id = ?',[$_POST['update']]);
	$newPost->title = trim($postTitle);
	$newPost->description = $postDesc;
	$newPost->img = $postImg;
	$newPost->content = $postContnet;



	if (R::store($newPost)) {
		die('{"type":"ok"}');
	}else{
		die('{"type":"error"}');
	}

	//header('Location: /edit-post/edit/'.$_POST['update']);
}

if (isset($_GET['type']) && $_GET['type'] == 'edit') {
	$postId = htmlspecialchars($_GET['id']);

	$getPost = R::findOne('news','id = ?',[$postId]);

	$type = 'update';

	$toPost = '<a href="/news/'.$postId.'/" style="padding: 10px; font-size: 18px; font-weight: 300; color: orange;"><i class="fas fa-arrow-left"></i> К статье</a>';

	if (!$getPost) {
		header('Location: /edit-post/new');
	}
}elseif (isset($_GET['type']) && $_GET['type'] == 'remove') {
	if ($authorization) {
		$postId = htmlspecialchars($_GET['id']);

		$getPost = R::findOne('news','id = ?',[$postId]);
		if ($getPost) {
			R::trash($getPost);
			header('Location: /');
		}else{
			header('Location: /');
		}
	}
	header('Location: /');
}elseif (isset($_GET['type']) && $_GET['type'] == 'hideToogle') {
	$postId = htmlspecialchars($_GET['id']);

	$getPost = R::findOne('news','id = ?',[$postId]);
	if ($getPost) {
		if ($getPost->visible == 1) {
			$getPost->visible = 0;
		}else{
			$getPost->visible = 1;
		}

		$savePost = R::store($getPost);

		header('Location: '.$_SERVER['HTTP_REFERER']);
	}else{
		header('Location: /');
	}
}else{
	$type = 'creat';
}


include 'inc/header.php';
?>

<div class="container">
	<div class="row">
		<div class="col-12">
			<div class="post-editor">
				<?=$toPost?>
				<form method="POST" action="/edit-post" class="formPost">
					<input type="text" name="postTitle" class="namePost" placeholder="Название статьи" value="<?=$getPost->title?>" required>

					<input type="text" name="postDesc" class="namePost postDesc" value="<?=$getPost->description?>" placeholder="Краткое описание" required>
					<input type="text" name="postImg" class="namePost postImg" value="<?=$getPost->img?>" placeholder="Превью картинка(ссылка)" required>
					
					<div id="editor">
						<?=htmlspecialchars_decode($getPost->content)?>
					</div>

					<div class="saveButton w-100">
						<input type="submit" id="sendFormPost" class="savePost" value="Сохранить">
					</div>
					<input type="text" name="<?=$type?>" style="position: absolute; right: -9999px; display: none;" value="<?=$getPost->id?>">
				</form>
			</div>
		</div>
	</div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="//cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script>
	var toolbarOptions = [
  ['bold', 'italic', 'underline', 'strike','link'],        // toggled buttons

  [{ 'header': 1 }, { 'header': 2 }],               // custom button values
  [{ 'list': 'ordered'}, { 'list': 'bullet' }],

  [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent

  [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
  [{ 'header': [1, 2, 3, 4, 5, 6, false] }],

  [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
  [{ 'align': [] }],
  ['video'],

  ['clean']                                         // remove formatting button
  ];

  var quill = new Quill('#editor', {
  	modules: { toolbar:toolbarOptions},
  	theme: 'snow'
  });

  $('#sendFormPost').click(function(e) {
  	e.preventDefault();

  	$.ajax({
  		type: "POST",
      	url: "/edit-post", //Change
      	data: $('.formPost').serialize()+'&postContnet='+quill.root.innerHTML,
      	success: function(data){
      		var ret = JSON.parse(data);
      		if (ret.type == 'ok') {
      			$.growl.notice({ message: "Статья сохранена." });
      		}else if(ret.type == 'error') {
      			$.growl.error({ message: "Не удалось сохранить статью. Попробуйте еще раз." });
      		}
      	}
      });
  	return false;
  });
</script>
<?
include 'inc/footer.php';
?>