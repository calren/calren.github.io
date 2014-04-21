<?php
    
    class SimpleImage {
        var $image;
        var $image_type;
        
        function load($filename) {
            $image_info = getimagesize($filename);
            $this->image_type = $image_info[2];
            if( $this->image_type == IMAGETYPE_JPEG ) {
                $this->image = imagecreatefromjpeg($filename);
            } elseif( $this->image_type == IMAGETYPE_GIF ) {
                $this->image = imagecreatefromgif($filename);
            } elseif( $this->image_type == IMAGETYPE_PNG ) {
                $this->image = imagecreatefrompng($filename);
            }
        }
        function save($filename, $image_type=IMAGETYPE_JPEG, $compression=75, $permissions=null) {
            if( $image_type == IMAGETYPE_JPEG ) {
                imagejpeg($this->image,$filename,$compression);
            } elseif( $image_type == IMAGETYPE_GIF ) {
                imagegif($this->image,$filename);
            } elseif( $image_type == IMAGETYPE_PNG ) {
                imagepng($this->image,$filename);
            }
            if( $permissions != null) {
                chmod($filename,$permissions);
            }
        }
        function output($image_type=IMAGETYPE_JPEG) {
            if( $image_type == IMAGETYPE_JPEG ) {
                imagejpeg($this->image);
            } elseif( $image_type == IMAGETYPE_GIF ) {
                imagegif($this->image);
            } elseif( $image_type == IMAGETYPE_PNG ) {
                imagepng($this->image);
            }
        }
        function getWidth() {
            return imagesx($this->image);
        }
        function getHeight() {
            return imagesy($this->image);
        }
        function resizeToHeight($height) {
            $ratio = $height / $this->getHeight();
            $width = $this->getWidth() * $ratio;
            $this->resize($width,$height);
        }
        function resizeToWidth($width) {
            $ratio = $width / $this->getWidth();
            $height = $this->getheight() * $ratio;
            $this->resize($width,$height);
        }
        function scale($scale) {
            $width = $this->getWidth() * $scale/100;
            $height = $this->getheight() * $scale/100;
            $this->resize($width,$height);
        }
        function resize($width) {
            
            if ($this->getHeight() > $this->getWidth()) {
                $height = $width;
                $width = ($height/$this->getHeight()) * $this->getWidth();
                $new_image = imagecreatetruecolor($width, $height);
                imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
                $this->image = $new_image;

            } else {
                $height = ($width/$this->getWidth()) * $this->getHeight();
                $new_image = imagecreatetruecolor($width, $height);
                imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
                $this->image = $new_image;
                }
        }
    }
    // End of SimpleImage class
    // Define the path as relative
    $path = "/Users/Caren/Desktop/spain/";
    
    // Using the opendir function
    $dir_handle = @opendir($path) or die("ERROR: Cannot open  <b>$path</b>");
    
    echo("Directory Listing of $path<br/>");
    
    $numOfPicture = 1;
    //running the while loop
    while ($file = readdir($dir_handle))
    {
        if($file != "." && $file != "..")
        {
            $image = new SimpleImage();
            $image->load("spain/".$file);
            $image->resize(1200, 979);
            $image->save("spainPictures/".$numOfPicture.".JPG");
        }
        $numOfPicture = $numOfPicture + 1;
    }
    
    //closing the directory
    closedir($dir_handle);
?>