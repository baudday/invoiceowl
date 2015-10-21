<?php

namespace App\Lib;

use App\Template;
use App\Client;
use App\Invoice;

class PdfGenerator {

  protected $template;
  protected $html_path;
  protected $pdf_path;
  protected $phantomjs_path;
  protected $script_path;

  public function __construct(Template $template) {
    $this->template = $template;
    $this->html_path = base_path("tmp/" . uniqid('html_template_') . ".html");
    $this->pdf_path = base_path("tmp/" . uniqid('invoice_') . ".pdf");
    $this->phantomjs_path = base_path("node_modules/phantomjs/lib/phantom/bin/phantomjs");
    $this->script_path = base_path("rasterize.js");
  }

  public function generate() {
    exec("$this->phantomjs_path $this->script_path $this->html_path $this->pdf_path Letter");
  }

  public function makeHtml(Client $client, Invoice $invoice, $total) {
    $lineItems = $invoice->lineItems()->get();
    $html = \DbView::make($this->template)
              ->field('body')
              ->with(compact('client', 'invoice', 'total', 'lineItems'))
              ->render();
    file_put_contents($this->html_path, $html);
  }

  public function htmlPath() {
    return $this->html_path;
  }

  public function pdfPath() {
    return $this->pdf_path;
  }
}
