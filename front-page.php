<?php

/**
 * 
 * Home page for the gradschoolzero Theme.
 * 
 * 
 * @package Team M
 * @subpackage gradschoolzero
 * @since gradschoolzero 1.0
 */
require 'header.php';

?>

<div class="container bg-white">
</div>

<?php

require 'classes/front-page-classes.php';

$comments = get_comments();
$reviews = array();

foreach ($comments as $comment) {
    $rating = get_comment_meta($comment->comment_ID, 'rat');
    $class_comment = new ClassReview();
    $class_comment->setComment_post_id($comment->comment_post_ID);
    $class_comment->setComment_author($comment->comment_author);
    $class_comment->setClass_rating($rating[0]);

    # echo ($class_comment->getComment_post_id() . ' --- ' . $class_comment->getComment_author() . ' --- ' . $class_comment->getClass_rating());
    # echo ('</p>');

    array_push($reviews, $class_comment);
}

$myposts = get_posts(array('post_type' => 'gradschoolzeroclass'));
$classes = array();

foreach ($myposts as $post) :
    $class_info = new ClassInfo();
    $class_info->setPost_ID($post->ID);
    $class_info->setPost_class_name($post->post_title);

    # echo ($class_info->getPost_ID() . ' --- ' . $class_info->getPost_class_name());
    # echo ('<p />');

    array_push($classes, $class_info);
endforeach;

$class_ratings = array();

foreach ($reviews as $review) :
    foreach($classes as $class) :
        $class_rating = new ClassRating();
        if ($class->getPost_ID() == $review->getComment_post_id()){
            $class_rating->setClass_id($class->getPost_ID());
            $class_rating->setClass_name($class->getPost_class_name());
            $class_rating->setClass_rating($review->getClass_rating());

            array_push($class_ratings, $class_rating);
        }
    endforeach;
endforeach;

// echo('id --- name --- rating </p>');

/*
foreach ($class_ratings as $rating) :
    echo($rating->getClass_id() . ' --- ' . $rating->getClass_name() . ' --- ' . $rating->getClass_rating());
    echo('<p/>');
endforeach;*/

$average_ratings = array();

foreach($classes as $class) :
    $num_of_classes = 0;
    $sum_of_ratings = 0;
    $average = 0;
    $temp_ratings = array();

    foreach ($class_ratings as $rating) :
        if($rating->getClass_id() != $class->getPost_id()){
            continue;
        }
        array_push($temp_ratings, $rating);
    endforeach;

    foreach ($temp_ratings as $temp) :
        $num_of_classes += 1;
        $sum_of_ratings += $temp->getClass_rating();
    endforeach;

    $average = $sum_of_ratings / $num_of_classes;

    $class_rating = new ClassAverageRating();
    $class_rating->setClass_id($class->getPost_ID());
    $class_rating->setClass_name($class->getPost_class_name());
    $class_rating->setAverage_rating($average);
    array_push($average_ratings, $class_rating);

    $num_of_classes = 0;
    $sum_of_ratings = 0;
    $average = 0;
    $temp_ratings = array(); // $temp_array is reinstantiated
endforeach;

// echo('id' . '-------' . 'class_name' . '------' . 'average rating' . '</p>');
/*foreach ($average_ratings as $average) :
    echo($average->getClass_id() . '-------' . $average->getClass_name() . '------' . $average->getAverage_rating());
    echo('</p>');
endforeach;*/

// Asc sort
usort($average_ratings, function($first,$second){
    return $first->average_rating < $second->average_rating;
});

echo('id' . '-------' . 'class_name' . '------' . 'average rating' . '</p>');
foreach ($average_ratings as $average) :
    echo($average->getClass_id() . '-------' . $average->getClass_name() . '------' . $average->getAverage_rating());
    echo('</p>');
endforeach;

?>

<table class="table">
    <thead class="thead-light">
        <tr>
            <th scope="col">#</th>
            <th scope="col">First</th>
            <th scope="col">Last</th>
            <th scope="col">Handle</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th scope="row">1</th>
            <td>Mark</td>
            <td>Otto</td>
            <td>@mdo</td>
        </tr>
        <tr>
            <th scope="row">2</th>
            <td>Jacob</td>
            <td>Thornton</td>
            <td>@fat</td>
        </tr>
        <tr>
            <th scope="row">3</th>
            <td>Larry</td>
            <td>the Bird</td>
            <td>@twitter</td>
        </tr>
    </tbody>
</table>

<?php require 'footer.php'; ?>