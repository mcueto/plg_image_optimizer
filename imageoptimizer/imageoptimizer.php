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

  function _classifyImage($image){
    return preg_match("^(http|https)://^", $image);
  }

  function _optimizeImage($image){
    $imageList = array();

    /*TODO: optimize and create every size of image*/
    array_push($imageList,["min","$image"]);

    return $imageList;

  }

  function _createImageConfig($link){
    return true;
  }

  function _checkImageConfig($link){
    /*
    TODO:
    -Check if $result is a json config
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
      return $result;
    }else{
      return false;
    }
  }

  /*
  TODO: validate if a image configuration exists or not
  */
  function _replaceImage(&$image, $config, $quality = 'min'){
    $config = json_decode($config);
    foreach ($config->{"qualities"} as $eq) {
      $image = $eq->{$quality};
      // echo($image);
    }
    return true;
  }

  /**
  * Plugin method with the same name as the event will be called automatically.
  */
  public function onContentPrepare($context, &$article, &$params, $limitstart)
  {
    $images = json_decode($article->images);
    foreach ($images as $key => &$image) {
      $config = $this->_checkImageConfig($image);
      if($config){
        $this->_replaceImage($image, $config, "min");
      }else{
        $imageList  = $this->_optimizeImage($image);
        // $config     = $this->_createImageConfig($imageList);
        // $this->_replaceImage($image, $config, "min");
      }
    }
    $article->images  = json_encode($images);

    /*
    TODO:
    0-if doesnt exists, create config, optimize image
    1-add settings to plugin to compress in different sizes(based on json config field)
    */

    return true;
  }

}
?>
