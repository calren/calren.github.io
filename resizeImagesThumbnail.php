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
        function resize($width, $height) {
            
            if ($this->getHeight() > $this->getWidth()) {
                $new_image = imagecreatetruecolor(400, 600);
                imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, 400, 600, $this->getWidth(), $this->getHeight());
                $new_image2 = imagecreatetruecolor(300, 200);
                imagecopy($new_image2, $new_image, 0, 0, 50, 170, 400, 600);
                $this->image = $new_image2;

            } else {
                    $new_image = imagecreatetruecolor($width, $height);
                    imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
                    $this->image = $new_image;
                }
        }
    }
    // End of SimpleImage class
    // Define the path as relative
    $path = "/Users/Caren/Desktop/summer/";
    
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
            $image->load("summer/".$file);
            $image->resize(300, 200);
            $image->save("summerThumbnails/thumbnail".$numOfPicture.".JPG");
        }
        $numOfPicture = $numOfPicture + 1;
    }
    
    //closing the directory
    closedir($dir_handle);
?>