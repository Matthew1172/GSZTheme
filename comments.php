<div class="container">
    <?php $comment_args = array(
        'label_submit' => 'Submit Review',
        'title_reply' => 'Post a Review',
        'comment_form_top' => 'ds',
        'comment_notes_before' => '',
        'comment_notes_after' => '',
        'comment_field' => '<p class="comment-form-comment"><textarea style="width:500px;" id=" comment" name="comment" placeholder="Write a Review" aria-required="true"></textarea></p>'
    );
    ?>
    <div>
        <div class="comment-rating">
            <ul class="star-rating">
                <li><a href="#" title="<?php _e('Zero'); ?>" class="zero-star" onclick="rateClick(0); return false;">0</a></li>
                <li><a href="#" title="<?php _e('Very Bad'); ?>" class="one-star" onclick="rateClick(1); return false;">1</a></li>
                <li><a href="#" title="<?php _e('Bad'); ?>" class="two-stars" onclick="rateClick(2); return false;">2</a></li>
                <li><a href="#" title="<?php _e('Good'); ?>" class="three-stars" onclick="rateClick(3); return false;">3</a></li>
                <li><a href="#" title="<?php _e('Very Good'); ?>" class="four-stars" onclick="rateClick(4); return false;">4</a></li>
                <li><a href="#" title="<?php _e('Excellent'); ?>" class="five-stars" onclick="rateClick(5); return false;">5</a></li>
            </ul>
        </div>
        <input type="hidden" name="rat" id="rat" value="<?php echo esc_attr($rat); ?>" />
    </div>
    <br>
    <br>
    <?php comment_form($comment_args); ?>
    <?php wp_list_comments('type=comment&callback=comment_template'); ?>
    

    <!-- <h2>Avg Ratings</h2>
    php (get_average_ratings($post->ID))?movie(get_average_ratings($post->ID)):'Not available';  -->
</div>

