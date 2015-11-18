<?php

namespace App\Lib;

class TemplateComposer {

  private $template;

  public function __construct(\App\Template $template)
  {
    $this->template = $template;
    $this->layout = $this->base_layout();
  }

  /**
   * Composes and returns html from template body
   *
   **/
  public function compose()
  {
    $sections = $this->getSections();
    foreach ($sections as $section => $content) {
      $this->replaceSection($section, $content);
    }

    $blocks = $this->getBlocks();
    foreach ($blocks as $block) {
      $this->replaceBlock($block);
    }

    $loops = $this->getLoops();
    foreach ($loops as $loop => $content) {
      $this->replaceLoop($loop);
      $this->replaceLoopBody($loop, $content);
    }

    $elements = $this->getElements();
    foreach ($elements as $element) {
      $this->replaceElement($element);
    }

    $this->template->html = $this->layout;

  }

  private function base_layout()
  {
    return file_get_contents(base_path() . '/resources/views/layouts/template.blade.php');
  }

  private function getSections()
  {
    $ret = [];
    preg_match_all('/{% ?section\(\'(\w+)\'\) ?%}(.+){% ?stop ?%}/sU', $this->template->body, $matches);
    foreach ($matches[1] as $key=>$match) {
      $ret[$match] = $matches[2][$key];
    }
    return $ret;
  }

  private function replaceSection($section, $content)
  {
    $this->layout = preg_replace("/@yield\(\'$section\'\)/", $content, $this->layout);
  }

  private function getBlocks()
  {
    $ret = [];
    preg_match_all('/{% ?(\w+)_block ?%}/U', $this->layout, $matches);
    return $matches[1];
  }

  private function replaceBlock($block)
  {
    $content = $this->getBlockContent($block);
    $this->layout = preg_replace("/{% ?{$block}_block ?%}/U", $content, $this->layout);
  }

  private function getBlockContent($block)
  {
    // return empty string if the file doesn't exist
    return @file_get_contents(base_path() . "/resources/views/templates/blocks/$block.blade.php") ?: "";
  }

  private function getElements()
  {
    $ret = [];
    preg_match_all("/{% ?(?!\w+_block|stop|endloop)(\w+) ?%}/U", $this->layout, $matches);
    return $matches[1];
  }

  private function replaceElement($element)
  {
    $content = $this->getElementContent($element);
    $this->layout = preg_replace("/{% ?$element ?%}/U", $content, $this->layout);
  }

  private function getElementContent($element)
  {
    return @file_get_contents(base_path() . "/resources/views/templates/elements/$element.blade.php") ?: "";
  }

  private function getLoops()
  {
    $ret = [];
    preg_match_all("/{% ?loop (\w+) ?%}(.*){% ?endloop ?%}/sU", $this->layout, $matches);
    foreach ($matches[1] as $key => $match) {
      $ret[$match] = $matches[2][$key];
    }
    return $ret;
  }

  public function replaceLoop($loop)
  {
    $content = $this->getLoopContent($loop);
    $this->layout = preg_replace("/{% ?loop $loop ?%}.*{% ?endloop ?%}/sU", $content, $this->layout);
  }

  private function replaceLoopBody($loop, $content)
  {
    $this->layout = preg_replace("/{% ?yield\(\'$loop\'\) ?%}/", $content, $this->layout);
  }

  public function getLoopContent($loop)
  {
    return @file_get_contents(base_path() . "/resources/views/templates/loops/$loop.blade.php") ?: "";
  }

}
