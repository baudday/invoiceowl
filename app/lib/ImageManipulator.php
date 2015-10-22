<?php

namespace App\Lib;

class ImageManipulator {

  public function __construct() {
    \Cloudinary::config([
      'cloud_name' => getenv('CLOUDINARY_CLOUD_NAME'),
      'api_key' => getenv('CLOUDINARY_API_KEY'),
      'api_secret' => getenv('CLOUDINARY_API_SECRET'),
    ]);
  }

  public function uploadUserLogo($path) {
    return \Cloudinary\Uploader::upload($path, [
      'width' => 200,
      'crop' => 'scale'
    ]);
  }

  public function uploadTemplateThumbnail($path)
  {
    return \Cloudinary\Uploader::upload($path, [
      'width' => 154,
      'height' => 200,
      'crop' => 'thumb'
    ]);
  }

}
