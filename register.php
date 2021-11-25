<?php

/**
 * 
 * Displays frontend for users to signup to and add all custom gradschoolzero User information to databases.
 * 
 * 
 * @package Team M
 * @subpackage gradschoolzero
 * @since gradschoolzero 1.0
 */
/* Template Name: register */

if (!is_user_logged_in()) {
    require 'header.php';
    ?>
    <style> 
    ul {
        list-style-type: none;
    }
    li {
        margin-bottom: 5px; /* adds space between inputs */
    }

    li:last-child {
        margin-bottom: 0px;
    }
    </style>
    <div class="banner">
        <div class="heading container">
            <!-- Can I call get_the_title() here?-->
            <h1 class="text-white">Sign up.</h1>
        </div>
    </div>
    <div class="container control-area">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <form id="signup" method="POST">
                    <p class="form-message"></p>
                    <ul class="form-list">
                        <li><input id="signup-fName" type="text" name="user_first" placeholder="First name" class="form-control" aria-label="small" data-toggle="tooltip" title="Enter your first name"></li>
                        <li><input id="signup-lName" type="text" name="user_last" placeholder="Last name" class="form-control" aria-label="small" data-toggle="tooltip" title="Enter your last name"></li>
                        <li><input id="signup-email" type="text" name="user_email" placeholder="Email" class="form-control" aria-label="small" data-toggle="tooltip" title="Enter your email address"></li>
                        <li><input id="signup-uid" type="text" name="user_uid" placeholder="Username (8 or more letters/numbers)" class="form-control" aria-label="small" data-toggle="tooltip" title="Enter a user name(8 or more letters/numbers)"></li>
                        <li><input id="signup-pw" type="password" name="user_pw" placeholder="Password (8 or more letters/numbers)" class="form-control" aria-label="small" data-toggle="tooltip" title="Enter a password (8 or more letters/numbers)"></li>
                        <li><input id="signup-pw2" type="password" name="user_pw2" placeholder="Confirm password" class="form-control" aria-label="small" data-toggle="tooltip" title="Confirm your password"></li>
                        <li>
                            <select class="form-control selector" id="user_selector" name="user_selector" style="font-size: 22px; height: 100% !important;">
                                <option selected="selected">I am applying as a</option>
                                <option value="student">Student</option>
                                <option value="instructor">Instructor</option>
                            </select>
                        </li>
                        <div class="partB" id="studentPartB" style="display:none;">
                            <li><input id="student-gpa" type="text" name="student_gpa" class="form-control" placeholder="GPA" aria-label="small" data-toggle="tooltip" title="Enter your undergraduate GPA"></li>
                        </div>
                        <br>
                        <div class="partC" id="partC" >
                            <li class="text-center"><button id="signupSubmit" type="submit" name="signupSubmit" class="w-50 btn btn-outline-primary">Sign up</button></li>
                        </div>
                    </ul>
                </form>
                <p class="text-center py-1"><a href="<?php echo get_permalink(get_page_by_path('sign-in')->ID); ?>">Already have an account?</a></p>
            </div>
        </div>
    </div>
<?php
    require 'footer.php';
} else {
    wp_redirect(home_url());
}