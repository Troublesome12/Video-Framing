<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index() {
		redirect('home/imageFraming');
	}

	public function imageFraming(){
		$this->load->view('imageFraming');
	}

	public function upload(){
		$data = $this->input->post('data');
		$id = $this->input->post('id');
		$imagePath = "./assets/img/$id.png";

		$uri =  substr($data,strpos($data,",")+1);
		file_put_contents($imagePath, base64_decode($uri));

		if(file_exists($imagePath)){
			header("Content-Type: application/force-download");
			header("Content-Disposition: attachment; filename=$imagePath");
			readfile($imagePath);
		}
	}

	public function imageProcessing() {
		$this->load->helper('directory'); 	//load directory helper
		$map = directory_map("assets/img/");	/* This function reads the directory path specified in the first parameter and builds an array representation of it and all its contained files. */
		
		natsort($map);	//sorting datavalue
		$map = array_values($map);	//inserting data to the same array for sorting indexes	

		$this->load->library('image_lib');
		foreach ($map as $imageName) {
			$this->imageWatermarking($imageName);
		}
		
		echo "<div class='container'>
			<h2>Image Processing Is Complete</h2><hr>
			<a href='margeFrames'>Click Here To Marge These Images</a> 
		</div>";
	}

    private function imageWatermarking($imageName) {
        $config['image_library'] 	= 'gd2';
        $config['source_image'] 	= "./assets/img/$imageName";
    	$config['new_image']     	= "./assets/img/$imageName";
        $config['maintain_ratio']   = TRUE;
        $config['wm_overlay_path'] 	= './assets/img/watermark.png';
        $config['wm_type'] 			= 'overlay';
        $config['wm_vrt_alignment'] = 'center';
        $config['wm_hor_alignment'] = 'center';

        $this->image_lib->initialize($config);
        if (!$this->image_lib->watermark()) {
            echo $this->image_lib->display_errors();
        }
        $this->image_lib->clear();
    }

    public function margeFrames() {
    	/*
		FFmpeg Commands
			-i Input File Name
			-an Disabled Audio
			-ss GET Image FROM X Seconds Of The Video
			-s Size Of The Image
		*/
	
		$ffmpeg = "D:\\ffmpeg\\bin\\ffmpeg";
		$imageFile = 'assets/img/%d.png';
		$videoFile = 'assets/out.mp4';

		$cmd = "$ffmpeg -r 2 -i $imageFile -c:v libx264 -vf fps=25,format=yuv420p $videoFile";
		shell_exec($cmd);
    }
}