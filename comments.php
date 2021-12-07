<?php 
$comment_args = array(
	'label_submit' => 'Submit Review',
	'title_reply' => 'Post a Review',
	'comment_form_top' => 'ds',
	'comment_notes_before' => '',
	'comment_notes_after' => '',
	'comment_field' => '<p class="comment-form-comment"><textarea style="width:500px;" id=" comment" name="comment" placeholder="Write a Review" aria-required="true"></textarea></p>'
);
comment_form($comment_args);
//wp_list_comments('type=comment');
