<?php
namespace Admin\Controller;
use Common\Controller\AdminBaseController;

class IndexController extends AdminBaseController {
    public function index() {
        $this->display();
    }
}