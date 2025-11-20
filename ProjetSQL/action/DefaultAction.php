<?php
declare(strict_types=1);
namespace sql\action;
class DefaultAction extends Action {
    public function execute() {
        print("L'action que vous avez choisi semble être incorrect <br>");
    }
}