<?php 

class webcontroller_default extends http_controller {

    public function default_action($request, $response) {
       	$view = new http_view($request->locale); 
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "pages/homepage.phtml");
		$response->append_body($view->render());
	}

}
