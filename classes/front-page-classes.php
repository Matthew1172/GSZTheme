<?php
class ClassReview
{
    public $comment_post_id;
    public $comment_author;
    public $class_rating;

    /**
     * Get the value of comment_post_id
     */
    public function getComment_post_id()
    {
        return $this->comment_post_id;
    }

    /**
     * Set the value of comment_post_id
     *
     * @return  self
     */
    public function setComment_post_id($comment_post_id)
    {
        $this->comment_post_id = $comment_post_id;

        return $this;
    }

    /**
     * Get the value of comment_author
     */
    public function getComment_author()
    {
        return $this->comment_author;
    }

    /**
     * Set the value of comment_author
     *
     * @return  self
     */
    public function setComment_author($comment_author)
    {
        $this->comment_author = $comment_author;

        return $this;
    }

    /**
     * Get the value of class_rating
     */
    public function getClass_rating()
    {
        return $this->class_rating;
    }

    /**
     * Set the value of class_rating
     *
     * @return  self
     */
    public function setClass_rating($class_rating)
    {
        $this->class_rating = $class_rating;

        return $this;
    }
}

class ClassInfo
{
    public $post_ID;
    public $post_class_name;

    /**
     * Get the value of post_ID
     */
    public function getPost_ID()
    {
        return $this->post_ID;
    }

    /**
     * Set the value of post_ID
     *
     * @return  self
     */
    public function setPost_ID($post_ID)
    {
        $this->post_ID = $post_ID;

        return $this;
    }

    /**
     * Get the value of post_class_name
     */
    public function getPost_class_name()
    {
        return $this->post_class_name;
    }

    /**
     * Set the value of post_class_name
     *
     * @return  self
     */
    public function setPost_class_name($post_class_name)
    {
        $this->post_class_name = $post_class_name;

        return $this;
    }
}

class ClassRating
{
    public $class_id;
    public $class_name;
    public $class_rating;

    /**
     * Get the value of class_id
     */ 
    public function getClass_id()
    {
        return $this->class_id;
    }

    /**
     * Set the value of class_id
     *
     * @return  self
     */ 
    public function setClass_id($class_id)
    {
        $this->class_id = $class_id;

        return $this;
    }

    /**
     * Get the value of class_name
     */ 
    public function getClass_name()
    {
        return $this->class_name;
    }

    /**
     * Set the value of class_name
     *
     * @return  self
     */ 
    public function setClass_name($class_name)
    {
        $this->class_name = $class_name;

        return $this;
    }

    /**
     * Get the value of class_rating
     */ 
    public function getClass_rating()
    {
        return $this->class_rating;
    }

    /**
     * Set the value of class_rating
     *
     * @return  self
     */ 
    public function setClass_rating($class_rating)
    {
        $this->class_rating = $class_rating;

        return $this;
    }
}

class ClassAverageRating
{
    public $class_id;
    public $class_name;
    public $average_rating;

    /**
     * Get the value of class_name
     */ 
    public function getClass_name()
    {
        return $this->class_name;
    }

    /**
     * Set the value of class_name
     *
     * @return  self
     */ 
    public function setClass_name($class_name)
    {
        $this->class_name = $class_name;

        return $this;
    }

    /**
     * Get the value of average_rating
     */ 
    public function getAverage_rating()
    {
        return $this->average_rating;
    }

    /**
     * Set the value of average_rating
     *
     * @return  self
     */ 
    public function setAverage_rating($average_rating)
    {
        $this->average_rating = $average_rating;

        return $this;
    }

    /**
     * Get the value of class_id
     */ 
    public function getClass_id()
    {
        return $this->class_id;
    }

    /**
     * Set the value of class_id
     *
     * @return  self
     */ 
    public function setClass_id($class_id)
    {
        $this->class_id = $class_id;

        return $this;
    }
}