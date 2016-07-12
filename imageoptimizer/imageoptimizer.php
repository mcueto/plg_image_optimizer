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

  function _classifyImages(&$article){
    $images = json_decode($article->images);
    $newImages = array(); //To delete

    $links = [
      "local" => array(),
      "external" => array()
    ];

    foreach ($images as $key => $image) {

      $newImage = $image;

      # TO delete
      if($key=="image_intro_caption"){
        $image= "http://www.google.cl";
      }

      if(!empty($image)){
        if(preg_match("^(http|https)://^", $image)){
          $links["external"][$key] = $image;
        }else{
          $links["local"][$key] = $image;
        }
      }

      $newImages[$key] = $newImage; //To delete
    }

    $article->images = json_encode($newImages);

    return $links;
  }

  function _checkImageConfig($link, $source){
    /*
    TODO:
    0-Check if local or external in order to fix problems
    1-Check if $result is a json config
    */

    $db = JFactory::getDbo();
    // Retrieve the shout
    $query = $db->getQuery(true)
    ->select($db->quoteName('config'))
    ->from($db->quoteName('#__imageoptimizer'))
    ->where('link = ' . $db->Quote($link));
    // Prepare the query
    $db->setQuery($query);
    // Load the row.
    $result = $db->loadResult();

    if($result){
      return true;
    }else{
      return false;
    }
  }

  /**
  * Plugin method with the same name as the event will be called automatically.
  */
  public function onContentPrepare($context, &$article, &$params, $limitstart)
  {
    $links = $this->_classifyImages($article);
    foreach ($links as $kcategory => $category) {
        foreach ($category as $klink => $link) {
          $config = $this->_checkImageConfig($link, $category)
          if($config){
            // replace image
          }else{
            // Create config file
            // replace image
          }
        }
    }

    /*
    TODO:
    0-if exists, replace the image with the smallest copy of it
    0-if doesnt exists, create config, optimize image
    1-add settings to plugin to compress in different sizes(based on json config field)
    */

    return true;
  }

}
?>
