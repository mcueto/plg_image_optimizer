<?php
// no direct access
defined( '_JEXEC' ) or die;

class plgContentImageoptimizer extends JPlugin
{
  /**
  * Load the language file on instantiation. Note this is only available in Joomla 3.1 and higher.
  * If you want to support 3.0 series you must override the constructor
  *
  * @var    boolean
  * @since  3.1
  */
  protected $autoloadLanguage = true;

  /**
  * Plugin method with the same name as the event will be called automatically.
  */
  public function onContentPrepare($context, &$article, &$params, $limitstart)
  {
    $images = json_decode($article->images);
    $newImages = array();
    $links = array();

    foreach ($images as $key => $image) {
      $newImage = $image;

      if($key=="image_intro_caption"){
          $image= "http://www.google.cl";
      }

      if(!empty($image)){
        if(preg_match("^(http|https)://^", $image)){
          array_push($links, $image);
        }
      }

      /*
      TODO:
      0-separate and validate links and no-links
      1-check if image config exists(json or database)
      2-if exists, replace the image with the smallest copy of it
      2-if doesnt exists, create config, optimize image and go to step 1
      */

      $newImages[$key] = $newImage;
    }

    $article->images = json_encode($newImages);

    return true;
  }

}
?>
