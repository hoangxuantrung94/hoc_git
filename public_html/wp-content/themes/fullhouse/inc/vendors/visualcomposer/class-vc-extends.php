<?php  
 
require_once vc_path_dir('SHORTCODES_DIR', 'vc-posts-grid.php');
class WPBakeryShortCode_PBR_Frontpageposts extends WPBakeryShortCode_VC_Posts_Grid {

}

class WPBakeryShortCode_PBR_Frontpageposts2 extends WPBakeryShortCode_VC_Posts_Grid {

}


class WPBakeryShortCode_PBR_Frontpageposts3 extends WPBakeryShortCode_VC_Posts_Grid {

}


 class WPBakeryShortCode_PBR_Frontpageposts4 extends WPBakeryShortCode_VC_Posts_Grid {

}

class WPBakeryShortCode_PBR_Frontpageposts9 extends WPBakeryShortCode_VC_Posts_Grid {

}

class WPBakeryShortCode_PBR_Frontpageposts12 extends WPBakeryShortCode_VC_Posts_Grid {

}

class WPBakeryShortCode_PBR_Frontpageposts13 extends WPBakeryShortCode_VC_Posts_Grid {

}

class WPBakeryShortCode_PBR_Frontpageposts14 extends WPBakeryShortCode_VC_Posts_Grid {

}

class WPBakeryShortCode_PBR_Timelinepost extends WPBakeryShortCode_VC_Posts_Grid {

}

class WPBakeryShortCode_PBR_Categoriespost extends WPBakeryShortCode_VC_Posts_Grid {

}

class WPBakeryShortCode_PBR_Listpost extends WPBakeryShortCode_VC_Posts_Grid {

}

class WPBakeryShortCode_PBR_Gridposts extends WPBakeryShortCode_VC_Posts_Grid {

}

class WPBakeryShortCode_PBR_Megablogs extends WPBakeryShortCode_VC_Posts_Grid {

}

class WPBakeryShortCode_PBR_Megaposts extends WPBakeryShortCode_VC_Posts_Grid {

}

class WPBakeryShortCode_PBR_slideshopbrst extends WPBakeryShortCode_VC_Posts_Grid {

}

class WPBakeryShortCode_PBR_Counter extends WPBakeryShortCode {

	public function __construct( $settings ) {
		parent::__construct( $settings );
		$this->jsCssScripts();
	}

	public function jsCssScripts() {

		wp_register_style('counterup_js',get_template_directory_uri().'/js/jquery.counterup.min.js',array(),false,true);
	 
	}
}

 

class WPBakeryShortCode_PBR_Frontpageblog extends WPBakeryShortCode_VC_Posts_Grid {}

/**
 * Elements
 */
class WPBakeryShortCode_Pbr_featuredbox  extends WPBakeryShortCode {}
class WPBakeryShortCode_Pbr_pricing 	 extends WPBakeryShortCode {}
class WPBakeryShortCode_Pbr_inforbox 	 extends WPBakeryShortCode {}
class WPBakeryShortCode_Pbr_timeline 	 extends WPBakeryShortCode {}

class WPBakeryShortCode_Pbr_Gallery extends  WPBakeryShortCode {}
/**
 * Themes
 */
class WPBakeryShortCode_Pbr_title_heading   extends WPBakeryShortCode {}
class WPBakeryShortCode_Pbr_Team extends WPBakeryShortCode {}
class WPBakeryShortCode_Pbr_team_list extends WPBakeryShortCode {}
class WPBakeryShortCode_Pbr_verticalmenu extends WPBakeryShortCode {}


class WPBakeryShortCode_Pbr_banner_countdown extends WPBakeryShortCode {}



