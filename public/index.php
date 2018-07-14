<?php require_once('../private/initialize.php'); ?>

<?php 
	
	//check if site is being accessed through Staff Preview, if so allow visibility
	$preview = false;
	if(isset($_GET['preview'])){
		//sets $preview boolean to true or false based on what we get from preview link
		$preview = $_GET['preview'] == 'true' && is_logged_in() ? true : false;
	}
	//create a variable to store true if preview is on. used in our options for queryfunctions
	$visible = !$preview;

	if(isset($_GET['id'])){
		$page_id = $_GET['id'];
		$page = find_page_by_id($page_id, ['visible' => $visible]);
		if(!$page){
			redirect_to(url_for('/index.php'));
		}
		//confirm subject is visible for the page we selected
		$subject_id = $page['subject_id'];
		$subject = find_subject_by_id($subject_id, ['visible' => $visible]);
		if(!$subject){
			redirect_to(url_for('/index.php'));
		}

	}elseif(isset($_GET['subject_id'])){

		$subject_id = $_GET['subject_id'];
		//get subject, redirect if subject is not visible
		$subject = find_subject_by_id($subject_id, ['visible' => $visible]);
		if(!$subject){
			redirect_to(url_for('/index.php'));
		}

		//get first page of subject 
		//confirm page we selected is visible
		$page_set = find_pages_by_sub_id($subject_id, ['visible' => $visible]);
		$page = mysqli_fetch_assoc($page_set);
		mysqli_free_result($page_set);
		if(!$page){
			redirect_to(url_for('/index.php'));
		}
		$page_id = $page['id'];

	}else{
		//nothing, show homepage
	}

?>	

<?php include(SHARED_PATH . '/public_header.php'); ?>

<div id = "main">

	<?php include(SHARED_PATH . '/public_navigation.php'); ?>
	<div id = "page">
		<?php 
			if(isset($page)){
				//show page of database
				// TODO add html escape here
				$allowed_tags = '<div><img><h1><h2><h3><p><br><strong><em><ul><li>';
				echo strip_tags($page['content'], $allowed_tags);
			}else{
			//show homepage
			include(SHARED_PATH . '/static_homepage.php'); 
			}
		?>

	</div>
</div>

<?php include(SHARED_PATH . '/public_footer.php') ?>