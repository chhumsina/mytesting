<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class App extends Site_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->library('image_lib');
	}

	public function index( )
	{
		$data['page']	= 'app/view';
		$data['action']	= 'Howto';
		$this->load->view('layout/admin',$data);
	}
	public function money(){
		$data['page']	= 'app/view';
		$data['action']	= 'Howto';
		$this->load->view('layout/app',$data);
	}

	public function moneyGame(){
		//$image = "http://graph.facebook.com/".$_POST['use_id']."/picture?redirect=1&height=200&type=normal&width=200";
		//$image = "./uploads/howto/mark.jpg";
		$use_id = $_POST['use_id'];
		$use_name =  $_POST['use_name'];
		$url = 'http://graph.facebook.com/'.$use_id.'/picture?redirect=1&height=130&type=normal&width=130';
		$data = file_get_contents($url);
		$fileName = "./uploads/howto/".$use_id.".jpg";
		$file = fopen($fileName, 'w+');
		fputs($file, $data);
		fclose($file);


		$config['image_library'] = 'gd2';//()

		$config['source_image'] = "./uploads/howto/image1.jpg";
		$config['new_image'] = './uploads/howto/'.$use_id.".jpg";
		$config['wm_overlay_path'] = $fileName;
		$config['quality'] = '90%';
		$config['wm_type'] = 'overlay';
		$config['wm_opacity'] = '100';
		$config['wm_vrt_alignment'] = 'middle';// top, middle, bottom
		$config['wm_hor_alignment'] = 'center';// left, center, right
		$config['wm_vrt_offset'] = '0';//??
		$config['wm_hor_offset'] = '0';//??

		$this->image_lib->initialize($config);
		$this->image_lib->watermark();

		$config['wm_text'] = $use_name;
		$config['wm_type'] = 'text';
		$config['source_image'] = './uploads/howto/'.$use_id.".jpg";
		$config['wm_font_path'] = './system/fonts/texb.ttf';
		$config['new_image'] = './uploads/howto/'.$use_id.".jpg";
		$config['wm_font_size'] = '46';
		$config['wm_font_color'] = '000000';
		$config['wm_vrt_alignment'] = 'bottom';
		$config['wm_hor_alignment'] = 'center';
		$config['wm_padding'] = '20';

		$this->image_lib->initialize($config);
		$this->image_lib->watermark();

	}

}