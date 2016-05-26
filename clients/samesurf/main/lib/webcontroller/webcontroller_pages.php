<?php 

class webcontroller_pages extends http_controller {

    public function default_action($request, $response) {
       	$view = new http_view($request->locale); 
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "pages/homepage.phtml");
		$response->append_body($view->render());
	}
	
	public function homepagenew_action($request, $response) {
       	$view = new http_view($request->locale); 
		$view->setLayout("views/default_layout_alt.phtml");
		$view->setBlock("main", "pages/homepagenew.phtml");
		$response->append_body($view->render());
	}

	public function howitworks_action($request, $response) {
   		$view = new http_view($request->locale); 
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "pages/howitworks.phtml");
		$response->append_body($view->render());
	}
	
	public function tour_howitworks_action($request, $response) {
   		$view = new http_view($request->locale); 
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "pages/tour_howitworks.phtml");
		$response->append_body($view->render());
	}

	public function features_action($request, $response) {
   		$view = new http_view($request->locale); 
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "pages/features.phtml");
		$response->append_body($view->render());
	}

	public function tour_features_action($request, $response) {
   		$view = new http_view($request->locale); 
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "pages/tour_features.phtml");
		$response->append_body($view->render());
	}

	public function faqs_action($request, $response) {
   		$view = new http_view($request->locale); 
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "pages/faqs.phtml");
		$response->append_body($view->render());
	}

	public function whitepapers_action($request, $response) {
   		$view = new http_view($request->locale); 
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "pages/whitepapers.phtml");
		$response->append_body($view->render());
	}

	public function whitepapersdetail_action($request, $response) {
   		$view = new http_view($request->locale); 
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "pages/whitepapersdetail.phtml");
		$response->append_body($view->render());
	}

	public function videos_action($request, $response) {
   		$view = new http_view($request->locale); 
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "pages/videos.phtml");
		$response->append_body($view->render());
	}
	
	public function uses_action($request, $response) {
   		$view = new http_view($request->locale); 
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "pages/uses.phtml");
		$response->append_body($view->render());
	}
	
	public function secondaryuses_action($request, $response) {
   		$view = new http_view($request->locale); 
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "pages/secondaryuses.phtml");
		$response->append_body($view->render());
	}
	
	public function benefits_action($request, $response) {
   		$view = new http_view($request->locale); 
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "pages/benefits.phtml");
		$response->append_body($view->render());
	}
	
		public function team_action($request, $response) {
   		$view = new http_view($request->locale); 
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "pages/team.phtml");
		$response->append_body($view->render());
	}
	
	public function legal_action($request, $response) {
   		$view = new http_view($request->locale); 
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "pages/legal.phtml");
		$response->append_body($view->render());
	}	

	public function contactus_action($request, $response) {
   		$view = new http_view($request->locale); 
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "pages/contactus.phtml");
		$response->append_body($view->render());
	}
	
	public function error404_action($request, $response) {
   		$view = new http_view($request->locale); 
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "pages/error404.phtml");
		$response->append_body($view->render());
	}
	
	public function error500_action($request, $response) {
   		$view = new http_view($request->locale); 
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "pages/error500.phtml");
		$response->append_body($view->render());
	}
	
	public function press_action($request, $response) {
   		$view = new http_view($request->locale); 
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "pages/press.phtml");
		$response->append_body($view->render());
	}
	
	public function jobs_action($request, $response) {
   		$view = new http_view($request->locale); 
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "pages/jobs.phtml");
		$response->append_body($view->render());
	}
	
	public function boardofadvisors_action($request, $response) {
   		$view = new http_view($request->locale); 
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "pages/boardofadvisors.phtml");
		$response->append_body($view->render());
	}

	public function customization_action($request, $response) {
   		$view = new http_view($request->locale); 
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "pages/customization.phtml");
		$response->append_body($view->render());
	}
	
	public function HIWpresentation_action($request, $response) {
   		$view = new http_view($request->locale); 
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "pages/HIWpresentation.phtml");
		$response->append_body($view->render());
	}

	public function browse_action($request, $response) {
   		$view = new http_view($request->locale); 
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "pages/browse.phtml");
		$response->append_body($view->render());
	}
	
	public function browsertesting_action($request, $response) {
   		$view = new http_view($request->locale); 
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "pages/browsertesting.phtml");
		$response->append_body($view->render());
	}
	
	public function collaboration_action($request, $response) {
   		$view = new http_view($request->locale); 
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "pages/collaboration.phtml");
		$response->append_body($view->render());
	}
	
	public function corptraining_action($request, $response) {
   		$view = new http_view($request->locale); 
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "pages/corptraining.phtml");
		$response->append_body($view->render());
	}
	
	public function education_action($request, $response) {
   		$view = new http_view($request->locale); 
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "pages/education.phtml");
		$response->append_body($view->render());
	}
	
	public function forwebsites_action($request, $response) {
   		$view = new http_view($request->locale); 
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "pages/forwebsites.phtml");
		$response->append_body($view->render());
	}
	
	public function marketresearch_action($request, $response) {
   		$view = new http_view($request->locale); 
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "pages/marketresearch.phtml");
		$response->append_body($view->render());
	}
	
	public function medical_action($request, $response) {
   		$view = new http_view($request->locale); 
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "pages/medical.phtml");
		$response->append_body($view->render());
	}
	
	public function meetings_action($request, $response) {
   		$view = new http_view($request->locale); 
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "pages/meetings.phtml");
		$response->append_body($view->render());
	}
	
	public function presentations_action($request, $response) {
   		$view = new http_view($request->locale); 
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "pages/presentations.phtml");
		$response->append_body($view->render());
	}
	
	public function remotecontrol_action($request, $response) {
   		$view = new http_view($request->locale); 
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "pages/remotecontrol.phtml");
		$response->append_body($view->render());
	}
	
	public function sales_action($request, $response) {
   		$view = new http_view($request->locale); 
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "pages/sales.phtml");
		$response->append_body($view->render());
	}
	
	public function search_action($request, $response) {
   		$view = new http_view($request->locale); 
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "pages/search.phtml");
		$response->append_body($view->render());
	}
	
	public function shop_action($request, $response) {
   		$view = new http_view($request->locale); 
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "pages/shop.phtml");
		$response->append_body($view->render());
	}
	
	public function support_action($request, $response) {
   		$view = new http_view($request->locale); 
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "pages/support.phtml");
		$response->append_body($view->render());
	}
	
	public function usabilitytesting_action($request, $response) {
   		$view = new http_view($request->locale); 
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "pages/usabilitytesting.phtml");
		$response->append_body($view->render());
	}
	
	public function watchvideos_action($request, $response) {
   		$view = new http_view($request->locale); 
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "pages/watchvideos.phtml");
		$response->append_body($view->render());
	}
	
	public function technology_action($request, $response) {
   		$view = new http_view($request->locale); 
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "pages/technology.phtml");
		$response->append_body($view->render());
	}
	
	public function security_action($request, $response) {
   		$view = new http_view($request->locale); 
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "pages/security.phtml");
		$response->append_body($view->render());
	}
	
	public function services_action($request, $response) {
   		$view = new http_view($request->locale); 
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "pages/services.phtml");
		$response->append_body($view->render());
	}
	
	public function integration_action($request, $response) {
   		$view = new http_view($request->locale); 
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "pages/integration.phtml");
		$response->append_body($view->render());
	}
	
	public function partners_action($request, $response) {
   		$view = new http_view($request->locale); 
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "pages/partners.phtml");
		$response->append_body($view->render());
	}
	
	public function app_action($request, $response) {
   		$view = new http_view($request->locale); 
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "pages/app.phtml");
		$response->append_body($view->render());
	}
	
	public function chromeosxdl_action($request, $response) {
   		$view = new http_view($request->locale); 
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "pages/chromeosxdl.phtml");
		$response->append_body($view->render());
	}
	
	public function firefoxosxdl_action($request, $response) {
   		$view = new http_view($request->locale); 
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "pages/firefoxosxdl.phtml");
		$response->append_body($view->render());
	}
	
	public function safariosxdl_action($request, $response) {
   		$view = new http_view($request->locale); 
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "pages/safariosxdl.phtml");
		$response->append_body($view->render());
	}
	
	public function chromewindl_action($request, $response) {
   		$view = new http_view($request->locale); 
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "pages/chromewindl.phtml");
		$response->append_body($view->render());
	}
	
	public function iewindl_action($request, $response) {
   		$view = new http_view($request->locale); 
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "pages/iewindl.phtml");
		$response->append_body($view->render());
	}
	
	public function firefoxwindl_action($request, $response) {
   		$view = new http_view($request->locale); 
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "pages/firefoxwindl.phtml");
		$response->append_body($view->render());
	}
	
	public function workflow_action($request, $response) {
   		$view = new http_view($request->locale); 
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "pages/workflow.phtml");
		$response->append_body($view->render());
	}
	
	public function enablesite_action($request, $response) {
   		$view = new http_view($request->locale); 
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "pages/enablesite.phtml");
		$response->append_body($view->render());
	}
	
	public function HIWmobile_action($request, $response) {
   		$view = new http_view($request->locale); 
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "pages/HIWmobile.phtml");
		$response->append_body($view->render());
	}
	
	public function HIWphonesupport_action($request, $response) {
   		$view = new http_view($request->locale); 
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "pages/HIWphonesupport.phtml");
		$response->append_body($view->render());
	}
	
	public function login_action($request, $response) {
   		$view = new http_view($request->locale); 
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "pages/login.phtml");
		$response->append_body($view->render());
	}
	
	public function pricing_action($request, $response) {
   		$view = new http_view($request->locale); 
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "pages/pricing.phtml");
		$response->append_body($view->render());
	}
	
	public function tour_pricing_action($request, $response) {
   		$view = new http_view($request->locale); 
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "pages/tour_pricing.phtml");
		$response->append_body($view->render());
	}

	public function forindividuals_action($request, $response) {
   		$view = new http_view($request->locale); 
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "pages/pricingindividual.phtml");
		$response->append_body($view->render());
	}

	public function forsupportandsales_action($request, $response) {
   		$view = new http_view($request->locale); 
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "pages/pricingsupport.phtml");
		$response->append_body($view->render());
	}

	public function forsiteintegration_action($request, $response) {
   		$view = new http_view($request->locale); 
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "pages/pricingweb.phtml");
		$response->append_body($view->render());
	}
	
	public function publicroomsinfo_action($request, $response) {
   		$view = new http_view($request->locale); 
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "pages/publicroomsinfo.phtml");
		$response->append_body($view->render());
	}
	
		public function requestdemo_action($request, $response) {
   		$view = new http_view($request->locale); 
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "pages/requestdemo.phtml");
		$response->append_body($view->render());
	}
	
	public function signup_action($request, $response) {
   		$view = new http_view($request->locale); 
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "pages/signup.phtml");
		$response->append_body($view->render());
	}
	
	public function different_action($request, $response) {
   		$view = new http_view($request->locale); 
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "pages/different.phtml");
		$response->append_body($view->render());
	}
	
	public function tour_different_action($request, $response) {
   		$view = new http_view($request->locale); 
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "pages/tour_different.phtml");
		$response->append_body($view->render());
	}
	
	public function ss_vs_screenshare_action($request, $response) {
   		$view = new http_view($request->locale); 
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "pages/ss_vs_screenshare.phtml");
		$response->append_body($view->render());
	}
	
	public function livechat_action($request, $response) {
   		$view = new http_view($request->locale); 
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "pages/livechat.phtml");
		$response->append_body($view->render());
	}
	
	public function phonesupport_action($request, $response) {
   		$view = new http_view($request->locale); 
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "pages/phonesupport.phtml");
		$response->append_body($view->render());
	}
	
	public function landing_action($request, $response) {
   		$view = new http_view($request->locale); 
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "pages/landing.phtml");
		$response->append_body($view->render());
	}
	
	public function privaterooms_action($request, $response) {
   		$view = new http_view($request->locale); 
		$view->setLayout("views/default_layout.phtml");
		$view->setBlock("main", "pages/privaterooms.phtml");
		$response->append_body($view->render());
	}

}
