<?php

class Post
{
  public $id;
  public $id_user;
  public $type; // text ou photo
  public $created_at;
  public $body;
  public $mine;
  public $user;
  public $liked;
  public $comments;
  public $likeCount;
}

interface PostDAO
{
  public function insert(Post $p);
  public function getHomeFeed($id_user);
  public function getUserFeed($id_user);
  public function getPhotosFrom($id_user);
}
