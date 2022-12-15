#!/usr/bin/php
<?php

function addNonEnterpriseVerticalToExistingClient($ppvertical_id,$subvertical_id,$version_id,$client_id,$logo="",$mobilelogo="",
                                        $origvertical_id="",$origsubvertical_id="",$origversion_id="",$origleadpop_type_id="", $origleadpop_template_id="",
										$origleadpop_id="",$origleadpop_version_id="",$origleadpop_version_seq="") {
		global $xzdb;
		global $globallogosrc;
		global $globalfavicon_dst;
		global $globallogo_color;
		global $globalcolored_dot;
		global $thissub_domain;
		global $thistop_domain;
		global$leadpoptype;

//		$bigvertical_id = $vertical_id;
//		print("dd" . $vertical_id);
//		print("dd" . $bigvertical_id);
       require_once '/var/www/vhosts/launch.leadpops.com/external/Image.php';
       require_once '/var/www/vhosts/launch.leadpops.com/external/Client.php';

	   $section = substr($client_id,0,1);

		if ($ppvertical_id == "1") {
			$vertical = "insurance";
		}
		else if ($ppvertical_id == "3") {
			$vertical = "mortgage";
		}
		else if ($ppvertical_id == "5") {
			$vertical = "realestate";
		}


		$s = "select * from clients where client_id = " . $client_id;
		$client = $xzdb->fetchRow($s);
		$client ['company_name'] = ucfirst(strtolower($client ['company_name']));
		$enteredEmail = $client["contact_email"]; // use this to look up in IFS
		$freeTrialBuilderAnswers = array("emailaddress" => $client["contact_email"],"phonenumber" => $client["phone_number"]);

         $generatecolors = false;
         if ($logo == "" && $mobilelogo == "") { // inother words use defaults for logo and mobile logo
			$useUploadedLogo = false;
		    $default_background_changed = "n";
		 }
         else if ($logo != "" && $mobilelogo != "" && $origleadpop_type_id != "" && $origleadpop_template_id != "" && $origleadpop_id != "" && $origleadpop_version_id !="" && $origleadpop_version_seq !="") {
		     $default_background_changed = "y";
             $generatecolors = false;  // in other workds use existing logo and mobile logo and copy them to new funnel as if no upload was done
		     $useUploadedLogo = true;
		 }
         else if ($logo != "" && $mobilelogo == "" && $origleadpop_type_id == "" && $origleadpop_template_id == "" && $origleadpop_id == "" && $origleadpop_version_id =="" && $origleadpop_version_seq =="") {
		    $default_background_changed = "y";
            $generatecolors = true;  // in other words act as if a new logo was uploaded & generate mobile logo
			$useUploadedLogo = true;
		 }

		$s = "select * from trial_launch_defaults where leadpop_vertical_id = " . $ppvertical_id;
//		print($s);
		$trialDefaults = $xzdb->fetchAll($s);

		//var_dump($trialDefaults[0]);
	//	die();
		for ($zz=0; $zz < count($trialDefaults); $zz++ ) {
//start *********************************************


        if ($generatecolors == false && $useUploadedLogo == false) { // not uploaded logo or have previous funnel to use

//			$s = "select * from trial_launch_defaults where leadpop_vertical_id = " . $vertical_id . " and leadpop_vertical_sub_id = " . $subvertical_id . " and leadpop_version_id = " . $version_id . " limit 1 ";
//			$trialDefaults = $xzdb->fetchAll($s);
			$s = "select * from default_swatches where active = 'y' order by id ";
			$finalTrialColors = $xzdb->fetchAll($s);
            $background_css = "linear-gradient(to bottom, rgba(108, 124, 156, 0.99) 0%, rgba(108, 124, 156, 0.99) 100%)";

 	        $cmd = '/bin/cp  /var/www/vhosts/launch.leadpops.com/trial/classiclogos/' . $trialDefaults[$zz]["logo_name_mobile"] . '  /var/www/vhosts/itclixmobile.com/css/'.str_replace(" ","",$trialDefaults[$zz]["subvertical_name"]).$trialDefaults[$zz]["leadpop_version_id"] . '/themes/images/' . $client_id . 'grouplogo.png';
            exec($cmd);

  		    $s = "select * from leadpops_verticals where id = " . $trialDefaults[$zz]["leadpop_vertical_id"];
		    $vertres = $xzdb->fetchRow ( $s );
		    $verticalName = $vertres ['lead_pop_vertical'];

			$s = "select * from leadpops_verticals_sub where leadpop_vertical_id  = " . $trialDefaults[$zz]["leadpop_vertical_id"];
			$s .= " and id = " . $trialDefaults[$zz]["leadpop_vertical_sub_id"];
			$subvertres = $xzdb->fetchRow ( $s );
			$subverticalName = $subvertres ['lead_pop_vertical_sub'];

			$logosrc = getHttpServer () . '/images/' . strtolower(str_replace(" ","",$verticalName)) . '/' . strtolower(str_replace(" ","",$subverticalName)). '_logos/' .$trialDefaults[$zz]["logo_name"];
		    insertDefaultClientUploadLogo($logosrc,$trialDefaults[$zz],$client_id);
		    $imgsrc = insertClientDefaultImage($trialDefaults[$zz],$client_id);


		}
        else if ($generatecolors == false && $useUploadedLogo == true) { // get colors from leadpops_background_swatches

				$s = "select * from leadpop_background_swatches ";
				$s .= " where  client_id = " . $client_id;
				$s .= " and leadpop_vertical_id = " . $origvertical_id;
				$s .= " and leadpop_vertical_sub_id = " . $origsubvertical_id;
				$s .= " and leadpop_type_id  = " . $origleadpop_type_id;
				$s .= " and leadpop_template_id = " . $origleadpop_template_id;
				$s .= " and  leadpop_id = " . $origleadpop_id;
				$s .= " and leadpop_version_id = " . $origleadpop_version_id;
				$s .= " and leadpop_version_seq = " . $origleadpop_version_seq;
				$finalTrialColors = $xzdb->fetchAll($s);


				for($t = 0; $t < count($finalTrialColors); $t++) {
					$s = "insert into leadpop_background_swatches (id,client_id,leadpop_vertical_id,";
					$s .= "leadpop_vertical_sub_id,leadpop_type_id,leadpop_template_id,";
					$s .= "leadpop_id,leadpop_version_id,leadpop_version_seq,";
					$s .= "swatch,is_primary,active) values (null,";
					$s .= $client_id . "," . $trialDefaults[$zz]["leadpop_vertical_id"] . ",";
					$s .= $trialDefaults[$zz]["leadpop_vertical_sub_id"] . ",";
					$s .= $leadpoptype . "," . $trialDefaults[$zz]['leadpop_template_id'] . ",";
					$s .= $trialDefaults[$zz]["leadpop_id"] . ",";
					$s .= $trialDefaults[$zz]["leadpop_version_id"] . ",";
					$s .= $trialDefaults[$zz]["leadpop_version_seq"] . ",";
					$s .= "'" . $finalTrialColors[$t]["swatch"] . "','".$finalTrialColors[$t]["is_primary"]."',";
					$s .= "'y')";
					$xzdb->query($s);
				}

				$s = "select background_color from leadpop_background_color ";
				$s .= " where  client_id = " . $client_id;
				$s .= " and leadpop_version_id = " . $origleadpop_version_id;
				$s .= " and leadpop_version_seq = " . $origleadpop_version_seq . " limit 1 ";
				$background_css = $xzdb->fetchOne($s);

				$s = "insert into leadpop_background_color (id,client_id,leadpop_vertical_id,";
				$s .= "leadpop_vertical_sub_id,leadpop_type_id,leadpop_template_id,";
				$s .= "leadpop_id,leadpop_version_id,leadpop_version_seq,";
				$s .= "background_color,active,default_changed) values (null,";
				$s .= $client_id . "," . $trialDefaults[$zz]["leadpop_vertical_id"] . ",";
				$s .= $trialDefaults[$zz]["leadpop_vertical_sub_id"] . ",";
				$s .= $leadpoptype . "," . $trialDefaults[$zz]['leadpop_template_id'] . ",";
				$s .= $trialDefaults[$zz]["leadpop_id"] . ",";
				$s .= $trialDefaults[$zz]["leadpop_version_id"] . ",";
				$s .= $trialDefaults[$zz]["leadpop_version_seq"] . ",";
				$s .= "'" . addslashes($background_css) . "','y','".$default_background_changed."')";
				$xzdb->query($s);

				$s = "select logo_color  from leadpop_logos ";
				$s .= " where  client_id = " . $client_id;
				$s .= " and leadpop_vertical_id = " . $origvertical_id;
				$s .= " and leadpop_vertical_sub_id = " . $origsubvertical_id;
				$s .= " and leadpop_type_id  = " . $origleadpop_type_id;
				$s .= " and leadpop_template_id = " . $origleadpop_template_id;
				$s .= " and  leadpop_id = " . $origleadpop_id;
				$s .= " and leadpop_version_id = " . $origleadpop_version_id;
				$s .= " and leadpop_version_seq = " . $origleadpop_version_seq . " limit 1 ";
				$colors = $xzdb->fetchAll($s);

//			$s = "select * from trial_launch_defaults where leadpop_vertical_id = " . $vertical_id . " and leadpop_vertical_sub_id = " . $subvertical_id . " and leadpop_version_id = " . $version_id . " limit 1 ";
//			$trialDefaults = $xzdb->fetchAll($s);

             // copy logo to new logo name
			  $logopath = '/var/www/vhosts/myleads.leadpops.com/images/clients/'.$section.'/'.$client_id.'/logos/';
			  $origlogo = $logopath . $logo;
			  $newlogoname = strtolower($client_id."_".$trialDefaults[$zz]["leadpop_id"]."_".$trialDefaults[$zz]["leadpop_type_id"]."_".$trialDefaults[$zz]["leadpop_vertical_id"]."_".$trialDefaults[$zz]["leadpop_vertical_sub_id"]."_".$trialDefaults[$zz]["leadpop_template_id"]."_".$trialDefaults[$zz]["leadpop_version_id"]."_".$trialDefaults[$zz]["leadpop_version_seq"]."_".$logo);
			  $newlogo = $logopath . $newlogoname;
			  $cmd = '/bin/cp  ' .$origlogo . '   ' . $newlogo;
			  exec($cmd);

			  // copy mobile logo to new name
			$s = "select include_path from mobile_paths where leadpop_id = " . $origleadpop_id . " limit 1 ";
			$origDestinationDirectory = $xzdb->fetchOne($s);
			$origCopyDestinationDirectoryFile   = "/var/www/vhosts/itclixmobile.com" .$origDestinationDirectory . $mobilelogo;

			$s = "select include_path from mobile_paths where leadpop_id = " . $trialDefaults[$zz]["leadpop_id"] . " limit 1 ";
			$DestinationDirectory = $xzdb->fetchOne($s);
		    $newmobilelogo = $client_id . "grouplogo.png";
			$CopyDestinationDirectoryFile = "/var/www/vhosts/itclixmobile.com" . $DestinationDirectory . $newmobilelogo;
		    $cmd = '/bin/cp  ' . $origCopyDestinationDirectoryFile . '   ' . $CopyDestinationDirectoryFile;
		    exec($cmd);

		   $oldfilename = strtolower($client_id."_".$origleadpop_id."_".$origleadpop_type_id."_".$origvertical_id."_".$origsubvertical_id."_".$origleadpop_template_id."_".$origleadpop_version_id."_".$origleadpop_version_seq);
	       $newfilename = $client_id."_".$trialDefaults[$zz]["leadpop_id"]."_1_".$trialDefaults[$zz]["leadpop_vertical_id"]."_".$trialDefaults[$zz]["leadpop_vertical_sub_id"]."_".$trialDefaults[$zz]['leadpop_template_id']."_".$trialDefaults[$zz]["leadpop_version_id"]."_".$trialDefaults[$zz]["leadpop_version_seq"];

		   $origfavicon_dst_src = '/var/www/vhosts/myleads.leadpops.com/images/clients/'. substr($client_id,0,1) . '/' . $client_id.'/logos/'.$oldfilename.'_favicon-circle.png';
		   $newfavicon_dst_src = '/var/www/vhosts/myleads.leadpops.com/images/clients/'. substr($client_id,0,1) . '/' . $client_id.'/logos/'.$newfilename.'_favicon-circle.png';
		   $cmd = '/bin/cp  ' . $origfavicon_dst_src . '   ' . $newfavicon_dst_src;
		   exec($cmd);

		   $origcolored_dot_src = '/var/www/vhosts/myleads.leadpops.com/images/clients/'. substr($client_id,0,1) . '/' . $client_id.'/logos/'.$oldfilename.'_dot_img.png';
		   $newcolored_dot_src = '/var/www/vhosts/myleads.leadpops.com/images/clients/'. substr($client_id,0,1) . '/' . $client_id.'/logos/'.$newfilename.'_dot_img.png';

		   $cmd = '/bin/cp  ' . $origcolored_dot_src . '   ' . $newcolored_dot_src;
		   exec($cmd);

		  $logosrc = newinsertClientUploadLogo($newlogoname,$trialDefaults[$zz],$client_id);
		  $imgsrc = insertClientNotDefaultImage($trialDefaults[$zz],$client_id,$origleadpop_id,$origleadpop_type_id,$origvertical_id,$origsubvertical_id,$origleadpop_template_id,$origleadpop_version_id,$origleadpop_version_seq);

		  $globallogosrc = $logosrc;
		  $globalfavicon_dst = $newfavicon_dst_src;
		  $globallogo_color = $colors[0]["logo_color"];
		  $globalcolored_dot = $newcolored_dot_src;

            // set mobile logo varibale
		  $origlogo = "";
		  $newlogo = "";
          $newlogoname = "";
		  $logopath  = "";
          $origcolored_dot_src = "";
		  $newcolored_dot_src = "";

		}
        else if ($generatecolors == true && $useUploadedLogo == true) { //

//			$s = "select * from trial_launch_defaults where leadpop_vertical_id = " . $vertical_id . " and leadpop_vertical_sub_id = " . $subvertical_id . " and leadpop_version_id = " . $version_id . " limit 1 ";
//			$trialDefaults = $xzdb->fetchAll($s);
          $logopath = '/var/www/vhosts/myleads.leadpops.com/images/clients/'.$section.'/'.$client_id.'/logos/';
		  $origlogo = $logopath . $logo;
          $newlogoname = strtolower($client_id."_".$trialDefaults[$zz]["leadpop_id"]."_".$trialDefaults[$zz]["leadpop_type_id"]."_".$trialDefaults[$zz]["leadpop_vertical_id"]."_".$trialDefaults[$zz]["leadpop_vertical_sub_id"]."_".$trialDefaults[$zz]["leadpop_template_id"]."_".$trialDefaults[$zz]["leadpop_version_id"]."_".$trialDefaults[$zz]["leadpop_version_seq"]."_".$logo);

		  $newlogo = $logopath . $newlogoname;

          $cmd = '/bin/cp  ' .$origlogo . '   ' . $newlogo;
          exec($cmd);

          $oclient = new Client();

		  //print($newlogo . "\r\n");

          $gis    = getimagesize($newlogo);
          $ow = $gis[0];
          $oh = $gis[1];
          $type = $gis[2];
         //die($type.' type');
          switch($type)
          {
                case "1":
                	$im = imagecreatefromgif($newlogo);
                	$image = $oclient->loadGif($newlogo);
          			$logo_color = $image->extract();
                break;
                case "2":
                	$im = imagecreatefromjpeg($newlogo);
                	$image = $oclient->loadJpeg($newlogo);
                	$logo_color = $image->extract();
                	break;
                case "3":
                	$im = imagecreatefrompng($newlogo);
                	$image = $oclient->loadPng($newlogo);
          			$logo_color = $image->extract();
                	break;
                default:  $im = imagecreatefromjpeg($newlogo);
          }


          if(is_array($logo_color)){
          	$logo_color = $logo_color[0];
          }

          $imagetype = image_type_to_mime_type($type);
          if($imagetype != 'image/jpeg' && $imagetype != 'image/png' &&  $imagetype != 'image/gif' ) {
              return 'bad' ;
          }

          $s = "insert into leadpop_logos (id,client_id,leadpop_id,leadpop_type_id,";
          $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,";
          $s .= "leadpop_version_id,leadpop_version_seq,use_default,";
          $s .= "logo_src,use_me,numpics,logo_color,ini_logo_color) values (null,";
          $s .= $client_id.",".$trialDefaults[$zz]["leadpop_id"].",".$trialDefaults[$zz]["leadpop_type_id"].",".$trialDefaults[$zz]["leadpop_vertical_id"].",".$trialDefaults[$zz]["leadpop_vertical_sub_id"].",";
          $s .= $trialDefaults[$zz]["leadpop_template_id"].",".$trialDefaults[$zz]["leadpop_version_id"].",".$trialDefaults[$zz]["leadpop_version_seq"].",";
          $s .= "'n','".$newlogoname."','y',1, '".$logo_color."','".$logo_color."') ";
          $xzdb->query($s);

		  $logosrc = getHttpAdminServer().'/images/clients/'. substr($client_id,0,1) . '/' . $client_id.'/logos/'. $newlogoname;

			$image_location = "/var/www/vhosts/itclix.com/images/dot-img.png";
			$favicon_location = "/var/www/vhosts/itclix.com/images/favicon-circle.png";
			$favicon_dst_src = '/var/www/vhosts/myleads.leadpops.com/images/clients/'. $section . '/' . $client_id.'/logos/'.$newlogoname.'_favicon-circle.png';
			$colored_dot_src = '/var/www/vhosts/myleads.leadpops.com/images/clients/'. $section . '/' . $client_id.'/logos/'.$newlogoname.'_dot_img.png';

			if (isset($logo_color) && $logo_color != "" ) {
				$new_clr = hex2rgb($logo_color);
			}

			$im = imagecreatefrompng($image_location);
			$myRed =  $new_clr[0];
			$myGreen =  $new_clr[1];
			$myBlue =  $new_clr[2];

			colorizeBasedOnAplhaChannnel( $image_location, $myRed, $myGreen, $myBlue, $colored_dot_src);
			colorizeBasedOnAplhaChannnel( $favicon_location, $myRed, $myGreen, $myBlue, $favicon_dst_src);

		    $colored_dot = getHttpAdminServer().'/images/clients/'. substr($client_id,0,1) . '/' . $client_id.'/logos/'.$newlogoname.'_dot_img.png';
		    $favicon_dst = getHttpAdminServer().'/images/clients/'. substr($client_id,0,1) . '/' . $client_id.'/logos/'.$newlogoname.'_favicon-circle.png';

		  	$swatches =   "213-230-229#23-177-163#159-182-183#65-88-96#110-158-159#132-212-204" ;

		  	$result = explode("#",$swatches);
		  	$new_color = hex2rgb($logo_color);
		  	$index = 0;
        	array_unshift($result, implode('-', $new_color));

        	// SET BACKGROUND COLOR
        	$background_from_logo = '/*###>*/background-color: rgba('.$new_color[0].', '.$new_color[1].', '.$new_color[2].', 1);/*@@@*/
			background-image: linear-gradient(to right bottom,rgba('.$new_color[0].', '.$new_color[1].', '.$new_color[2].', 1) 0%,rgba('.$new_color[0].', '.$new_color[1].', '.$new_color[2].', 1) 100%); /* W3C */';

			$s = "insert into leadpop_background_color (id,client_id,leadpop_vertical_id,";
			$s .= "leadpop_vertical_sub_id,leadpop_type_id,leadpop_template_id,";
			$s .= "leadpop_id,leadpop_version_id,leadpop_version_seq,";
			$s .= "background_color,active,default_changed) values (null,";
			$s .= $client_id . "," . $trialDefaults[$zz]["leadpop_vertical_id"] . ",";
			$s .= $trialDefaults[$zz]["leadpop_vertical_sub_id"] . ",";
			$s .= $trialDefaults[$zz]["leadpop_type_id"] . "," . $trialDefaults[$zz]["leadpop_template_id"] . ",";
			$s .= $trialDefaults[$zz]["leadpop_id"] . ",";
			$s .= $trialDefaults[$zz]["leadpop_version_id"] . ",";
			$s .= $trialDefaults[$zz]["leadpop_version_seq"] . ",";
			$s .= "'" . addslashes($background_from_logo) . "','y','y')";
			$xzdb->query($s);

			foreach($result as $key => $value) {

				  	list($red,$green,$blue) = explode("-",$value);

					if($key<1){
						$str0 = "linear-gradient(to bottom, rgba(".$red.",".$green.",".$blue.",1.0) 0%,rgba(".$red.",".$green.",".$blue.",1.0) 100%)";
					}else{
						$str0 = "linear-gradient(to bottom, rgba(".$red.",".$green.",".$blue.",1.0) 0%,rgba(".$red.",".$green.",".$blue.",.7) 100%)";
					}

					$str1 = "linear-gradient(to top, rgba(".$red.",".$green.",".$blue.",1.0) 0%,rgba(".$red.",".$green.",".$blue.",.7) 100%)";
				    $str2 = "linear-gradient(to bottom right, rgba(".$red.",".$green.",".$blue.",1.0) 0%,rgba(".$red.",".$green.",".$blue.",.7) 100%)";
				    $str3 = "linear-gradient(to bottom, rgba(".$red.",".$green.",".$blue.",1.0) 0%,rgba(".$red.",".$green.",".$blue.",1.0) 100%)";

			  		$swatches = array($str0,$str1,$str2,$str3);
			      	for($i=0;  $i<4; $i++) {
			      		$index++;
			      		$is_primary = 'n';
			      		if($index==1){
			      			$is_primary = 'y';
			      		}

						$s = "insert into leadpop_background_swatches (id,client_id,leadpop_vertical_id,";
						$s .= "leadpop_vertical_sub_id,leadpop_type_id,leadpop_template_id,";
						$s .= "leadpop_id,leadpop_version_id,leadpop_version_seq,";
						$s .= "swatch,is_primary,active) values (null,";
						$s .= $client_id . "," . $trialDefaults[$zz]["leadpop_vertical_id"] . ",";
						$s .= $trialDefaults[$zz]["leadpop_vertical_sub_id"] . ",";
						$s .= $trialDefaults[$zz]["leadpop_type_id"] . "," . $trialDefaults[$zz]["leadpop_template_id"] . ",";
						$s .= $trialDefaults[$zz]["leadpop_id"] . ",";
						$s .= $trialDefaults[$zz]["leadpop_version_id"] . ",";
						$s .= $trialDefaults[$zz]["leadpop_version_seq"] . ",";
						$s .= "'" . addslashes($swatches[$i]) . "',";
						$s .= "'".$is_primary."','y')";
						$xzdb->query($s);

				  	}
			}

            $s = "select background_color from leadpop_background_color ";
			$s .= " where  client_id = " . $client_id;
			$s .= " and leadpop_version_id = " . $trialDefaults[$zz]["leadpop_version_id"];
			$s .= " and leadpop_version_seq = " . $trialDefaults[$zz]["leadpop_version_seq"] . " limit 1 ";
            $background_css = $xzdb->fetchOne($s);

            $s = "select * from leadpop_background_swatches ";
			$s .= " where  client_id = " . $client_id;
			$s .= " and leadpop_vertical_id = " . $trialDefaults[$zz]["leadpop_vertical_id"];
			$s .= " and leadpop_vertical_sub_id = " . $trialDefaults[$zz]["leadpop_vertical_sub_id"];
			$s .= " and leadpop_type_id  = " . $trialDefaults[$zz]["leadpop_type_id"];
			$s .= " and leadpop_template_id = " . $trialDefaults[$zz]["leadpop_template_id"];
			$s .= " and  leadpop_id = " . $trialDefaults[$zz]["leadpop_id"];
			$s .= " and leadpop_version_id = " . $trialDefaults[$zz]["leadpop_version_id"];
			$s .= " and leadpop_version_seq = " . $trialDefaults[$zz]["leadpop_version_seq"] . " limit 1 ";
			$finalTrialColors = $xzdb->fetchAll($s);

//		    $logo = $newlogoname; // set $logo to be used down stream
			//print ($logo . "    bbbb \r\n");
			//print ($newlogoname . "    cccc \r\n");
			/* now generate the mobile logo mobile logo mobile logo mobile logo mobile logo mobile logo */
			/* now generate the mobile logo mobile logo mobile logo mobile logo mobile logo mobile logo */
			/* now generate the mobile logo mobile logo mobile logo mobile logo mobile logo mobile logo */
			$s = "select include_path from mobile_paths where leadpop_id = " . $trialDefaults[$zz]["leadpop_id"] . " limit 1 ";
			$DestinationDirectory = $xzdb->fetchOne($s);
			$CopyDestinationDirectoryFile = "/var/www/vhosts/itclixmobile.com" . $DestinationDirectory;
			//$DestinationDirectory = "/var/www/vhosts/myleads.leadpops.com/data/mobileimages/";
			$Quality = 90;
            // set mobile logo varibale
		    $mobilelogo = $client_id . "grouplogo.png";

			$resize = true;
			if ($ow <= 320  &&  $oh <= 70) { // best fit for logo image is no larger than this
			    $resize = false;
			}

			//$DestImageName = $DestinationDirectory . $mobilelogo; // Image with destination directory
            $CopyDestinationDirectoryFile = $CopyDestinationDirectoryFile . $mobilelogo;

	        resizeImage($ow,$oh,$CopyDestinationDirectoryFile,$im,$Quality,$type,$resize,$newlogo);
           // $cmd = '/bin/cp  ' . $DestImageName . '  ' . $CopyDestinationDirectoryFile;
            //exec($cmd);

			/* now generate the mobile logo mobile logo mobile logo mobile logo mobile logo mobile logo */
			/* now generate the mobile logo mobile logo mobile logo mobile logo mobile logo mobile logo */
			/* now generate the mobile logo mobile logo mobile logo mobile logo mobile logo mobile logo */

		    $logosrc = newinsertClientUploadLogo($newlogoname,$trialDefaults[$zz],$client_id);
		    $imgsrc = insertClientDefaultImage($trialDefaults[$zz],$client_id);

		  $globallogosrc = $logosrc;
		  $globalfavicon_dst = $favicon_dst;
		  $globallogo_color = $logo_color;
		  $globalcolored_dot = $colored_dot;
		  print($newlogo . "\r\n");
		  unset($origlogo);
		  unset($newlogo);
          unset($newlogoname);
		  unset($logopath);
          unset($origcolored_dot_src);
		  unset($newcolored_dot_src);
		  unset($oclient);
		  print($zz . " at zz \r\n");
		}

		$dt = date("Y-m-d H:i:s");
		$dname = '/var/www/vhosts/itclix.com/images/clients/' . substr($client_id,0,1) . '/' . $client_id;
		if (!file_exists($dname)) {
			createClientInitialDirectories($client_id);
        }

		// craete this array so as not to have to chg code

            insertDefaultAutoResponders ($client_id, $trialDefaults[$zz], $client["contact_email"], $client["phone_number"]) ;

			$s = "select * from leadpops_template_info where leadpop_vertical_id = " . $trialDefaults[$zz]["leadpop_vertical_id"];
			$s .= " and leadpop_vertical_sub_id = " . $trialDefaults[$zz]["leadpop_vertical_sub_id"] . " and leadpop_version_id = " . $trialDefaults[$zz]["leadpop_version_id"];
			$template_info = $xzdb->fetchRow($s);

			$now = new DateTime();
			$s = "insert into clients_leadpops (id,client_id,leadpop_id,leadpop_version_id,leadpop_active,access_code,leadpop_version_seq,date_added) values (null,";
			$s .= $client_id . "," . $trialDefaults[$zz]["leadpop_id"] . "," . $trialDefaults[$zz]["leadpop_version_id"] . ",'1',''," . $trialDefaults[$zz]["leadpop_version_seq"] . ",'".$now->format("Y-m-d H:i:s")."')";
			$xzdb->query ( $s );

			$s = "insert into clients_leadpops_content (id,client_id,leadpop_id,leadpop_version_id,leadpop_active,access_code,leadpop_version_seq,";
  			$s .= "section1,section2,section3,section4,section5,section6,section7,section8,section9,section10,template) values (null,";
			$s .= $client_id . "," . $trialDefaults[$zz]["leadpop_id"] . "," . $trialDefaults[$zz]["leadpop_version_id"] . ",'1',''," . $trialDefaults[$zz]["leadpop_version_seq"] . ",";
			$s .= "'<h4>section one</h4>','<h4>section two</h4>','<h4>section three</h4>','<h4>section four</h4>',";
			$s .= "'<h4>section five</h4>','<h4>section six</h4>','<h4>section seven</h4>','<h4>section eight</h4>','<h4>section nine</h4>',";
			$s .= "'<h4>section ten</h4>',1)";
			$xzdb->query($s);

			checkIfNeedMultipleStepInsert ( $trialDefaults[$zz]["leadpop_version_id"], $client_id );
			// look up domain name
			$s = "select * from clients where client_id = " . $client_id . " limit 1 ";
			$client = $xzdb->fetchRow($s);
			$subdomain = $client ['company_name'];
			$subdomain = preg_replace ( '/[^a-zA-Z]/', '', $subdomain );
			$s = "select domain from top_level_domains where primary_domain = 'y' limit 1 ";
			$topdomain = $xzdb->fetchOne ( $s );
			if ($leadpoptype == $thissub_domain) {
				$s = "select  count(*) from clients_subdomains where  ";
				$s .= " subdomain_name = '" . $subdomain . "' ";
				$s .= " and top_level_domain = '" . $topdomain . "' ";
				$foundsubdomain = $xzdb->fetchOne ( $s );
				if ($foundsubdomain > 0) {
				//die("ass");
					$s = "select domain from top_level_domains where primary_domain != 'y' ";
					$nonprimary = $xzdb->fetchAll ( $s );
					$foundone = false;
					while ( $foundone == false ) {
						for($k = 0; $k < count ( $nonprimary ); $k ++) {
							$s = "select  count(*) from clients_subdomains where  ";
							$s .= " subdomain_name = '" . $subdomain . "' ";
							$s .= " and top_level_domain = '" . $nonprimary [$k] ['domain'] . "' ";
							$foundsubdomain = $xzdb->fetchOne ( $s );
							if ($foundsubdomain == 0) {
								$s = "insert into clients_subdomains (id,client_id,subdomain_name,top_level_domain,leadpop_vertical_id,";
								$s .= "leadpop_vertical_sub_id,leadpop_type_id,leadpop_template_id,";
								$s .= "leadpop_id,leadpop_version_id,leadpop_version_seq ) values (null,";
								$s .= $client_id . ",'" . $subdomain . "','" . $nonprimary [$k] ['domain'] . "',";
								$s .= $trialDefaults[$zz]["leadpop_vertical_id"] . "," . $trialDefaults[$zz]["leadpop_vertical_sub_id"] . "," . $leadpoptype . "," . $trialDefaults[$zz]['leadpop_template_id'] . ",";
								$s .= $trialDefaults[$zz]["leadpop_id"] . "," . $trialDefaults[$zz]["leadpop_version_id"] . "," . $trialDefaults[$zz]["leadpop_version_seq"] . ")";
								$xzdb->query ( $s );
								/* emma insert */
								/* emma insert */
								/* emma insert */

                                $s = "insert into client_emma_cron (id,client_id,emma_default_group,account_type,domain_name,account_name,master_account_ids,has_run, leadpop_vertical_id,leadpop_subvertical_id) values (null,";
    					        $s .= $client_id . ",'". $trialDefaults[$zz]['emma_default_group'] ."','".$emma_account_type."','". strtolower($subdomain . "." . $nonprimary [$k] ['domain']) ."','". $emma_account_name ."','";
								$s .= addslashes($emmaAccount) . "','n',".$trialDefaults[$zz]["leadpop_vertical_id"].",".$trialDefaults[$zz]["leadpop_vertical_sub_id"].")";
								$xzdb->query ($s);

								/* emma insert */
								/* emma insert */
								/* emma insert */

								$foundmobile = false;
								$randc = "";
								while ( $foundmobile == false ) {
									$s =  "select count(*) as cnt from mobileclients where mobiledomain = '".$subdomain . $randc .  ".itclixmobile.com'  ";
									$nummobile = $xzdb->fetchOne($s);
									if($nummobile == 0) {
										$foundmobile = true;
									}
									else {
										$randc = $randc . getRandomCharacter ();
									}
								}

                                if ($generatecolors == false && $useUploadedLogo == true) { // get mobile from old funnel
                                    // set 	client_or_domain_logo_image to 'c'  to use upploaded logo
									/* mobile domain and logo */
									$s = "select * from mobileclients  where client_id = " . $client_id ;
									$s .= " and leadpop_id = " . $origleadpop_id;
									$s .= " and leadpop_type_id = " . $origleadpop_type_id;
									$s .= " and leadpop_vertical_id = " . $origvertical_id;
									$s .= " and leadpop_vertical_sub_id = " . $origsubvertical_id;
									$s .=  " and leadpop_template_id = " . $origleadpop_template_id;
									$s .= " and leadpop_version_id = " . $origleadpop_version_id;
									$s .= " and leadpop_version_seq = " . $origleadpop_version_seq . " limit 1 ";
		                            $oldmobile = $xzdb->fetchAll($s);

									$s = "INSERT INTO mobileclients (nonmobiledomain, mobiledomain, client_id, id, leadpop_id, ";
									$s .= "leadpop_vertical_id,leadpop_vertical_sub_id, leadpop_type_id, leadpop_template_id,";
									$s .= "leadpop_version_id, leadpop_version_seq, ";
									$s .= "iszillow, zillow_api, active, group_design, phone, company,	client_or_domain_logo_image,call_to_action,thank_you) VALUES (";
									$s .= "'".$subdomain . "." . $nonprimary [$k] ['domain'] . "','" . $subdomain . $randc .".itclixmobile.com',";
									$s .= $client_id .",null,". $trialDefaults[$zz]["leadpop_id"] . "," . $trialDefaults[$zz]["leadpop_vertical_id"] . "," . $trialDefaults[$zz]["leadpop_vertical_sub_id"] . "," . $trialDefaults[$zz]["leadpop_type_id"] . "," .  $trialDefaults[$zz]['leadpop_template_id'];
									$s .= "," . $trialDefaults[$zz]["leadpop_version_id"] . "," . $trialDefaults[$zz]["leadpop_version_seq"] . ",'n','n','y','y','".preg_replace ('/[^0-9]/', '', $client ['phone_number'])."', '".addslashes($client ['company_name'])."','c','".addslashes($oldmobile[0]['call_to_action'])."','".addslashes($oldmobile[0]["thank_you"])."') ";
									$xzdb->query ($s);
								}
								else {
                                    // set 	client_or_domain_logo_image to 'o' for no uploaded logo
									/* mobile domain and logo */

									$s = "INSERT INTO mobileclients (nonmobiledomain, mobiledomain, client_id, id, leadpop_id, ";
									$s .= "leadpop_vertical_id,leadpop_vertical_sub_id, leadpop_type_id, leadpop_template_id,";
									$s .= "leadpop_version_id, leadpop_version_seq, ";
									$s .= "iszillow, zillow_api, active, group_design, phone, company,	client_or_domain_logo_image,call_to_action,thank_you) VALUES (";
									$s .= "'".$subdomain . "." . $nonprimary [$k] ['domain'] . "','" . $subdomain . $randc .".itclixmobile.com',";
									$s .= $client_id .",null,". $trialDefaults[$zz]["leadpop_id"] . "," . $trialDefaults[$zz]["leadpop_vertical_id"] . "," . $trialDefaults[$zz]["leadpop_vertical_sub_id"] . "," . $leadpoptype . "," .  $trialDefaults[$zz]['leadpop_template_id'];
									$s .= "," . $trialDefaults[$zz]["leadpop_version_id"] . "," . $trialDefaults[$zz]["leadpop_version_seq"] . ",'n','n','y','y','".preg_replace ('/[^0-9]/', '', $client ['phone_number'])."', '".addslashes($client ['company_name'])."','c','".addslashes($trialDefaults[$zz]['mobile_call_to_action'])."','".addslashes($trialDefaults[$zz]["mobile_thank_you"])."') ";
									$xzdb->query ($s);

								}

								$checkdomain = $subdomain . "." . $nonprimary [$k] ['domain'];
								$s = "insert into check_mobile (id,url,active,scope) values (null,";
								$s .= "'". $checkdomain ."','y', 'phone,tablet')";
                                $xzdb->query ($s);

								//die($cmd);
/* zzxx	*/
								$googleDomain = $subdomain . "." . $nonprimary [$k] ['domain'];
								insertPurchasedGoogle ( $client_id, $googleDomain );

                                if ($generatecolors == false && $useUploadedLogo == true) { // get mobile from old funnel
                                    // set 	client_or_domain_logo_image to 'c'  to use upploaded logo
									/* mobile domain and logo */
									$s = "select * from bottom_links  where client_id = " . $client_id ;
									$s .= " and leadpop_id = " . $origleadpop_id;
									$s .= " and leadpop_type_id = " . $origleadpop_type_id;
									$s .= " and leadpop_vertical_id = " . $origvertical_id;
									$s .= " and leadpop_vertical_sub_id = " . $origsubvertical_id;
									$s .=  " and leadpop_template_id = " . $origleadpop_template_id;
									$s .= " and leadpop_version_id = " . $origleadpop_version_id;
									$s .= " and leadpop_version_seq = " . $origleadpop_version_seq . " limit 1 ";
		                            $oldbototm = $xzdb->fetchAll($s);

									$s = "insert into  bottom_links (id,client_id,leadpop_id,leadpop_type_id,leadpop_vertical_id,";
									$s .= "leadpop_vertical_sub_id,leadpop_template_id,leadpop_version_id,";
									$s .= "leadpop_version_seq,privacy,terms,disclosures,licensing,about,contact,";
									$s .= "privacy_active,terms_active,disclosures_active,licensing_active,about_active,contact_active,";
									$s .= "privacy_type,terms_type,disclosures_type,licensing_type,about_type,contact_type,privacy_url,";
									$s .= "terms_url,disclosures_url,licensing_url,about_url,contact_url,privacy_text,";
									$s .= "terms_text,disclosures_text,licensing_text,about_text,contact_text,";
									$s .= "compliance_text,compliance_is_linked,compliance_link,compliance_active,";
									$s .= "license_number_active,license_number_is_linked,license_number_text,license_number_link";
									$s .= ") values (null,";
									$s .= $client_id . "," . $trialDefaults[$zz]["leadpop_id"] . "," . $trialDefaults[$zz]["leadpop_type_id"] . "," . $trialDefaults[$zz]["leadpop_vertical_id"] . "," . $trialDefaults[$zz]["leadpop_vertical_sub_id"] . ",";
									$s .= $trialDefaults[$zz]['leadpop_template_id'] . "," . $trialDefaults[$zz]["leadpop_version_id"] . "," . $trialDefaults[$zz]["leadpop_version_seq"];
									$s .= ",'','','','','','','n','n','n','n','n','n','m','m','m','m','m','m','','','','','','','','','','','','',";
                                    $s .= "'".$oldbototm[0]["compliance_text"]."','".$oldbototm[0]["compliance_is_linked"]."','".$oldbototm[0]["compliance_link"]."','".$oldbototm[0]["compliance_active"]."',";
									$s .= "'".$oldbototm[0]["license_number_active"]."','".$oldbototm[0]["license_number_is_linked"]."','".$oldbototm[0]["license_number_text"]."','".$oldbototm[0]["license_number_link"]."'";
									$s .= ") ";
									$xzdb->query($s);
                                }
								else {
									if (($vertical == "mortgage" || $vertical == "realestate")) {
										$license_number_text = "";
										$s = "insert into  bottom_links (id,client_id,leadpop_id,leadpop_type_id,leadpop_vertical_id,";
										$s .= "leadpop_vertical_sub_id,leadpop_template_id,leadpop_version_id,";
										$s .= "leadpop_version_seq,privacy,terms,disclosures,licensing,about,contact,";
										$s .= "privacy_active,terms_active,disclosures_active,licensing_active,about_active,contact_active,";
										$s .= "privacy_type,terms_type,disclosures_type,licensing_type,about_type,contact_type,privacy_url,";
										$s .= "terms_url,disclosures_url,licensing_url,about_url,contact_url,privacy_text,";
										$s .= "terms_text,disclosures_text,licensing_text,about_text,contact_text,";
										$s .= "compliance_text,compliance_is_linked,compliance_link,compliance_active,";
										$s .= "license_number_active,license_number_is_linked,license_number_text,license_number_link";
										$s .= ") values (null,";
										$s .= $client_id . "," . $trialDefaults[$zz]["leadpop_id"] . "," . $trialDefaults[$zz]["leadpop_type_id"] . "," . $trialDefaults[$zz]["leadpop_vertical_id"] . "," . $trialDefaults[$zz]["leadpop_vertical_sub_id"] . ",";
										$s .= $trialDefaults[$zz]['leadpop_template_id'] . "," . $trialDefaults[$zz]["leadpop_version_id"] . "," . $trialDefaults[$zz]["leadpop_version_seq"];
										$s .= ",'','','','','','','n','n','n','n','n','n','m','m','m','m','m','m','','','','','','','','','','','','',";
										$s .= "'NMLS Consumer Look Up','y','http://www.nmlsconsumeraccess.org','y',";
										$s .= "'y','n','".$license_number_text."',''";
										$s .= ") ";

										$xzdb->query ( $s );
									}
									else if ($vertical == "insurance") {
										$license_number_text = "";
										$s = "insert into  bottom_links (id,client_id,leadpop_id,leadpop_type_id,leadpop_vertical_id,";
										$s .= "leadpop_vertical_sub_id,leadpop_template_id,leadpop_version_id,";
										$s .= "leadpop_version_seq,privacy,terms,disclosures,licensing,about,contact,";
										$s .= "privacy_active,terms_active,disclosures_active,licensing_active,about_active,contact_active,";
										$s .= "privacy_type,terms_type,disclosures_type,licensing_type,about_type,contact_type,privacy_url,";
										$s .= "terms_url,disclosures_url,licensing_url,about_url,contact_url,privacy_text,";
										$s .= "terms_text,disclosures_text,licensing_text,about_text,contact_text,";
										$s .= "compliance_text,compliance_is_linked,compliance_link,compliance_active,";
										$s .= "license_number_active,license_number_is_linked,license_number_text,license_number_link";
										$s .= ") values (null,";
										$s .= $client_id . "," . $trialDefaults[$zz]["leadpop_id"] . "," . $trialDefaults[$zz]["leadpop_type_id"] . "," . $trialDefaults[$zz]["leadpop_vertical_id"] . "," . $trialDefaults[$zz]["leadpop_vertical_sub_id"] . ",";
										$s .= $trialDefaults[$zz]['leadpop_template_id'] . "," . $trialDefaults[$zz]["leadpop_version_id"] . "," . $trialDefaults[$zz]["leadpop_version_seq"];
										$s .= ",'','','','','','','n','n','n','n','n','n','m','m','m','m','m','m','','','','','','','','','','','','',";
										$s .= "'NMLS Consumer Look Up','y','http://www.nmlsconsumeraccess.org','y',";
										$s .= "'y','n','".$license_number_text."',''";
										$s .= ") ";
										$xzdb->query ( $s );
									}
									else {
										$s = "insert into  bottom_links (id,client_id,leadpop_id,leadpop_type_id,leadpop_vertical_id,";
										$s .= "leadpop_vertical_sub_id,leadpop_template_id,leadpop_version_id,";
										$s .= "leadpop_version_seq,privacy,terms,disclosures,licensing,about,contact,";
										$s .= "privacy_active,terms_active,disclosures_active,licensing_active,about_active,contact_active,";
										$s .= "privacy_type,terms_type,disclosures_type,licensing_type,about_type,contact_type,privacy_url,";
										$s .= "terms_url,disclosures_url,licensing_url,about_url,contact_url,privacy_text,";
										$s .= "terms_text,disclosures_text,licensing_text,about_text,contact_text,";
										$s .= "compliance_text,compliance_is_linked,compliance_link,compliance_active,";
										$s .= "license_number_active,license_number_is_linked,license_number_text,license_number_link";
										$s .= ") values (null,";
										$s .= $client_id . "," . $trialDefaults[$zz]["leadpop_id"] . "," . $trialDefaults[$zz]["leadpop_type_id"] . "," . $trialDefaults[$zz]["leadpop_vertical_id"] . "," . $trialDefaults[$zz]["leadpop_vertical_sub_id"] . ",";
										$s .= $trialDefaults[$zz]['leadpop_template_id'] . "," . $trialDefaults[$zz]["leadpop_version_id"] . "," . $trialDefaults[$zz]["leadpop_version_seq"];
										$s .= ",'','','','','','','n','n','n','n','n','n','m','m','m','m','m','m','','','','','','','','','','','','',";
										$s .= "'','','','',";
										$s .= "'','','',''";
										$s .= ") ";
										$xzdb->query ( $s );
									}
								}

								$x1 = '<p style="text-align: center;">';
								$x1 .= '     <span style="font-family:arial,helvetica,sans-serif;">';
								$x1 .= '     <span style="font-size: 22px;">';
								$x1 .= '     <span style="color: rgb(51, 102, 255);">Thank You For Your Submission!</span><br />';
								$x1 .= '     <span style="color: rgb(51, 51, 51);">';
								$x1 .= '     <span style="font-size: 14px;">We have received your inquiry. An expert will follow up with you shortly.';
								$x1 .= '     </span>';
								$x1 .= '     </span>';
								$x1 .= '     </span>';
								$x1 .= '     </span>        ';
								$x1 .= '   </p>   ';

								$s = "insert into contact_options (id,client_id,leadpop_id,";
								$s .= "leadpop_type_id,leadpop_vertical_id,leadpop_vertical_sub_id,";
								$s .= "leadpop_template_id,leadpop_version_id,leadpop_version_seq,";
								$s .= "companyname,phonenumber,email,companyname_active,";
								$s .= "phonenumber_active,email_active) values (null,";
								$s .= $client_id . "," . $trialDefaults[$zz]["leadpop_id"] . "," . $trialDefaults[$zz]["leadpop_type_id"] . "," . $trialDefaults[$zz]["leadpop_vertical_id"] . "," . $trialDefaults[$zz]["leadpop_vertical_sub_id"] . ",";
								$s .= $trialDefaults[$zz]['leadpop_template_id'] . "," . $trialDefaults[$zz]["leadpop_version_id"] . "," . $trialDefaults[$zz]["leadpop_version_seq"] . ",";
								// $s .= "'" . addslashes ( $client ['company_name'] ) . "','" . $client ['phone_number'] . "','";
								$s .= "'" . addslashes ( $client ['company_name'] ) . "','Call Today! " . $client ['phone_number'] . "','";
								$s .= $client ['contact_email'] . "','n','y','n')";
								$xzdb->query ( $s );

								$autotext = getAutoResponderText ( $trialDefaults[$zz]["leadpop_vertical_id"], $trialDefaults[$zz]["leadpop_vertical_sub_id"] , $trialDefaults[$zz]["leadpop_id"]);
                                if ($autotext == "not found") {
									$thehtml =  "";
									$thesubject = "";
                                }
                                else {
									$thehtml =  $autotext[0]["html"];
									$thesubject = $autotext[0]["subject_line"];
                                }
							    $s = "insert into autoresponder_options (id,client_id,leadpop_id,";
								$s .= "leadpop_type_id,leadpop_vertical_id,leadpop_vertical_sub_id,";
								$s .= "leadpop_template_id,leadpop_version_id,leadpop_version_seq,";
								$s .= "html,thetext,html_active,text_active,subject_line ) values (null,";
								$s .= $client_id . "," . $trialDefaults[$zz]["leadpop_id"] . "," . $trialDefaults[$zz]["leadpop_type_id"] . "," . $trialDefaults[$zz]["leadpop_vertical_id"] . "," . $trialDefaults[$zz]["leadpop_vertical_sub_id"] . ",";
								$s .= $trialDefaults[$zz]['leadpop_template_id'] . "," . $trialDefaults[$zz]["leadpop_version_id"] . "," . $trialDefaults[$zz]["leadpop_version_seq"] . ",";
								$s .= "'" . addslashes ( $thehtml ) . "','','y','n','".addslashes($thesubject)."')";
								//print($s);
								$xzdb->query ( $s );

								$title_tag =  " FREE " . $trialDefaults[$zz]["display_name"] . " | " . addslashes ( ucwords($client ['company_name']) );
                                //FREE Home Purchase Qualifier | Sentinel Mortgage Company

								$s = "insert into seo_options (id,client_id,leadpop_id,";
								$s .= "leadpop_type_id,leadpop_vertical_id,leadpop_vertical_sub_id,";
								$s .= "leadpop_template_id,leadpop_version_id,leadpop_version_seq,";
								$s .= "titletag,description,metatags,titletag_active,";
								$s .= "description_active,metatags_active) values (null,";
								$s .= $client_id . "," . $trialDefaults[$zz]["leadpop_id"] . "," . $trialDefaults[$zz]["leadpop_type_id"] . "," . $trialDefaults[$zz]["leadpop_vertical_id"] . "," . $trialDefaults[$zz]["leadpop_vertical_sub_id"] . ",";
								$s .= $trialDefaults[$zz]['leadpop_template_id'] . "," . $trialDefaults[$zz]["leadpop_version_id"] . "," . $trialDefaults[$zz]["leadpop_version_seq"] . ",";
								$s .= "'" . addslashes ( $title_tag ) . "','','','y','n','n') ";
								$xzdb->query ( $s );

								$s = "select * from leadpops_verticals where id = " . $trialDefaults[$zz]["leadpop_vertical_id"];
								$vertres = $xzdb->fetchRow ( $s );
								$verticalName = $vertres ['lead_pop_vertical'];

								if (isset ($trialDefaults[$zz]["leadpop_vertical_sub_id"] ) && $trialDefaults[$zz]["leadpop_vertical_sub_id"] != "") {
									$s = "select * from leadpops_verticals_sub where leadpop_vertical_id  = " . $trialDefaults[$zz]["leadpop_vertical_id"];
									$s .= " and id = " . $trialDefaults[$zz]["leadpop_vertical_sub_id"];
									$subvertres = $xzdb->fetchRow ( $s );
									$subverticalName = $subvertres ['lead_pop_vertical_sub'];
								} else {
									$subverticalName = "";
								}

								$submissionText = getSubmissionText($trialDefaults[$zz]["leadpop_id"],$trialDefaults[$zz]["leadpop_vertical_id"],$trialDefaults[$zz]["leadpop_vertical_sub_id"]);
					            $submissionText = str_replace("##clientlogo##",$logosrc,$submissionText);
					            $submissionText = str_replace("##clientphonenumber##",$freeTrialBuilderAnswers['phonenumber'],$submissionText);

								$s = "insert into submission_options (id,client_id,leadpop_id,leadpop_type_id,";
								$s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,";
								$s .= "leadpop_version_id,leadpop_version_seq,thankyou,information,";
								$s .= "thirdparty,thankyou_active,information_active,thirdparty_active) values (null,";
								$s .= $client_id . "," . $trialDefaults[$zz]["leadpop_id"] . "," . $trialDefaults[$zz]["leadpop_type_id"] . "," . $trialDefaults[$zz]["leadpop_vertical_id"] . "," . $trialDefaults[$zz]["leadpop_vertical_sub_id"] . ",";
								$s .= $trialDefaults[$zz]['leadpop_template_id'] . "," . $trialDefaults[$zz]["leadpop_version_id"] . "," . $trialDefaults[$zz]["leadpop_version_seq"] . ",";
								$s .= "'" . addslashes ( $submissionText ) . "','','','y','n','n')";
								$xzdb->query ( $s );

								$foundone = true;
								break 2;
							}
						}
						$subdomain = $subdomain . getRandomCharacter ();
					}
				} else {

					$s = "insert into clients_subdomains (id,client_id,subdomain_name,top_level_domain,leadpop_vertical_id,";
					$s .= "leadpop_vertical_sub_id,leadpop_type_id,leadpop_template_id,";
					$s .= "leadpop_id,leadpop_version_id,leadpop_version_seq ) values (null,";
					$s .= $client_id . ",'" . $subdomain . "','" . $topdomain . "',";
					$s .= $trialDefaults[$zz]["leadpop_vertical_id"] . "," . $trialDefaults[$zz]["leadpop_vertical_sub_id"] . "," . $trialDefaults[$zz]["leadpop_type_id"] . "," . $trialDefaults[$zz]['leadpop_template_id'] . ",";
					$s .= $trialDefaults[$zz]["leadpop_id"] . "," . $trialDefaults[$zz]["leadpop_version_id"] . "," . $trialDefaults[$zz]["leadpop_version_seq"] . ")";
					$xzdb->query ( $s );

								/* emma insert */
								/* emma insert */
								/* emma insert */
								$s = "insert into client_emma_cron (id,client_id,emma_default_group,account_type,domain_name,account_name,master_account_ids,has_run,leadpop_vertical_id,leadpop_subvertical_id) values (null,";
								$s .= $client_id . ",'". $trialDefaults[$zz]['emma_default_group'] ."','".$emma_account_type."','". strtolower($subdomain . "." . $topdomain) ."','". $emma_account_name ."','";
								$s .= addslashes($emmaAccount) . "','n',".$trialDefaults[$zz]["leadpop_vertical_id"].",".$trialDefaults[$zz]["leadpop_vertical_sub_id"].")";
								$xzdb->query ($s);
								/* emma insert */
								/* emma insert */
								/* emma insert */


					$foundmobile = false;
					$randc = "";
					while ( $foundmobile == false ) {
						$s =  "select count(*) as cnt from mobileclients where mobiledomain = '".$subdomain . $randc .  ".itclixmobile.com'  ";
						$nummobile = $xzdb->fetchOne($s);
						if($nummobile == 0) {
							$foundmobile = true;
						}
						else {
							$randc = $randc . getRandomCharacter ();
						}
					}

						if ($generatecolors == false && $useUploadedLogo == true) { // get mobile from old funnel
							// set 	client_or_domain_logo_image to 'c'  to use upploaded logo
							/* mobile domain and logo */
							$s = "select * from mobileclients  where client_id = " . $client_id ;
							$s .= " and leadpop_id = " . $origleadpop_id;
							$s .= " and leadpop_type_id = " . $origleadpop_type_id;
							$s .= " and leadpop_vertical_id = " . $origvertical_id;
							$s .= " and leadpop_vertical_sub_id = " . $origsubvertical_id;
							$s .=  " and leadpop_template_id = " . $origleadpop_template_id;
							$s .= " and leadpop_version_id = " . $origleadpop_version_id;
							$s .= " and leadpop_version_seq = " . $origleadpop_version_seq . " limit 1 ";
							$oldmobile = $xzdb->fetchAll($s);

							$s = "INSERT INTO mobileclients (nonmobiledomain, mobiledomain, client_id, id, leadpop_id, ";
							$s .= "leadpop_vertical_id,leadpop_vertical_sub_id, leadpop_type_id, leadpop_template_id,";
							$s .= "leadpop_version_id, leadpop_version_seq, ";
							$s .= "iszillow, zillow_api, active, group_design, phone, company,	client_or_domain_logo_image,call_to_action,thank_you) VALUES (";
							$s .= "'".$subdomain . "." . $topdomain . "','" . $subdomain . $randc .".itclixmobile.com',";
							$s .= $client_id .",null,". $trialDefaults[$zz]["leadpop_id"] . "," . $trialDefaults[$zz]["leadpop_vertical_id"] . "," . $trialDefaults[$zz]["leadpop_vertical_sub_id"] . "," . $trialDefaults[$zz]["leadpop_type_id"] . "," .  $trialDefaults[$zz]['leadpop_template_id'];
							$s .= "," . $trialDefaults[$zz]["leadpop_version_id"] . "," . $trialDefaults[$zz]["leadpop_version_seq"] . ",'n','n','y','y','".preg_replace ('/[^0-9]/', '', $client ['phone_number'])."', '".addslashes($client ['company_name'])."','c','".addslashes($oldmobile[0]['call_to_action'])."','".addslashes($oldmobile[0]["thank_you"])."') ";
							$xzdb->query ($s);
						}
						else {

							$s = "INSERT INTO mobileclients (nonmobiledomain, mobiledomain, client_id, id, leadpop_id, ";
							$s .= "leadpop_vertical_id,leadpop_vertical_sub_id, leadpop_type_id, leadpop_template_id,";
							$s .= "leadpop_version_id, leadpop_version_seq, ";
							$s .= "iszillow, zillow_api, active, group_design, phone, company,	client_or_domain_logo_image,call_to_action,thank_you) VALUES (";
							$s .= "'".$subdomain . "." . $topdomain . "','" . $subdomain . $randc .".itclixmobile.com',";
							$s .= $client_id .",null,". $trialDefaults[$zz]["leadpop_id"] . "," . $trialDefaults[$zz]["leadpop_vertical_id"] . "," . $trialDefaults[$zz]["leadpop_vertical_sub_id"] . "," . $leadpoptype . "," .  $trialDefaults[$zz]['leadpop_template_id'];
							$s .= "," . $trialDefaults[$zz]["leadpop_version_id"] . "," . $trialDefaults[$zz]["leadpop_version_seq"] . ",'n','n','y','y','".preg_replace ('/[^0-9]/', '', $client ['phone_number'])."', '".addslashes($client ['company_name'])."','c','".addslashes($trialDefaults[$zz]['mobile_call_to_action'])."','".addslashes($trialDefaults[$zz]["mobile_thank_you"])."') ";
							$xzdb->query ($s);

						}

					$checkdomain = $subdomain . "." . $topdomain;
					$s = "insert into check_mobile (id,url,active,scope) values (null,";
					$s .= "'". $checkdomain ."','y', 'phone,tablet')";
					$xzdb->query ($s);


					$googleDomain = $subdomain . "." . $topdomain;
					insertPurchasedGoogle ( $client_id, $googleDomain );

						if ($generatecolors == false && $useUploadedLogo == true) { // get mobile from old funnel
							// set 	client_or_domain_logo_image to 'c'  to use upploaded logo
							/* mobile domain and logo */
							$s = "select * from bottom_links  where client_id = " . $client_id ;
							$s .= " and leadpop_id = " . $origleadpop_id;
							$s .= " and leadpop_type_id = " . $origleadpop_type_id;
							$s .= " and leadpop_vertical_id = " . $origvertical_id;
							$s .= " and leadpop_vertical_sub_id = " . $origsubvertical_id;
							$s .=  " and leadpop_template_id = " . $origleadpop_template_id;
							$s .= " and leadpop_version_id = " . $origleadpop_version_id;
							$s .= " and leadpop_version_seq = " . $origleadpop_version_seq . " limit 1 ";
							$oldbototm = $xzdb->fetchAll($s);

							$s = "insert into  bottom_links (id,client_id,leadpop_id,leadpop_type_id,leadpop_vertical_id,";
							$s .= "leadpop_vertical_sub_id,leadpop_template_id,leadpop_version_id,";
							$s .= "leadpop_version_seq,privacy,terms,disclosures,licensing,about,contact,";
							$s .= "privacy_active,terms_active,disclosures_active,licensing_active,about_active,contact_active,";
							$s .= "privacy_type,terms_type,disclosures_type,licensing_type,about_type,contact_type,privacy_url,";
							$s .= "terms_url,disclosures_url,licensing_url,about_url,contact_url,privacy_text,";
							$s .= "terms_text,disclosures_text,licensing_text,about_text,contact_text,";
							$s .= "compliance_text,compliance_is_linked,compliance_link,compliance_active,";
							$s .= "license_number_active,license_number_is_linked,license_number_text,license_number_link";
							$s .= ") values (null,";
							$s .= $client_id . "," . $trialDefaults[$zz]["leadpop_id"] . "," . $trialDefaults[$zz]["leadpop_type_id"] . "," . $trialDefaults[$zz]["leadpop_vertical_id"] . "," . $trialDefaults[$zz]["leadpop_vertical_sub_id"] . ",";
							$s .= $trialDefaults[$zz]['leadpop_template_id'] . "," . $trialDefaults[$zz]["leadpop_version_id"] . "," . $trialDefaults[$zz]["leadpop_version_seq"];
							$s .= ",'','','','','','','n','n','n','n','n','n','m','m','m','m','m','m','','','','','','','','','','','','',";
							$s .= "'".$oldbototm[0]["compliance_text"]."','".$oldbototm[0]["compliance_is_linked"]."','".$oldbototm[0]["compliance_link"]."','".$oldbototm[0]["compliance_active"]."',";
							$s .= "'".$oldbototm[0]["license_number_active"]."','".$oldbototm[0]["license_number_is_linked"]."','".$oldbototm[0]["license_number_text"]."','".$oldbototm[0]["license_number_link"]."'";
							$s .= ") ";
							$xzdb->query($s);
						}
						else {
							if (($vertical == "mortgage" || $vertical == "realestate")) {
								$license_number_text = "";
								$s = "insert into  bottom_links (id,client_id,leadpop_id,leadpop_type_id,leadpop_vertical_id,";
								$s .= "leadpop_vertical_sub_id,leadpop_template_id,leadpop_version_id,";
								$s .= "leadpop_version_seq,privacy,terms,disclosures,licensing,about,contact,";
								$s .= "privacy_active,terms_active,disclosures_active,licensing_active,about_active,contact_active,";
								$s .= "privacy_type,terms_type,disclosures_type,licensing_type,about_type,contact_type,privacy_url,";
								$s .= "terms_url,disclosures_url,licensing_url,about_url,contact_url,privacy_text,";
								$s .= "terms_text,disclosures_text,licensing_text,about_text,contact_text,";
								$s .= "compliance_text,compliance_is_linked,compliance_link,compliance_active,";
								$s .= "license_number_active,license_number_is_linked,license_number_text,license_number_link";
								$s .= ") values (null,";
								$s .= $client_id . "," . $trialDefaults[$zz]["leadpop_id"] . "," . $trialDefaults[$zz]["leadpop_type_id"] . "," . $trialDefaults[$zz]["leadpop_vertical_id"] . "," . $trialDefaults[$zz]["leadpop_vertical_sub_id"] . ",";
								$s .= $trialDefaults[$zz]['leadpop_template_id'] . "," . $trialDefaults[$zz]["leadpop_version_id"] . "," . $trialDefaults[$zz]["leadpop_version_seq"];
								$s .= ",'','','','','','','n','n','n','n','n','n','m','m','m','m','m','m','','','','','','','','','','','','',";
								$s .= "'NMLS Consumer Look Up','y','http://www.nmlsconsumeraccess.org','y',";
								$s .= "'y','n','".$license_number_text."',''";
								$s .= ") ";

								$xzdb->query ( $s );
							}
							else if ($vertical == "insurance") {
								$license_number_text = "";
								$s = "insert into  bottom_links (id,client_id,leadpop_id,leadpop_type_id,leadpop_vertical_id,";
								$s .= "leadpop_vertical_sub_id,leadpop_template_id,leadpop_version_id,";
								$s .= "leadpop_version_seq,privacy,terms,disclosures,licensing,about,contact,";
								$s .= "privacy_active,terms_active,disclosures_active,licensing_active,about_active,contact_active,";
								$s .= "privacy_type,terms_type,disclosures_type,licensing_type,about_type,contact_type,privacy_url,";
								$s .= "terms_url,disclosures_url,licensing_url,about_url,contact_url,privacy_text,";
								$s .= "terms_text,disclosures_text,licensing_text,about_text,contact_text,";
								$s .= "compliance_text,compliance_is_linked,compliance_link,compliance_active,";
								$s .= "license_number_active,license_number_is_linked,license_number_text,license_number_link";
								$s .= ") values (null,";
								$s .= $client_id . "," . $trialDefaults[$zz]["leadpop_id"] . "," . $trialDefaults[$zz]["leadpop_type_id"] . "," . $trialDefaults[$zz]["leadpop_vertical_id"] . "," . $trialDefaults[$zz]["leadpop_vertical_sub_id"] . ",";
								$s .= $trialDefaults[$zz]['leadpop_template_id'] . "," . $trialDefaults[$zz]["leadpop_version_id"] . "," . $trialDefaults[$zz]["leadpop_version_seq"];
								$s .= ",'','','','','','','n','n','n','n','n','n','m','m','m','m','m','m','','','','','','','','','','','','',";
								$s .= "'NMLS Consumer Look Up','y','http://www.nmlsconsumeraccess.org','y',";
								$s .= "'y','n','".$license_number_text."',''";
								$s .= ") ";
								$xzdb->query ( $s );
							}
							else {
								$s = "insert into  bottom_links (id,client_id,leadpop_id,leadpop_type_id,leadpop_vertical_id,";
								$s .= "leadpop_vertical_sub_id,leadpop_template_id,leadpop_version_id,";
								$s .= "leadpop_version_seq,privacy,terms,disclosures,licensing,about,contact,";
								$s .= "privacy_active,terms_active,disclosures_active,licensing_active,about_active,contact_active,";
								$s .= "privacy_type,terms_type,disclosures_type,licensing_type,about_type,contact_type,privacy_url,";
								$s .= "terms_url,disclosures_url,licensing_url,about_url,contact_url,privacy_text,";
								$s .= "terms_text,disclosures_text,licensing_text,about_text,contact_text,";
								$s .= "compliance_text,compliance_is_linked,compliance_link,compliance_active,";
								$s .= "license_number_active,license_number_is_linked,license_number_text,license_number_link";
								$s .= ") values (null,";
								$s .= $client_id . "," . $trialDefaults[$zz]["leadpop_id"] . "," . $trialDefaults[$zz]["leadpop_type_id"] . "," . $trialDefaults[$zz]["leadpop_vertical_id"] . "," . $trialDefaults[$zz]["leadpop_vertical_sub_id"] . ",";
								$s .= $trialDefaults[$zz]['leadpop_template_id'] . "," . $trialDefaults[$zz]["leadpop_version_id"] . "," . $trialDefaults[$zz]["leadpop_version_seq"];
								$s .= ",'','','','','','','n','n','n','n','n','n','m','m','m','m','m','m','','','','','','','','','','','','',";
								$s .= "'','','','',";
								$s .= "'','','',''";
								$s .= ") ";
								$xzdb->query ( $s );
							}
						}

					$x1 = '<p style="text-align: center;">';
					$x1 .= '     <span style="font-family:arial,helvetica,sans-serif;">';
					$x1 .= '     <span style="font-size: 22px;">';
					$x1 .= '     <span style="color: rgb(51, 102, 255);">Thank You For Your Submission!</span><br />';
					$x1 .= '     <span style="color: rgb(51, 51, 51);">';
					$x1 .= '     <span style="font-size: 14px;">We have received your inquiry. An expert will follow up with you shortly.';
					$x1 .= '     </span>';
					$x1 .= '     </span>';
					$x1 .= '     </span>';
					$x1 .= '     </span>        ';
					$x1 .= '   </p>   ';

					$s = "insert into contact_options (id,client_id,leadpop_id,";
					$s .= "leadpop_type_id,leadpop_vertical_id,leadpop_vertical_sub_id,";
					$s .= "leadpop_template_id,leadpop_version_id,leadpop_version_seq,";
					$s .= "companyname,phonenumber,email,companyname_active,";
					$s .= "phonenumber_active,email_active) values (null,";
					$s .= $client_id . "," . $trialDefaults[$zz]["leadpop_id"] . "," . $trialDefaults[$zz]["leadpop_type_id"] . "," . $trialDefaults[$zz]["leadpop_vertical_id"] . "," . $trialDefaults[$zz]["leadpop_vertical_sub_id"] . ",";
					$s .= $trialDefaults[$zz]['leadpop_template_id'] . "," . $trialDefaults[$zz]["leadpop_version_id"] . "," . $trialDefaults[$zz]["leadpop_version_seq"] . ",";
					// $s .= "'" . addslashes ( $client ['company_name'] ) . "','" . $client ['phone_number'] . "','";
					$s .= "'" . addslashes ( $client ['company_name'] ) . "','Call Today! " . $client ['phone_number'] . "','";
					$s .= $client ['contact_email'] . "','n','y','n')";
					$xzdb->query ( $s );

					$autotext = getAutoResponderText ( $trialDefaults[$zz]["leadpop_vertical_id"], $trialDefaults[$zz]["leadpop_vertical_sub_id"] , $trialDefaults[$zz]["leadpop_id"]);
					if ($autotext == "not found") {
						$thehtml =  "";
						$thesubject = "";
					}
					else {
						$thehtml =  $autotext[0]["html"];
						$thesubject = $autotext[0]["subject_line"];
					}

					$s = "insert into autoresponder_options (id,client_id,leadpop_id,";
					$s .= "leadpop_type_id,leadpop_vertical_id,leadpop_vertical_sub_id,";
					$s .= "leadpop_template_id,leadpop_version_id,leadpop_version_seq,";
					$s .= "html,thetext,html_active,text_active,subject_line ) values (null,";
					$s .= $client_id . "," . $trialDefaults[$zz]["leadpop_id"] . "," . $trialDefaults[$zz]["leadpop_type_id"] . "," . $trialDefaults[$zz]["leadpop_vertical_id"] . "," . $trialDefaults[$zz]["leadpop_vertical_sub_id"] . ",";
					$s .= $trialDefaults[$zz]['leadpop_template_id'] . "," . $trialDefaults[$zz]["leadpop_version_id"] . "," . $trialDefaults[$zz]["leadpop_version_seq"] . ",";
					$s .= "'" . addslashes ( $thehtml ) . "','','y','n','".addslashes($thesubject)."')";
					$xzdb->query ($s);

					try {
					    $xzdb->query ($s);
					}
					catch ( PDOException $e) {
                        print ("Error!: " . $e->getMessage() . "<br/>") ;
					    print($s);
						die();
					}


					$title_tag =  " FREE " . $trialDefaults[$zz]["display_name"] . " | " . addslashes ( ucwords($client ['company_name']) );
					//FREE Home Purchase Qualifier | Sentinel Mortgage Company

					$s = "insert into seo_options (id,client_id,leadpop_id,";
					$s .= "leadpop_type_id,leadpop_vertical_id,leadpop_vertical_sub_id,";
					$s .= "leadpop_template_id,leadpop_version_id,leadpop_version_seq,";
					$s .= "titletag,description,metatags,titletag_active,";
					$s .= "description_active,metatags_active) values (null,";
					$s .= $client_id . "," . $trialDefaults[$zz]["leadpop_id"] . "," . $trialDefaults[$zz]["leadpop_type_id"] . "," . $trialDefaults[$zz]["leadpop_vertical_id"] . "," . $trialDefaults[$zz]["leadpop_vertical_sub_id"] . ",";
					$s .= $trialDefaults[$zz]['leadpop_template_id'] . "," . $trialDefaults[$zz]["leadpop_version_id"] . "," . $trialDefaults[$zz]["leadpop_version_seq"] . ",";
					$s .= "'" . addslashes ( $title_tag ) . "','','','y','n','n') ";
					$xzdb->query ( $s );

					$s = "select * from leadpops_verticals where id = " . $trialDefaults[$zz]["leadpop_vertical_id"];
					$vertres = $xzdb->fetchRow ( $s );
					$verticalName = $vertres ['lead_pop_vertical'];

					if (isset ($trialDefaults[$zz]["leadpop_vertical_sub_id"] ) && $trialDefaults[$zz]["leadpop_vertical_sub_id"] != "") {
						$s = "select * from leadpops_verticals_sub where leadpop_vertical_id  = " . $trialDefaults[$zz]["leadpop_vertical_id"];
						$s .= " and id = " . $trialDefaults[$zz]["leadpop_vertical_sub_id"];
						$subvertres = $xzdb->fetchRow ( $s );
						$subverticalName = $subvertres ['lead_pop_vertical_sub'];
					} else {
						$subverticalName = "";
					}

					$submissionText = getSubmissionText($trialDefaults[$zz]["leadpop_id"],$trialDefaults[$zz]["leadpop_vertical_id"],$trialDefaults[$zz]["leadpop_vertical_sub_id"]);
					$submissionText = str_replace("##clientlogo##",$logosrc,$submissionText);
					$submissionText = str_replace("##clientphonenumber##",$freeTrialBuilderAnswers['phonenumber'],$submissionText);

					$s = "insert into submission_options (id,client_id,leadpop_id,leadpop_type_id,";
					$s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,";
					$s .= "leadpop_version_id,leadpop_version_seq,thankyou,information,";
					$s .= "thirdparty,thankyou_active,information_active,thirdparty_active) values (null,";
					$s .= $client_id . "," . $trialDefaults[$zz]["leadpop_id"] . "," . $trialDefaults[$zz]["leadpop_type_id"] . "," . $trialDefaults[$zz]["leadpop_vertical_id"] . "," . $trialDefaults[$zz]["leadpop_vertical_sub_id"] . ",";
					$s .= $trialDefaults[$zz]['leadpop_template_id'] . "," . $trialDefaults[$zz]["leadpop_version_id"] . "," . $trialDefaults[$zz]["leadpop_version_seq"] . ",";
					$s .= "'" . addslashes ( $submissionText ) . "','','','y','n','n')";
					$xzdb->query ( $s );

				}
			}

			$s = "select * from leadpops_templates_placeholders_info where leadpop_template_id = " . $trialDefaults[$zz]['leadpop_template_id'] . " order by step ";
			$placeholder_info = $xzdb->fetchAll ( $s );
			for($j = 0; $j < count ( $placeholder_info ); $j ++) {
				$s = "insert into leadpops_templates_placeholders (id,";
				$s .= "leadpop_template_id,step,client_id,leadpop_version_seq,";
				$s .= "placeholder_one,";
				$s .= "placeholder_two,";
				$s .= "placeholder_three,";
				$s .= "placeholder_four,";
				$s .= "placeholder_five,";
				$s .= "placeholder_six,";
				$s .= "placeholder_seven,";
				$s .= "placeholder_eight,";
				$s .= "placeholder_nine,";
				$s .= "placeholder_ten,";
				$s .= "placeholder_eleven,";
				$s .= "placeholder_twelve,";
				$s .= "placeholder_thirteen,";
				$s .= "placeholder_fourteen,";
				$s .= "placeholder_fifteen,";
				$s .= "placeholder_sixteen,";
				$s .= "placeholder_seventeen,";
				$s .= "placeholder_eighteen,";
				$s .= "placeholder_nineteen,";
				$s .= "placeholder_twenty,";
				$s .= "placeholder_twentyone,";
				$s .= "placeholder_twentytwo,";
				$s .= "placeholder_twentythree,";
				$s .= "placeholder_twentyfour,";
				$s .= "placeholder_twentyfive,";
				$s .= "placeholder_twentysix,";
				$s .= "placeholder_twentyseven,";
				$s .= "placeholder_twentyeight,";
				$s .= "placeholder_twentynine,";
				$s .= "placeholder_thirty,";
				$s .= "placeholder_thirtyone,";
				$s .= "placeholder_thirtytwo,";
				$s .= "placeholder_thirtythree,";
				$s .= "placeholder_thirtyfour,";
				$s .= "placeholder_thirtyfive,";
				$s .= "placeholder_thirtysix,";
				$s .= "placeholder_thirtyseven,";
				$s .= "placeholder_thirtyeight,";
				$s .= "placeholder_thirtynine,";
				$s .= "placeholder_forty,";
				$s .= "placeholder_fortyone,";
				$s .= "placeholder_fortytwo,";
				$s .= "placeholder_fortythree,";
				$s .= "placeholder_fortyfour,";
				$s .= "placeholder_fortyfive,";
				$s .= "placeholder_fortysix,";
				$s .= "placeholder_fortyseven,";
				$s .= "placeholder_fortyeight,";
				$s .= "placeholder_fortynine,";
				$s .= "placeholder_fifty,";
				$s .= "placeholder_fiftyone,";
				$s .= "placeholder_fiftytwo,";
				$s .= "placeholder_fiftythree,";
				$s .= "placeholder_fiftyfour,";
				$s .= "placeholder_fiftyfive,";
				$s .= "placeholder_fiftysix,";
				$s .= "placeholder_fiftyseven,";
				$s .= "placeholder_fiftyeight,";
				$s .= "placeholder_fiftynine,";
				$s .= "placeholder_sixty,";
				$s .= "placeholder_sixtyone,";
				$s .= "placeholder_sixtytwo,";
				$s .= "placeholder_sixtythree,";
				$s .= "placeholder_sixtyfour,";
				$s .= "placeholder_sixtyfive,";
				$s .= "placeholder_sixtysix,";
				$s .= "placeholder_sixtyseven,";
				$s .= "placeholder_sixtyeight,";
				$s .= "placeholder_sixtynine,";
				$s .= "placeholder_seventy,";
				$s .= "placeholder_seventyone,";
				$s .= "placeholder_seventytwo,";
				$s .= "placeholder_seventythree,";
				$s .= "placeholder_seventyfour,";
				$s .= "placeholder_seventyfive,";
				$s .= "placeholder_seventysix,";
				$s .= "placeholder_seventyseven,";
				$s .= "placeholder_seventyeight,";
				$s .= "placeholder_seventynine,";
				$s .= "placeholder_eighty,";
				$s .= "placeholder_eightyone,";
				$s .= "placeholder_eightytwo,";
				$s .= "placeholder_eightythree";
				$s .= "    ) values (null," . $trialDefaults[$zz]['leadpop_template_id'] . ",";
				$s .= $placeholder_info [$j] ['step'] . "," . $client_id . "," . $trialDefaults[$zz]["leadpop_version_seq"] . ",";
				$s .= "'" . $placeholder_info [$j] ['placeholder_one'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_two'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_three'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_four'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_five'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_six'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_seven'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_eight'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_nine'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_ten'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_eleven'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_twelve'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_thirteen'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fourteen'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fifteen'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_sixteen'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_seventeen'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_eighteen'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_nineteen'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_twenty'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_twentyone'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_twentytwo'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_twentythree'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_twentyfour'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_twentyfive'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_twentysix'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_twentyseven'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_twentyeight'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_twentynine'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_thirty'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_thirtyone'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_thirtytwo'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_thirtythree'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_thirtyfour'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_thirtyfive'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_thirtysix'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_thirtyseven'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_thirtyeight'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_thirtynine'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_forty'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fortyone'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fortytwo'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fortythree'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fortyfour'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fortyfive'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fortysix'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fortyseven'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fortyeight'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fortynine'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fifty'] . "', ";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fiftyone'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fiftytwo'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fiftythree'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fiftyfour'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fiftyfive'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fiftysix'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fiftyseven'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fiftyeight'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fiftynine'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_sixty'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_sixtyone'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_sixtytwo'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_sixtythree'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_sixtyfour'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_sixtyfive'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_sixtysix'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_sixtyseven'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_sixtyeight'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_sixtynine'] . "' ,";
				$s .= "'" . addslashes ( $placeholder_info [$j] ['placeholder_seventy'] ) . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_seventyone'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_seventytwo'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_seventythree'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_seventyfour'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_seventyfive'] . "', ";
				$s .= "'" . $placeholder_info [$j] ['placeholder_seventysix'] . "', ";
				$s .= "'" . $placeholder_info [$j] ['placeholder_seventyseven'] . "', ";
				$s .= "'" . $placeholder_info [$j] ['placeholder_seventyeight'] . "', ";
				$s .= "'" . $placeholder_info [$j] ['placeholder_seventynine'] . "', ";
				$s .= "'" . $placeholder_info [$j] ['placeholder_eighty'] . "', ";
				$s .= "'" . $placeholder_info [$j] ['placeholder_eightyone'] . "', ";
				$s .= "'" . $placeholder_info [$j] ['placeholder_eightytwo'] . "', ";
				$s .= "'" . $placeholder_info [$j] ['placeholder_eightythree'] . "' ";
				$s .= " )";
				$xzdb->query ( $s );
				$placeholder_id = $xzdb->lastInsertId ();

				$s = "select * from leadpops_templates_placeholders_values_info where ";
				$s .= " leadpop_template_id = " . $placeholder_info [$j] ['leadpop_template_id'];
				$s .= " and step = " . $placeholder_info [$j] ['step'];
				$s .= " and placeholder_fortyseven = '".$placeholder_info[$j]['placeholder_fortyseven']."' ";
				$placeholder_values = $xzdb->fetchRow ( $s );

				$s = "insert into leadpops_templates_placeholders_values (id,client_leadpop_id,";
				$s .= "  leadpop_template_placeholder_id,";
				$s .= "  placeholder_one,";
				$s .= "  placeholder_two,";
				$s .= "  placeholder_three,";
				$s .= "  placeholder_four,";
				$s .= "  placeholder_five,";
				$s .= "  placeholder_six,";
				$s .= "  placeholder_seven,";
				$s .= "  placeholder_eight,";
				$s .= "  placeholder_nine,";
				$s .= "  placeholder_ten,";
				$s .= "  placeholder_eleven,";
				$s .= "  placeholder_twelve,";
				$s .= "  placeholder_thirteen,";
				$s .= "  placeholder_fourteen,";
				$s .= "  placeholder_fifteen,";
				$s .= "  placeholder_sixteen,";
				$s .= "  placeholder_seventeen,";
				$s .= "  placeholder_eighteen,";
				$s .= "  placeholder_nineteen,";
				$s .= "  placeholder_twenty,";
				$s .= "  placeholder_twentyone,";
				$s .= "  placeholder_twentytwo,";
				$s .= "  placeholder_twentythree,";
				$s .= "  placeholder_twentyfour,";
				$s .= "  placeholder_twentyfive,";
				$s .= "  placeholder_twentysix,";
				$s .= "  placeholder_twentyseven,";
				$s .= "  placeholder_twentyeight,";
				$s .= "  placeholder_twentynine,";
				$s .= "  placeholder_thirty,";
				$s .= "  placeholder_thirtyone,";
				$s .= "  placeholder_thirtytwo,";
				$s .= "  placeholder_thirtythree,";
				$s .= "  placeholder_thirtyfour,";
				$s .= "  placeholder_thirtyfive,";
				$s .= "  placeholder_thirtysix,";
				$s .= "  placeholder_thirtyseven,";
				$s .= "  placeholder_thirtyeight,";
				$s .= "  placeholder_thirtynine,";
				$s .= "  placeholder_forty,";
				$s .= "  placeholder_fortyone,";
				$s .= "  placeholder_fortytwo,";
				$s .= "  placeholder_fortythree,";
				$s .= "  placeholder_fortyfour,";
				$s .= "  placeholder_fortyfive,";
				$s .= "  placeholder_fortysix,";
				$s .= "  placeholder_fortyseven,";
				$s .= "  placeholder_fortyeight,";
				$s .= "  placeholder_fortynine,";
				$s .= "  placeholder_fifty, ";
				$s .= "placeholder_fiftyone,";
				$s .= "placeholder_fiftytwo,";
				$s .= "placeholder_fiftythree,";
				$s .= "placeholder_fiftyfour,";
				$s .= "placeholder_fiftyfive,";
				$s .= "placeholder_fiftysix,";
				$s .= "placeholder_fiftyseven,";
				$s .= "placeholder_fiftyeight,";
				$s .= "placeholder_fiftynine,";
				$s .= "placeholder_sixty,";
				$s .= "placeholder_sixtyone,";
				$s .= "placeholder_sixtytwo,";
				$s .= "placeholder_sixtythree,";
				$s .= "placeholder_sixtyfour,";
				$s .= "placeholder_sixtyfive,";
				$s .= "placeholder_sixtysix,";
				$s .= "placeholder_sixtyseven,";
				$s .= "placeholder_sixtyeight,";
				$s .= "placeholder_sixtynine,";
				$s .= "placeholder_seventy,";
				$s .= "placeholder_seventyone,";
				$s .= "placeholder_seventytwo,";
				$s .= "placeholder_seventythree,";
				$s .= "placeholder_seventyfour,";
				$s .= "placeholder_seventyfive,";
				$s .= "placeholder_seventysix,";
				$s .= "placeholder_seventyseven,";
				$s .= "placeholder_seventyeight,";
				$s .= "placeholder_seventynine,";
				$s .= "placeholder_eighty,";
				$s .= "placeholder_eightyone,";
				$s .= "placeholder_eightytwo,";
				$s .= "placeholder_eightythree";
				$s .= ") values (null," . $trialDefaults[$zz]["leadpop_id"] . ",";
				$s .= $placeholder_id . ",";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_one'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_two'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_three'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_four'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_five'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_six'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_seven'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_eight'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_nine'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_ten'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_eleven'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_twelve'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_thirteen'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_fourteen'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_fifteen'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_sixteen'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_seventeen'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_eighteen'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_nineteen'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_twenty'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_twentyone'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_twentytwo'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_twentythree'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_twentyfour'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_twentyfive'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_twentysix'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_twentyseven'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_twentyeight'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_twentynine'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_thirty'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_thirtyone'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_thirtytwo'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_thirtythree'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_thirtyfour'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_thirtyfive'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_thirtysix'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_thirtyseven'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_thirtyeight'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_thirtynine'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_forty'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_fortyone'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_fortytwo'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_fortythree'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_fortyfour'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_fortyfive'] ) . "', ";
				$s .= "'" . $placeholder_values ['placeholder_fortysix'] . "', ";
				$s .= "'" . $placeholder_values ['placeholder_fortyseven'] . "', ";
				$s .= "'" . $verticalName . "', ";
				$s .= "'" . $subverticalName . "', ";
				$s .= "'" . $trialDefaults[$zz]["leadpop_version_id"] . "',  ";
				$s .= "'" . $placeholder_values ['placeholder_fiftyone'] . "', ";
				$s .= "'" . $placeholder_values ['placeholder_fiftytwo'] . "', ";
				$s .= "'" . $placeholder_values ['placeholder_fiftythree'] . "', ";
				$s .= "'" . $placeholder_values ['placeholder_fiftyfour'] . "', ";
				$s .= "'" . $placeholder_values ['placeholder_fiftyfive'] . "', ";
				$s .= "'" . $placeholder_values ['placeholder_fiftysix'] . "', ";
				$s .= "'" . $placeholder_values ['placeholder_fiftyseven'] . "', ";
				$s .= "'" . $placeholder_values ['placeholder_fiftyeight'] . "', ";
				$s .= "'" . $placeholder_values ['placeholder_fiftynine'] . "', ";
				$s .= "'" . $placeholder_values ['placeholder_sixty'] . "', ";
				$s .= "'" . strtolower ( str_replace ( " ", "", $imgsrc ) ) . "', ";
				$s .= "'" . strtolower ( str_replace ( " ", "", $logosrc ) ) . "', ";
				$s .= "'" . $template_info ['csspath'] . "', ";
				$s .= "'" . $template_info ['imagepath'] . "', ";
				$s .= "'" . addslashes ( $submissionText ) . "', ";
				// $client ['company_name'] = ucwords(strtolower($client ['company_name']));
				// $s .= "'" . addslashes ( $client ['company_name'] ) . "', ";
				$s .= "'', ";
				$client ['phone_number'] = str_replace(")-",") ",$client ['phone_number']);
				$tempPhone = "'Call Today! " . $client ['phone_number'] . "',";
				$s .= $tempPhone;
				$s .= "'" . $client ['contact_email'] . "', ";

				$lead_line = '<span style="font-family: '.$trialDefaults[$zz]["main_message_font"].'; font-size: '.$trialDefaults[$zz]["main_message_font_size"].'; color: '. ($globallogo_color==""?$trialDefaults[$zz]["mainmessage_color"]:$globallogo_color).'">'.$trialDefaults[$zz]["main_message"].'</span>';
				$s .= "'" . addslashes ( $lead_line ) . "', ";
				$second_line = '<span style="font-family: '.$trialDefaults[$zz]["description_font"].'; font-size: '.$trialDefaults[$zz]["description_font_size"].'; color: '. $trialDefaults[$zz]["description_color"] .'">'.$trialDefaults[$zz]["description"].'</span>';

				$s .= "'" . addslashes ( $second_line ) . "', ";
				$s .= "'" . $placeholder_values ['placeholder_seventyone'] . "', ";
				$s .= "'" . $placeholder_values ['placeholder_seventytwo'] . "', ";
				$s .= "'" . addslashes ( $title_tag ) . "', ";
				$s .= "'" . $placeholder_values ['placeholder_seventyfour'] . "', ";
				$s .= "'" . $placeholder_values ['placeholder_seventyfive'] . "', ";
				$s .= "'" . $placeholder_values['placeholder_seventysix'] . "', ";
				$s .= "'" . $placeholder_values['placeholder_seventyseven'] . "', ";
				$s .= "'" . $placeholder_values ['placeholder_seventyeight'] . "', ";
				$s .= "'" . $placeholder_values['placeholder_seventynine'] . "', ";
				$s .= "'" . $placeholder_values['placeholder_eighty'] . "', ";
				$s .= "'" . $placeholder_values['placeholder_eightyone'] . "', ";
				$s .= "'" . $placeholder_values['placeholder_eightytwo'] . "', ";
				$s .= "'" . $placeholder_values['placeholder_eightythree'] . "' ";
				$s .= ")";
				$xzdb->query ($s);
			}

/*
$trialDefaults[$zz]["leadpop_vertical_id"]
$trialDefaults[$zz]["leadpop_vertical_sub_id"]
$trialDefaults[$zz]['leadpop_template_id']
$trialDefaults[$zz]["leadpop_id"]
$trialDefaults[$zz]["leadpop_version_id"]
$trialDefaults[$zz]["leadpop_version_seq"]
*/

			$s = "select id from leadpops_templates_placeholders ";
			$s .= " where leadpop_template_id = " . $trialDefaults[$zz]['leadpop_template_id'];
			$s .= " and client_id = " . $client_id;
			$s .= " and leadpop_version_seq = " . $trialDefaults[$zz]["leadpop_version_seq"];

			$leadpops_templates_placeholders = $xzdb->fetchAll ( $s );

			for($xx = 0; $xx < count ( $leadpops_templates_placeholders ); $xx ++) {
				$s = "update leadpops_templates_placeholders_values  set placeholder_forty= '" . addslashes ( $submissionText ) . "' ";
				$s .= " where client_leadpop_id = " . $trialDefaults[$zz]["leadpop_id"];
				$s .= " and leadpop_template_placeholder_id = " . $leadpops_templates_placeholders [$xx] ['id'];
				$xzdb->query ( $s );
			}
			/*  set default submission options  ******************************************************************************** */
			/*  set default contact_options  ******************************************************************************** */

			for($xx = 0; $xx < count ( $leadpops_templates_placeholders ); $xx ++) {
				$s = "update leadpops_templates_placeholders_values  set placeholder_fortyone = '' , ";
				$s .= "placeholder_fortytwo = '', placeholder_fortythree = ''  where client_leadpop_id = " . $trialDefaults[$zz]["leadpop_id"];
				$s .= " and leadpop_template_placeholder_id = " . $leadpops_templates_placeholders [$xx] ['id'];
				$xzdb->query ( $s );
			}

			for($xx = 0; $xx < count ( $leadpops_templates_placeholders ); $xx ++) {
				$s = "update leadpops_templates_placeholders_values  set placeholder_fortyone = '" . addslashes ( $client["company_name"] ) . "'  ";
				$s .= "  where client_leadpop_id = " . $trialDefaults[$zz]["leadpop_id"];
				$s .= " and leadpop_template_placeholder_id = " . $leadpops_templates_placeholders [$xx] ['id'];
				$xzdb->query ( $s );
			}
			for($xx = 0; $xx < count ( $leadpops_templates_placeholders ); $xx ++) {
				$s = "update leadpops_templates_placeholders_values  set placeholder_fortytwo = '" . addslashes ( $client["phone_number"] ) . "'  ";
				$s .= "  where client_leadpop_id = " . $trialDefaults[$zz]["leadpop_id"];
				$s .= " and leadpop_template_placeholder_id = " . $leadpops_templates_placeholders [$xx] ['id'];
				$xzdb->query ( $s );
			}
			for($xx = 0; $xx < count ( $leadpops_templates_placeholders ); $xx ++) {
				$s = "update leadpops_templates_placeholders_values  set placeholder_fortythree = '" . addslashes ( $client["contact_email"] ) . "'  ";
				$s .= "  where client_leadpop_id = " . $trialDefaults[$zz]["leadpop_id"];
				$s .= " and leadpop_template_placeholder_id = " . $leadpops_templates_placeholders [$xx] ['id'];
				$xzdb->query ( $s );
			}

			/*  set default contact_options  ******************************************************************************** */
			/*  set default auto_responder options  ******************************************************************************** */

			for($xx = 0; $xx < count ( $leadpops_templates_placeholders ); $xx ++) {
				$s = "update leadpops_templates_placeholders_values  set placeholder_fortysix = '<p>Thank you for your submission.</p>' ";
				$s .= " where client_leadpop_id = " . $trialDefaults[$zz]["leadpop_id"];
				$s .= " and leadpop_template_placeholder_id = " . $leadpops_templates_placeholders [$xx] ['id'];
				$xzdb->query ( $s );
			}

			for($xx = 0; $xx < count ( $leadpops_templates_placeholders ); $xx ++) {
				$s = " update leadpops_templates_placeholders_values  set placeholder_thirtyseven = '" . $logosrc . "'  where client_leadpop_id = " . $trialDefaults[$zz]["leadpop_id"];
				$s .= " and leadpop_template_placeholder_id = " . $leadpops_templates_placeholders [$xx] ['id'];
				$xzdb->query ( $s );
			}

			for($xx = 0; $xx < count ( $leadpops_templates_placeholders ); $xx ++) {
			    $s = " update leadpops_templates_placeholders_values  set placeholder_sixtytwo = '".$globallogosrc."', placeholder_eightyone = '".$globallogo_color."' , placeholder_eightytwo = '".$globalcolored_dot."', placeholder_eightythree = '".$globalfavicon_dst."'  where client_leadpop_id = " . $trialDefaults[$zz]["leadpop_id"];
			    $s .= " and leadpop_template_placeholder_id = " . $leadpops_templates_placeholders[$xx]['id'];
			    $xzdb->query($s);
			}

/*
$trialDefaults[$zz]["leadpop_vertical_id"]
$trialDefaults[$zz]["leadpop_vertical_sub_id"]
$trialDefaults[$zz]['leadpop_template_id']
$trialDefaults[$zz]["leadpop_id"]
$trialDefaults[$zz]["leadpop_version_id"]
$trialDefaults[$zz]["leadpop_version_seq"]
*/
   /*         if ($generatecolors == false && $useUploadedLogo == true) { // not uploaded logo or have previous funnel to use
				for($t = 0; $t < count($finalTrialColors); $t++) {
					$s = "insert into leadpop_background_swatches (id,client_id,leadpop_vertical_id,";
					$s .= "leadpop_vertical_sub_id,leadpop_type_id,leadpop_template_id,";
					$s .= "leadpop_id,leadpop_version_id,leadpop_version_seq,";
					$s .= "swatch,is_primary,active) values (null,";
					$s .= $client_id . "," . $trialDefaults[$zz]["leadpop_vertical_id"] . ",";
					$s .= $trialDefaults[$zz]["leadpop_vertical_sub_id"] . ",";
					$s .= $leadpoptype . "," . $trialDefaults[$zz]['leadpop_template_id'] . ",";
					$s .= $trialDefaults[$zz]["leadpop_id"] . ",";
					$s .= $trialDefaults[$zz]["leadpop_version_id"] . ",";
					$s .= $trialDefaults[$zz]["leadpop_version_seq"] . ",";
					$s .= "'" . $finalTrialColors[$t]["swatch"] . "',";
					if ($t == 0 ) {
						$s .= "'y',";
					}
					else {
						$s .= "'n',";
					}
					$s .= "'y')";
					$xzdb->query($s);
				}

				$s = "insert into leadpop_background_color (id,client_id,leadpop_vertical_id,";
				$s .= "leadpop_vertical_sub_id,leadpop_type_id,leadpop_template_id,";
				$s .= "leadpop_id,leadpop_version_id,leadpop_version_seq,";
				$s .= "background_color,active,default_changed) values (null,";
				$s .= $client_id . "," . $trialDefaults[$zz]["leadpop_vertical_id"] . ",";
				$s .= $trialDefaults[$zz]["leadpop_vertical_sub_id"] . ",";
				$s .= $leadpoptype . "," . $trialDefaults[$zz]['leadpop_template_id'] . ",";
				$s .= $trialDefaults[$zz]["leadpop_id"] . ",";
				$s .= $trialDefaults[$zz]["leadpop_version_id"] . ",";
				$s .= $trialDefaults[$zz]["leadpop_version_seq"] . ",";
				$s .= "'" . addslashes($background_css) . "','y','".$default_background_changed."')";
				$xzdb->query($s);
			} */


//end ********************************************
		}
		print("addNonEnterpriseVerticalToExistingClient added " . $client_id);
}

function addNonEnterpriseVerticalSubverticalVersionToExistingClient($xpvertical_id , $subvertical_id,$version_id,$client_id,$logo="",$mobilelogo="",
                                        $origvertical_id="",$origsubvertical_id="",$origversion_id="",$origleadpop_type_id="", $origleadpop_template_id="",
										$origleadpop_id="",$origleadpop_version_id="",$origleadpop_version_seq="") {
		global $thissub_domain;
		global $thistop_domain;
		global$leadpoptype;
		global $db;
		global $xzdb;

        require_once '/var/www/vhosts/launch.leadpops.com/external/Image.php';
        require_once '/var/www/vhosts/launch.leadpops.com/external/Client.php';

		global $globallogosrc;
		global $globalfavicon_dst;
		global $globallogo_color;
		global $globalcolored_dot;

//        $tbigvertical_id = $pvertical_id;
		/*      fish       */
	    $section = substr($client_id,0,1);

		if ($xpvertical_id == "1") {
			$vertical = "insurance";
		}
		else if ($xpvertical_id == "3") {
			$vertical = "mortgage";
		}
		else if ($xpvertical_id == "5") {
			$vertical = "realestate";
		}

//die($xpvertical_id);

		$s = "select * from clients where client_id = " . $client_id;
		$client = $xzdb->fetchRow($s);
		$client ['company_name'] = ucfirst(strtolower($client ['company_name']));
		$enteredEmail = $client["contact_email"]; // use this to look up in IFS

//       /var/www/vhosts/myleads.leadpops.com/images/clients/7/702/logos/702_22_1_3_8_11_11_1_et2bn1cudzrrji5smkay.png
//       /var/www/vhosts/itclixmobile.com/css/refinance11/themes/images/702grouplogo.png
         $generatecolors = false;
         if ($logo == "" && $mobilelogo == "") { // inother words use defaults for logo and mobile logo
			$useUploadedLogo = false;
		    $default_background_changed = "n";
		 }
         else if ($logo != "" && $mobilelogo != "" && $origleadpop_type_id != "" && $origleadpop_template_id != "" && $origleadpop_id != "" && $origleadpop_version_id !="" && $origleadpop_version_seq !="") {
		     $default_background_changed = "y";
             $generatecolors = false;  // in other workds use existing logo and mobile logo and copy them to new funnel as if no upload was done
		     $useUploadedLogo = true;
		 }
         else if ($logo != "" && $mobilelogo == "" && $origleadpop_type_id == "" && $origleadpop_template_id == "" && $origleadpop_id == "" && $origleadpop_version_id =="" && $origleadpop_version_seq =="") {
	        $default_background_changed = "y";
            $generatecolors = true;  // in other words act as if a new logo was uploaded & generate mobile logo
			$useUploadedLogo = true;
		 }


        if ($generatecolors == false && $useUploadedLogo == false) { // not uploaded logo or have previous funnel to use

			$s = "select * from trial_launch_defaults where leadpop_vertical_id = " . $xpvertical_id . " and leadpop_vertical_sub_id = " . $subvertical_id . " and leadpop_version_id = " . $version_id . " limit 1 ";

			$trialDefaults = $xzdb->fetchAll($s);
			$s = "select * from default_swatches where active = 'y' order by id ";
			$finalTrialColors = $xzdb->fetchAll($s);
            $background_css = "linear-gradient(to bottom, rgba(108, 124, 156, 0.99) 0%, rgba(108, 124, 156, 0.99) 100%)";

 	        $cmd = '/bin/cp  /var/www/vhosts/launch.leadpops.com/trial/classiclogos/' . $trialDefaults[0]["logo_name_mobile"] . '  /var/www/vhosts/itclixmobile.com/css/'.str_replace(" ","",$trialDefaults[0]["subvertical_name"]).$trialDefaults[0]["leadpop_version_id"] . '/themes/images/' . $client_id . 'grouplogo.png';
            exec($cmd);

  		    $s = "select * from leadpops_verticals where id = " . $trialDefaults[0]["leadpop_vertical_id"];
		    $vertres = $xzdb->fetchRow ( $s );
		    $verticalName = $vertres ['lead_pop_vertical'];

			$s = "select * from leadpops_verticals_sub where leadpop_vertical_id  = " . $trialDefaults[0]["leadpop_vertical_id"];
			$s .= " and id = " . $trialDefaults[0]["leadpop_vertical_sub_id"];
			$subvertres = $xzdb->fetchRow ( $s );
			$subverticalName = $subvertres ['lead_pop_vertical_sub'];

			$logosrc = getHttpServer () . '/images/' . strtolower(str_replace(" ","",$verticalName)) . '/' . strtolower(str_replace(" ","",$subverticalName)). '_logos/' .$trialDefaults[0]["logo_name"];
		    insertDefaultClientUploadLogo($logosrc,$trialDefaults[0],$client_id);
		    $imgsrc = insertClientDefaultImage($trialDefaults[0],$client_id);


		}
        else if ($generatecolors == false && $useUploadedLogo == true) { // get colors from leadpops_background_swatches

			$y = "select * from trial_launch_defaults where leadpop_vertical_id = ".$xpvertical_id." and leadpop_vertical_sub_id = " . $subvertical_id . " and leadpop_version_id = " . $version_id . " limit 1 ";
			$trialDefaults = $xzdb->fetchAll($y);

            $s = "select * from leadpop_background_swatches ";
			$s .= " where  client_id = " . $client_id;
			$s .= " and leadpop_vertical_id = " . $origvertical_id;
			$s .= " and leadpop_vertical_sub_id =  " . $origsubvertical_id;
			$s .= " and leadpop_type_id  = " . $origleadpop_type_id;
			$s .= " and leadpop_template_id = " . $origleadpop_template_id;
			$s .= " and  leadpop_id = " . $origleadpop_id;
			$s .= " and leadpop_version_id = " . $origleadpop_version_id;
			$s .= " and leadpop_version_seq = " . $origleadpop_version_seq;
			$finalTrialColors = $xzdb->fetchAll($s);

			for($t = 0; $t < count($finalTrialColors); $t++) {
				$s = "insert into leadpop_background_swatches (id,client_id,leadpop_vertical_id,";
				$s .= "leadpop_vertical_sub_id,leadpop_type_id,leadpop_template_id,";
				$s .= "leadpop_id,leadpop_version_id,leadpop_version_seq,";
				$s .= "swatch,is_primary,active) values (null,";
				$s .= $client_id . "," . $trialDefaults[0]["leadpop_vertical_id"] . ",";
				$s .= $trialDefaults[0]["leadpop_vertical_sub_id"] . ",";
				$s .= $leadpoptype . "," . $trialDefaults[0]['leadpop_template_id'] . ",";
				$s .= $trialDefaults[0]["leadpop_id"] . ",";
				$s .= $trialDefaults[0]["leadpop_version_id"] . ",";
				$s .= $trialDefaults[0]["leadpop_version_seq"] . ",";
				$s .= "'" . $finalTrialColors[$t]["swatch"] . "','".$finalTrialColors[$t]["is_primary"]."',";
				$s .= "'y')";
				$xzdb->query($s);
			}

            $s = "select background_color from leadpop_background_color ";
			$s .= " where  client_id = " . $client_id;
			$s .= " and leadpop_version_id = " . $origleadpop_version_id;
			$s .= " and leadpop_version_seq = " . $origleadpop_version_seq . " limit 1 ";
            $background_css = $xzdb->fetchOne($s);

			$s = "insert into leadpop_background_color (id,client_id,leadpop_vertical_id,";
			$s .= "leadpop_vertical_sub_id,leadpop_type_id,leadpop_template_id,";
			$s .= "leadpop_id,leadpop_version_id,leadpop_version_seq,";
			$s .= "background_color,active,default_changed) values (null,";
			$s .= $client_id . "," . $trialDefaults[0]["leadpop_vertical_id"] . ",";
			$s .= $trialDefaults[0]["leadpop_vertical_sub_id"] . ",";
			$s .= $leadpoptype . "," . $trialDefaults[0]['leadpop_template_id'] . ",";
			$s .= $trialDefaults[0]["leadpop_id"] . ",";
			$s .= $trialDefaults[0]["leadpop_version_id"] . ",";
			$s .= $trialDefaults[0]["leadpop_version_seq"] . ",";
			$s .= "'" . addslashes($background_css) . "','y','".$default_background_changed."')";
			$xzdb->query($s);

            $s = "select logo_color  from leadpop_logos ";
			$s .= " where  client_id = " . $client_id;
			$s .= " and leadpop_vertical_id = " . $origvertical_id;
			$s .= " and leadpop_vertical_sub_id  = " . $origsubvertical_id;
			$s .= " and leadpop_type_id  = " . $origleadpop_type_id;
			$s .= " and leadpop_template_id = " . $origleadpop_template_id;
			$s .= " and  leadpop_id = " . $origleadpop_id;
			$s .= " and leadpop_version_id = " . $origleadpop_version_id;
			$s .= " and leadpop_version_seq = " . $origleadpop_version_seq . " limit 1 ";
			$colors = $xzdb->fetchAll($s);


             // copy logo to new logo name
			  $logopath = '/var/www/vhosts/myleads.leadpops.com/images/clients/'.$section.'/'.$client_id.'/logos/';
			  $origlogo = $logopath . $logo;
			  $newlogoname = strtolower($client_id."_".$trialDefaults[0]["leadpop_id"]."_".$trialDefaults[0]["leadpop_type_id"]."_".$trialDefaults[0]["leadpop_vertical_id"]."_".$trialDefaults[0]["leadpop_vertical_sub_id"]."_".$trialDefaults[0]["leadpop_template_id"]."_".$trialDefaults[0]["leadpop_version_id"]."_".$trialDefaults[0]["leadpop_version_seq"]."_".$logo);
			  $newlogo = $logopath . $newlogoname;
			  $cmd = '/bin/cp  ' .$origlogo . '   ' . $newlogo;
			  exec($cmd);

			  // copy mobile logo to new name
			$s = "select include_path from mobile_paths where leadpop_id = " . $origleadpop_id . " limit 1 ";
			$origDestinationDirectory = $xzdb->fetchOne($s);
			$origCopyDestinationDirectoryFile   = "/var/www/vhosts/itclixmobile.com" .$origDestinationDirectory . $mobilelogo;

			$s = "select include_path from mobile_paths where leadpop_id = " . $trialDefaults[0]["leadpop_id"] . " limit 1 ";
			$DestinationDirectory = $xzdb->fetchOne($s);
		    $newmobilelogo = $client_id . "grouplogo.png";
			$CopyDestinationDirectoryFile = "/var/www/vhosts/itclixmobile.com" . $DestinationDirectory . $newmobilelogo;
		    $cmd = '/bin/cp  ' . $origCopyDestinationDirectoryFile . '   ' . $CopyDestinationDirectoryFile;
		    exec($cmd);

		   $oldfilename = strtolower($client_id."_".$origleadpop_id."_".$origleadpop_type_id."_".$origvertical_id."_".$origsubvertical_id."_".$origleadpop_template_id."_".$origleadpop_version_id."_".$origleadpop_version_seq);
	       $newfilename = $client_id."_".$trialDefaults[0]["leadpop_id"]."_1_".$trialDefaults[0]["leadpop_vertical_id"]."_".$trialDefaults[0]["leadpop_vertical_sub_id"]."_".$trialDefaults[0]['leadpop_template_id']."_".$trialDefaults[0]["leadpop_version_id"]."_".$trialDefaults[0]["leadpop_version_seq"];

		   $origfavicon_dst_src = '/var/www/vhosts/myleads.leadpops.com/images/clients/'. substr($client_id,0,1) . '/' . $client_id.'/logos/'.$oldfilename.'_favicon-circle.png';
		   $newfavicon_dst_src = '/var/www/vhosts/myleads.leadpops.com/images/clients/'. substr($client_id,0,1) . '/' . $client_id.'/logos/'.$newfilename.'_favicon-circle.png';
		   $cmd = '/bin/cp  ' . $origfavicon_dst_src . '   ' . $newfavicon_dst_src;
		   exec($cmd);

		   $origcolored_dot_src = '/var/www/vhosts/myleads.leadpops.com/images/clients/'. substr($client_id,0,1) . '/' . $client_id.'/logos/'.$oldfilename.'_dot_img.png';
		   $newcolored_dot_src = '/var/www/vhosts/myleads.leadpops.com/images/clients/'. substr($client_id,0,1) . '/' . $client_id.'/logos/'.$newfilename.'_dot_img.png';

		   $cmd = '/bin/cp  ' . $origcolored_dot_src . '   ' . $newcolored_dot_src;
		   exec($cmd);

		    $logosrc = newinsertClientUploadLogo($newlogoname,$trialDefaults[0],$client_id);
		    $imgsrc = insertClientNotDefaultImage($trialDefaults[0],$client_id,$origleadpop_id,$origleadpop_type_id,$origvertical_id,$origsubvertical_id,$origleadpop_template_id,$origleadpop_version_id,$origleadpop_version_seq);

		  $globallogosrc = $logosrc;
		  $globalfavicon_dst = $newfavicon_dst_src;
		  $globallogo_color = $colors[0]["logo_color"];
		  $globalcolored_dot = $newcolored_dot_src;

            // set mobile logo varibale

		}
        else if ($generatecolors == true && $useUploadedLogo == true) { //

			$s = "select * from trial_launch_defaults where leadpop_vertical_id = " . $xpvertical_id . " and leadpop_vertical_sub_id = " . $subvertical_id . " and leadpop_version_id = " . $version_id . " limit 1 ";
			$trialDefaults = $xzdb->fetchAll($s);
//	      id leadpop_vertical_id	leadpop_vertical_sub_id	leadpop_type_id	leadpop_template_id	leadpop_id	leadpop_version_id	leadpop_version_seq
//       /var/www/vhosts/myleads.leadpops.com/images/clients/7/702/logos/ 702_22_1_3_8_11_11_1_et2bn1cudzrrji5smkay.png
//       /var/www/vhosts/itclixmobile.com/css/refinance11/themes/images/    702grouplogo.png
// pass in logo name only
          $logopath = '/var/www/vhosts/myleads.leadpops.com/images/clients/'.$section.'/'.$client_id.'/logos/';
		  $origlogo = $logopath . $logo;
          $newlogoname = strtolower($client_id."_".$trialDefaults[0]["leadpop_id"]."_".$trialDefaults[0]["leadpop_type_id"]."_".$trialDefaults[0]["leadpop_vertical_id"]."_".$trialDefaults[0]["leadpop_vertical_sub_id"]."_".$trialDefaults[0]["leadpop_template_id"]."_".$trialDefaults[0]["leadpop_version_id"]."_".$trialDefaults[0]["leadpop_version_seq"]."_".$logo);

		  $newlogo = $logopath . $newlogoname;

          $cmd = '/bin/cp  ' .$origlogo . '   ' . $newlogo;
          exec($cmd);

          $oclient = new Client();

          $gis       = getimagesize($newlogo);
          $ow = $gis[0];
          $oh = $gis[1];
          $type = $gis[2];
         //die($type.' type');
          switch($type)
          {
                case "1":
                	$im = imagecreatefromgif($newlogo);
                	$image = $oclient->loadGif($newlogo);
          			$logo_color = $image->extract();
                break;
                case "2":
                	$im = imagecreatefromjpeg($newlogo);
                	$image = $oclient->loadJpeg($newlogo);
                	$logo_color = $image->extract();
                	break;
                case "3":
                	$im = imagecreatefrompng($newlogo);
                	$image = $oclient->loadPng($newlogo);
          			$logo_color = $image->extract();
                	break;
                default:  $im = imagecreatefromjpeg($newlogo);
          }

          if(is_array($logo_color)){
          	$logo_color = $logo_color[0];
          }

          $imagetype = image_type_to_mime_type($type);
          if($imagetype != 'image/jpeg' && $imagetype != 'image/png' &&  $imagetype != 'image/gif' ) {
              return 'bad' ;
          }

          $s = "insert into leadpop_logos (id,client_id,leadpop_id,leadpop_type_id,";
          $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,";
          $s .= "leadpop_version_id,leadpop_version_seq,use_default,";
          $s .= "logo_src,use_me,numpics,logo_color,ini_logo_color) values (null,";
          $s .= $client_id.",".$trialDefaults[0]["leadpop_id"].",".$trialDefaults[0]["leadpop_type_id"].",".$trialDefaults[0]["leadpop_vertical_id"].",".$trialDefaults[0]["leadpop_vertical_sub_id"].",";
          $s .= $trialDefaults[0]["leadpop_template_id"].",".$trialDefaults[0]["leadpop_version_id"].",".$trialDefaults[0]["leadpop_version_seq"].",";
          $s .= "'n','".$newlogoname."','y',1, '".$logo_color."','".$logo_color."') ";
          $xzdb->query($s);

		  $logosrc = getHttpAdminServer().'/images/clients/'. substr($client_id,0,1) . '/' . $client_id.'/logos/'. $newlogoname;

			$image_location = "/var/www/vhosts/itclix.com/images/dot-img.png";
			$favicon_location = "/var/www/vhosts/itclix.com/images/favicon-circle.png";
			$favicon_dst_src = '/var/www/vhosts/myleads.leadpops.com/images/clients/'. $section . '/' . $client_id.'/logos/'.$newlogoname.'_favicon-circle.png';
			$colored_dot_src = '/var/www/vhosts/myleads.leadpops.com/images/clients/'. $section . '/' . $client_id.'/logos/'.$newlogoname.'_dot_img.png';

			if (isset($logo_color) && $logo_color != "" ) {
				$new_clr = hex2rgb($logo_color);
			}

			$im = imagecreatefrompng($image_location);
			$myRed =  $new_clr[0];
			$myGreen =  $new_clr[1];
			$myBlue =  $new_clr[2];

			colorizeBasedOnAplhaChannnel( $image_location, $myRed, $myGreen, $myBlue, $colored_dot_src);
			colorizeBasedOnAplhaChannnel( $favicon_location, $myRed, $myGreen, $myBlue, $favicon_dst_src);

		    $colored_dot = getHttpAdminServer().'/images/clients/'. substr($client_id,0,1) . '/' . $client_id.'/logos/'.$newlogoname.'_dot_img.png';
		    $favicon_dst = getHttpAdminServer().'/images/clients/'. substr($client_id,0,1) . '/' . $client_id.'/logos/'.$newlogoname.'_favicon-circle.png';

		  	$swatches =   "213-230-229#23-177-163#159-182-183#65-88-96#110-158-159#132-212-204" ;

		  	$result = explode("#",$swatches);
		  	$new_color = hex2rgb($logo_color);
		  	$index = 0;
        	array_unshift($result, implode('-', $new_color));

        	// SET BACKGROUND COLOR
        	$background_from_logo = '/*###>*/background-color: rgba('.$new_color[0].', '.$new_color[1].', '.$new_color[2].', 1);/*@@@*/
			background-image: linear-gradient(to right bottom,rgba('.$new_color[0].', '.$new_color[1].', '.$new_color[2].', 1) 0%,rgba('.$new_color[0].', '.$new_color[1].', '.$new_color[2].', 1) 100%); /* W3C */';

			$s = "insert into leadpop_background_color (id,client_id,leadpop_vertical_id,";
			$s .= "leadpop_vertical_sub_id,leadpop_type_id,leadpop_template_id,";
			$s .= "leadpop_id,leadpop_version_id,leadpop_version_seq,";
			$s .= "background_color,active,default_changed) values (null,";
			$s .= $client_id . "," . $trialDefaults[0]["leadpop_vertical_id"] . ",";
			$s .= $trialDefaults[0]["leadpop_vertical_sub_id"] . ",";
			$s .= $trialDefaults[0]["leadpop_type_id"] . "," . $trialDefaults[0]["leadpop_template_id"] . ",";
			$s .= $trialDefaults[0]["leadpop_id"] . ",";
			$s .= $trialDefaults[0]["leadpop_version_id"] . ",";
			$s .= $trialDefaults[0]["leadpop_version_seq"] . ",";
			$s .= "'" . addslashes($background_from_logo) . "','y','y')";
			$xzdb->query($s);

			foreach($result as $key => $value) {

				  	list($red,$green,$blue) = explode("-",$value);

					if($key<1){
						$str0 = "linear-gradient(to bottom, rgba(".$red.",".$green.",".$blue.",1.0) 0%,rgba(".$red.",".$green.",".$blue.",1.0) 100%)";
					}else{
						$str0 = "linear-gradient(to bottom, rgba(".$red.",".$green.",".$blue.",1.0) 0%,rgba(".$red.",".$green.",".$blue.",.7) 100%)";
					}

					$str1 = "linear-gradient(to top, rgba(".$red.",".$green.",".$blue.",1.0) 0%,rgba(".$red.",".$green.",".$blue.",.7) 100%)";
				    $str2 = "linear-gradient(to bottom right, rgba(".$red.",".$green.",".$blue.",1.0) 0%,rgba(".$red.",".$green.",".$blue.",.7) 100%)";
				    $str3 = "linear-gradient(to bottom, rgba(".$red.",".$green.",".$blue.",1.0) 0%,rgba(".$red.",".$green.",".$blue.",1.0) 100%)";

			  		$swatches = array($str0,$str1,$str2,$str3);
			      	for($i=0;  $i<4; $i++) {
			      		$index++;
			      		$is_primary = 'n';
			      		if($index==1){
			      			$is_primary = 'y';
			      		}

						$s = "insert into leadpop_background_swatches (id,client_id,leadpop_vertical_id,";
						$s .= "leadpop_vertical_sub_id,leadpop_type_id,leadpop_template_id,";
						$s .= "leadpop_id,leadpop_version_id,leadpop_version_seq,";
						$s .= "swatch,is_primary,active) values (null,";
						$s .= $client_id . "," . $trialDefaults[0]["leadpop_vertical_id"] . ",";
						$s .= $trialDefaults[0]["leadpop_vertical_sub_id"] . ",";
						$s .= $trialDefaults[0]["leadpop_type_id"] . "," . $trialDefaults[0]["leadpop_template_id"] . ",";
						$s .= $trialDefaults[0]["leadpop_id"] . ",";
						$s .= $trialDefaults[0]["leadpop_version_id"] . ",";
						$s .= $trialDefaults[0]["leadpop_version_seq"] . ",";
						$s .= "'" . addslashes($swatches[$i]) . "',";
						$s .= "'".$is_primary."','y')";
						$xzdb->query($s);

				  	}
			}

            $s = "select background_color from leadpop_background_color ";
			$s .= " where  client_id = " . $client_id;
			$s .= " and leadpop_version_id = " . $trialDefaults[0]["leadpop_version_id"];
			$s .= " and leadpop_version_seq = " . $trialDefaults[0]["leadpop_version_seq"] . " limit 1 ";
            $background_css = $xzdb->fetchOne($s);

            $s = "select * from leadpop_background_swatches ";
			$s .= " where  client_id = " . $client_id;
			$s .= " and leadpop_vertical_id = " . $trialDefaults[0]["leadpop_vertical_id"];
			$s .= " and leadpop_vertical_sub_id = " . $trialDefaults[0]["leadpop_vertical_sub_id"];
			$s .= " and leadpop_type_id  = " . $trialDefaults[0]["leadpop_type_id"];
			$s .= " and leadpop_template_id = " . $trialDefaults[0]["leadpop_template_id"];
			$s .= " and  leadpop_id = " . $trialDefaults[0]["leadpop_id"];
			$s .= " and leadpop_version_id = " . $trialDefaults[0]["leadpop_version_id"];
			$s .= " and leadpop_version_seq = " . $trialDefaults[0]["leadpop_version_seq"] . " limit 1 ";
			$finalTrialColors = $xzdb->fetchAll($s);

		    $logo = $newlogoname; // set $logo to be used down stream
			/* now generate the mobile logo mobile logo mobile logo mobile logo mobile logo mobile logo */
			/* now generate the mobile logo mobile logo mobile logo mobile logo mobile logo mobile logo */
			/* now generate the mobile logo mobile logo mobile logo mobile logo mobile logo mobile logo */
			$s = "select include_path from mobile_paths where leadpop_id = " . $trialDefaults[0]["leadpop_id"] . " limit 1 ";
			$DestinationDirectory = $xzdb->fetchOne($s);
			$CopyDestinationDirectoryFile = "/var/www/vhosts/itclixmobile.com" . $DestinationDirectory;
			$DestinationDirectory = "/var/www/vhosts/myleads.leadpops.com/data/mobileimages/";
			$Quality = 90;
            // set mobile logo varibale
		    $mobilelogo = $client_id . "grouplogo.png";

			$resize = true;
			if ($ow <= 320  &&  $oh <= 70) { // best fit for logo image is no larger than this
			    $resize = false;
			}

			$DestImageName = $DestinationDirectory . $mobilelogo; // Image with destination directory
            $CopyDestinationDirectoryFile = $CopyDestinationDirectoryFile . $mobilelogo;

	        resizeImage($ow,$oh,$DestImageName,$im,$Quality,$type,$resize,$newlogo);
            $cmd = '/bin/cp  ' . $DestImageName . '  ' . $CopyDestinationDirectoryFile;
            exec($cmd);

			/* now generate the mobile logo mobile logo mobile logo mobile logo mobile logo mobile logo */
			/* now generate the mobile logo mobile logo mobile logo mobile logo mobile logo mobile logo */
			/* now generate the mobile logo mobile logo mobile logo mobile logo mobile logo mobile logo */

		    $logosrc = newinsertClientUploadLogo($newlogoname,$trialDefaults[0],$client_id);
		    $imgsrc = insertClientDefaultImage($trialDefaults[0],$client_id);

		  $globallogosrc = $logosrc;
		  $globalfavicon_dst = $favicon_dst;
		  $globallogo_color = $logo_color;
		  $globalcolored_dot = $colored_dot;

		}

		$dt = date("Y-m-d H:i:s");
		$dname = '/var/www/vhosts/itclix.com/images/clients/' . substr($client_id,0,1) . '/' . $client_id;
		if (!file_exists($dname)) {
			createClientInitialDirectories($client_id);
        }

		// craete this array so as not to have to chg code
		$freeTrialBuilderAnswers = array("emailaddress" => $client["contact_email"],"phonenumber" => $client["phone_number"]);

            insertDefaultAutoResponders ($client_id, $trialDefaults[0], $client["contact_email"], $client["phone_number"]) ;

			$s = "select * from leadpops_template_info where leadpop_vertical_id = " . $trialDefaults[0]["leadpop_vertical_id"];
			$s .= " and leadpop_vertical_sub_id = " . $trialDefaults[0]["leadpop_vertical_sub_id"] . " and leadpop_version_id = " . $trialDefaults[0]["leadpop_version_id"];
			$template_info = $xzdb->fetchRow($s);

	        $now = new DateTime();
			$s = "insert into clients_leadpops (id,client_id,leadpop_id,leadpop_version_id,leadpop_active,access_code,leadpop_version_seq,date_added) values (null,";
			$s .= $client_id . "," . $trialDefaults[0]["leadpop_id"] . "," . $trialDefaults[0]["leadpop_version_id"] . ",'1',''," . $trialDefaults[0]["leadpop_version_seq"] . ",'".$now->format("Y-m-d H:i:s")."')";
			$xzdb->query ( $s );

			$s = "insert into clients_leadpops_content (id,client_id,leadpop_id,leadpop_version_id,leadpop_active,access_code,leadpop_version_seq,";
  			$s .= "section1,section2,section3,section4,section5,section6,section7,section8,section9,section10,template) values (null,";
			$s .= $client_id . "," . $trialDefaults[0]["leadpop_id"] . "," . $trialDefaults[0]["leadpop_version_id"] . ",'1',''," . $trialDefaults[0]["leadpop_version_seq"] . ",";
			$s .= "'<h4>section one</h4>','<h4>section two</h4>','<h4>section three</h4>','<h4>section four</h4>',";
			$s .= "'<h4>section five</h4>','<h4>section six</h4>','<h4>section seven</h4>','<h4>section eight</h4>','<h4>section nine</h4>',";
			$s .= "'<h4>section ten</h4>',1)";
			$xzdb->query($s);

			checkIfNeedMultipleStepInsert ( $trialDefaults[0]["leadpop_version_id"], $client_id );
			// look up domain name
			$s = "select * from clients where client_id = " . $client_id . " limit 1 ";
			$client = $xzdb->fetchRow($s);
			$subdomain = $client ['company_name'];
			$subdomain = preg_replace ( '/[^a-zA-Z]/', '', $subdomain );
			$s = "select domain from top_level_domains where primary_domain = 'y' limit 1 ";
			$topdomain = $xzdb->fetchOne ( $s );
			if ($leadpoptype == $thissub_domain) {
				$s = "select  count(*) from clients_subdomains where  ";
				$s .= " subdomain_name = '" . $subdomain . "' ";
				$s .= " and top_level_domain = '" . $topdomain . "' ";
				$foundsubdomain = $xzdb->fetchOne ( $s );
				if ($foundsubdomain > 0) {
				//die("ass");
					$s = "select domain from top_level_domains where primary_domain != 'y' ";
					$nonprimary = $xzdb->fetchAll ( $s );
					$foundone = false;
					while ( $foundone == false ) {
						for($k = 0; $k < count ( $nonprimary ); $k ++) {
							$s = "select  count(*) from clients_subdomains where  ";
							$s .= " subdomain_name = '" . $subdomain . "' ";
							$s .= " and top_level_domain = '" . $nonprimary [$k] ['domain'] . "' ";
							$foundsubdomain = $xzdb->fetchOne ( $s );
							if ($foundsubdomain == 0) {
								$s = "insert into clients_subdomains (id,client_id,subdomain_name,top_level_domain,leadpop_vertical_id,";
								$s .= "leadpop_vertical_sub_id,leadpop_type_id,leadpop_template_id,";
								$s .= "leadpop_id,leadpop_version_id,leadpop_version_seq ) values (null,";
								$s .= $client_id . ",'" . $subdomain . "','" . $nonprimary [$k] ['domain'] . "',";
								$s .= $trialDefaults[0]["leadpop_vertical_id"] . "," . $trialDefaults[0]["leadpop_vertical_sub_id"] . "," . $leadpoptype . "," . $trialDefaults[0]['leadpop_template_id'] . ",";
								$s .= $trialDefaults[0]["leadpop_id"] . "," . $trialDefaults[0]["leadpop_version_id"] . "," . $trialDefaults[0]["leadpop_version_seq"] . ")";
								$xzdb->query ( $s );
								/* emma insert */
								/* emma insert */
								/* emma insert */
								/* no emma for these folks
                                $s = "insert into client_emma_cron (id,client_id,emma_default_group,account_type,domain_name,account_name,master_account_ids,has_run, leadpop_vertical_id,leadpop_subvertical_id) values (null,";
    					        $s .= $client_id . ",'". $trialDefaults[0]['emma_default_group'] ."','".$emma_account_type."','". strtolower($subdomain . "." . $nonprimary [$k] ['domain']) ."','". $emma_account_name ."','";
								$s .= addslashes($emmaAccount) . "','n',".$trialDefaults[$i]["leadpop_vertical_id"].",".$trialDefaults[$i]["leadpop_vertical_sub_id"].")";
								$xzdb->query ($s);
								*/
								/* emma insert */
								/* emma insert */
								/* emma insert */

								$foundmobile = false;
								$randc = "";
								while ( $foundmobile == false ) {
									$s =  "select count(*) as cnt from mobileclients where mobiledomain = '".$subdomain . $randc .  ".itclixmobile.com'  ";
									$nummobile = $xzdb->fetchOne($s);
									if($nummobile == 0) {
										$foundmobile = true;
									}
									else {
										$randc = $randc . getRandomCharacter ();
									}
								}

                                if ($generatecolors == false && $useUploadedLogo == true) { // get mobile from old funnel
                                    // set 	client_or_domain_logo_image to 'c'  to use upploaded logo
									/* mobile domain and logo */
									$s = "select * from mobileclients  where client_id = " . $client_id ;
									$s .= " and leadpop_id = " . $origleadpop_id;
									$s .= " and leadpop_type_id = " . $origleadpop_type_id;
									$s .= " and leadpop_vertical_id = " . $origvertical_id;
									$s .= " and leadpop_vertical_sub_id = " . $origsubvertical_id;
									$s .=  " and leadpop_template_id = " . $origleadpop_template_id;
									$s .= " and leadpop_version_id = " . $origleadpop_version_id;
									$s .= " and leadpop_version_seq = " . $origleadpop_version_seq . " limit 1 ";
		                            $oldmobile = $xzdb->fetchAll($s);

									$s = "INSERT INTO mobileclients (nonmobiledomain, mobiledomain, client_id, id, leadpop_id, ";
									$s .= "leadpop_vertical_id,leadpop_vertical_sub_id, leadpop_type_id, leadpop_template_id,";
									$s .= "leadpop_version_id, leadpop_version_seq, ";
									$s .= "iszillow, zillow_api, active, group_design, phone, company,	client_or_domain_logo_image,call_to_action,thank_you) VALUES (";
									$s .= "'".$subdomain . "." . $nonprimary [$k] ['domain'] . "','" . $subdomain . $randc .".itclixmobile.com',";
									$s .= $client_id .",null,". $trialDefaults[0]["leadpop_id"] . "," . $trialDefaults[0]["leadpop_vertical_id"] . "," . $trialDefaults[0]["leadpop_vertical_sub_id"] . "," . $trialDefaults[0]["leadpop_type_id"] . "," .  $trialDefaults[0]['leadpop_template_id'];
									$s .= "," . $trialDefaults[0]["leadpop_version_id"] . "," . $trialDefaults[0]["leadpop_version_seq"] . ",'n','n','y','y','".preg_replace ('/[^0-9]/', '', $client ['phone_number'])."', '".addslashes($client ['company_name'])."','c','".addslashes($oldmobile[0]['call_to_action'])."','".addslashes($oldmobile[0]["thank_you"])."') ";
									$xzdb->query ($s);
								}
								else {
                                    // set 	client_or_domain_logo_image to 'o' for no uploaded logo
									/* mobile domain and logo */

									$s = "INSERT INTO mobileclients (nonmobiledomain, mobiledomain, client_id, id, leadpop_id, ";
									$s .= "leadpop_vertical_id,leadpop_vertical_sub_id, leadpop_type_id, leadpop_template_id,";
									$s .= "leadpop_version_id, leadpop_version_seq, ";
									$s .= "iszillow, zillow_api, active, group_design, phone, company,	client_or_domain_logo_image,call_to_action,thank_you) VALUES (";
									$s .= "'".$subdomain . "." . $nonprimary [$k] ['domain'] . "','" . $subdomain . $randc .".itclixmobile.com',";
									$s .= $client_id .",null,". $trialDefaults[0]["leadpop_id"] . "," . $trialDefaults[0]["leadpop_vertical_id"] . "," . $trialDefaults[0]["leadpop_vertical_sub_id"] . "," . $leadpoptype . "," .  $trialDefaults[0]['leadpop_template_id'];
									$s .= "," . $trialDefaults[0]["leadpop_version_id"] . "," . $trialDefaults[0]["leadpop_version_seq"] . ",'n','n','y','y','".preg_replace ('/[^0-9]/', '', $client ['phone_number'])."', '".addslashes($client ['company_name'])."','c','".addslashes($trialDefaults[0]['mobile_call_to_action'])."','".addslashes($trialDefaults[0]["mobile_thank_you"])."') ";
									$xzdb->query ($s);

								}

								$checkdomain = $subdomain . "." . $nonprimary [$k] ['domain'];
								$s = "insert into check_mobile (id,url,active,scope) values (null,";
								$s .= "'". $checkdomain ."','y', 'phone,tablet')";
                                $xzdb->query ($s);

								//die($cmd);
/* zzxx	*/
								$googleDomain = $subdomain . "." . $nonprimary [$k] ['domain'];
								insertPurchasedGoogle ( $client_id, $googleDomain );

                                if ($generatecolors == false && $useUploadedLogo == true) { // get mobile from old funnel
                                    // set 	client_or_domain_logo_image to 'c'  to use upploaded logo
									/* mobile domain and logo */
									$s = "select * from bottom_links  where client_id = " . $client_id ;
									$s .= " and leadpop_id = " . $origleadpop_id;
									$s .= " and leadpop_type_id = " . $origleadpop_type_id;
									$s .= " and leadpop_vertical_id = " . $origvertical_id;
									$s .= " and leadpop_vertical_sub_id = " . $origsubvertical_id;
									$s .=  " and leadpop_template_id = " . $origleadpop_template_id;
									$s .= " and leadpop_version_id = " . $origleadpop_version_id;
									$s .= " and leadpop_version_seq = " . $origleadpop_version_seq . " limit 1 ";
		                            $oldbototm = $xzdb->fetchAll($s);

									$s = "insert into  bottom_links (id,client_id,leadpop_id,leadpop_type_id,leadpop_vertical_id,";
									$s .= "leadpop_vertical_sub_id,leadpop_template_id,leadpop_version_id,";
									$s .= "leadpop_version_seq,privacy,terms,disclosures,licensing,about,contact,";
									$s .= "privacy_active,terms_active,disclosures_active,licensing_active,about_active,contact_active,";
									$s .= "privacy_type,terms_type,disclosures_type,licensing_type,about_type,contact_type,privacy_url,";
									$s .= "terms_url,disclosures_url,licensing_url,about_url,contact_url,privacy_text,";
									$s .= "terms_text,disclosures_text,licensing_text,about_text,contact_text,";
									$s .= "compliance_text,compliance_is_linked,compliance_link,compliance_active,";
									$s .= "license_number_active,license_number_is_linked,license_number_text,license_number_link";
									$s .= ") values (null,";
									$s .= $client_id . "," . $trialDefaults[0]["leadpop_id"] . "," . $trialDefaults[0]["leadpop_type_id"] . "," . $trialDefaults[0]["leadpop_vertical_id"] . "," . $trialDefaults[0]["leadpop_vertical_sub_id"] . ",";
									$s .= $trialDefaults[0]['leadpop_template_id'] . "," . $trialDefaults[0]["leadpop_version_id"] . "," . $trialDefaults[0]["leadpop_version_seq"];
									$s .= ",'','','','','','','n','n','n','n','n','n','m','m','m','m','m','m','','','','','','','','','','','','',";
                                    $s .= "'".$oldbototm[0]["compliance_text"]."','".$oldbototm[0]["compliance_is_linked"]."','".$oldbototm[0]["compliance_link"]."','".$oldbototm[0]["compliance_active"]."',";
									$s .= "'".$oldbototm[0]["license_number_active"]."','".$oldbototm[0]["license_number_is_linked"]."','".$oldbototm[0]["license_number_text"]."','".$oldbototm[0]["license_number_link"]."'";
									$s .= ") ";
									$xzdb->query($s);
                                }
								else {
									if (($vertical == "mortgage" || $vertical == "realestate")) {
										$license_number_text = "";
										$s = "insert into  bottom_links (id,client_id,leadpop_id,leadpop_type_id,leadpop_vertical_id,";
										$s .= "leadpop_vertical_sub_id,leadpop_template_id,leadpop_version_id,";
										$s .= "leadpop_version_seq,privacy,terms,disclosures,licensing,about,contact,";
										$s .= "privacy_active,terms_active,disclosures_active,licensing_active,about_active,contact_active,";
										$s .= "privacy_type,terms_type,disclosures_type,licensing_type,about_type,contact_type,privacy_url,";
										$s .= "terms_url,disclosures_url,licensing_url,about_url,contact_url,privacy_text,";
										$s .= "terms_text,disclosures_text,licensing_text,about_text,contact_text,";
										$s .= "compliance_text,compliance_is_linked,compliance_link,compliance_active,";
										$s .= "license_number_active,license_number_is_linked,license_number_text,license_number_link";
										$s .= ") values (null,";
										$s .= $client_id . "," . $trialDefaults[0]["leadpop_id"] . "," . $trialDefaults[0]["leadpop_type_id"] . "," . $trialDefaults[0]["leadpop_vertical_id"] . "," . $trialDefaults[0]["leadpop_vertical_sub_id"] . ",";
										$s .= $trialDefaults[0]['leadpop_template_id'] . "," . $trialDefaults[0]["leadpop_version_id"] . "," . $trialDefaults[0]["leadpop_version_seq"];
										$s .= ",'','','','','','','n','n','n','n','n','n','m','m','m','m','m','m','','','','','','','','','','','','',";
										$s .= "'NMLS Consumer Look Up','y','http://www.nmlsconsumeraccess.org','y',";
										$s .= "'y','n','".$license_number_text."',''";
										$s .= ") ";

										$xzdb->query ( $s );
									}
									else if ($vertical == "insurance") {
										$license_number_text = "";
										$s = "insert into  bottom_links (id,client_id,leadpop_id,leadpop_type_id,leadpop_vertical_id,";
										$s .= "leadpop_vertical_sub_id,leadpop_template_id,leadpop_version_id,";
										$s .= "leadpop_version_seq,privacy,terms,disclosures,licensing,about,contact,";
										$s .= "privacy_active,terms_active,disclosures_active,licensing_active,about_active,contact_active,";
										$s .= "privacy_type,terms_type,disclosures_type,licensing_type,about_type,contact_type,privacy_url,";
										$s .= "terms_url,disclosures_url,licensing_url,about_url,contact_url,privacy_text,";
										$s .= "terms_text,disclosures_text,licensing_text,about_text,contact_text,";
										$s .= "compliance_text,compliance_is_linked,compliance_link,compliance_active,";
										$s .= "license_number_active,license_number_is_linked,license_number_text,license_number_link";
										$s .= ") values (null,";
										$s .= $client_id . "," . $trialDefaults[0]["leadpop_id"] . "," . $trialDefaults[0]["leadpop_type_id"] . "," . $trialDefaults[0]["leadpop_vertical_id"] . "," . $trialDefaults[0]["leadpop_vertical_sub_id"] . ",";
										$s .= $trialDefaults[0]['leadpop_template_id'] . "," . $trialDefaults[0]["leadpop_version_id"] . "," . $trialDefaults[0]["leadpop_version_seq"];
										$s .= ",'','','','','','','n','n','n','n','n','n','m','m','m','m','m','m','','','','','','','','','','','','',";
										$s .= "'NMLS Consumer Look Up','y','http://www.nmlsconsumeraccess.org','y',";
										$s .= "'y','n','".$license_number_text."',''";
										$s .= ") ";
										$xzdb->query ( $s );
									}
									else {
										$s = "insert into  bottom_links (id,client_id,leadpop_id,leadpop_type_id,leadpop_vertical_id,";
										$s .= "leadpop_vertical_sub_id,leadpop_template_id,leadpop_version_id,";
										$s .= "leadpop_version_seq,privacy,terms,disclosures,licensing,about,contact,";
										$s .= "privacy_active,terms_active,disclosures_active,licensing_active,about_active,contact_active,";
										$s .= "privacy_type,terms_type,disclosures_type,licensing_type,about_type,contact_type,privacy_url,";
										$s .= "terms_url,disclosures_url,licensing_url,about_url,contact_url,privacy_text,";
										$s .= "terms_text,disclosures_text,licensing_text,about_text,contact_text,";
										$s .= "compliance_text,compliance_is_linked,compliance_link,compliance_active,";
										$s .= "license_number_active,license_number_is_linked,license_number_text,license_number_link";
										$s .= ") values (null,";
										$s .= $client_id . "," . $trialDefaults[0]["leadpop_id"] . "," . $trialDefaults[0]["leadpop_type_id"] . "," . $trialDefaults[0]["leadpop_vertical_id"] . "," . $trialDefaults[0]["leadpop_vertical_sub_id"] . ",";
										$s .= $trialDefaults[0]['leadpop_template_id'] . "," . $trialDefaults[0]["leadpop_version_id"] . "," . $trialDefaults[0]["leadpop_version_seq"];
										$s .= ",'','','','','','','n','n','n','n','n','n','m','m','m','m','m','m','','','','','','','','','','','','',";
										$s .= "'','','','',";
										$s .= "'','','',''";
										$s .= ") ";
										$xzdb->query ( $s );
									}
								}

								$x1 = '<p style="text-align: center;">';
								$x1 .= '     <span style="font-family:arial,helvetica,sans-serif;">';
								$x1 .= '     <span style="font-size: 22px;">';
								$x1 .= '     <span style="color: rgb(51, 102, 255);">Thank You For Your Submission!</span><br />';
								$x1 .= '     <span style="color: rgb(51, 51, 51);">';
								$x1 .= '     <span style="font-size: 14px;">We have received your inquiry. An expert will follow up with you shortly.';
								$x1 .= '     </span>';
								$x1 .= '     </span>';
								$x1 .= '     </span>';
								$x1 .= '     </span>        ';
								$x1 .= '   </p>   ';

								$s = "insert into contact_options (id,client_id,leadpop_id,";
								$s .= "leadpop_type_id,leadpop_vertical_id,leadpop_vertical_sub_id,";
								$s .= "leadpop_template_id,leadpop_version_id,leadpop_version_seq,";
								$s .= "companyname,phonenumber,email,companyname_active,";
								$s .= "phonenumber_active,email_active) values (null,";
								$s .= $client_id . "," . $trialDefaults[0]["leadpop_id"] . "," . $trialDefaults[0]["leadpop_type_id"] . "," . $trialDefaults[0]["leadpop_vertical_id"] . "," . $trialDefaults[0]["leadpop_vertical_sub_id"] . ",";
								$s .= $trialDefaults[0]['leadpop_template_id'] . "," . $trialDefaults[0]["leadpop_version_id"] . "," . $trialDefaults[0]["leadpop_version_seq"] . ",";
								// $s .= "'" . addslashes ( $client ['company_name'] ) . "','" . $client ['phone_number'] . "','";
								$s .= "'" . addslashes ( $client ['company_name'] ) . "','Call Today! " . $client ['phone_number'] . "','";
								$s .= $client ['contact_email'] . "','n','y','n')";
								$xzdb->query ( $s );

								$autotext = getAutoResponderText ( $trialDefaults[0]["leadpop_vertical_id"], $trialDefaults[0]["leadpop_vertical_sub_id"] , $trialDefaults[0]["leadpop_id"]);
                                if ($autotext == "not found") {
									$thehtml =  "";
									$thesubject = "";
                                }
                                else {
									$thehtml =  $autotext[0]["html"];
									$thesubject = $autotext[0]["subject_line"];
                                }
							    $s = "insert into autoresponder_options (id,client_id,leadpop_id,";
								$s .= "leadpop_type_id,leadpop_vertical_id,leadpop_vertical_sub_id,";
								$s .= "leadpop_template_id,leadpop_version_id,leadpop_version_seq,";
								$s .= "html,thetext,html_active,text_active,subject_line ) values (null,";
								$s .= $client_id . "," . $trialDefaults[0]["leadpop_id"] . "," . $trialDefaults[0]["leadpop_type_id"] . "," . $trialDefaults[0]["leadpop_vertical_id"] . "," . $trialDefaults[0]["leadpop_vertical_sub_id"] . ",";
								$s .= $trialDefaults[0]['leadpop_template_id'] . "," . $trialDefaults[0]["leadpop_version_id"] . "," . $trialDefaults[0]["leadpop_version_seq"] . ",";
								$s .= "'" . addslashes ( $thehtml ) . "','','y','n','".addslashes($thesubject)."')";
								//print($s);
								$xzdb->query ( $s );

								$title_tag =  " FREE " . $trialDefaults[0]["display_name"] . " | " . addslashes ( ucwords($client ['company_name']) );
                                //FREE Home Purchase Qualifier | Sentinel Mortgage Company

								$s = "insert into seo_options (id,client_id,leadpop_id,";
								$s .= "leadpop_type_id,leadpop_vertical_id,leadpop_vertical_sub_id,";
								$s .= "leadpop_template_id,leadpop_version_id,leadpop_version_seq,";
								$s .= "titletag,description,metatags,titletag_active,";
								$s .= "description_active,metatags_active) values (null,";
								$s .= $client_id . "," . $trialDefaults[0]["leadpop_id"] . "," . $trialDefaults[0]["leadpop_type_id"] . "," . $trialDefaults[0]["leadpop_vertical_id"] . "," . $trialDefaults[0]["leadpop_vertical_sub_id"] . ",";
								$s .= $trialDefaults[0]['leadpop_template_id'] . "," . $trialDefaults[0]["leadpop_version_id"] . "," . $trialDefaults[0]["leadpop_version_seq"] . ",";
								$s .= "'" . addslashes ( $title_tag ) . "','','','y','n','n') ";
								$xzdb->query ( $s );

								$s = "select * from leadpops_verticals where id = " . $trialDefaults[0]["leadpop_vertical_id"];
								$vertres = $xzdb->fetchRow ( $s );
								$verticalName = $vertres ['lead_pop_vertical'];

								if (isset ($trialDefaults[0]["leadpop_vertical_sub_id"] ) && $trialDefaults[0]["leadpop_vertical_sub_id"] != "") {
									$s = "select * from leadpops_verticals_sub where leadpop_vertical_id  = " . $trialDefaults[0]["leadpop_vertical_id"];
									$s .= " and id = " . $trialDefaults[0]["leadpop_vertical_sub_id"];
									$subvertres = $xzdb->fetchRow ( $s );
									$subverticalName = $subvertres ['lead_pop_vertical_sub'];
								} else {
									$subverticalName = "";
								}

								$submissionText = getSubmissionText($trialDefaults[0]["leadpop_id"],$trialDefaults[0]["leadpop_vertical_id"],$trialDefaults[0]["leadpop_vertical_sub_id"]);
					            $submissionText = str_replace("##clientlogo##",$logosrc,$submissionText);
					            $submissionText = str_replace("##clientphonenumber##",$freeTrialBuilderAnswers['phonenumber'],$submissionText);

								$s = "insert into submission_options (id,client_id,leadpop_id,leadpop_type_id,";
								$s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,";
								$s .= "leadpop_version_id,leadpop_version_seq,thankyou,information,";
								$s .= "thirdparty,thankyou_active,information_active,thirdparty_active) values (null,";
								$s .= $client_id . "," . $trialDefaults[0]["leadpop_id"] . "," . $trialDefaults[0]["leadpop_type_id"] . "," . $trialDefaults[0]["leadpop_vertical_id"] . "," . $trialDefaults[0]["leadpop_vertical_sub_id"] . ",";
								$s .= $trialDefaults[0]['leadpop_template_id'] . "," . $trialDefaults[0]["leadpop_version_id"] . "," . $trialDefaults[0]["leadpop_version_seq"] . ",";
								$s .= "'" . addslashes ( $submissionText ) . "','','','y','n','n')";
								$xzdb->query ( $s );

								$foundone = true;
								break 2;
							}
						}
						$subdomain = $subdomain . getRandomCharacter ();
					}
				} else {

					$s = "insert into clients_subdomains (id,client_id,subdomain_name,top_level_domain,leadpop_vertical_id,";
					$s .= "leadpop_vertical_sub_id,leadpop_type_id,leadpop_template_id,";
					$s .= "leadpop_id,leadpop_version_id,leadpop_version_seq ) values (null,";
					$s .= $client_id . ",'" . $subdomain . "','" . $topdomain . "',";
					$s .= $trialDefaults[0]["leadpop_vertical_id"] . "," . $trialDefaults[0]["leadpop_vertical_sub_id"] . "," . $trialDefaults[0]["leadpop_type_id"] . "," . $trialDefaults[0]['leadpop_template_id'] . ",";
					$s .= $trialDefaults[0]["leadpop_id"] . "," . $trialDefaults[0]["leadpop_version_id"] . "," . $trialDefaults[0]["leadpop_version_seq"] . ")";
					$xzdb->query ( $s );

								/* emma insert */
								/* emma insert */
								/* emma insert */
//					$s = "insert into client_emma_cron (id,client_id,emma_default_group,account_type,domain_name,account_name,master_account_ids,has_run,leadpop_vertical_id,leadpop_subvertical_id) values (null,";
//					$s .= $client_id . ",'". $trialDefaults[0]['emma_default_group'] ."','".$emma_account_type."','". strtolower($subdomain . "." . $topdomain) ."','". $emma_account_name ."','";
//					$s .= addslashes($emmaAccount) . "','n',".$trialDefaults[0]["leadpop_vertical_id"].",".$trialDefaults[0]["leadpop_vertical_sub_id"].")";
//					$xzdb->query ($s);
								/* emma insert */
								/* emma insert */
								/* emma insert */


					$foundmobile = false;
					$randc = "";
					while ( $foundmobile == false ) {
						$s =  "select count(*) as cnt from mobileclients where mobiledomain = '".$subdomain . $randc .  ".itclixmobile.com'  ";
						$nummobile = $xzdb->fetchOne($s);
						if($nummobile == 0) {
							$foundmobile = true;
						}
						else {
							$randc = $randc . getRandomCharacter ();
						}
					}

						if ($generatecolors == false && $useUploadedLogo == true) { // get mobile from old funnel
							// set 	client_or_domain_logo_image to 'c'  to use upploaded logo
							/* mobile domain and logo */
							$s = "select * from mobileclients  where client_id = " . $client_id ;
							$s .= " and leadpop_id = " . $origleadpop_id;
							$s .= " and leadpop_type_id = " . $origleadpop_type_id;
							$s .= " and leadpop_vertical_id = " . $origvertical_id;
							$s .= " and leadpop_vertical_sub_id = " . $origsubvertical_id;
							$s .=  " and leadpop_template_id = " . $origleadpop_template_id;
							$s .= " and leadpop_version_id = " . $origleadpop_version_id;
							$s .= " and leadpop_version_seq = " . $origleadpop_version_seq . " limit 1 ";
							$oldmobile = $xzdb->fetchAll($s);

							$s = "INSERT INTO mobileclients (nonmobiledomain, mobiledomain, client_id, id, leadpop_id, ";
							$s .= "leadpop_vertical_id,leadpop_vertical_sub_id, leadpop_type_id, leadpop_template_id,";
							$s .= "leadpop_version_id, leadpop_version_seq, ";
							$s .= "iszillow, zillow_api, active, group_design, phone, company,	client_or_domain_logo_image,call_to_action,thank_you) VALUES (";
							$s .= "'".$subdomain . "." . $topdomain . "','" . $subdomain . $randc .".itclixmobile.com',";
							$s .= $client_id .",null,". $trialDefaults[0]["leadpop_id"] . "," . $trialDefaults[0]["leadpop_vertical_id"] . "," . $trialDefaults[0]["leadpop_vertical_sub_id"] . "," . $trialDefaults[0]["leadpop_type_id"] . "," .  $trialDefaults[0]['leadpop_template_id'];
							$s .= "," . $trialDefaults[0]["leadpop_version_id"] . "," . $trialDefaults[0]["leadpop_version_seq"] . ",'n','n','y','y','".preg_replace ('/[^0-9]/', '', $client ['phone_number'])."', '".addslashes($client ['company_name'])."','c','".addslashes($oldmobile[0]['call_to_action'])."','".addslashes($oldmobile[0]["thank_you"])."') ";
							$xzdb->query ($s);
						}
						else {

							$s = "INSERT INTO mobileclients (nonmobiledomain, mobiledomain, client_id, id, leadpop_id, ";
							$s .= "leadpop_vertical_id,leadpop_vertical_sub_id, leadpop_type_id, leadpop_template_id,";
							$s .= "leadpop_version_id, leadpop_version_seq, ";
							$s .= "iszillow, zillow_api, active, group_design, phone, company,	client_or_domain_logo_image,call_to_action,thank_you) VALUES (";
							$s .= "'".$subdomain . "." . $topdomain . "','" . $subdomain . $randc .".itclixmobile.com',";
							$s .= $client_id .",null,". $trialDefaults[0]["leadpop_id"] . "," . $trialDefaults[0]["leadpop_vertical_id"] . "," . $trialDefaults[0]["leadpop_vertical_sub_id"] . "," . $leadpoptype . "," .  $trialDefaults[0]['leadpop_template_id'];
							$s .= "," . $trialDefaults[0]["leadpop_version_id"] . "," . $trialDefaults[0]["leadpop_version_seq"] . ",'n','n','y','y','".preg_replace ('/[^0-9]/', '', $client ['phone_number'])."', '".addslashes($client ['company_name'])."','c','".addslashes($trialDefaults[0]['mobile_call_to_action'])."','".addslashes($trialDefaults[0]["mobile_thank_you"])."') ";
							$xzdb->query ($s);

						}

					$checkdomain = $subdomain . "." . $topdomain;
					$s = "insert into check_mobile (id,url,active,scope) values (null,";
					$s .= "'". $checkdomain ."','y', 'phone,tablet')";
					$xzdb->query ($s);


					$googleDomain = $subdomain . "." . $topdomain;
					insertPurchasedGoogle ( $client_id, $googleDomain );

						if ($generatecolors == false && $useUploadedLogo == true) { // get mobile from old funnel
							// set 	client_or_domain_logo_image to 'c'  to use upploaded logo
							/* mobile domain and logo */
							$s = "select * from bottom_links  where client_id = " . $client_id ;
							$s .= " and leadpop_id = " . $origleadpop_id;
							$s .= " and leadpop_type_id = " . $origleadpop_type_id;
							$s .= " and leadpop_vertical_id = " . $origvertical_id;
							$s .= " and leadpop_vertical_sub_id = " . $origsubvertical_id;
							$s .=  " and leadpop_template_id = " . $origleadpop_template_id;
							$s .= " and leadpop_version_id = " . $origleadpop_version_id;
							$s .= " and leadpop_version_seq = " . $origleadpop_version_seq . " limit 1 ";
							$oldbototm = $xzdb->fetchAll($s);

							$s = "insert into  bottom_links (id,client_id,leadpop_id,leadpop_type_id,leadpop_vertical_id,";
							$s .= "leadpop_vertical_sub_id,leadpop_template_id,leadpop_version_id,";
							$s .= "leadpop_version_seq,privacy,terms,disclosures,licensing,about,contact,";
							$s .= "privacy_active,terms_active,disclosures_active,licensing_active,about_active,contact_active,";
							$s .= "privacy_type,terms_type,disclosures_type,licensing_type,about_type,contact_type,privacy_url,";
							$s .= "terms_url,disclosures_url,licensing_url,about_url,contact_url,privacy_text,";
							$s .= "terms_text,disclosures_text,licensing_text,about_text,contact_text,";
							$s .= "compliance_text,compliance_is_linked,compliance_link,compliance_active,";
							$s .= "license_number_active,license_number_is_linked,license_number_text,license_number_link";
							$s .= ") values (null,";
							$s .= $client_id . "," . $trialDefaults[0]["leadpop_id"] . "," . $trialDefaults[0]["leadpop_type_id"] . "," . $trialDefaults[0]["leadpop_vertical_id"] . "," . $trialDefaults[0]["leadpop_vertical_sub_id"] . ",";
							$s .= $trialDefaults[0]['leadpop_template_id'] . "," . $trialDefaults[0]["leadpop_version_id"] . "," . $trialDefaults[0]["leadpop_version_seq"];
							$s .= ",'','','','','','','n','n','n','n','n','n','m','m','m','m','m','m','','','','','','','','','','','','',";
							$s .= "'".$oldbototm[0]["compliance_text"]."','".$oldbototm[0]["compliance_is_linked"]."','".$oldbototm[0]["compliance_link"]."','".$oldbototm[0]["compliance_active"]."',";
							$s .= "'".$oldbototm[0]["license_number_active"]."','".$oldbototm[0]["license_number_is_linked"]."','".$oldbototm[0]["license_number_text"]."','".$oldbototm[0]["license_number_link"]."'";
							$s .= ") ";
							$xzdb->query($s);
						}
						else {
							if (($vertical == "mortgage" || $vertical == "realestate")) {
								$license_number_text = "";
								$s = "insert into  bottom_links (id,client_id,leadpop_id,leadpop_type_id,leadpop_vertical_id,";
								$s .= "leadpop_vertical_sub_id,leadpop_template_id,leadpop_version_id,";
								$s .= "leadpop_version_seq,privacy,terms,disclosures,licensing,about,contact,";
								$s .= "privacy_active,terms_active,disclosures_active,licensing_active,about_active,contact_active,";
								$s .= "privacy_type,terms_type,disclosures_type,licensing_type,about_type,contact_type,privacy_url,";
								$s .= "terms_url,disclosures_url,licensing_url,about_url,contact_url,privacy_text,";
								$s .= "terms_text,disclosures_text,licensing_text,about_text,contact_text,";
								$s .= "compliance_text,compliance_is_linked,compliance_link,compliance_active,";
								$s .= "license_number_active,license_number_is_linked,license_number_text,license_number_link";
								$s .= ") values (null,";
								$s .= $client_id . "," . $trialDefaults[0]["leadpop_id"] . "," . $trialDefaults[0]["leadpop_type_id"] . "," . $trialDefaults[0]["leadpop_vertical_id"] . "," . $trialDefaults[0]["leadpop_vertical_sub_id"] . ",";
								$s .= $trialDefaults[0]['leadpop_template_id'] . "," . $trialDefaults[0]["leadpop_version_id"] . "," . $trialDefaults[0]["leadpop_version_seq"];
								$s .= ",'','','','','','','n','n','n','n','n','n','m','m','m','m','m','m','','','','','','','','','','','','',";
								$s .= "'NMLS Consumer Look Up','y','http://www.nmlsconsumeraccess.org','y',";
								$s .= "'y','n','".$license_number_text."',''";
								$s .= ") ";

								$xzdb->query ( $s );
							}
							else if ($vertical == "insurance") {
								$license_number_text = "";
								$s = "insert into  bottom_links (id,client_id,leadpop_id,leadpop_type_id,leadpop_vertical_id,";
								$s .= "leadpop_vertical_sub_id,leadpop_template_id,leadpop_version_id,";
								$s .= "leadpop_version_seq,privacy,terms,disclosures,licensing,about,contact,";
								$s .= "privacy_active,terms_active,disclosures_active,licensing_active,about_active,contact_active,";
								$s .= "privacy_type,terms_type,disclosures_type,licensing_type,about_type,contact_type,privacy_url,";
								$s .= "terms_url,disclosures_url,licensing_url,about_url,contact_url,privacy_text,";
								$s .= "terms_text,disclosures_text,licensing_text,about_text,contact_text,";
								$s .= "compliance_text,compliance_is_linked,compliance_link,compliance_active,";
								$s .= "license_number_active,license_number_is_linked,license_number_text,license_number_link";
								$s .= ") values (null,";
								$s .= $client_id . "," . $trialDefaults[0]["leadpop_id"] . "," . $trialDefaults[0]["leadpop_type_id"] . "," . $trialDefaults[0]["leadpop_vertical_id"] . "," . $trialDefaults[0]["leadpop_vertical_sub_id"] . ",";
								$s .= $trialDefaults[0]['leadpop_template_id'] . "," . $trialDefaults[0]["leadpop_version_id"] . "," . $trialDefaults[0]["leadpop_version_seq"];
								$s .= ",'','','','','','','n','n','n','n','n','n','m','m','m','m','m','m','','','','','','','','','','','','',";
								$s .= "'NMLS Consumer Look Up','y','http://www.nmlsconsumeraccess.org','y',";
								$s .= "'y','n','".$license_number_text."',''";
								$s .= ") ";
								$xzdb->query ( $s );
							}
							else {
								$s = "insert into  bottom_links (id,client_id,leadpop_id,leadpop_type_id,leadpop_vertical_id,";
								$s .= "leadpop_vertical_sub_id,leadpop_template_id,leadpop_version_id,";
								$s .= "leadpop_version_seq,privacy,terms,disclosures,licensing,about,contact,";
								$s .= "privacy_active,terms_active,disclosures_active,licensing_active,about_active,contact_active,";
								$s .= "privacy_type,terms_type,disclosures_type,licensing_type,about_type,contact_type,privacy_url,";
								$s .= "terms_url,disclosures_url,licensing_url,about_url,contact_url,privacy_text,";
								$s .= "terms_text,disclosures_text,licensing_text,about_text,contact_text,";
								$s .= "compliance_text,compliance_is_linked,compliance_link,compliance_active,";
								$s .= "license_number_active,license_number_is_linked,license_number_text,license_number_link";
								$s .= ") values (null,";
								$s .= $client_id . "," . $trialDefaults[0]["leadpop_id"] . "," . $trialDefaults[0]["leadpop_type_id"] . "," . $trialDefaults[0]["leadpop_vertical_id"] . "," . $trialDefaults[0]["leadpop_vertical_sub_id"] . ",";
								$s .= $trialDefaults[0]['leadpop_template_id'] . "," . $trialDefaults[0]["leadpop_version_id"] . "," . $trialDefaults[0]["leadpop_version_seq"];
								$s .= ",'','','','','','','n','n','n','n','n','n','m','m','m','m','m','m','','','','','','','','','','','','',";
								$s .= "'','','','',";
								$s .= "'','','',''";
								$s .= ") ";
								$xzdb->query ( $s );
							}
						}

					$x1 = '<p style="text-align: center;">';
					$x1 .= '     <span style="font-family:arial,helvetica,sans-serif;">';
					$x1 .= '     <span style="font-size: 22px;">';
					$x1 .= '     <span style="color: rgb(51, 102, 255);">Thank You For Your Submission!</span><br />';
					$x1 .= '     <span style="color: rgb(51, 51, 51);">';
					$x1 .= '     <span style="font-size: 14px;">We have received your inquiry. An expert will follow up with you shortly.';
					$x1 .= '     </span>';
					$x1 .= '     </span>';
					$x1 .= '     </span>';
					$x1 .= '     </span>        ';
					$x1 .= '   </p>   ';

					$s = "insert into contact_options (id,client_id,leadpop_id,";
					$s .= "leadpop_type_id,leadpop_vertical_id,leadpop_vertical_sub_id,";
					$s .= "leadpop_template_id,leadpop_version_id,leadpop_version_seq,";
					$s .= "companyname,phonenumber,email,companyname_active,";
					$s .= "phonenumber_active,email_active) values (null,";
					$s .= $client_id . "," . $trialDefaults[0]["leadpop_id"] . "," . $trialDefaults[0]["leadpop_type_id"] . "," . $trialDefaults[0]["leadpop_vertical_id"] . "," . $trialDefaults[0]["leadpop_vertical_sub_id"] . ",";
					$s .= $trialDefaults[0]['leadpop_template_id'] . "," . $trialDefaults[0]["leadpop_version_id"] . "," . $trialDefaults[0]["leadpop_version_seq"] . ",";
					// $s .= "'" . addslashes ( $client ['company_name'] ) . "','" . $client ['phone_number'] . "','";
					$s .= "'" . addslashes ( $client ['company_name'] ) . "','Call Today! " . $client ['phone_number'] . "','";
					$s .= $client ['contact_email'] . "','n','y','n')";
					$xzdb->query ( $s );

					$autotext = getAutoResponderText ( $trialDefaults[0]["leadpop_vertical_id"], $trialDefaults[0]["leadpop_vertical_sub_id"] , $trialDefaults[0]["leadpop_id"]);
					if ($autotext == "not found") {
						$thehtml =  "";
						$thesubject = "";
					}
					else {
						$thehtml =  $autotext[0]["html"];
						$thesubject = $autotext[0]["subject_line"];
					}

					$s = "insert into autoresponder_options (id,client_id,leadpop_id,";
					$s .= "leadpop_type_id,leadpop_vertical_id,leadpop_vertical_sub_id,";
					$s .= "leadpop_template_id,leadpop_version_id,leadpop_version_seq,";
					$s .= "html,thetext,html_active,text_active,subject_line ) values (null,";
					$s .= $client_id . "," . $trialDefaults[0]["leadpop_id"] . "," . $trialDefaults[0]["leadpop_type_id"] . "," . $trialDefaults[0]["leadpop_vertical_id"] . "," . $trialDefaults[0]["leadpop_vertical_sub_id"] . ",";
					$s .= $trialDefaults[0]['leadpop_template_id'] . "," . $trialDefaults[0]["leadpop_version_id"] . "," . $trialDefaults[0]["leadpop_version_seq"] . ",";
					$s .= "'" . addslashes ( $thehtml ) . "','','y','n','".addslashes($thesubject)."')";
					$xzdb->query ($s);

					try {
					    $xzdb->query ($s);
					}
					catch ( PDOException $e) {
                        print ("Error!: " . $e->getMessage() . "<br/>") ;
					    print($s);
						die();
					}


					$title_tag =  " FREE " . $trialDefaults[0]["display_name"] . " | " . addslashes ( ucwords($client ['company_name']) );
					//FREE Home Purchase Qualifier | Sentinel Mortgage Company

					$s = "insert into seo_options (id,client_id,leadpop_id,";
					$s .= "leadpop_type_id,leadpop_vertical_id,leadpop_vertical_sub_id,";
					$s .= "leadpop_template_id,leadpop_version_id,leadpop_version_seq,";
					$s .= "titletag,description,metatags,titletag_active,";
					$s .= "description_active,metatags_active) values (null,";
					$s .= $client_id . "," . $trialDefaults[0]["leadpop_id"] . "," . $trialDefaults[0]["leadpop_type_id"] . "," . $trialDefaults[0]["leadpop_vertical_id"] . "," . $trialDefaults[0]["leadpop_vertical_sub_id"] . ",";
					$s .= $trialDefaults[0]['leadpop_template_id'] . "," . $trialDefaults[0]["leadpop_version_id"] . "," . $trialDefaults[0]["leadpop_version_seq"] . ",";
					$s .= "'" . addslashes ( $title_tag ) . "','','','y','n','n') ";
					$xzdb->query ( $s );

					$s = "select * from leadpops_verticals where id = " . $trialDefaults[0]["leadpop_vertical_id"];
					$vertres = $xzdb->fetchRow ( $s );
					$verticalName = $vertres ['lead_pop_vertical'];

					if (isset ($trialDefaults[0]["leadpop_vertical_sub_id"] ) && $trialDefaults[0]["leadpop_vertical_sub_id"] != "") {
						$s = "select * from leadpops_verticals_sub where leadpop_vertical_id  = " . $trialDefaults[0]["leadpop_vertical_id"];
						$s .= " and id = " . $trialDefaults[0]["leadpop_vertical_sub_id"];
						$subvertres = $xzdb->fetchRow ( $s );
						$subverticalName = $subvertres ['lead_pop_vertical_sub'];
					} else {
						$subverticalName = "";
					}

					$submissionText = getSubmissionText($trialDefaults[0]["leadpop_id"],$trialDefaults[0]["leadpop_vertical_id"],$trialDefaults[0]["leadpop_vertical_sub_id"]);
					$submissionText = str_replace("##clientlogo##",$logosrc,$submissionText);
					$submissionText = str_replace("##clientphonenumber##",$freeTrialBuilderAnswers['phonenumber'],$submissionText);

					$s = "insert into submission_options (id,client_id,leadpop_id,leadpop_type_id,";
					$s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,";
					$s .= "leadpop_version_id,leadpop_version_seq,thankyou,information,";
					$s .= "thirdparty,thankyou_active,information_active,thirdparty_active) values (null,";
					$s .= $client_id . "," . $trialDefaults[0]["leadpop_id"] . "," . $trialDefaults[0]["leadpop_type_id"] . "," . $trialDefaults[0]["leadpop_vertical_id"] . "," . $trialDefaults[0]["leadpop_vertical_sub_id"] . ",";
					$s .= $trialDefaults[0]['leadpop_template_id'] . "," . $trialDefaults[0]["leadpop_version_id"] . "," . $trialDefaults[0]["leadpop_version_seq"] . ",";
					$s .= "'" . addslashes ( $submissionText ) . "','','','y','n','n')";
					$xzdb->query ( $s );

				}
			}

			$s = "select * from leadpops_templates_placeholders_info where leadpop_template_id = " . $trialDefaults[0]['leadpop_template_id'] . " order by step ";
			$placeholder_info = $xzdb->fetchAll ( $s );
			for($j = 0; $j < count ( $placeholder_info ); $j ++) {
				$s = "insert into leadpops_templates_placeholders (id,";
				$s .= "leadpop_template_id,step,client_id,leadpop_version_seq,";
				$s .= "placeholder_one,";
				$s .= "placeholder_two,";
				$s .= "placeholder_three,";
				$s .= "placeholder_four,";
				$s .= "placeholder_five,";
				$s .= "placeholder_six,";
				$s .= "placeholder_seven,";
				$s .= "placeholder_eight,";
				$s .= "placeholder_nine,";
				$s .= "placeholder_ten,";
				$s .= "placeholder_eleven,";
				$s .= "placeholder_twelve,";
				$s .= "placeholder_thirteen,";
				$s .= "placeholder_fourteen,";
				$s .= "placeholder_fifteen,";
				$s .= "placeholder_sixteen,";
				$s .= "placeholder_seventeen,";
				$s .= "placeholder_eighteen,";
				$s .= "placeholder_nineteen,";
				$s .= "placeholder_twenty,";
				$s .= "placeholder_twentyone,";
				$s .= "placeholder_twentytwo,";
				$s .= "placeholder_twentythree,";
				$s .= "placeholder_twentyfour,";
				$s .= "placeholder_twentyfive,";
				$s .= "placeholder_twentysix,";
				$s .= "placeholder_twentyseven,";
				$s .= "placeholder_twentyeight,";
				$s .= "placeholder_twentynine,";
				$s .= "placeholder_thirty,";
				$s .= "placeholder_thirtyone,";
				$s .= "placeholder_thirtytwo,";
				$s .= "placeholder_thirtythree,";
				$s .= "placeholder_thirtyfour,";
				$s .= "placeholder_thirtyfive,";
				$s .= "placeholder_thirtysix,";
				$s .= "placeholder_thirtyseven,";
				$s .= "placeholder_thirtyeight,";
				$s .= "placeholder_thirtynine,";
				$s .= "placeholder_forty,";
				$s .= "placeholder_fortyone,";
				$s .= "placeholder_fortytwo,";
				$s .= "placeholder_fortythree,";
				$s .= "placeholder_fortyfour,";
				$s .= "placeholder_fortyfive,";
				$s .= "placeholder_fortysix,";
				$s .= "placeholder_fortyseven,";
				$s .= "placeholder_fortyeight,";
				$s .= "placeholder_fortynine,";
				$s .= "placeholder_fifty,";
				$s .= "placeholder_fiftyone,";
				$s .= "placeholder_fiftytwo,";
				$s .= "placeholder_fiftythree,";
				$s .= "placeholder_fiftyfour,";
				$s .= "placeholder_fiftyfive,";
				$s .= "placeholder_fiftysix,";
				$s .= "placeholder_fiftyseven,";
				$s .= "placeholder_fiftyeight,";
				$s .= "placeholder_fiftynine,";
				$s .= "placeholder_sixty,";
				$s .= "placeholder_sixtyone,";
				$s .= "placeholder_sixtytwo,";
				$s .= "placeholder_sixtythree,";
				$s .= "placeholder_sixtyfour,";
				$s .= "placeholder_sixtyfive,";
				$s .= "placeholder_sixtysix,";
				$s .= "placeholder_sixtyseven,";
				$s .= "placeholder_sixtyeight,";
				$s .= "placeholder_sixtynine,";
				$s .= "placeholder_seventy,";
				$s .= "placeholder_seventyone,";
				$s .= "placeholder_seventytwo,";
				$s .= "placeholder_seventythree,";
				$s .= "placeholder_seventyfour,";
				$s .= "placeholder_seventyfive,";
				$s .= "placeholder_seventysix,";
				$s .= "placeholder_seventyseven,";
				$s .= "placeholder_seventyeight,";
				$s .= "placeholder_seventynine,";
				$s .= "placeholder_eighty,";
				$s .= "placeholder_eightyone,";
				$s .= "placeholder_eightytwo,";
				$s .= "placeholder_eightythree";
				$s .= "    ) values (null," . $trialDefaults[0]['leadpop_template_id'] . ",";
				$s .= $placeholder_info [$j] ['step'] . "," . $client_id . "," . $trialDefaults[0]["leadpop_version_seq"] . ",";
				$s .= "'" . $placeholder_info [$j] ['placeholder_one'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_two'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_three'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_four'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_five'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_six'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_seven'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_eight'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_nine'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_ten'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_eleven'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_twelve'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_thirteen'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fourteen'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fifteen'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_sixteen'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_seventeen'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_eighteen'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_nineteen'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_twenty'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_twentyone'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_twentytwo'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_twentythree'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_twentyfour'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_twentyfive'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_twentysix'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_twentyseven'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_twentyeight'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_twentynine'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_thirty'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_thirtyone'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_thirtytwo'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_thirtythree'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_thirtyfour'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_thirtyfive'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_thirtysix'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_thirtyseven'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_thirtyeight'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_thirtynine'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_forty'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fortyone'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fortytwo'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fortythree'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fortyfour'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fortyfive'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fortysix'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fortyseven'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fortyeight'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fortynine'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fifty'] . "', ";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fiftyone'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fiftytwo'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fiftythree'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fiftyfour'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fiftyfive'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fiftysix'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fiftyseven'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fiftyeight'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fiftynine'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_sixty'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_sixtyone'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_sixtytwo'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_sixtythree'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_sixtyfour'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_sixtyfive'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_sixtysix'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_sixtyseven'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_sixtyeight'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_sixtynine'] . "' ,";
				$s .= "'" . addslashes ( $placeholder_info [$j] ['placeholder_seventy'] ) . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_seventyone'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_seventytwo'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_seventythree'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_seventyfour'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_seventyfive'] . "', ";
				$s .= "'" . $placeholder_info [$j] ['placeholder_seventysix'] . "', ";
				$s .= "'" . $placeholder_info [$j] ['placeholder_seventyseven'] . "', ";
				$s .= "'" . $placeholder_info [$j] ['placeholder_seventyeight'] . "', ";
				$s .= "'" . $placeholder_info [$j] ['placeholder_seventynine'] . "', ";
				$s .= "'" . $placeholder_info [$j] ['placeholder_eighty'] . "', ";
				$s .= "'" . $placeholder_info [$j] ['placeholder_eightyone'] . "', ";
				$s .= "'" . $placeholder_info [$j] ['placeholder_eightytwo'] . "', ";
				$s .= "'" . $placeholder_info [$j] ['placeholder_eightythree'] . "' ";
				$s .= " )";
				$xzdb->query ( $s );
				$placeholder_id = $xzdb->lastInsertId ();

				$s = "select * from leadpops_templates_placeholders_values_info where ";
				$s .= " leadpop_template_id = " . $placeholder_info [$j] ['leadpop_template_id'];
				$s .= " and step = " . $placeholder_info [$j] ['step'];
				$s .= " and placeholder_fortyseven = '".$placeholder_info[$j]['placeholder_fortyseven']."' ";
				$placeholder_values = $xzdb->fetchRow ( $s );

				$s = "insert into leadpops_templates_placeholders_values (id,client_leadpop_id,";
				$s .= "  leadpop_template_placeholder_id,";
				$s .= "  placeholder_one,";
				$s .= "  placeholder_two,";
				$s .= "  placeholder_three,";
				$s .= "  placeholder_four,";
				$s .= "  placeholder_five,";
				$s .= "  placeholder_six,";
				$s .= "  placeholder_seven,";
				$s .= "  placeholder_eight,";
				$s .= "  placeholder_nine,";
				$s .= "  placeholder_ten,";
				$s .= "  placeholder_eleven,";
				$s .= "  placeholder_twelve,";
				$s .= "  placeholder_thirteen,";
				$s .= "  placeholder_fourteen,";
				$s .= "  placeholder_fifteen,";
				$s .= "  placeholder_sixteen,";
				$s .= "  placeholder_seventeen,";
				$s .= "  placeholder_eighteen,";
				$s .= "  placeholder_nineteen,";
				$s .= "  placeholder_twenty,";
				$s .= "  placeholder_twentyone,";
				$s .= "  placeholder_twentytwo,";
				$s .= "  placeholder_twentythree,";
				$s .= "  placeholder_twentyfour,";
				$s .= "  placeholder_twentyfive,";
				$s .= "  placeholder_twentysix,";
				$s .= "  placeholder_twentyseven,";
				$s .= "  placeholder_twentyeight,";
				$s .= "  placeholder_twentynine,";
				$s .= "  placeholder_thirty,";
				$s .= "  placeholder_thirtyone,";
				$s .= "  placeholder_thirtytwo,";
				$s .= "  placeholder_thirtythree,";
				$s .= "  placeholder_thirtyfour,";
				$s .= "  placeholder_thirtyfive,";
				$s .= "  placeholder_thirtysix,";
				$s .= "  placeholder_thirtyseven,";
				$s .= "  placeholder_thirtyeight,";
				$s .= "  placeholder_thirtynine,";
				$s .= "  placeholder_forty,";
				$s .= "  placeholder_fortyone,";
				$s .= "  placeholder_fortytwo,";
				$s .= "  placeholder_fortythree,";
				$s .= "  placeholder_fortyfour,";
				$s .= "  placeholder_fortyfive,";
				$s .= "  placeholder_fortysix,";
				$s .= "  placeholder_fortyseven,";
				$s .= "  placeholder_fortyeight,";
				$s .= "  placeholder_fortynine,";
				$s .= "  placeholder_fifty, ";
				$s .= "placeholder_fiftyone,";
				$s .= "placeholder_fiftytwo,";
				$s .= "placeholder_fiftythree,";
				$s .= "placeholder_fiftyfour,";
				$s .= "placeholder_fiftyfive,";
				$s .= "placeholder_fiftysix,";
				$s .= "placeholder_fiftyseven,";
				$s .= "placeholder_fiftyeight,";
				$s .= "placeholder_fiftynine,";
				$s .= "placeholder_sixty,";
				$s .= "placeholder_sixtyone,";
				$s .= "placeholder_sixtytwo,";
				$s .= "placeholder_sixtythree,";
				$s .= "placeholder_sixtyfour,";
				$s .= "placeholder_sixtyfive,";
				$s .= "placeholder_sixtysix,";
				$s .= "placeholder_sixtyseven,";
				$s .= "placeholder_sixtyeight,";
				$s .= "placeholder_sixtynine,";
				$s .= "placeholder_seventy,";
				$s .= "placeholder_seventyone,";
				$s .= "placeholder_seventytwo,";
				$s .= "placeholder_seventythree,";
				$s .= "placeholder_seventyfour,";
				$s .= "placeholder_seventyfive,";
				$s .= "placeholder_seventysix,";
				$s .= "placeholder_seventyseven,";
				$s .= "placeholder_seventyeight,";
				$s .= "placeholder_seventynine,";
				$s .= "placeholder_eighty,";
				$s .= "placeholder_eightyone,";
				$s .= "placeholder_eightytwo,";
				$s .= "placeholder_eightythree";
				$s .= ") values (null," . $trialDefaults[0]["leadpop_id"] . ",";
				$s .= $placeholder_id . ",";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_one'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_two'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_three'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_four'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_five'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_six'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_seven'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_eight'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_nine'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_ten'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_eleven'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_twelve'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_thirteen'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_fourteen'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_fifteen'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_sixteen'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_seventeen'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_eighteen'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_nineteen'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_twenty'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_twentyone'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_twentytwo'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_twentythree'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_twentyfour'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_twentyfive'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_twentysix'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_twentyseven'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_twentyeight'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_twentynine'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_thirty'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_thirtyone'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_thirtytwo'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_thirtythree'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_thirtyfour'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_thirtyfive'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_thirtysix'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_thirtyseven'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_thirtyeight'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_thirtynine'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_forty'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_fortyone'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_fortytwo'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_fortythree'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_fortyfour'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_fortyfive'] ) . "', ";
				$s .= "'" . $placeholder_values ['placeholder_fortysix'] . "', ";
				$s .= "'" . $placeholder_values ['placeholder_fortyseven'] . "', ";
				$s .= "'" . $verticalName . "', ";
				$s .= "'" . $subverticalName . "', ";
				$s .= "'" . $trialDefaults[0]["leadpop_version_id"] . "',  ";
				$s .= "'" . $placeholder_values ['placeholder_fiftyone'] . "', ";
				$s .= "'" . $placeholder_values ['placeholder_fiftytwo'] . "', ";
				$s .= "'" . $placeholder_values ['placeholder_fiftythree'] . "', ";
				$s .= "'" . $placeholder_values ['placeholder_fiftyfour'] . "', ";
				$s .= "'" . $placeholder_values ['placeholder_fiftyfive'] . "', ";
				$s .= "'" . $placeholder_values ['placeholder_fiftysix'] . "', ";
				$s .= "'" . $placeholder_values ['placeholder_fiftyseven'] . "', ";
				$s .= "'" . $placeholder_values ['placeholder_fiftyeight'] . "', ";
				$s .= "'" . $placeholder_values ['placeholder_fiftynine'] . "', ";
				$s .= "'" . $placeholder_values ['placeholder_sixty'] . "', ";
				$s .= "'" . strtolower ( str_replace ( " ", "", $imgsrc ) ) . "', ";
				$s .= "'" . strtolower ( str_replace ( " ", "", $logosrc ) ) . "', ";
				$s .= "'" . $template_info ['csspath'] . "', ";
				$s .= "'" . $template_info ['imagepath'] . "', ";
				$s .= "'" . addslashes ( $submissionText ) . "', ";
				// $client ['company_name'] = ucwords(strtolower($client ['company_name']));
				// $s .= "'" . addslashes ( $client ['company_name'] ) . "', ";
				$s .= "'', ";
				$client ['phone_number'] = str_replace(")-",") ",$client ['phone_number']);
				$tempPhone = "'Call Today! " . $client ['phone_number'] . "',";
				$s .= $tempPhone;
				$s .= "'" . $client ['contact_email'] . "', ";

				$lead_line = '<span style="font-family: '.$trialDefaults[0]["main_message_font"].'; font-size: '.$trialDefaults[0]["main_message_font_size"].'; color: '. ($globallogo_color==""?$trialDefaults[0]["mainmessage_color"]:$globallogo_color).'">'.$trialDefaults[0]["main_message"].'</span>';
				$s .= "'" . addslashes ( $lead_line ) . "', ";
				$second_line = '<span style="font-family: '.$trialDefaults[0]["description_font"].'; font-size: '.$trialDefaults[0]["description_font_size"].'; color: '. $trialDefaults[0]["description_color"] .'">'.$trialDefaults[0]["description"].'</span>';

				$s .= "'" . addslashes ( $second_line ) . "', ";
				$s .= "'" . $placeholder_values ['placeholder_seventyone'] . "', ";
				$s .= "'" . $placeholder_values ['placeholder_seventytwo'] . "', ";
				$s .= "'" . addslashes ( $title_tag ) . "', ";
				$s .= "'" . $placeholder_values ['placeholder_seventyfour'] . "', ";
				$s .= "'" . $placeholder_values ['placeholder_seventyfive'] . "', ";
				$s .= "'" . $placeholder_values['placeholder_seventysix'] . "', ";
				$s .= "'" . $placeholder_values['placeholder_seventyseven'] . "', ";
				$s .= "'" . $placeholder_values ['placeholder_seventyeight'] . "', ";
				$s .= "'" . $placeholder_values['placeholder_seventynine'] . "', ";
				$s .= "'" . $placeholder_values['placeholder_eighty'] . "', ";
				$s .= "'" . $placeholder_values['placeholder_eightyone'] . "', ";
				$s .= "'" . $placeholder_values['placeholder_eightytwo'] . "', ";
				$s .= "'" . $placeholder_values['placeholder_eightythree'] . "' ";
				$s .= ")";
				$xzdb->query ($s);
			}

/*
$trialDefaults[0]["leadpop_vertical_id"]
$trialDefaults[0]["leadpop_vertical_sub_id"]
$trialDefaults[0]['leadpop_template_id']
$trialDefaults[0]["leadpop_id"]
$trialDefaults[0]["leadpop_version_id"]
$trialDefaults[0]["leadpop_version_seq"]
*/

			$s = "select id from leadpops_templates_placeholders ";
			$s .= " where leadpop_template_id = " . $trialDefaults[0]['leadpop_template_id'];
			$s .= " and client_id = " . $client_id;
			$s .= " and leadpop_version_seq = " . $trialDefaults[0]["leadpop_version_seq"];

			$leadpops_templates_placeholders = $xzdb->fetchAll ( $s );

			for($xx = 0; $xx < count ( $leadpops_templates_placeholders ); $xx ++) {
				$s = "update leadpops_templates_placeholders_values  set placeholder_forty= '" . addslashes ( $submissionText ) . "' ";
				$s .= " where client_leadpop_id = " . $trialDefaults[0]["leadpop_id"];
				$s .= " and leadpop_template_placeholder_id = " . $leadpops_templates_placeholders [$xx] ['id'];
				$xzdb->query ( $s );
			}
			/*  set default submission options  ******************************************************************************** */
			/*  set default contact_options  ******************************************************************************** */

			for($xx = 0; $xx < count ( $leadpops_templates_placeholders ); $xx ++) {
				$s = "update leadpops_templates_placeholders_values  set placeholder_fortyone = '' , ";
				$s .= "placeholder_fortytwo = '', placeholder_fortythree = ''  where client_leadpop_id = " . $trialDefaults[0]["leadpop_id"];
				$s .= " and leadpop_template_placeholder_id = " . $leadpops_templates_placeholders [$xx] ['id'];
				$xzdb->query ( $s );
			}

			for($xx = 0; $xx < count ( $leadpops_templates_placeholders ); $xx ++) {
				$s = "update leadpops_templates_placeholders_values  set placeholder_fortyone = '" . addslashes ( $client["company_name"] ) . "'  ";
				$s .= "  where client_leadpop_id = " . $trialDefaults[0]["leadpop_id"];
				$s .= " and leadpop_template_placeholder_id = " . $leadpops_templates_placeholders [$xx] ['id'];
				$xzdb->query ( $s );
			}
			for($xx = 0; $xx < count ( $leadpops_templates_placeholders ); $xx ++) {
				$s = "update leadpops_templates_placeholders_values  set placeholder_fortytwo = '" . addslashes ( $client["phone_number"] ) . "'  ";
				$s .= "  where client_leadpop_id = " . $trialDefaults[0]["leadpop_id"];
				$s .= " and leadpop_template_placeholder_id = " . $leadpops_templates_placeholders [$xx] ['id'];
				$xzdb->query ( $s );
			}
			for($xx = 0; $xx < count ( $leadpops_templates_placeholders ); $xx ++) {
				$s = "update leadpops_templates_placeholders_values  set placeholder_fortythree = '" . addslashes ( $client["contact_email"] ) . "'  ";
				$s .= "  where client_leadpop_id = " . $trialDefaults[0]["leadpop_id"];
				$s .= " and leadpop_template_placeholder_id = " . $leadpops_templates_placeholders [$xx] ['id'];
				$xzdb->query ( $s );
			}

			/*  set default contact_options  ******************************************************************************** */
			/*  set default auto_responder options  ******************************************************************************** */

			for($xx = 0; $xx < count ( $leadpops_templates_placeholders ); $xx ++) {
				$s = "update leadpops_templates_placeholders_values  set placeholder_fortysix = '<p>Thank you for your submission.</p>' ";
				$s .= " where client_leadpop_id = " . $trialDefaults[0]["leadpop_id"];
				$s .= " and leadpop_template_placeholder_id = " . $leadpops_templates_placeholders [$xx] ['id'];
				$xzdb->query ( $s );
			}

			for($xx = 0; $xx < count ( $leadpops_templates_placeholders ); $xx ++) {
				$s = " update leadpops_templates_placeholders_values  set placeholder_thirtyseven = '" . $logosrc . "'  where client_leadpop_id = " . $trialDefaults[0]["leadpop_id"];
				$s .= " and leadpop_template_placeholder_id = " . $leadpops_templates_placeholders [$xx] ['id'];
				$xzdb->query ( $s );
			}

			for($xx = 0; $xx < count ( $leadpops_templates_placeholders ); $xx ++) {
			    $s = " update leadpops_templates_placeholders_values  set placeholder_sixtytwo = '".$globallogosrc."', placeholder_eightyone = '".$globallogo_color."' , placeholder_eightytwo = '".$globalcolored_dot."', placeholder_eightythree = '".$globalfavicon_dst."'  where client_leadpop_id = " . $trialDefaults[0]["leadpop_id"];
			    $s .= " and leadpop_template_placeholder_id = " . $leadpops_templates_placeholders[$xx]['id'];
			    $xzdb->query($s);
			}

/*
$trialDefaults[0]["leadpop_vertical_id"]
$trialDefaults[0]["leadpop_vertical_sub_id"]
$trialDefaults[0]['leadpop_template_id']
$trialDefaults[0]["leadpop_id"]
$trialDefaults[0]["leadpop_version_id"]
$trialDefaults[0]["leadpop_version_seq"]
*/
            if ($generatecolors != false && $useUploadedLogo != false) { // not uploaded logo or have previous funnel to use

				for($t = 0; $t < count($finalTrialColors); $t++) {
					$s = "insert into leadpop_background_swatches (id,client_id,leadpop_vertical_id,";
					$s .= "leadpop_vertical_sub_id,leadpop_type_id,leadpop_template_id,";
					$s .= "leadpop_id,leadpop_version_id,leadpop_version_seq,";
					$s .= "swatch,is_primary,active) values (null,";
					$s .= $client_id . "," . $trialDefaults[0]["leadpop_vertical_id"] . ",";
					$s .= $trialDefaults[0]["leadpop_vertical_sub_id"] . ",";
					$s .= $leadpoptype . "," . $trialDefaults[0]['leadpop_template_id'] . ",";
					$s .= $trialDefaults[0]["leadpop_id"] . ",";
					$s .= $trialDefaults[0]["leadpop_version_id"] . ",";
					$s .= $trialDefaults[0]["leadpop_version_seq"] . ",";
					$s .= "'" . $finalTrialColors[$t]["swatch"] . "',";
					if ($t == 0 ) {
						$s .= "'y',";
					}
					else {
						$s .= "'n',";
					}
					$s .= "'y')";
					$xzdb->query($s);
				}

				$s = "insert into leadpop_background_color (id,client_id,leadpop_vertical_id,";
				$s .= "leadpop_vertical_sub_id,leadpop_type_id,leadpop_template_id,";
				$s .= "leadpop_id,leadpop_version_id,leadpop_version_seq,";
				$s .= "background_color,active,default_changed) values (null,";
				$s .= $client_id . "," . $trialDefaults[0]["leadpop_vertical_id"] . ",";
				$s .= $trialDefaults[0]["leadpop_vertical_sub_id"] . ",";
				$s .= $leadpoptype . "," . $trialDefaults[0]['leadpop_template_id'] . ",";
				$s .= $trialDefaults[0]["leadpop_id"] . ",";
				$s .= $trialDefaults[0]["leadpop_version_id"] . ",";
				$s .= $trialDefaults[0]["leadpop_version_seq"] . ",";
				$s .= "'" . addslashes($background_css) . "','y','".$default_background_changed."')";
				$xzdb->query($s);
			}
			print("addNonEnterpriseVerticalSubverticalVersionToExistingClient - added " . $client_id);
}

/* start new enterprise function */
/* start new enterprise function */
/* start new enterprise function */

function addNewClientGenericEnterprise($vertical, $subvertical,$version, $emailaddress, $firstname, $lastname, $company,$phone) {
	global $thissub_domain;
	global $thistop_domain;
	global$leadpoptype;
	global $db;
	global $xzdb;

    require_once '/var/www/vhosts/launch.leadpops.com/external/Image.php';
    require_once '/var/www/vhosts/launch.leadpops.com/external/Client.php';

	$logo_name_mobile = "home_refinance_mobile.png";
	$logo_name = "home_refinance.png";
	$image_name = "Refinance.png";
	$logo = ""; // a blank logo value indicate to use the default logo

		/* check if email exists in system */
		$dt = date('Y-m-d H:i:s');

		$s = "select count(*) as cnt  from clients where contact_email = '".trim($emailaddress)."' ";
		$existingEmail = $xzdb->fetchOne($s);
		$duplicateEmail = false;
		if($existingEmail != 0) { // new client
			$random = generateRandomString() . "-";
			$duplicateEmail = true;   // email andrew/charles & have them get another client contact email address
			$emailaddress = $random . $emailaddress;
		}

		/* insert into clients table */

		$password = generateRandomString("8");
		$encryptedpassword = encrypt($password);

		$s = "insert into clients (client_id,first_name,last_name,company_name,phone_number,";
		$s .= "fax_number,address1, address2,city,state,zip,cell_number,join_date,";
		$s .= "contact_email,password,active) values (null,";
		$s .= " '".addslashes($firstname)."' , '".addslashes($lastname)."' , '".addslashes($company)."' , ";
		$s .= " '".$phone."', '','','',";
		$s .= "'','','','','".$dt."',";
		$s .= "'".$emailaddress."','".$encryptedpassword."','1')";
		$xzdb->query($s);
		$client_id = $xzdb->lastInsertId();

		$s = "INSERT INTO client_vertical_packages_permissions (id,client_id,clone,thedate) VALUES (NULL,";
		$s .= $client_id .", 'n', '".$dt."')";
		$xzdb->query($s);

		/* insert into active order table */
		$s = "insert into has_one_active_order (id,client_id,hasorder) values (null,".$client_id.",'y') ";
		$xzdb->query($s);

		$thedate = date ( 'Y-m-d H:i:s' );
		$s = " insert into sales_clients (sales_id,client_id,start_date,end_date,active) values (1,".$client_id.",'".$thedate."','".$thedate."','y')";
		$xzdb->query($s);
			switch ($vertical) {
				case "3":
					$emmaAccount = '1758432';
					$emma_account_type = "mortgage";
					break;
				case "1":
					$emmaAccount =  '1760824';
					$emma_account_type = "insurance";
					break;
				case "5":
					$emmaAccount = '1758435';
					$emma_account_type = "realestate";
					break;
				 default :
				    $emmaAccount = '999999';
			}
			$emma_account_name = $company;
		/* values to insert into client_emma_cron to create accounts */

		require_once('/var/www/vhosts/launch.leadpops.com/isdk/src/isdk.php');
		require_once('/var/www/library/Zend/Mail.php');

		$app = new iSDK();
		$app->cfgCon("leadpops");

		$returnFields = array('Id');
		$query = array('Email' => $emailaddress);
		$contacts = $app->dsQuery("Contact",10,0,$query,$returnFields);
		if (count($contacts) > 0) {
			## $conDat = array('_AdminLink0' => 'https://myleads.leadpops.com/login/is_andrew?xxxzzaqlk=' . $client_id,
			$conDat = array('_AdminLink0' => 'https://myleads.leadpops.com/lp/login/is_andrew?leadpopsspopdael=' . $client_id,
								   '_AdminUserName' => $emailaddress,
								   '_AdminPassword' =>  $password  );
			$conID = $app->updateCon($contacts[0]["Id"], $conDat);
			$ContactGroupId = "505";
			$Integration = 'le234'; // leadpops subdomain in use
			$callName = 'Welcome Campaign - Funnels'; // api callname

		   $gr = $app->grpAssign($conID, $ContactGroupId);
		   $goal = $app->achieveGoal($Integration, $callName, $conID);

		}
		else {
		//something
		}
		/* create client leadpops */
		$dname = '/var/www/vhosts/itclix.com/images/clients/' . substr($client_id,0,1) . '/' . $client_id;
		if (!file_exists($dname)) {
			createClientInitialDirectories($client_id);
        }
					$s = "select * from enterprise_funnels where leadpop_vertical_id = " . $vertical . " and leadpop_vertical_sub_id = " . $subvertical . " and leadpop_version_id = " . $version . " limit 1 ";
					$trialDefaults = $xzdb->fetchAll($s);
					insertDefaultEnterpriseAutoResponders ($client_id,$trialDefaults[0], $emailaddress,$phone,$xzdb);

					$s = "select * from leadpops_template_info where leadpop_vertical_id = " . $trialDefaults[0]["leadpop_vertical_id"];
					$s .= " and leadpop_vertical_sub_id = " . $trialDefaults[0]["leadpop_vertical_sub_id"] . " and leadpop_version_id = " . $trialDefaults[0]["leadpop_version_id"];
					$template_info = $xzdb->fetchRow($s);

	                $now = new DateTime();
					$s = "insert into clients_leadpops (id,client_id,leadpop_id,leadpop_version_id,leadpop_active,access_code,leadpop_version_seq,date_added) values (null,";
					$s .= $client_id . "," . $trialDefaults[0]["leadpop_id"] . "," . $trialDefaults[0]["leadpop_version_id"] . ",'1',''," . $trialDefaults[0]["leadpop_version_seq"] . ",'".$now->format("Y-m-d H:i:s")."')";
					$xzdb->query ( $s );

					$s = "insert into clients_leadpops_content (id,client_id,leadpop_id,leadpop_version_id,leadpop_active,access_code,leadpop_version_seq,";
					$s .= "section1,section2,section3,section4,section5,section6,section7,section8,section9,section10,template) values (null,";
					$s .= $client_id . "," . $trialDefaults[0]["leadpop_id"] . "," . $trialDefaults[0]["leadpop_version_id"] . ",'1',''," . $trialDefaults[0]["leadpop_version_seq"] . ",";
					$s .= "'<h4>section one</h4>','<h4>section two</h4>','<h4>section three</h4>','<h4>section four</h4>',";
					$s .= "'<h4>section five</h4>','<h4>section six</h4>','<h4>section seven</h4>','<h4>section eight</h4>','<h4>section nine</h4>',";
					$s .= "'<h4>section ten</h4>',1)";
					$xzdb->query($s);

					checkIfNeedMultipleStepInsert ( $trialDefaults[0]["leadpop_version_id"], $client_id );
					// look up domain name
					$s = "select * from clients where client_id = " . $client_id . " limit 1 ";
					$client = $xzdb->fetchRow($s);
					$subdomain = $client ['company_name'];
					$subdomain = preg_replace ( '/[^a-zA-Z]/', '', $subdomain );
					$s = "select domain from top_level_domains where primary_domain = 'y' limit 1 ";
					$topdomain = $xzdb->fetchOne ( $s );
					if ($leadpoptype == $thissub_domain) {
						$s = "select  count(*) from clients_subdomains where  ";
						$s .= " subdomain_name = '" . $subdomain . "' ";
						$s .= " and top_level_domain = '" . $topdomain . "' ";
						$foundsubdomain = $xzdb->fetchOne ( $s );
						if ($foundsubdomain > 0) {
							$s = "select domain from top_level_domains where primary_domain != 'y' ";
							$nonprimary = $xzdb->fetchAll ( $s );
							$foundone = false;
							while ( $foundone == false ) {
								for($k = 0; $k < count ( $nonprimary ); $k ++) {
									$s = "select  count(*) from clients_subdomains where  ";
									$s .= " subdomain_name = '" . $subdomain . "' ";
									$s .= " and top_level_domain = '" . $nonprimary [$k] ['domain'] . "' ";
									$foundsubdomain = $xzdb->fetchOne ( $s );
									if ($foundsubdomain == 0) {
										$s = "insert into clients_subdomains (id,client_id,subdomain_name,top_level_domain,leadpop_vertical_id,";
										$s .= "leadpop_vertical_sub_id,leadpop_type_id,leadpop_template_id,";
										$s .= "leadpop_id,leadpop_version_id,leadpop_version_seq ) values (null,";
										$s .= $client_id . ",'" . $subdomain . "','" . $nonprimary [$k] ['domain'] . "',";
										$s .= $trialDefaults[0]["leadpop_vertical_id"] . "," . $trialDefaults[0]["leadpop_vertical_sub_id"] . "," . $leadpoptype . "," . $trialDefaults[0]['leadpop_template_id'] . ",";
										$s .= $trialDefaults[0]["leadpop_id"] . "," . $trialDefaults[0]["leadpop_version_id"] . "," . $trialDefaults[0]["leadpop_version_seq"] . ")";
										$xzdb->query ( $s );
		/* emma insert */
		/* emma insert */
		/* emma insert */
		                                if ($emmaAccount != '999999') {
											$s = "insert into client_emma_cron (id,client_id,emma_default_group,account_type,domain_name,account_name,master_account_ids,has_run, leadpop_vertical_id,leadpop_subvertical_id) values (null,";
											$s .= $client_id . ",'". $trialDefaults[0]['emma_default_group'] ."','".$emma_account_type."','". strtolower($subdomain . "." . $nonprimary [$k] ['domain']) ."','". $emma_account_name ."','";
											$s .= addslashes($emmaAccount) . "','n',".$trialDefaults[0]["leadpop_vertical_id"].",".$trialDefaults[0]["leadpop_vertical_sub_id"].")";
											$xzdb->query ($s);
                                        }
		/* emma insert */
		/* emma insert */
		/* emma insert */

										$foundmobile = false;
										$randc = "";
										while ( $foundmobile == false ) {
											$s =  "select count(*) as cnt from mobileclients where mobiledomain = '".$subdomain . $randc .  ".itclixmobile.com'  ";
											$nummobile = $xzdb->fetchOne($s);
											if($nummobile == 0) {
												$foundmobile = true;
											}
											else {
												$randc = $randc . getRandomCharacter ();
											}
										}

											// set 	client_or_domain_logo_image to 'o' for no uploaded logo
											/* mobile domain and logo */

										$s = "INSERT INTO mobileclients (nonmobiledomain, mobiledomain, client_id, id, leadpop_id, ";
										$s .= "leadpop_vertical_id,leadpop_vertical_sub_id, leadpop_type_id, leadpop_template_id,";
										$s .= "leadpop_version_id, leadpop_version_seq, ";
										$s .= "iszillow, zillow_api, active, group_design, phone, company,	client_or_domain_logo_image) VALUES (";
										$s .= "'".$subdomain . "." . $nonprimary [$k] ['domain'] . "','" . $subdomain . $randc .".itclixmobile.com',";
										$s .= $client_id .",null,". $trialDefaults[0]["leadpop_id"] . "," . $trialDefaults[0]["leadpop_vertical_id"] . "," . $trialDefaults[0]["leadpop_vertical_sub_id"] . "," . $leadpoptype . "," .  $trialDefaults[0]['leadpop_template_id'];
										$s .= "," . $trialDefaults[0]["leadpop_version_id"] . "," . $trialDefaults[0]["leadpop_version_seq"] . ",'n','n','y','y','".preg_replace ('/[^0-9]/', '', $client ['phone_number'])."', '".addslashes($client ['company_name'])."','o') ";
										$xzdb->query ($s);

										$checkdomain = $subdomain . "." . $nonprimary [$k] ['domain'];
										$s = "insert into check_mobile (id,url,active,scope) values (null,";
										$s .= "'". $checkdomain ."','y', 'phone,tablet')";
										$xzdb->query ($s);

										$cmd = '/bin/cp  /var/www/vhosts/launch.leadpops.com/trial/classiclogos/' . $logo_name_mobile . '  /var/www/vhosts/itclixmobile.com/css/'.$trialDefaults[0]["subvertical_name"] . '/themes/images/' . $client_id . 'grouplogo.png';
										exec($cmd);

										$googleDomain = $subdomain . "." . $nonprimary [$k] ['domain'];
										insertPurchasedGoogle ( $client_id, $googleDomain );

										$s = "insert into  bottom_links (id,client_id,leadpop_id,leadpop_type_id,leadpop_vertical_id,";
										$s .= "leadpop_vertical_sub_id,leadpop_template_id,leadpop_version_id,";
										$s .= "leadpop_version_seq,privacy,terms,disclosures,licensing,about,contact,";
										$s .= "privacy_active,terms_active,disclosures_active,licensing_active,about_active,contact_active,";
										$s .= "privacy_type,terms_type,disclosures_type,licensing_type,about_type,contact_type,privacy_url,";
										$s .= "terms_url,disclosures_url,licensing_url,about_url,contact_url,privacy_text,";
										$s .= "terms_text,disclosures_text,licensing_text,about_text,contact_text,";
										$s .= "compliance_text,compliance_is_linked,compliance_link,compliance_active,";
										$s .= "license_number_active,license_number_is_linked,license_number_text,license_number_link";
										$s .= ") values (null,";
										$s .= $client_id . "," . $trialDefaults[0]["leadpop_id"] . "," . $leadpoptype . "," . $trialDefaults[0]["leadpop_vertical_id"] . "," . $trialDefaults[0]["leadpop_vertical_sub_id"] . ",";
										$s .= $trialDefaults[0]['leadpop_template_id'] . "," . $trialDefaults[0]["leadpop_version_id"] . "," . $trialDefaults[0]["leadpop_version_seq"];
										$s .= ",'','','','','','','n','n','n','n','n','y','m','m','m','m','m','m','','','','','','','','','','','','',";
										$s .= "'','','','',";
										$s .= "'','','',''";
										$s .= ") ";
										$xzdb->query ( $s );

										$s = "insert into contact_options (id,client_id,leadpop_id,";
										$s .= "leadpop_type_id,leadpop_vertical_id,leadpop_vertical_sub_id,";
										$s .= "leadpop_template_id,leadpop_version_id,leadpop_version_seq,";
										$s .= "companyname,phonenumber,email,companyname_active,";
										$s .= "phonenumber_active,email_active) values (null,";
										$s .= $client_id . "," . $trialDefaults[0]["leadpop_id"] . "," . $leadpoptype . "," . $trialDefaults[0]["leadpop_vertical_id"] . "," . $trialDefaults[0]["leadpop_vertical_sub_id"] . ",";
										$s .= $trialDefaults[0]['leadpop_template_id'] . "," . $trialDefaults[0]["leadpop_version_id"] . "," . $trialDefaults[0]["leadpop_version_seq"] . ",";
										$s .= "'" . addslashes ( $client ['company_name'] ) . "','Call Today! " . $client ['phone_number'] . "','";
										$s .= $client ['contact_email'] . "','n','y','n')";
										$xzdb->query ( $s );

										$autotext = getAutoResponderText ( $trialDefaults[0]["leadpop_vertical_id"], $trialDefaults[0]["leadpop_vertical_sub_id"] , $trialDefaults[0]["leadpop_id"]);
										if ($autotext == "not found") {
											$thehtml =  "";
											$thesubject = "";
										}
										else {
											$thehtml =  $autotext[0]["html"];
											$thesubject = $autotext[0]["subject_line"];
										}

										$s = "insert into autoresponder_options (id,client_id,leadpop_id,";
										$s .= "leadpop_type_id,leadpop_vertical_id,leadpop_vertical_sub_id,";
										$s .= "leadpop_template_id,leadpop_version_id,leadpop_version_seq,";
										$s .= "html,thetext,html_active,text_active,subject_line ) values (null,";
										$s .= $client_id . "," . $trialDefaults[0]["leadpop_id"] . "," . $leadpoptype . "," . $trialDefaults[0]["leadpop_vertical_id"] . "," . $trialDefaults[0]["leadpop_vertical_sub_id"] . ",";
										$s .= $trialDefaults[0]['leadpop_template_id'] . "," . $trialDefaults[0]["leadpop_version_id"] . "," . $trialDefaults[0]["leadpop_version_seq"] . ",";
										$s .= "'" . addslashes ( $thehtml ) . "','','y','n','".addslashes($thesubject)."')";
										$xzdb->query ( $s );

								        $title_tag =  " FREE " . $trialDefaults[0]["display_name"] . " | " . addslashes ( ucwords($client['company_name']) );

										$s = "insert into seo_options (id,client_id,leadpop_id,";
										$s .= "leadpop_type_id,leadpop_vertical_id,leadpop_vertical_sub_id,";
										$s .= "leadpop_template_id,leadpop_version_id,leadpop_version_seq,";
										$s .= "titletag,description,metatags,titletag_active,";
										$s .= "description_active,metatags_active) values (null,";
										$s .= $client_id . "," . $trialDefaults[0]["leadpop_id"] . "," . $leadpoptype . "," . $trialDefaults[0]["leadpop_vertical_id"] . "," . $trialDefaults[0]["leadpop_vertical_sub_id"] . ",";
										$s .= $trialDefaults[0]['leadpop_template_id'] . "," . $trialDefaults[0]["leadpop_version_id"] . "," . $trialDefaults[0]["leadpop_version_seq"] . ",";
										$s .= "'" . addslashes ( $title_tag ) . "','','','y','n','n') ";
										$xzdb->query ( $s );

										$s = "select * from leadpops_verticals where id = " . $trialDefaults[0]["leadpop_vertical_id"];
										$vertres = $xzdb->fetchRow ( $s );
										$verticalName = $vertres ['lead_pop_vertical'];
               //  	funnel_type 	subvertical_name 	leadpop_vertical_id 	leadpop_vertical_sub_id 	leadpop_type_id 	leadpop_template_id 	leadpop_id 	leadpop_version_id 	leadpop_version_seq

										if (isset ($trialDefaults[0]["leadpop_vertical_sub_id"] ) && $trialDefaults[0]["leadpop_vertical_sub_id"] != "") {
											$s = "select * from leadpops_verticals_sub where leadpop_vertical_id  = " . $trialDefaults[0]["leadpop_vertical_id"];
											$s .= " and id = " . $trialDefaults[0]["leadpop_vertical_sub_id"];
											$subvertres = $xzdb->fetchRow ( $s );
											$subverticalName = $subvertres ['lead_pop_vertical_sub'];
										} else {
											$subverticalName = "";
										}

										$logosrc = "";
										$imgsrc = "";
										$uploadedLogo = $logo;
										if ($subverticalName == "") {
											$logosrc = getHttpServer () . '/images/' . strtolower(str_replace(" ","",$verticalName)) . '/' . $logo_name;
										} else {
											$logosrc = getHttpServer () . '/images/' . strtolower(str_replace(" ","",$verticalName)) . '/' . strtolower(str_replace(" ","",$subverticalName)). '_logos/' .$logo_name;
										}
										insertDefaultClientUploadLogo($logosrc,$trialDefaults[0],$client_id);

										$imgsrc = insertClientDefaultEnterpriseImage($trialDefaults[0],$image_name,$client_id);

										$nine = "999999";
										$submissionText = getSubmissionText($trialDefaults[0]["leadpop_id"],$trialDefaults[0]["leadpop_vertical_id"],$trialDefaults[0]["leadpop_vertical_sub_id"],$nine);
										$submissionText = str_replace("##clientlogo##",$logosrc,$submissionText);
										$submissionText = str_replace("##clientphonenumber##",$phone,$submissionText);

										$s = "insert into submission_options (id,client_id,leadpop_id,leadpop_type_id,";
										$s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,";
										$s .= "leadpop_version_id,leadpop_version_seq,thankyou,information,";
										$s .= "thirdparty,thankyou_active,information_active,thirdparty_active) values (null,";
										$s .= $client_id . "," . $trialDefaults[0]["leadpop_id"] . "," . $leadpoptype . "," . $trialDefaults[0]["leadpop_vertical_id"] . "," . $trialDefaults[0]["leadpop_vertical_sub_id"] . ",";
										$s .= $trialDefaults[0]['leadpop_template_id'] . "," . $trialDefaults[0]["leadpop_version_id"] . "," . $trialDefaults[0]["leadpop_version_seq"] . ",";
										$s .= "'" . addslashes ( $submissionText ) . "','','','y','n','n')";
										$xzdb->query ( $s );

										$foundone = true;
										break 2;
									}
								}
								$subdomain = $subdomain . getRandomCharacter ();
							}
						} else {

							$s = "insert into clients_subdomains (id,client_id,subdomain_name,top_level_domain,leadpop_vertical_id,";
							$s .= "leadpop_vertical_sub_id,leadpop_type_id,leadpop_template_id,";
							$s .= "leadpop_id,leadpop_version_id,leadpop_version_seq ) values (null,";
							$s .= $client_id . ",'" . $subdomain . "','" . $topdomain . "',";
							$s .= $trialDefaults[0]["leadpop_vertical_id"] . "," . $trialDefaults[0]["leadpop_vertical_sub_id"] . "," . $leadpoptype . "," . $trialDefaults[0]['leadpop_template_id'] . ",";
							$s .= $trialDefaults[0]["leadpop_id"] . "," . $trialDefaults[0]["leadpop_version_id"] . "," . $trialDefaults[0]["leadpop_version_seq"] . ")";
							$xzdb->query ( $s );

		/* emma insert */
		/* emma insert */
		/* emma insert */
							if ($emmaAccount != '999999') {
								$s = "insert into client_emma_cron (id,client_id,emma_default_group,account_type,domain_name,account_name,master_account_ids,has_run,leadpop_vertical_id,leadpop_subvertical_id) values (null,";
								$s .= $client_id . ",'". $trialDefaults[0]['emma_default_group'] ."','".$emma_account_type."','". strtolower($subdomain . "." . $topdomain) ."','". $emma_account_name ."','";
								$s .= addslashes($emmaAccount) . "','n',".$trialDefaults[0]["leadpop_vertical_id"].",".$trialDefaults[0]["leadpop_vertical_sub_id"].")";
								$xzdb->query ($s);
							}
		/* emma insert */
		/* emma insert */
		/* emma insert */

							$foundmobile = false;
							$randc = "";
							while ( $foundmobile == false ) {
								$s =  "select count(*) as cnt from mobileclients where mobiledomain = '".$subdomain . $randc .  ".itclixmobile.com'  ";
								$nummobile = $xzdb->fetchOne($s);
								if($nummobile == 0) {
									$foundmobile = true;
								}
								else {
									$randc = $randc . getRandomCharacter ();
								}
							}

							$s = "INSERT INTO mobileclients (nonmobiledomain, mobiledomain, client_id, id, leadpop_id, ";
							$s .= "leadpop_vertical_id,leadpop_vertical_sub_id, leadpop_type_id, leadpop_template_id,";
							$s .= "leadpop_version_id, leadpop_version_seq, ";
							$s .= "iszillow, zillow_api, active, group_design, phone, company) VALUES (";
							$s .= "'".$subdomain . "." . $topdomain . "','".$subdomain . $randc . ".itclixmobile.com',";
							$s .= $client_id  .",null,". $trialDefaults[0]["leadpop_id"] . "," . $trialDefaults[0]["leadpop_vertical_id"] . "," . $trialDefaults[0]["leadpop_vertical_sub_id"] . "," . $leadpoptype . "," .  $trialDefaults[0]['leadpop_template_id'];
							$s .= "," . $trialDefaults[0]["leadpop_version_id"] . "," . $trialDefaults[0]["leadpop_version_seq"] . ",'n','n','y','y','".preg_replace ('/[^0-9]/', '', $client ['phone_number'])."', '".addslashes($client ['company_name'])."') ";
							$xzdb->query ($s);

							$checkdomain = $subdomain . "." . $topdomain;
							$s = "insert into check_mobile (id,url,active,scope) values (null,";
							$s .= "'". $checkdomain ."','y', 'phone,tablet')";
							$xzdb->query ($s);

							$cmd = '/bin/cp  /var/www/vhosts/launch.leadpops.com/trial/classiclogos/' . $logo_name_mobile . '  /var/www/vhosts/itclixmobile.com/css/'.$trialDefaults[0]["subvertical_name"] . '/themes/images/' . $client_id . 'grouplogo.png';
							exec($cmd);

							$googleDomain = $subdomain . "." . $topdomain;
							insertPurchasedGoogle ( $client_id, $googleDomain );

							$s = "insert into  bottom_links (id,client_id,leadpop_id,leadpop_type_id,leadpop_vertical_id,";
							$s .= "leadpop_vertical_sub_id,leadpop_template_id,leadpop_version_id,";
							$s .= "leadpop_version_seq,privacy,terms,disclosures,licensing,about,contact,";
							$s .= "privacy_active,terms_active,disclosures_active,licensing_active,about_active,contact_active,";
							$s .= "privacy_type,terms_type,disclosures_type,licensing_type,about_type,contact_type,privacy_url,";
							$s .= "terms_url,disclosures_url,licensing_url,about_url,contact_url,privacy_text,";
							$s .= "terms_text,disclosures_text,licensing_text,about_text,contact_text,";
							$s .= "compliance_text,compliance_is_linked,compliance_link,compliance_active,";
							$s .= "license_number_active,license_number_is_linked,license_number_text,license_number_link";
							$s .= ") values (null,";
							$s .= $client_id . "," . $trialDefaults[0]["leadpop_id"] . "," . $leadpoptype . "," . $trialDefaults[0]["leadpop_vertical_id"] . "," . $trialDefaults[0]["leadpop_vertical_sub_id"] . ",";
							$s .= $trialDefaults[0]['leadpop_template_id'] . "," . $trialDefaults[0]["leadpop_version_id"] . "," . $trialDefaults[0]["leadpop_version_seq"];
							$s .= ",'','','','','','','n','n','n','n','n','y','m','m','m','m','m','m','','','','','','','','','','','','',";
							$s .= "'','','','',";
							$s .= "'','','',''";
							$s .= ") ";
							$xzdb->query ( $s );

							$s = "insert into contact_options (id,client_id,leadpop_id,";
							$s .= "leadpop_type_id,leadpop_vertical_id,leadpop_vertical_sub_id,";
							$s .= "leadpop_template_id,leadpop_version_id,leadpop_version_seq,";
							$s .= "companyname,phonenumber,email,companyname_active,";
							$s .= "phonenumber_active,email_active) values (null,";
							$s .= $client_id . "," . $trialDefaults[0]["leadpop_id"] . "," . $leadpoptype . "," . $trialDefaults[0]["leadpop_vertical_id"] . "," . $trialDefaults[0]["leadpop_vertical_sub_id"] . ",";
							$s .= $trialDefaults[0]['leadpop_template_id'] . "," . $trialDefaults[0]["leadpop_version_id"] . "," . $trialDefaults[0]["leadpop_version_seq"] . ",";
							$s .= "'" . addslashes ( $client ['company_name'] ) . "','Call Today! " . $client ['phone_number'] . "','";
							$s .= $client ['contact_email'] . "','n','y','n')";
							$xzdb->query ( $s );

							$autotext = getAutoResponderText ( $trialDefaults[0]["leadpop_vertical_id"], $trialDefaults[0]["leadpop_vertical_sub_id"] , $trialDefaults[0]["leadpop_id"]);
							if ($autotext == "not found") {
								$thehtml =  "";
								$thesubject = "";
							}
							else {
								$thehtml =  $autotext[0]["html"];
								$thesubject = $autotext[0]["subject_line"];
							}

							$s = "insert into autoresponder_options (id,client_id,leadpop_id,";
							$s .= "leadpop_type_id,leadpop_vertical_id,leadpop_vertical_sub_id,";
							$s .= "leadpop_template_id,leadpop_version_id,leadpop_version_seq,";
							$s .= "html,thetext,html_active,text_active,subject_line ) values (null,";
							$s .= $client_id . "," . $trialDefaults[0]["leadpop_id"] . "," . $leadpoptype . "," . $trialDefaults[0]["leadpop_vertical_id"] . "," . $trialDefaults[0]["leadpop_vertical_sub_id"] . ",";
							$s .= $trialDefaults[0]['leadpop_template_id'] . "," . $trialDefaults[0]["leadpop_version_id"] . "," . $trialDefaults[0]["leadpop_version_seq"] . ",";
							$s .= "'" . addslashes ( $thehtml ) . "','','y','n','".addslashes($thesubject)."')";
							$xzdb->query ($s);

							try {
								$xzdb->query ($s);
							}
							catch ( PDOException $e) {
								print ("Error!: " . $e->getMessage() . "<br/>") ;
								print($s);
								die();
							}

					        $title_tag =  " FREE " . $trialDefaults[0]["display_name"] . " | " . addslashes ( ucwords($client['company_name']) );
							//FREE Home Purchase Qualifier | Sentinel Mortgage Company

							$s = "insert into seo_options (id,client_id,leadpop_id,";
							$s .= "leadpop_type_id,leadpop_vertical_id,leadpop_vertical_sub_id,";
							$s .= "leadpop_template_id,leadpop_version_id,leadpop_version_seq,";
							$s .= "titletag,description,metatags,titletag_active,";
							$s .= "description_active,metatags_active) values (null,";
							$s .= $client_id . "," . $trialDefaults[0]["leadpop_id"] . "," . $leadpoptype . "," . $trialDefaults[0]["leadpop_vertical_id"] . "," . $trialDefaults[0]["leadpop_vertical_sub_id"] . ",";
							$s .= $trialDefaults[0]['leadpop_template_id'] . "," . $trialDefaults[0]["leadpop_version_id"] . "," . $trialDefaults[0]["leadpop_version_seq"] . ",";
							$s .= "'" . addslashes ( $title_tag ) . "','','','y','n','n') ";
							$xzdb->query ( $s );

							$s = "select * from leadpops_verticals where id = " . $trialDefaults[0]["leadpop_vertical_id"];
							$vertres = $xzdb->fetchRow ( $s );
							$verticalName = $vertres ['lead_pop_vertical'];

							if (isset ($trialDefaults[0]["leadpop_vertical_sub_id"] ) && $trialDefaults[0]["leadpop_vertical_sub_id"] != "") {
								$s = "select * from leadpops_verticals_sub where leadpop_vertical_id  = " . $trialDefaults[0]["leadpop_vertical_id"];
								$s .= " and id = " . $trialDefaults[0]["leadpop_vertical_sub_id"];
								$subvertres = $xzdb->fetchRow ( $s );
								$subverticalName = $subvertres ['lead_pop_vertical_sub'];
							} else {
								$subverticalName = "";
							}

							$logosrc = "";
							$imgsrc = "";
							$uploadedLogo = $logo;

							if ($subverticalName == "") {
								$logosrc = getHttpServer () . '/images/' . strtolower(str_replace(" ","",$verticalName)) . '/' . $logo_name;
							} else {
								$logosrc = getHttpServer () . '/images/' . strtolower(str_replace(" ","",$verticalName)) . '/' . strtolower(str_replace(" ","",$subverticalName)). '_logos/' . $logo_name;
							}
							insertDefaultClientUploadLogo($logosrc,$trialDefaults[0],$client_id);
							$imgsrc = insertClientDefaultEnterpriseImage($trialDefaults[0],$image_name,$client_id);

							$nine = "999999";
							$submissionText = getSubmissionText($trialDefaults[0]["leadpop_id"],$trialDefaults[0]["leadpop_vertical_id"],$trialDefaults[0]["leadpop_vertical_sub_id"],$nine);
							$submissionText = str_replace("##clientlogo##",$logosrc,$submissionText);
							$submissionText = str_replace("##clientphonenumber##",$phone,$submissionText);

							$s = "insert into submission_options (id,client_id,leadpop_id,leadpop_type_id,";
							$s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,";
							$s .= "leadpop_version_id,leadpop_version_seq,thankyou,information,";
							$s .= "thirdparty,thankyou_active,information_active,thirdparty_active) values (null,";
							$s .= $client_id . "," . $trialDefaults[0]["leadpop_id"] . "," . $leadpoptype . "," . $trialDefaults[0]["leadpop_vertical_id"] . "," . $trialDefaults[0]["leadpop_vertical_sub_id"] . ",";
							$s .= $trialDefaults[0]['leadpop_template_id'] . "," . $trialDefaults[0]["leadpop_version_id"] . "," . $trialDefaults[0]["leadpop_version_seq"] . ",";
							$s .= "'" . addslashes ( $submissionText ) . "','','','y','n','n')";
							$xzdb->query ( $s );

						}
					}

			$s = "select * from leadpops_templates_placeholders_info where leadpop_template_id = " . $trialDefaults[0]['leadpop_template_id'] . " order by step ";
			$placeholder_info = $xzdb->fetchAll ( $s );
			for($j = 0; $j < count ( $placeholder_info ); $j ++) {
				$s = "insert into leadpops_templates_placeholders (id,";
				$s .= "leadpop_template_id,step,client_id,leadpop_version_seq,";
				$s .= "placeholder_one,";
				$s .= "placeholder_two,";
				$s .= "placeholder_three,";
				$s .= "placeholder_four,";
				$s .= "placeholder_five,";
				$s .= "placeholder_six,";
				$s .= "placeholder_seven,";
				$s .= "placeholder_eight,";
				$s .= "placeholder_nine,";
				$s .= "placeholder_ten,";
				$s .= "placeholder_eleven,";
				$s .= "placeholder_twelve,";
				$s .= "placeholder_thirteen,";
				$s .= "placeholder_fourteen,";
				$s .= "placeholder_fifteen,";
				$s .= "placeholder_sixteen,";
				$s .= "placeholder_seventeen,";
				$s .= "placeholder_eighteen,";
				$s .= "placeholder_nineteen,";
				$s .= "placeholder_twenty,";
				$s .= "placeholder_twentyone,";
				$s .= "placeholder_twentytwo,";
				$s .= "placeholder_twentythree,";
				$s .= "placeholder_twentyfour,";
				$s .= "placeholder_twentyfive,";
				$s .= "placeholder_twentysix,";
				$s .= "placeholder_twentyseven,";
				$s .= "placeholder_twentyeight,";
				$s .= "placeholder_twentynine,";
				$s .= "placeholder_thirty,";
				$s .= "placeholder_thirtyone,";
				$s .= "placeholder_thirtytwo,";
				$s .= "placeholder_thirtythree,";
				$s .= "placeholder_thirtyfour,";
				$s .= "placeholder_thirtyfive,";
				$s .= "placeholder_thirtysix,";
				$s .= "placeholder_thirtyseven,";
				$s .= "placeholder_thirtyeight,";
				$s .= "placeholder_thirtynine,";
				$s .= "placeholder_forty,";
				$s .= "placeholder_fortyone,";
				$s .= "placeholder_fortytwo,";
				$s .= "placeholder_fortythree,";
				$s .= "placeholder_fortyfour,";
				$s .= "placeholder_fortyfive,";
				$s .= "placeholder_fortysix,";
				$s .= "placeholder_fortyseven,";
				$s .= "placeholder_fortyeight,";
				$s .= "placeholder_fortynine,";
				$s .= "placeholder_fifty,";
				$s .= "placeholder_fiftyone,";
				$s .= "placeholder_fiftytwo,";
				$s .= "placeholder_fiftythree,";
				$s .= "placeholder_fiftyfour,";
				$s .= "placeholder_fiftyfive,";
				$s .= "placeholder_fiftysix,";
				$s .= "placeholder_fiftyseven,";
				$s .= "placeholder_fiftyeight,";
				$s .= "placeholder_fiftynine,";
				$s .= "placeholder_sixty,";
				$s .= "placeholder_sixtyone,";
				$s .= "placeholder_sixtytwo,";
				$s .= "placeholder_sixtythree,";
				$s .= "placeholder_sixtyfour,";
				$s .= "placeholder_sixtyfive,";
				$s .= "placeholder_sixtysix,";
				$s .= "placeholder_sixtyseven,";
				$s .= "placeholder_sixtyeight,";
				$s .= "placeholder_sixtynine,";
				$s .= "placeholder_seventy,";
				$s .= "placeholder_seventyone,";
				$s .= "placeholder_seventytwo,";
				$s .= "placeholder_seventythree,";
				$s .= "placeholder_seventyfour,";
				$s .= "placeholder_seventyfive,";
				$s .= "placeholder_seventysix,";
				$s .= "placeholder_seventyseven,";
				$s .= "placeholder_seventyeight,";
				$s .= "placeholder_seventynine,";
				$s .= "placeholder_eighty,";
				$s .= "placeholder_eightyone,";
				$s .= "placeholder_eightytwo,";
				$s .= "placeholder_eightythree";
				$s .= "    ) values (null," . $trialDefaults[0]['leadpop_template_id'] . ",";
				$s .= $placeholder_info [$j] ['step'] . "," . $client_id . "," . $trialDefaults[0]["leadpop_version_seq"] . ",";
				$s .= "'" . $placeholder_info [$j] ['placeholder_one'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_two'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_three'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_four'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_five'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_six'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_seven'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_eight'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_nine'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_ten'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_eleven'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_twelve'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_thirteen'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fourteen'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fifteen'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_sixteen'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_seventeen'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_eighteen'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_nineteen'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_twenty'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_twentyone'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_twentytwo'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_twentythree'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_twentyfour'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_twentyfive'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_twentysix'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_twentyseven'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_twentyeight'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_twentynine'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_thirty'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_thirtyone'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_thirtytwo'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_thirtythree'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_thirtyfour'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_thirtyfive'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_thirtysix'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_thirtyseven'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_thirtyeight'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_thirtynine'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_forty'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fortyone'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fortytwo'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fortythree'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fortyfour'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fortyfive'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fortysix'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fortyseven'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fortyeight'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fortynine'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fifty'] . "', ";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fiftyone'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fiftytwo'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fiftythree'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fiftyfour'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fiftyfive'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fiftysix'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fiftyseven'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fiftyeight'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fiftynine'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_sixty'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_sixtyone'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_sixtytwo'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_sixtythree'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_sixtyfour'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_sixtyfive'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_sixtysix'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_sixtyseven'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_sixtyeight'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_sixtynine'] . "' ,";
				$s .= "'" . addslashes ( $placeholder_info [$j] ['placeholder_seventy'] ) . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_seventyone'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_seventytwo'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_seventythree'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_seventyfour'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_seventyfive'] . "', ";
				$s .= "'" . $placeholder_info [$j] ['placeholder_seventysix'] . "', ";
				$s .= "'" . $placeholder_info [$j] ['placeholder_seventyseven'] . "', ";
				$s .= "'" . $placeholder_info [$j] ['placeholder_seventyeight'] . "', ";
				$s .= "'" . $placeholder_info [$j] ['placeholder_seventynine'] . "', ";
				$s .= "'" . $placeholder_info [$j] ['placeholder_eighty'] . "', ";
				$s .= "'" . $placeholder_info [$j] ['placeholder_eightyone'] . "', ";
				$s .= "'" . $placeholder_info [$j] ['placeholder_eightytwo'] . "', ";
				$s .= "'" . $placeholder_info [$j] ['placeholder_eightythree'] . "' ";
				$s .= " )";
				$xzdb->query ( $s );
				$placeholder_id = $xzdb->lastInsertId ();

				$s = "select * from leadpops_templates_placeholders_values_info where ";
				$s .= " leadpop_template_id = " . $placeholder_info [$j] ['leadpop_template_id'];
				$s .= " and step = " . $placeholder_info [$j] ['step'];
				$s .= " and placeholder_fortyseven = '".$placeholder_info[$j]['placeholder_fortyseven']."' ";
				$placeholder_values = $xzdb->fetchRow ( $s );

				$s = "insert into leadpops_templates_placeholders_values (id,client_leadpop_id,";
				$s .= "  leadpop_template_placeholder_id,";
				$s .= "  placeholder_one,";
				$s .= "  placeholder_two,";
				$s .= "  placeholder_three,";
				$s .= "  placeholder_four,";
				$s .= "  placeholder_five,";
				$s .= "  placeholder_six,";
				$s .= "  placeholder_seven,";
				$s .= "  placeholder_eight,";
				$s .= "  placeholder_nine,";
				$s .= "  placeholder_ten,";
				$s .= "  placeholder_eleven,";
				$s .= "  placeholder_twelve,";
				$s .= "  placeholder_thirteen,";
				$s .= "  placeholder_fourteen,";
				$s .= "  placeholder_fifteen,";
				$s .= "  placeholder_sixteen,";
				$s .= "  placeholder_seventeen,";
				$s .= "  placeholder_eighteen,";
				$s .= "  placeholder_nineteen,";
				$s .= "  placeholder_twenty,";
				$s .= "  placeholder_twentyone,";
				$s .= "  placeholder_twentytwo,";
				$s .= "  placeholder_twentythree,";
				$s .= "  placeholder_twentyfour,";
				$s .= "  placeholder_twentyfive,";
				$s .= "  placeholder_twentysix,";
				$s .= "  placeholder_twentyseven,";
				$s .= "  placeholder_twentyeight,";
				$s .= "  placeholder_twentynine,";
				$s .= "  placeholder_thirty,";
				$s .= "  placeholder_thirtyone,";
				$s .= "  placeholder_thirtytwo,";
				$s .= "  placeholder_thirtythree,";
				$s .= "  placeholder_thirtyfour,";
				$s .= "  placeholder_thirtyfive,";
				$s .= "  placeholder_thirtysix,";
				$s .= "  placeholder_thirtyseven,";
				$s .= "  placeholder_thirtyeight,";
				$s .= "  placeholder_thirtynine,";
				$s .= "  placeholder_forty,";
				$s .= "  placeholder_fortyone,";
				$s .= "  placeholder_fortytwo,";
				$s .= "  placeholder_fortythree,";
				$s .= "  placeholder_fortyfour,";
				$s .= "  placeholder_fortyfive,";
				$s .= "  placeholder_fortysix,";
				$s .= "  placeholder_fortyseven,";
				$s .= "  placeholder_fortyeight,";
				$s .= "  placeholder_fortynine,";
				$s .= "  placeholder_fifty, ";
				$s .= "placeholder_fiftyone,";
				$s .= "placeholder_fiftytwo,";
				$s .= "placeholder_fiftythree,";
				$s .= "placeholder_fiftyfour,";
				$s .= "placeholder_fiftyfive,";
				$s .= "placeholder_fiftysix,";
				$s .= "placeholder_fiftyseven,";
				$s .= "placeholder_fiftyeight,";
				$s .= "placeholder_fiftynine,";
				$s .= "placeholder_sixty,";
				$s .= "placeholder_sixtyone,";
				$s .= "placeholder_sixtytwo,";
				$s .= "placeholder_sixtythree,";
				$s .= "placeholder_sixtyfour,";
				$s .= "placeholder_sixtyfive,";
				$s .= "placeholder_sixtysix,";
				$s .= "placeholder_sixtyseven,";
				$s .= "placeholder_sixtyeight,";
				$s .= "placeholder_sixtynine,";
				$s .= "placeholder_seventy,";
				$s .= "placeholder_seventyone,";
				$s .= "placeholder_seventytwo,";
				$s .= "placeholder_seventythree,";
				$s .= "placeholder_seventyfour,";
				$s .= "placeholder_seventyfive,";
				$s .= "placeholder_seventysix,";
				$s .= "placeholder_seventyseven,";
				$s .= "placeholder_seventyeight,";
				$s .= "placeholder_seventynine,";
				$s .= "placeholder_eighty,";
				$s .= "placeholder_eightyone,";
				$s .= "placeholder_eightytwo,";
				$s .= "placeholder_eightythree";
				$s .= ") values (null," . $trialDefaults[0]["leadpop_id"] . ",";
				$s .= $placeholder_id . ",";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_one'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_two'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_three'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_four'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_five'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_six'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_seven'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_eight'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_nine'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_ten'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_eleven'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_twelve'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_thirteen'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_fourteen'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_fifteen'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_sixteen'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_seventeen'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_eighteen'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_nineteen'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_twenty'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_twentyone'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_twentytwo'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_twentythree'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_twentyfour'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_twentyfive'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_twentysix'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_twentyseven'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_twentyeight'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_twentynine'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_thirty'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_thirtyone'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_thirtytwo'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_thirtythree'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_thirtyfour'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_thirtyfive'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_thirtysix'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_thirtyseven'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_thirtyeight'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_thirtynine'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_forty'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_fortyone'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_fortytwo'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_fortythree'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_fortyfour'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_fortyfive'] ) . "', ";
				$s .= "'" . $placeholder_values ['placeholder_fortysix'] . "', ";
				$s .= "'" . $placeholder_values ['placeholder_fortyseven'] . "', ";
				$s .= "'" . $verticalName . "', ";
				$s .= "'" . $subverticalName . "', ";
				$s .= "'" . $trialDefaults[0]["leadpop_version_id"] . "',  ";
				$s .= "'" . $placeholder_values ['placeholder_fiftyone'] . "', ";
				$s .= "'" . $placeholder_values ['placeholder_fiftytwo'] . "', ";
				$s .= "'" . $placeholder_values ['placeholder_fiftythree'] . "', ";
				$s .= "'" . $placeholder_values ['placeholder_fiftyfour'] . "', ";
				$s .= "'" . $placeholder_values ['placeholder_fiftyfive'] . "', ";
				$s .= "'" . $placeholder_values ['placeholder_fiftysix'] . "', ";
				$s .= "'" . $placeholder_values ['placeholder_fiftyseven'] . "', ";
				$s .= "'" . $placeholder_values ['placeholder_fiftyeight'] . "', ";
				$s .= "'" . $placeholder_values ['placeholder_fiftynine'] . "', ";
				$s .= "'" . $placeholder_values ['placeholder_sixty'] . "', ";
//				$s .= "'" . $placeholder_values ['placeholder_sixtyone'] . "', ";
				$s .= "'" . strtolower ( str_replace ( " ", "", $imgsrc ) ) . "', ";
				$s .= "'" . strtolower ( str_replace ( " ", "", $logosrc ) ) . "', ";
				$s .= "'" . $template_info ['csspath'] . "', ";
				$s .= "'" . $template_info ['imagepath'] . "', ";
				$s .= "'" . addslashes ( $submissionText ) . "', ";
				// $s .= "'" . addslashes ( $client ['company_name'] ) . "', ";
				$s .= "'', ";
				$client ['phone_number'] = str_replace(")-",") ",$client ['phone_number']);
				$tempPhone = "'Call Today! " . $client ['phone_number'] . "',";
				$s .= $tempPhone;
				$s .= "'" . $client ['contact_email'] . "', ";
				$lead_line = '<span style="font-family: arial; font-size: 12px; color: #000">test</span>';
				$s .= "'" . addslashes ( $lead_line ) . "', ";
				$second_line = '<span style="font-family: arial; font-size: 10px; color: #000">test</span>';
				$s .= "'" . addslashes ( $second_line ) . "', ";
				$s .= "'" . $placeholder_values ['placeholder_seventyone'] . "', ";
				$s .= "'" . $placeholder_values ['placeholder_seventytwo'] . "', ";
				$s .= "'" . addslashes ( $title_tag ) . "', ";
				$s .= "'" . $placeholder_values ['placeholder_seventyfour'] . "', ";
				$s .= "'" . $placeholder_values ['placeholder_seventyfive'] . "', ";
				$s .= "'" . $placeholder_values['placeholder_seventysix'] . "', ";
				$s .= "'" . $placeholder_values['placeholder_seventyseven'] . "', ";
				$s .= "'" . $placeholder_values ['placeholder_seventyeight'] . "', ";
				$s .= "'" . $placeholder_values['placeholder_seventynine'] . "', ";
				$s .= "'" . $placeholder_values['placeholder_eighty'] . "', ";
				$s .= "'" . $placeholder_values['placeholder_eightyone'] . "', ";
				$s .= "'" . $placeholder_values['placeholder_eightytwo'] . "', ";
				$s .= "'" . $placeholder_values['placeholder_eightythree'] . "' ";
				$s .= ")";
				$xzdb->query ($s);
			}


			$s = "select id from leadpops_templates_placeholders ";
			$s .= " where leadpop_template_id = " . $trialDefaults[0]['leadpop_template_id'];
			$s .= " and client_id = " . $client_id;
			$s .= " and leadpop_version_seq = " . $trialDefaults[0]["leadpop_version_seq"];

			$leadpops_templates_placeholders = $xzdb->fetchAll ( $s );

			for($xx = 0; $xx < count ( $leadpops_templates_placeholders ); $xx ++) {
				$s = "update leadpops_templates_placeholders_values  set placeholder_forty= '" . addslashes ( $submissionText ) . "' ";
				$s .= " where client_leadpop_id = " . $trialDefaults[0]["leadpop_id"];
				$s .= " and leadpop_template_placeholder_id = " . $leadpops_templates_placeholders [$xx] ['id'];
				$xzdb->query ( $s );
			}
			/*  set default submission options  ******************************************************************************** */
			/*  set default contact_options  ******************************************************************************** */

			for($xx = 0; $xx < count ( $leadpops_templates_placeholders ); $xx ++) {
				$s = "update leadpops_templates_placeholders_values  set placeholder_fortyone = '' , ";
				$s .= "placeholder_fortytwo = '', placeholder_fortythree = ''  where client_leadpop_id = " . $trialDefaults[0]["leadpop_id"];
				$s .= " and leadpop_template_placeholder_id = " . $leadpops_templates_placeholders [$xx] ['id'];
				$xzdb->query ( $s );
			}
			for($xx = 0; $xx < count ( $leadpops_templates_placeholders ); $xx ++) {
				$s = "update leadpops_templates_placeholders_values  set placeholder_fortyone = '" . addslashes ( $client["company_name"] ) . "'  ";
				$s .= "  where client_leadpop_id = " . $trialDefaults[0]["leadpop_id"];
				$s .= " and leadpop_template_placeholder_id = " . $leadpops_templates_placeholders [$xx] ['id'];
				$xzdb->query ( $s );
			}
			for($xx = 0; $xx < count ( $leadpops_templates_placeholders ); $xx ++) {
				$s = "update leadpops_templates_placeholders_values  set placeholder_fortytwo = '" . addslashes ( $client["phone_number"] ) . "'  ";
				$s .= "  where client_leadpop_id = " . $trialDefaults[0]["leadpop_id"];
				$s .= " and leadpop_template_placeholder_id = " . $leadpops_templates_placeholders [$xx] ['id'];
				$xzdb->query ( $s );
			}
			for($xx = 0; $xx < count ( $leadpops_templates_placeholders ); $xx ++) {
				$s = "update leadpops_templates_placeholders_values  set placeholder_fortythree = '" . addslashes ( $client["contact_email"] ) . "'  ";
				$s .= "  where client_leadpop_id = " . $trialDefaults[0]["leadpop_id"];
				$s .= " and leadpop_template_placeholder_id = " . $leadpops_templates_placeholders [$xx] ['id'];
				$xzdb->query ( $s );
			}

			/*  set default contact_options  ******************************************************************************** */
			/*  set default auto_responder options  ******************************************************************************** */

			for($xx = 0; $xx < count ( $leadpops_templates_placeholders ); $xx ++) {
				$s = "update leadpops_templates_placeholders_values  set placeholder_fortysix = '<p>Thank you for your submission.</p>' ";
				$s .= " where client_leadpop_id = " . $trialDefaults[0]["leadpop_id"];
				$s .= " and leadpop_template_placeholder_id = " . $leadpops_templates_placeholders [$xx] ['id'];
				$xzdb->query ( $s );
			}

			for($xx = 0; $xx < count ( $leadpops_templates_placeholders ); $xx ++) {
				$s = " update leadpops_templates_placeholders_values  set placeholder_thirtyseven = '" . $logosrc . "'  where client_leadpop_id = " . $trialDefaults[0]["leadpop_id"];
				$s .= " and leadpop_template_placeholder_id = " . $leadpops_templates_placeholders [$xx] ['id'];
				$xzdb->query ( $s );
			}

			for($xx = 0; $xx < count ( $leadpops_templates_placeholders ); $xx ++) {
			    $s = " update leadpops_templates_placeholders_values  set placeholder_sixtytwo = '".$logosrc."'  where client_leadpop_id = " . $trialDefaults[0]["leadpop_id"];
			    $s .= " and leadpop_template_placeholder_id = " . $leadpops_templates_placeholders[$xx]['id'];
			    $xzdb->query($s);
			}

			$dname = '/var/www/vhosts/itclix.com/images/clients/' . substr($client_id,0,1) . '/' . $client_id;
			if (!file_exists($dname)) {
				createCkfinderDirectories($client_id);
			}

			$s = "update add_client_funnels  set has_run = 'y' ";
            $xzdb->query($s);

}
/* end new enterprise function */
/* end new enterprise function */
/* end new enterprise function */


/* start existing enterprise */

function addExistingClientGenericEnterprise($vertical,$subvertical,$version,$client_id) {

    require_once '/var/www/vhosts/launch.leadpops.com/external/Image.php';
    require_once '/var/www/vhosts/launch.leadpops.com/external/Client.php';

	global $thissub_domain;
	global $thistop_domain;
	global$leadpoptype;
	global $db;
	global $xzdb;
	$logo_name_mobile = "home_refinance_mobile.png";
	$logo_name = "home_refinance.png";
	$image_name = "Refinance.png";
	$logo = ""; // a blank logo value indicate to use the default logo

	$s = "select * from clients where client_id = " . $client_id . " limit 1 ";
	$client = $xzdb->fetchRow($s);
//var_dump($client);
	/* check if email exists in system */
	$dt = date('Y-m-d H:i:s');
	$thedate = date ( 'Y-m-d H:i:s' );

		switch ($vertical) {
			case "3":
				$emmaAccount = '1758432';
				$emma_account_type = "mortgage";
				break;
			case "1":
				$emmaAccount =  '1760824';
				$emma_account_type = "insurance";
				break;
			case "5":
				$emmaAccount = '1758435';
				$emma_account_type = "realestate";
				break;
			 default :
				$emmaAccount = '999999';
		}

		$emma_account_name = $client["company_name"];
		/* values to insert into client_emma_cron to create accounts */

		/* create client leadpops */
        //  	funnel_type 	subvertical_name 	leadpop_vertical_id 	leadpop_vertical_sub_id 	leadpop_type_id 	leadpop_template_id 	leadpop_id 	leadpop_version_id 	leadpop_version_seq
        //	  lendingtree 	      lendingtree 	                  7 	                              33                               	1 	                       41                   	   82 	                    41                         	1
					$s = "select * from enterprise_funnels where leadpop_vertical_id = " . $vertical . " and leadpop_vertical_sub_id = " . $subvertical . " and leadpop_version_id = " . $version . " limit 1 ";
					$trialDefaults = $xzdb->fetchAll($s);

//					var_dump($trialDefaults);
//					die("pp");
					// *** since this client exists we need to get the version_seq and add one if it exists and not use the ont from the enterprise_funnels table;
					// ***  since this client exists we need to get the version_seq and add one if it exists and not use the ont from the enterprise_funnels table;

                    $s = "select max(leadpop_version_seq)  as version_id  from clients_leadpops where client_id = " . $client_id;
                    $s .= " and leadpop_version_id = " . $trialDefaults[0]["leadpop_version_id"];
                    $maxv =  $xzdb->fetchAll($s);

					if ($maxv[0]["version_id"] != "" ) { // curently has one so increment by one
					    $trialDefaults[0]["leadpop_version_seq"] = $maxv[0]["version_id"] + 1;
					}

					// ***  since this client exists we need to get the version_seq and add one if it exists and not use the ont from the enterprise_funnels table;
					// ***  since this client exists we need to get the version_seq and add one if it exists and not use the ont from the enterprise_funnels table;

					insertDefaultEnterpriseAutoResponders ($client_id,$trialDefaults[0], $client["contact_email"],$client["phone_number"],$xzdb);

					$s = "select * from leadpops_template_info where leadpop_vertical_id = " . $trialDefaults[0]["leadpop_vertical_id"];
					$s .= " and leadpop_vertical_sub_id = " . $trialDefaults[0]["leadpop_vertical_sub_id"] . " and leadpop_version_id = " . $trialDefaults[0]["leadpop_version_id"];
					$template_info = $xzdb->fetchRow($s);

	                $now = new DateTime();
					$s = "insert into clients_leadpops (id,client_id,leadpop_id,leadpop_version_id,leadpop_active,access_code,leadpop_version_seq,date_added) values (null,";
					$s .= $client_id . "," . $trialDefaults[0]["leadpop_id"] . "," . $trialDefaults[0]["leadpop_version_id"] . ",'1',''," . $trialDefaults[0]["leadpop_version_seq"] . ",'".$now->format("Y-m-d H:i:s")."')";
					$xzdb->query ( $s );

					$s = "insert into clients_leadpops_content (id,client_id,leadpop_id,leadpop_version_id,leadpop_active,access_code,leadpop_version_seq,";
					$s .= "section1,section2,section3,section4,section5,section6,section7,section8,section9,section10,template) values (null,";
					$s .= $client_id . "," . $trialDefaults[0]["leadpop_id"] . "," . $trialDefaults[0]["leadpop_version_id"] . ",'1',''," . $trialDefaults[0]["leadpop_version_seq"] . ",";
					$s .= "'<h4>section one</h4>','<h4>section two</h4>','<h4>section three</h4>','<h4>section four</h4>',";
					$s .= "'<h4>section five</h4>','<h4>section six</h4>','<h4>section seven</h4>','<h4>section eight</h4>','<h4>section nine</h4>',";
					$s .= "'<h4>section ten</h4>',1)";
					$xzdb->query($s);

					checkIfNeedMultipleStepInsert ( $trialDefaults[0]["leadpop_version_id"], $client_id );
					// look up domain name
//					$s = "select * from clients where client_id = " . $client_id . " limit 1 ";
//					$client = $xzdb->fetchRow($s);
					$subdomain = $client ['company_name'];
					$subdomain = preg_replace ( '/[^a-zA-Z]/', '', $subdomain );
					$s = "select domain from top_level_domains where primary_domain = 'y' limit 1 ";
					$topdomain = $xzdb->fetchOne ( $s );
					if ($leadpoptype == $thissub_domain) {
						$s = "select  count(*) from clients_subdomains where  ";
						$s .= " subdomain_name = '" . $subdomain . "' ";
						$s .= " and top_level_domain = '" . $topdomain . "' ";
						$foundsubdomain = $xzdb->fetchOne ( $s );
						if ($foundsubdomain > 0) {
							$s = "select domain from top_level_domains where primary_domain != 'y' ";
							$nonprimary = $xzdb->fetchAll ( $s );
							$foundone = false;
							while ( $foundone == false ) {
								for($k = 0; $k < count ( $nonprimary ); $k ++) {
									$s = "select  count(*) from clients_subdomains where  ";
									$s .= " subdomain_name = '" . $subdomain . "' ";
									$s .= " and top_level_domain = '" . $nonprimary [$k] ['domain'] . "' ";
									$foundsubdomain = $xzdb->fetchOne ( $s );
									if ($foundsubdomain == 0) {
										$s = "insert into clients_subdomains (id,client_id,subdomain_name,top_level_domain,leadpop_vertical_id,";
										$s .= "leadpop_vertical_sub_id,leadpop_type_id,leadpop_template_id,";
										$s .= "leadpop_id,leadpop_version_id,leadpop_version_seq ) values (null,";
										$s .= $client_id . ",'" . $subdomain . "','" . $nonprimary [$k] ['domain'] . "',";
										$s .= $trialDefaults[0]["leadpop_vertical_id"] . "," . $trialDefaults[0]["leadpop_vertical_sub_id"] . "," . $leadpoptype . "," . $trialDefaults[0]['leadpop_template_id'] . ",";
										$s .= $trialDefaults[0]["leadpop_id"] . "," . $trialDefaults[0]["leadpop_version_id"] . "," . $trialDefaults[0]["leadpop_version_seq"] . ")";
										$xzdb->query ( $s );
		/* emma insert */
		/* emma insert */
		/* emma insert */
		                                if ($emmaAccount != '999999') {
											$s = "insert into client_emma_cron (id,client_id,emma_default_group,account_type,domain_name,account_name,master_account_ids,has_run, leadpop_vertical_id,leadpop_subvertical_id) values (null,";
											$s .= $client_id . ",'". $trialDefaults[0]['emma_default_group'] ."','".$emma_account_type."','". strtolower($subdomain . "." . $nonprimary [$k] ['domain']) ."','". $emma_account_name ."','";
											$s .= addslashes($emmaAccount) . "','n',".$trialDefaults[0]["leadpop_vertical_id"].",".$trialDefaults[0]["leadpop_vertical_sub_id"].")";
											$xzdb->query ($s);
                                        }
		/* emma insert */
		/* emma insert */
		/* emma insert */
										$foundmobile = false;
										$randc = "";
										while ( $foundmobile == false ) {
											$s =  "select count(*) as cnt from mobileclients where mobiledomain = '".$subdomain . $randc .  ".itclixmobile.com'  ";
											$nummobile = $xzdb->fetchOne($s);
											if($nummobile == 0) {
												$foundmobile = true;
											}
											else {
												$randc = $randc . getRandomCharacter ();
											}
										}
											// set 	client_or_domain_logo_image to 'o' for no uploaded logo
											/* mobile domain and logo */
										$s = "INSERT INTO mobileclients (nonmobiledomain, mobiledomain, client_id, id, leadpop_id, ";
										$s .= "leadpop_vertical_id,leadpop_vertical_sub_id, leadpop_type_id, leadpop_template_id,";
										$s .= "leadpop_version_id, leadpop_version_seq, ";
										$s .= "iszillow, zillow_api, active, group_design, phone, company,	client_or_domain_logo_image) VALUES (";
										$s .= "'".$subdomain . "." . $nonprimary [$k] ['domain'] . "','" . $subdomain . $randc .".itclixmobile.com',";
										$s .= $client_id .",null,". $trialDefaults[0]["leadpop_id"] . "," . $trialDefaults[0]["leadpop_vertical_id"] . "," . $trialDefaults[0]["leadpop_vertical_sub_id"] . "," . $leadpoptype . "," .  $trialDefaults[0]['leadpop_template_id'];
										$s .= "," . $trialDefaults[0]["leadpop_version_id"] . "," . $trialDefaults[0]["leadpop_version_seq"] . ",'n','n','y','y','".preg_replace ('/[^0-9]/', '', $client ['phone_number'])."', '".addslashes($client ['company_name'])."','o') ";
										$xzdb->query ($s);

										$checkdomain = $subdomain . "." . $nonprimary [$k] ['domain'];
										$s = "insert into check_mobile (id,url,active,scope) values (null,";
										$s .= "'". $checkdomain ."','y', 'phone,tablet')";
										$xzdb->query ($s);

										$cmd = '/bin/cp  /var/www/vhosts/launch.leadpops.com/trial/classiclogos/' . $logo_name_mobile . '  /var/www/vhosts/itclixmobile.com/css/'.$trialDefaults[0]["subvertical_name"] . '/themes/images/' . $client_id . 'grouplogo.png';
										exec($cmd);

										$googleDomain = $subdomain . "." . $nonprimary [$k] ['domain'];
										insertPurchasedGoogle ( $client_id, $googleDomain );

										$s = "insert into  bottom_links (id,client_id,leadpop_id,leadpop_type_id,leadpop_vertical_id,";
										$s .= "leadpop_vertical_sub_id,leadpop_template_id,leadpop_version_id,";
										$s .= "leadpop_version_seq,privacy,terms,disclosures,licensing,about,contact,";
										$s .= "privacy_active,terms_active,disclosures_active,licensing_active,about_active,contact_active,";
										$s .= "privacy_type,terms_type,disclosures_type,licensing_type,about_type,contact_type,privacy_url,";
										$s .= "terms_url,disclosures_url,licensing_url,about_url,contact_url,privacy_text,";
										$s .= "terms_text,disclosures_text,licensing_text,about_text,contact_text,";
										$s .= "compliance_text,compliance_is_linked,compliance_link,compliance_active,";
										$s .= "license_number_active,license_number_is_linked,license_number_text,license_number_link";
										$s .= ") values (null,";
										$s .= $client_id . "," . $trialDefaults[0]["leadpop_id"] . "," . $leadpoptype . "," . $trialDefaults[0]["leadpop_vertical_id"] . "," . $trialDefaults[0]["leadpop_vertical_sub_id"] . ",";
										$s .= $trialDefaults[0]['leadpop_template_id'] . "," . $trialDefaults[0]["leadpop_version_id"] . "," . $trialDefaults[0]["leadpop_version_seq"];
										$s .= ",'','','','','','','n','n','n','n','n','y','m','m','m','m','m','m','','','','','','','','','','','','',";
										$s .= "'','','','',";
										$s .= "'','','',''";
										$s .= ") ";
										$xzdb->query ( $s );

										$s = "insert into contact_options (id,client_id,leadpop_id,";
										$s .= "leadpop_type_id,leadpop_vertical_id,leadpop_vertical_sub_id,";
										$s .= "leadpop_template_id,leadpop_version_id,leadpop_version_seq,";
										$s .= "companyname,phonenumber,email,companyname_active,";
										$s .= "phonenumber_active,email_active) values (null,";
										$s .= $client_id . "," . $trialDefaults[0]["leadpop_id"] . "," . $leadpoptype . "," . $trialDefaults[0]["leadpop_vertical_id"] . "," . $trialDefaults[0]["leadpop_vertical_sub_id"] . ",";
										$s .= $trialDefaults[0]['leadpop_template_id'] . "," . $trialDefaults[0]["leadpop_version_id"] . "," . $trialDefaults[0]["leadpop_version_seq"] . ",";
										$s .= "'" . addslashes ( $client ['company_name'] ) . "','" . $client ['phone_number'] . "','";
										$s .= $client ['contact_email'] . "','n','y','n')";
										$xzdb->query ( $s );

										$autotext = getAutoResponderText ( $trialDefaults[0]["leadpop_vertical_id"], $trialDefaults[0]["leadpop_vertical_sub_id"] , $trialDefaults[0]["leadpop_id"]);
										if ($autotext == "not found") {
											$thehtml =  "";
											$thesubject = "";
										}
										else {
											$thehtml =  $autotext[0]["html"];
											$thesubject = $autotext[0]["subject_line"];
										}

										$s = "insert into autoresponder_options (id,client_id,leadpop_id,";
										$s .= "leadpop_type_id,leadpop_vertical_id,leadpop_vertical_sub_id,";
										$s .= "leadpop_template_id,leadpop_version_id,leadpop_version_seq,";
										$s .= "html,thetext,html_active,text_active,subject_line ) values (null,";
										$s .= $client_id . "," . $trialDefaults[0]["leadpop_id"] . "," . $leadpoptype . "," . $trialDefaults[0]["leadpop_vertical_id"] . "," . $trialDefaults[0]["leadpop_vertical_sub_id"] . ",";
										$s .= $trialDefaults[0]['leadpop_template_id'] . "," . $trialDefaults[0]["leadpop_version_id"] . "," . $trialDefaults[0]["leadpop_version_seq"] . ",";
										$s .= "'" . addslashes ( $thehtml ) . "','','y','n','".addslashes($thesubject)."')";
										$xzdb->query ( $s );

								        $title_tag =  " FREE " . $trialDefaults[0]["display_name"] . " | " . addslashes ( ucwords($client['company_name']) );

										//FREE Home Purchase Qualifier | Sentinel Mortgage Company

										$s = "insert into seo_options (id,client_id,leadpop_id,";
										$s .= "leadpop_type_id,leadpop_vertical_id,leadpop_vertical_sub_id,";
										$s .= "leadpop_template_id,leadpop_version_id,leadpop_version_seq,";
										$s .= "titletag,description,metatags,titletag_active,";
										$s .= "description_active,metatags_active) values (null,";
										$s .= $client_id . "," . $trialDefaults[0]["leadpop_id"] . "," . $leadpoptype . "," . $trialDefaults[0]["leadpop_vertical_id"] . "," . $trialDefaults[0]["leadpop_vertical_sub_id"] . ",";
										$s .= $trialDefaults[0]['leadpop_template_id'] . "," . $trialDefaults[0]["leadpop_version_id"] . "," . $trialDefaults[0]["leadpop_version_seq"] . ",";
										$s .= "'" . addslashes ( $title_tag ) . "','','','y','n','n') ";
										$xzdb->query ( $s );

										$s = "select * from leadpops_verticals where id = " . $trialDefaults[0]["leadpop_vertical_id"];
										$vertres = $xzdb->fetchRow ( $s );
										$verticalName = $vertres ['lead_pop_vertical'];
               //  	funnel_type 	subvertical_name 	leadpop_vertical_id 	leadpop_vertical_sub_id 	leadpop_type_id 	leadpop_template_id 	leadpop_id 	leadpop_version_id 	leadpop_version_seq

										if (isset ($trialDefaults[0]["leadpop_vertical_sub_id"] ) && $trialDefaults[0]["leadpop_vertical_sub_id"] != "") {
											$s = "select * from leadpops_verticals_sub where leadpop_vertical_id  = " . $trialDefaults[0]["leadpop_vertical_id"];
											$s .= " and id = " . $trialDefaults[0]["leadpop_vertical_sub_id"];
											$subvertres = $xzdb->fetchRow ( $s );
											$subverticalName = $subvertres ['lead_pop_vertical_sub'];
										} else {
											$subverticalName = "";
										}

										$logosrc = "";
										$imgsrc = "";
										$uploadedLogo = $logo;
										if ($subverticalName == "") {
											$logosrc = getHttpServer () . '/images/' . strtolower(str_replace(" ","",$verticalName)) . '/' . $logo_name;
										} else {
											$logosrc = getHttpServer () . '/images/' . strtolower(str_replace(" ","",$verticalName)) . '/' . strtolower(str_replace(" ","",$subverticalName)). '_logos/' .$logo_name;
										}
										insertDefaultClientUploadLogo($logosrc,$trialDefaults[0],$client_id);

										$imgsrc = insertClientDefaultEnterpriseImage($trialDefaults[0],$image_name,$client_id);

										$nine = "999999";
										$submissionText = getSubmissionText($trialDefaults[0]["leadpop_id"],$trialDefaults[0]["leadpop_vertical_id"],$trialDefaults[0]["leadpop_vertical_sub_id"],$nine);
										$submissionText = str_replace("##clientlogo##",$logosrc,$submissionText);
										$submissionText = str_replace("##clientphonenumber##",$client["phone_number"],$submissionText);

										$s = "insert into submission_options (id,client_id,leadpop_id,leadpop_type_id,";
										$s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,";
										$s .= "leadpop_version_id,leadpop_version_seq,thankyou,information,";
										$s .= "thirdparty,thankyou_active,information_active,thirdparty_active) values (null,";
										$s .= $client_id . "," . $trialDefaults[0]["leadpop_id"] . "," . $leadpoptype . "," . $trialDefaults[0]["leadpop_vertical_id"] . "," . $trialDefaults[0]["leadpop_vertical_sub_id"] . ",";
										$s .= $trialDefaults[0]['leadpop_template_id'] . "," . $trialDefaults[0]["leadpop_version_id"] . "," . $trialDefaults[0]["leadpop_version_seq"] . ",";
										$s .= "'" . addslashes ( $submissionText ) . "','','','y','n','n')";
										$xzdb->query ( $s );

										$foundone = true;
										break 2;
									}
								}
								$subdomain = $subdomain . getRandomCharacter ();
							}
						} else {

							$s = "insert into clients_subdomains (id,client_id,subdomain_name,top_level_domain,leadpop_vertical_id,";
							$s .= "leadpop_vertical_sub_id,leadpop_type_id,leadpop_template_id,";
							$s .= "leadpop_id,leadpop_version_id,leadpop_version_seq ) values (null,";
							$s .= $client_id . ",'" . $subdomain . "','" . $topdomain . "',";
							$s .= $trialDefaults[0]["leadpop_vertical_id"] . "," . $trialDefaults[0]["leadpop_vertical_sub_id"] . "," . $leadpoptype . "," . $trialDefaults[0]['leadpop_template_id'] . ",";
							$s .= $trialDefaults[0]["leadpop_id"] . "," . $trialDefaults[0]["leadpop_version_id"] . "," . $trialDefaults[0]["leadpop_version_seq"] . ")";
							$xzdb->query ( $s );

		/* emma insert */
		/* emma insert */
		/* emma insert */
							if ($emmaAccount != '999999') {
								$s = "insert into client_emma_cron (id,client_id,emma_default_group,account_type,domain_name,account_name,master_account_ids,has_run,leadpop_vertical_id,leadpop_subvertical_id) values (null,";
								$s .= $client_id . ",'". $trialDefaults[0]['emma_default_group'] ."','".$emma_account_type."','". strtolower($subdomain . "." . $topdomain) ."','". $emma_account_name ."','";
								$s .= addslashes($emmaAccount) . "','n',".$trialDefaults[0]["leadpop_vertical_id"].",".$trialDefaults[0]["leadpop_vertical_sub_id"].")";
								$xzdb->query ($s);
							}
		/* emma insert */
		/* emma insert */
		/* emma insert */

							$foundmobile = false;
							$randc = "";
							while ( $foundmobile == false ) {
								$s =  "select count(*) as cnt from mobileclients where mobiledomain = '".$subdomain . $randc .  ".itclixmobile.com'  ";
								$nummobile = $xzdb->fetchOne($s);
								if($nummobile == 0) {
									$foundmobile = true;
								}
								else {
									$randc = $randc . getRandomCharacter ();
								}
							}

							$s = "INSERT INTO mobileclients (nonmobiledomain, mobiledomain, client_id, id, leadpop_id, ";
							$s .= "leadpop_vertical_id,leadpop_vertical_sub_id, leadpop_type_id, leadpop_template_id,";
							$s .= "leadpop_version_id, leadpop_version_seq, ";
							$s .= "iszillow, zillow_api, active, group_design, phone, company) VALUES (";
							$s .= "'".$subdomain . "." . $topdomain . "','".$subdomain . $randc . ".itclixmobile.com',";
							$s .= $client_id  .",null,". $trialDefaults[0]["leadpop_id"] . "," . $trialDefaults[0]["leadpop_vertical_id"] . "," . $trialDefaults[0]["leadpop_vertical_sub_id"] . "," . $leadpoptype . "," .  $trialDefaults[0]['leadpop_template_id'];
							$s .= "," . $trialDefaults[0]["leadpop_version_id"] . "," . $trialDefaults[0]["leadpop_version_seq"] . ",'n','n','y','y','".preg_replace ('/[^0-9]/', '', $client ['phone_number'])."', '".addslashes($client ['company_name'])."') ";
							$xzdb->query ($s);

							$checkdomain = $subdomain . "." . $topdomain;
							$s = "insert into check_mobile (id,url,active,scope) values (null,";
							$s .= "'". $checkdomain ."','y', 'phone,tablet')";
							$xzdb->query ($s);

							$cmd = '/bin/cp  /var/www/vhosts/launch.leadpops.com/trial/classiclogos/' . $logo_name_mobile . '  /var/www/vhosts/itclixmobile.com/css/'.$trialDefaults[0]["subvertical_name"] . '/themes/images/' . $client_id . 'grouplogo.png';
							exec($cmd);

							$googleDomain = $subdomain . "." . $topdomain;
							insertPurchasedGoogle ( $client_id, $googleDomain );

							$s = "insert into  bottom_links (id,client_id,leadpop_id,leadpop_type_id,leadpop_vertical_id,";
							$s .= "leadpop_vertical_sub_id,leadpop_template_id,leadpop_version_id,";
							$s .= "leadpop_version_seq,privacy,terms,disclosures,licensing,about,contact,";
							$s .= "privacy_active,terms_active,disclosures_active,licensing_active,about_active,contact_active,";
							$s .= "privacy_type,terms_type,disclosures_type,licensing_type,about_type,contact_type,privacy_url,";
							$s .= "terms_url,disclosures_url,licensing_url,about_url,contact_url,privacy_text,";
							$s .= "terms_text,disclosures_text,licensing_text,about_text,contact_text,";
							$s .= "compliance_text,compliance_is_linked,compliance_link,compliance_active,";
							$s .= "license_number_active,license_number_is_linked,license_number_text,license_number_link";
							$s .= ") values (null,";
							$s .= $client_id . "," . $trialDefaults[0]["leadpop_id"] . "," . $leadpoptype . "," . $trialDefaults[0]["leadpop_vertical_id"] . "," . $trialDefaults[0]["leadpop_vertical_sub_id"] . ",";
							$s .= $trialDefaults[0]['leadpop_template_id'] . "," . $trialDefaults[0]["leadpop_version_id"] . "," . $trialDefaults[0]["leadpop_version_seq"];
							$s .= ",'','','','','','','n','n','n','n','n','y','m','m','m','m','m','m','','','','','','','','','','','','',";
							$s .= "'','','','',";
							$s .= "'','','',''";
							$s .= ") ";
							$xzdb->query ( $s );

							$s = "insert into contact_options (id,client_id,leadpop_id,";
							$s .= "leadpop_type_id,leadpop_vertical_id,leadpop_vertical_sub_id,";
							$s .= "leadpop_template_id,leadpop_version_id,leadpop_version_seq,";
							$s .= "companyname,phonenumber,email,companyname_active,";
							$s .= "phonenumber_active,email_active) values (null,";
							$s .= $client_id . "," . $trialDefaults[0]["leadpop_id"] . "," . $leadpoptype . "," . $trialDefaults[0]["leadpop_vertical_id"] . "," . $trialDefaults[0]["leadpop_vertical_sub_id"] . ",";
							$s .= $trialDefaults[0]['leadpop_template_id'] . "," . $trialDefaults[0]["leadpop_version_id"] . "," . $trialDefaults[0]["leadpop_version_seq"] . ",";
							$s .= "'" . addslashes ( $client ['company_name'] ) . "','Call Today! " . $client ['phone_number'] . "','";
							$s .= $client ['contact_email'] . "','n','y','n')";
							$xzdb->query ( $s );

							$autotext = getAutoResponderText ( $trialDefaults[0]["leadpop_vertical_id"], $trialDefaults[0]["leadpop_vertical_sub_id"] , $trialDefaults[0]["leadpop_id"]);
							if ($autotext == "not found") {
								$thehtml =  "";
								$thesubject = "";
							}
							else {
								$thehtml =  $autotext[0]["html"];
								$thesubject = $autotext[0]["subject_line"];
							}

							$s = "insert into autoresponder_options (id,client_id,leadpop_id,";
							$s .= "leadpop_type_id,leadpop_vertical_id,leadpop_vertical_sub_id,";
							$s .= "leadpop_template_id,leadpop_version_id,leadpop_version_seq,";
							$s .= "html,thetext,html_active,text_active,subject_line ) values (null,";
							$s .= $client_id . "," . $trialDefaults[0]["leadpop_id"] . "," . $leadpoptype . "," . $trialDefaults[0]["leadpop_vertical_id"] . "," . $trialDefaults[0]["leadpop_vertical_sub_id"] . ",";
							$s .= $trialDefaults[0]['leadpop_template_id'] . "," . $trialDefaults[0]["leadpop_version_id"] . "," . $trialDefaults[0]["leadpop_version_seq"] . ",";
							$s .= "'" . addslashes ( $thehtml ) . "','','y','n','".addslashes($thesubject)."')";
							$xzdb->query ($s);

							try {
								$xzdb->query ($s);
							}
							catch ( PDOException $e) {
								print ("Error!: " . $e->getMessage() . "<br/>") ;
								print($s);
								die();
							}

					       $title_tag =  " FREE " . $trialDefaults[0]["display_name"] . " | " . addslashes ( ucwords($client ['company_name']) );

							//FREE Home Purchase Qualifier | Sentinel Mortgage Company

							$s = "insert into seo_options (id,client_id,leadpop_id,";
							$s .= "leadpop_type_id,leadpop_vertical_id,leadpop_vertical_sub_id,";
							$s .= "leadpop_template_id,leadpop_version_id,leadpop_version_seq,";
							$s .= "titletag,description,metatags,titletag_active,";
							$s .= "description_active,metatags_active) values (null,";
							$s .= $client_id . "," . $trialDefaults[0]["leadpop_id"] . "," . $leadpoptype . "," . $trialDefaults[0]["leadpop_vertical_id"] . "," . $trialDefaults[0]["leadpop_vertical_sub_id"] . ",";
							$s .= $trialDefaults[0]['leadpop_template_id'] . "," . $trialDefaults[0]["leadpop_version_id"] . "," . $trialDefaults[0]["leadpop_version_seq"] . ",";
							$s .= "'" . addslashes ( $title_tag ) . "','','','y','n','n') ";
							$xzdb->query ( $s );

							$s = "select * from leadpops_verticals where id = " . $trialDefaults[0]["leadpop_vertical_id"];
							$vertres = $xzdb->fetchRow ( $s );
							$verticalName = $vertres ['lead_pop_vertical'];

							if (isset ($trialDefaults[0]["leadpop_vertical_sub_id"] ) && $trialDefaults[0]["leadpop_vertical_sub_id"] != "") {
								$s = "select * from leadpops_verticals_sub where leadpop_vertical_id  = " . $trialDefaults[0]["leadpop_vertical_id"];
								$s .= " and id = " . $trialDefaults[0]["leadpop_vertical_sub_id"];
								$subvertres = $xzdb->fetchRow ( $s );
								$subverticalName = $subvertres ['lead_pop_vertical_sub'];
							} else {
								$subverticalName = "";
							}

							$logosrc = "";
							$imgsrc = "";
							$uploadedLogo = $logo;

							if ($subverticalName == "") {
								$logosrc = getHttpServer () . '/images/' . strtolower(str_replace(" ","",$verticalName)) . '/' . $logo_name;
							} else {
								$logosrc = getHttpServer () . '/images/' . strtolower(str_replace(" ","",$verticalName)) . '/' . strtolower(str_replace(" ","",$subverticalName)). '_logos/' . $logo_name;
							}
							insertDefaultClientUploadLogo($logosrc,$trialDefaults[0],$client_id);
							$imgsrc = insertClientDefaultEnterpriseImage($trialDefaults[0],$image_name,$client_id);

							$nine = "999999";
							$submissionText = getSubmissionText($trialDefaults[0]["leadpop_id"],$trialDefaults[0]["leadpop_vertical_id"],$trialDefaults[0]["leadpop_vertical_sub_id"],$nine);
							$submissionText = str_replace("##clientlogo##",$logosrc,$submissionText);
							$submissionText = str_replace("##clientphonenumber##",$client["phone_number"],$submissionText);

							$s = "insert into submission_options (id,client_id,leadpop_id,leadpop_type_id,";
							$s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,";
							$s .= "leadpop_version_id,leadpop_version_seq,thankyou,information,";
							$s .= "thirdparty,thankyou_active,information_active,thirdparty_active) values (null,";
							$s .= $client_id . "," . $trialDefaults[0]["leadpop_id"] . "," . $leadpoptype . "," . $trialDefaults[0]["leadpop_vertical_id"] . "," . $trialDefaults[0]["leadpop_vertical_sub_id"] . ",";
							$s .= $trialDefaults[0]['leadpop_template_id'] . "," . $trialDefaults[0]["leadpop_version_id"] . "," . $trialDefaults[0]["leadpop_version_seq"] . ",";
							$s .= "'" . addslashes ( $submissionText ) . "','','','y','n','n')";
							$xzdb->query ( $s );

						}
					}

			$s = "select * from leadpops_templates_placeholders_info where leadpop_template_id = " . $trialDefaults[0]['leadpop_template_id'] . " order by step ";
			$placeholder_info = $xzdb->fetchAll ( $s );
			for($j = 0; $j < count ( $placeholder_info ); $j ++) {
				$s = "insert into leadpops_templates_placeholders (id,";
				$s .= "leadpop_template_id,step,client_id,leadpop_version_seq,";
				$s .= "placeholder_one,";
				$s .= "placeholder_two,";
				$s .= "placeholder_three,";
				$s .= "placeholder_four,";
				$s .= "placeholder_five,";
				$s .= "placeholder_six,";
				$s .= "placeholder_seven,";
				$s .= "placeholder_eight,";
				$s .= "placeholder_nine,";
				$s .= "placeholder_ten,";
				$s .= "placeholder_eleven,";
				$s .= "placeholder_twelve,";
				$s .= "placeholder_thirteen,";
				$s .= "placeholder_fourteen,";
				$s .= "placeholder_fifteen,";
				$s .= "placeholder_sixteen,";
				$s .= "placeholder_seventeen,";
				$s .= "placeholder_eighteen,";
				$s .= "placeholder_nineteen,";
				$s .= "placeholder_twenty,";
				$s .= "placeholder_twentyone,";
				$s .= "placeholder_twentytwo,";
				$s .= "placeholder_twentythree,";
				$s .= "placeholder_twentyfour,";
				$s .= "placeholder_twentyfive,";
				$s .= "placeholder_twentysix,";
				$s .= "placeholder_twentyseven,";
				$s .= "placeholder_twentyeight,";
				$s .= "placeholder_twentynine,";
				$s .= "placeholder_thirty,";
				$s .= "placeholder_thirtyone,";
				$s .= "placeholder_thirtytwo,";
				$s .= "placeholder_thirtythree,";
				$s .= "placeholder_thirtyfour,";
				$s .= "placeholder_thirtyfive,";
				$s .= "placeholder_thirtysix,";
				$s .= "placeholder_thirtyseven,";
				$s .= "placeholder_thirtyeight,";
				$s .= "placeholder_thirtynine,";
				$s .= "placeholder_forty,";
				$s .= "placeholder_fortyone,";
				$s .= "placeholder_fortytwo,";
				$s .= "placeholder_fortythree,";
				$s .= "placeholder_fortyfour,";
				$s .= "placeholder_fortyfive,";
				$s .= "placeholder_fortysix,";
				$s .= "placeholder_fortyseven,";
				$s .= "placeholder_fortyeight,";
				$s .= "placeholder_fortynine,";
				$s .= "placeholder_fifty,";
				$s .= "placeholder_fiftyone,";
				$s .= "placeholder_fiftytwo,";
				$s .= "placeholder_fiftythree,";
				$s .= "placeholder_fiftyfour,";
				$s .= "placeholder_fiftyfive,";
				$s .= "placeholder_fiftysix,";
				$s .= "placeholder_fiftyseven,";
				$s .= "placeholder_fiftyeight,";
				$s .= "placeholder_fiftynine,";
				$s .= "placeholder_sixty,";
				$s .= "placeholder_sixtyone,";
				$s .= "placeholder_sixtytwo,";
				$s .= "placeholder_sixtythree,";
				$s .= "placeholder_sixtyfour,";
				$s .= "placeholder_sixtyfive,";
				$s .= "placeholder_sixtysix,";
				$s .= "placeholder_sixtyseven,";
				$s .= "placeholder_sixtyeight,";
				$s .= "placeholder_sixtynine,";
				$s .= "placeholder_seventy,";
				$s .= "placeholder_seventyone,";
				$s .= "placeholder_seventytwo,";
				$s .= "placeholder_seventythree,";
				$s .= "placeholder_seventyfour,";
				$s .= "placeholder_seventyfive,";
				$s .= "placeholder_seventysix,";
				$s .= "placeholder_seventyseven,";
				$s .= "placeholder_seventyeight,";
				$s .= "placeholder_seventynine,";
				$s .= "placeholder_eighty,";
				$s .= "placeholder_eightyone,";
				$s .= "placeholder_eightytwo,";
				$s .= "placeholder_eightythree";
				$s .= "    ) values (null," . $trialDefaults[0]['leadpop_template_id'] . ",";
				$s .= $placeholder_info [$j] ['step'] . "," . $client_id . "," . $trialDefaults[0]["leadpop_version_seq"] . ",";
				$s .= "'" . $placeholder_info [$j] ['placeholder_one'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_two'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_three'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_four'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_five'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_six'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_seven'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_eight'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_nine'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_ten'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_eleven'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_twelve'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_thirteen'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fourteen'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fifteen'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_sixteen'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_seventeen'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_eighteen'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_nineteen'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_twenty'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_twentyone'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_twentytwo'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_twentythree'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_twentyfour'] . "',";
				$s .= "'" . $placeholder_info [$j] ['placeholder_twentyfive'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_twentysix'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_twentyseven'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_twentyeight'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_twentynine'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_thirty'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_thirtyone'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_thirtytwo'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_thirtythree'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_thirtyfour'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_thirtyfive'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_thirtysix'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_thirtyseven'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_thirtyeight'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_thirtynine'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_forty'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fortyone'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fortytwo'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fortythree'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fortyfour'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fortyfive'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fortysix'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fortyseven'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fortyeight'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fortynine'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fifty'] . "', ";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fiftyone'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fiftytwo'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fiftythree'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fiftyfour'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fiftyfive'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fiftysix'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fiftyseven'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fiftyeight'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_fiftynine'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_sixty'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_sixtyone'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_sixtytwo'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_sixtythree'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_sixtyfour'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_sixtyfive'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_sixtysix'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_sixtyseven'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_sixtyeight'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_sixtynine'] . "' ,";
				$s .= "'" . addslashes ( $placeholder_info [$j] ['placeholder_seventy'] ) . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_seventyone'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_seventytwo'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_seventythree'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_seventyfour'] . "' ,";
				$s .= "'" . $placeholder_info [$j] ['placeholder_seventyfive'] . "', ";
				$s .= "'" . $placeholder_info [$j] ['placeholder_seventysix'] . "', ";
				$s .= "'" . $placeholder_info [$j] ['placeholder_seventyseven'] . "', ";
				$s .= "'" . $placeholder_info [$j] ['placeholder_seventyeight'] . "', ";
				$s .= "'" . $placeholder_info [$j] ['placeholder_seventynine'] . "', ";
				$s .= "'" . $placeholder_info [$j] ['placeholder_eighty'] . "', ";
				$s .= "'" . $placeholder_info [$j] ['placeholder_eightyone'] . "', ";
				$s .= "'" . $placeholder_info [$j] ['placeholder_eightytwo'] . "', ";
				$s .= "'" . $placeholder_info [$j] ['placeholder_eightythree'] . "' ";
				$s .= " )";
				$xzdb->query ( $s );
				$placeholder_id = $xzdb->lastInsertId ();

				$s = "select * from leadpops_templates_placeholders_values_info where ";
				$s .= " leadpop_template_id = " . $placeholder_info [$j] ['leadpop_template_id'];
				$s .= " and step = " . $placeholder_info [$j] ['step'];
				$s .= " and placeholder_fortyseven = '".$placeholder_info[$j]['placeholder_fortyseven']."' ";
				$placeholder_values = $xzdb->fetchRow ( $s );

				$s = "insert into leadpops_templates_placeholders_values (id,client_leadpop_id,";
				$s .= "  leadpop_template_placeholder_id,";
				$s .= "  placeholder_one,";
				$s .= "  placeholder_two,";
				$s .= "  placeholder_three,";
				$s .= "  placeholder_four,";
				$s .= "  placeholder_five,";
				$s .= "  placeholder_six,";
				$s .= "  placeholder_seven,";
				$s .= "  placeholder_eight,";
				$s .= "  placeholder_nine,";
				$s .= "  placeholder_ten,";
				$s .= "  placeholder_eleven,";
				$s .= "  placeholder_twelve,";
				$s .= "  placeholder_thirteen,";
				$s .= "  placeholder_fourteen,";
				$s .= "  placeholder_fifteen,";
				$s .= "  placeholder_sixteen,";
				$s .= "  placeholder_seventeen,";
				$s .= "  placeholder_eighteen,";
				$s .= "  placeholder_nineteen,";
				$s .= "  placeholder_twenty,";
				$s .= "  placeholder_twentyone,";
				$s .= "  placeholder_twentytwo,";
				$s .= "  placeholder_twentythree,";
				$s .= "  placeholder_twentyfour,";
				$s .= "  placeholder_twentyfive,";
				$s .= "  placeholder_twentysix,";
				$s .= "  placeholder_twentyseven,";
				$s .= "  placeholder_twentyeight,";
				$s .= "  placeholder_twentynine,";
				$s .= "  placeholder_thirty,";
				$s .= "  placeholder_thirtyone,";
				$s .= "  placeholder_thirtytwo,";
				$s .= "  placeholder_thirtythree,";
				$s .= "  placeholder_thirtyfour,";
				$s .= "  placeholder_thirtyfive,";
				$s .= "  placeholder_thirtysix,";
				$s .= "  placeholder_thirtyseven,";
				$s .= "  placeholder_thirtyeight,";
				$s .= "  placeholder_thirtynine,";
				$s .= "  placeholder_forty,";
				$s .= "  placeholder_fortyone,";
				$s .= "  placeholder_fortytwo,";
				$s .= "  placeholder_fortythree,";
				$s .= "  placeholder_fortyfour,";
				$s .= "  placeholder_fortyfive,";
				$s .= "  placeholder_fortysix,";
				$s .= "  placeholder_fortyseven,";
				$s .= "  placeholder_fortyeight,";
				$s .= "  placeholder_fortynine,";
				$s .= "  placeholder_fifty, ";
				$s .= "placeholder_fiftyone,";
				$s .= "placeholder_fiftytwo,";
				$s .= "placeholder_fiftythree,";
				$s .= "placeholder_fiftyfour,";
				$s .= "placeholder_fiftyfive,";
				$s .= "placeholder_fiftysix,";
				$s .= "placeholder_fiftyseven,";
				$s .= "placeholder_fiftyeight,";
				$s .= "placeholder_fiftynine,";
				$s .= "placeholder_sixty,";
				$s .= "placeholder_sixtyone,";
				$s .= "placeholder_sixtytwo,";
				$s .= "placeholder_sixtythree,";
				$s .= "placeholder_sixtyfour,";
				$s .= "placeholder_sixtyfive,";
				$s .= "placeholder_sixtysix,";
				$s .= "placeholder_sixtyseven,";
				$s .= "placeholder_sixtyeight,";
				$s .= "placeholder_sixtynine,";
				$s .= "placeholder_seventy,";
				$s .= "placeholder_seventyone,";
				$s .= "placeholder_seventytwo,";
				$s .= "placeholder_seventythree,";
				$s .= "placeholder_seventyfour,";
				$s .= "placeholder_seventyfive,";
				$s .= "placeholder_seventysix,";
				$s .= "placeholder_seventyseven,";
				$s .= "placeholder_seventyeight,";
				$s .= "placeholder_seventynine,";
				$s .= "placeholder_eighty,";
				$s .= "placeholder_eightyone,";
				$s .= "placeholder_eightytwo,";
				$s .= "placeholder_eightythree";
				$s .= ") values (null," . $trialDefaults[0]["leadpop_id"] . ",";
				$s .= $placeholder_id . ",";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_one'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_two'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_three'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_four'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_five'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_six'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_seven'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_eight'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_nine'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_ten'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_eleven'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_twelve'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_thirteen'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_fourteen'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_fifteen'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_sixteen'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_seventeen'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_eighteen'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_nineteen'] ) . "',";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_twenty'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_twentyone'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_twentytwo'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_twentythree'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_twentyfour'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_twentyfive'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_twentysix'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_twentyseven'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_twentyeight'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_twentynine'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_thirty'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_thirtyone'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_thirtytwo'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_thirtythree'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_thirtyfour'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_thirtyfive'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_thirtysix'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_thirtyseven'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_thirtyeight'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_thirtynine'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_forty'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_fortyone'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_fortytwo'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_fortythree'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_fortyfour'] ) . "', ";
				$s .= "'" . addslashes ( $placeholder_values ['placeholder_fortyfive'] ) . "', ";
				$s .= "'" . $placeholder_values ['placeholder_fortysix'] . "', ";
				$s .= "'" . $placeholder_values ['placeholder_fortyseven'] . "', ";
				$s .= "'" . $verticalName . "', ";
				$s .= "'" . $subverticalName . "', ";
				$s .= "'" . $trialDefaults[0]["leadpop_version_id"] . "',  ";
				$s .= "'" . $placeholder_values ['placeholder_fiftyone'] . "', ";
				$s .= "'" . $placeholder_values ['placeholder_fiftytwo'] . "', ";
				$s .= "'" . $placeholder_values ['placeholder_fiftythree'] . "', ";
				$s .= "'" . $placeholder_values ['placeholder_fiftyfour'] . "', ";
				$s .= "'" . $placeholder_values ['placeholder_fiftyfive'] . "', ";
				$s .= "'" . $placeholder_values ['placeholder_fiftysix'] . "', ";
				$s .= "'" . $placeholder_values ['placeholder_fiftyseven'] . "', ";
				$s .= "'" . $placeholder_values ['placeholder_fiftyeight'] . "', ";
				$s .= "'" . $placeholder_values ['placeholder_fiftynine'] . "', ";
				$s .= "'" . $placeholder_values ['placeholder_sixty'] . "', ";
//				$s .= "'" . $placeholder_values ['placeholder_sixtyone'] . "', ";
				$s .= "'" . strtolower ( str_replace ( " ", "", $imgsrc ) ) . "', ";
				$s .= "'" . strtolower ( str_replace ( " ", "", $logosrc ) ) . "', ";
				$s .= "'" . $template_info ['csspath'] . "', ";
				$s .= "'" . $template_info ['imagepath'] . "', ";
				$s .= "'" . addslashes ( $submissionText ) . "', ";
				// $s .= "'" . addslashes ( $client ['company_name'] ) . "', ";
				$s .= "'', ";
				$client ['phone_number'] = str_replace(")-",") ",$client ['phone_number']);
				$tempPhone = "'Call Today! " . $client ['phone_number'] . "',";
				$s .= $tempPhone;
				$s .= "'" . $client ['contact_email'] . "', ";
				$lead_line = '<span style="font-family: arial; font-size: 12px; color: #000">test</span>';
				$s .= "'" . addslashes ( $lead_line ) . "', ";
				$second_line = '<span style="font-family: arial; font-size: 10px; color: #000">test</span>';
				$s .= "'" . addslashes ( $second_line ) . "', ";
				$s .= "'" . $placeholder_values ['placeholder_seventyone'] . "', ";
				$s .= "'" . $placeholder_values ['placeholder_seventytwo'] . "', ";
				$s .= "'" . addslashes ( $title_tag ) . "', ";
				$s .= "'" . $placeholder_values ['placeholder_seventyfour'] . "', ";
				$s .= "'" . $placeholder_values ['placeholder_seventyfive'] . "', ";
				$s .= "'" . $placeholder_values['placeholder_seventysix'] . "', ";
				$s .= "'" . $placeholder_values['placeholder_seventyseven'] . "', ";
				$s .= "'" . $placeholder_values ['placeholder_seventyeight'] . "', ";
				$s .= "'" . $placeholder_values['placeholder_seventynine'] . "', ";
				$s .= "'" . $placeholder_values['placeholder_eighty'] . "', ";
				$s .= "'" . $placeholder_values['placeholder_eightyone'] . "', ";
				$s .= "'" . $placeholder_values['placeholder_eightytwo'] . "', ";
				$s .= "'" . $placeholder_values['placeholder_eightythree'] . "' ";
				$s .= ")";
				$xzdb->query ($s);
			}

			$s = "select id from leadpops_templates_placeholders ";
			$s .= " where leadpop_template_id = " . $trialDefaults[0]['leadpop_template_id'];
			$s .= " and client_id = " . $client_id;
			$s .= " and leadpop_version_seq = " . $trialDefaults[0]["leadpop_version_seq"];

			$leadpops_templates_placeholders = $xzdb->fetchAll ( $s );

			for($xx = 0; $xx < count ( $leadpops_templates_placeholders ); $xx ++) {
				$s = "update leadpops_templates_placeholders_values  set placeholder_forty= '" . addslashes ( $submissionText ) . "' ";
				$s .= " where client_leadpop_id = " . $trialDefaults[0]["leadpop_id"];
				$s .= " and leadpop_template_placeholder_id = " . $leadpops_templates_placeholders [$xx] ['id'];
				$xzdb->query ( $s );
			}
			/*  set default submission options  ******************************************************************************** */
			/*  set default contact_options  ******************************************************************************** */

			for($xx = 0; $xx < count ( $leadpops_templates_placeholders ); $xx ++) {
				$s = "update leadpops_templates_placeholders_values  set placeholder_fortyone = '' , ";
				$s .= "placeholder_fortytwo = '', placeholder_fortythree = ''  where client_leadpop_id = " . $trialDefaults[0]["leadpop_id"];
				$s .= " and leadpop_template_placeholder_id = " . $leadpops_templates_placeholders [$xx] ['id'];
				$xzdb->query ( $s );
			}
			for($xx = 0; $xx < count ( $leadpops_templates_placeholders ); $xx ++) {
				$s = "update leadpops_templates_placeholders_values  set placeholder_fortyone = '" . addslashes ( $client["company_name"] ) . "'  ";
				$s .= "  where client_leadpop_id = " . $trialDefaults[0]["leadpop_id"];
				$s .= " and leadpop_template_placeholder_id = " . $leadpops_templates_placeholders [$xx] ['id'];
				$xzdb->query ( $s );
			}
			for($xx = 0; $xx < count ( $leadpops_templates_placeholders ); $xx ++) {
				$s = "update leadpops_templates_placeholders_values  set placeholder_fortytwo = '" . addslashes ( $client["phone_number"] ) . "'  ";
				$s .= "  where client_leadpop_id = " . $trialDefaults[0]["leadpop_id"];
				$s .= " and leadpop_template_placeholder_id = " . $leadpops_templates_placeholders [$xx] ['id'];
				$xzdb->query ( $s );
			}
			for($xx = 0; $xx < count ( $leadpops_templates_placeholders ); $xx ++) {
				$s = "update leadpops_templates_placeholders_values  set placeholder_fortythree = '" . addslashes ( $client["contact_email"] ) . "'  ";
				$s .= "  where client_leadpop_id = " . $trialDefaults[0]["leadpop_id"];
				$s .= " and leadpop_template_placeholder_id = " . $leadpops_templates_placeholders [$xx] ['id'];
				$xzdb->query ( $s );
			}

			/*  set default contact_options  ******************************************************************************** */
			/*  set default auto_responder options  ******************************************************************************** */

			for($xx = 0; $xx < count ( $leadpops_templates_placeholders ); $xx ++) {
				$s = "update leadpops_templates_placeholders_values  set placeholder_fortysix = '<p>Thank you for your submission.</p>' ";
				$s .= " where client_leadpop_id = " . $trialDefaults[0]["leadpop_id"];
				$s .= " and leadpop_template_placeholder_id = " . $leadpops_templates_placeholders [$xx] ['id'];
				$xzdb->query ( $s );
			}

			for($xx = 0; $xx < count ( $leadpops_templates_placeholders ); $xx ++) {
				$s = " update leadpops_templates_placeholders_values  set placeholder_thirtyseven = '" . $logosrc . "'  where client_leadpop_id = " . $trialDefaults[0]["leadpop_id"];
				$s .= " and leadpop_template_placeholder_id = " . $leadpops_templates_placeholders [$xx] ['id'];
				$xzdb->query ( $s );
			}

			for($xx = 0; $xx < count ( $leadpops_templates_placeholders ); $xx ++) {
			    $s = " update leadpops_templates_placeholders_values  set placeholder_sixtytwo = '".$logosrc."'  where client_leadpop_id = " . $trialDefaults[0]["leadpop_id"];
			    $s .= " and leadpop_template_placeholder_id = " . $leadpops_templates_placeholders[$xx]['id'];
			    $xzdb->query($s);
			}

			$s = "update add_client_funnels  set has_run = 'y' ";
            $xzdb->query($s);

}




/* end existing enterprise */


//array(1) { [0]=> array(9) { ["email"]=> string(0) "" ["firstname"]=> string(0) "" ["lastname"]=> string(0) "" ["company"]=> string(0) ""
//["phone"]=> string(0) "" ["client_id"]=> string(1) "1" ["vertical_id"]=> string(1) "7" ["subvertical_id"]=> string(2) "35" ["has_run"]=> string(1) "n" } }

//var_dump($_POST);
//die();
/*savedsession (
session_id varchar(200),background text,gradient varchar(1000),fontcolor varchar(200),company_name varchar(200),
company_phone varchar(100),emails varchar(200),metainfo varchar(1000),data text,gogetem varchar(100)
*/
/* connect to local leadpops */


function findIt($string, $sub_strings){
    foreach($sub_strings as $substr){
        if(strpos($string, $substr) !== FALSE)
        {
          return TRUE; // at least one of the needle strings are substring of heystack, $string
        }
    }

   return FALSE; // no sub_strings is substring of $string.
}

function getHttpServer() {
	global $xzdb;
	$s = "select http from httpclientserver limit 1 ";
	$http = $xzdb->fetchOne ( $s );
	return $http;
}

function isValidEmail($email){
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function insertDefaultEnterpriseAutoResponders ($client_id,$trialDefaults,$email,$phone,$xzdb) {

        // insert primary client
		$s = "insert into lp_auto_recipients (client_id,leadpop_id,leadpop_type_id,";
		$s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,leadpop_version_id,";
		$s .= "leadpop_version_seq,email_address,is_primary) values (" . $client_id . ",";
		$s .= $trialDefaults["leadpop_id"] . "," . $trialDefaults["leadpop_type_id"] . "," . $trialDefaults["leadpop_vertical_id"] . "," . $trialDefaults["leadpop_vertical_sub_id"] . "," . $trialDefaults["leadpop_template_id"] . "," . $trialDefaults["leadpop_version_id"];
		$s .= "," . $trialDefaults["leadpop_version_seq"] . ",'" . $email . "','y')";
		$xzdb->query ( $s );
		$lastId = $xzdb->lastInsertId ();

		$s = "insert into lp_auto_text_recipients (client_id,lp_auto_recipients_id,leadpop_id,leadpop_type_id,";
		$s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,leadpop_version_id,";
		$s .= "leadpop_version_seq,phone_number,carrier,is_primary) values (" . $client_id . "," . $lastId . ",";
		$s .= $trialDefaults["leadpop_id"] . "," . $trialDefaults["leadpop_type_id"] . "," . $trialDefaults["leadpop_vertical_id"] . "," . $trialDefaults["leadpop_vertical_sub_id"] . "," . $trialDefaults["leadpop_template_id"] . "," . $trialDefaults["leadpop_version_id"];
		$s .= "," . $trialDefaults["leadpop_version_seq"] . ",'" . $phone . "','none','y')";
		$xzdb->query ( $s );

}


function insertDefaultAutoResponders ($client_id, $trialDefaults, $emailaddress, $phonenumber) {
  global $xzdb;

        // insert primary client
		$s = "insert into lp_auto_recipients (client_id,leadpop_id,leadpop_type_id,";
		$s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,leadpop_version_id,";
		$s .= "leadpop_version_seq,email_address,is_primary) values (" . $client_id . ",";
		$s .= $trialDefaults["leadpop_id"] . "," . $trialDefaults["leadpop_type_id"] . "," . $trialDefaults["leadpop_vertical_id"] . "," . $trialDefaults["leadpop_vertical_sub_id"] . "," . $trialDefaults["leadpop_template_id"] . "," . $trialDefaults["leadpop_version_id"];
		$s .= "," . $trialDefaults["leadpop_version_seq"] . ",'" . $emailaddress . "','y')";
		$xzdb->query ( $s );
		$lastId = $xzdb->lastInsertId ();

		$s = "insert into lp_auto_text_recipients (client_id,lp_auto_recipients_id,leadpop_id,leadpop_type_id,";
		$s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,leadpop_version_id,";
		$s .= "leadpop_version_seq,phone_number,carrier,is_primary) values (" . $client_id . "," . $lastId . ",";
		$s .= $trialDefaults["leadpop_id"] . "," . $trialDefaults["leadpop_type_id"] . "," . $trialDefaults["leadpop_vertical_id"] . "," . $trialDefaults["leadpop_vertical_sub_id"] . "," . $trialDefaults["leadpop_template_id"] . "," . $trialDefaults["leadpop_version_id"];
		$s .= "," . $trialDefaults["leadpop_version_seq"] . ",'" . $phonenumber . "','none','y')";
		$xzdb->query ( $s );

}

function insertClientDefaultEnterpriseImage($trialDefaults,$image_name,$client_id) {
      global $xzdb;
      global $ssh;
      $use_default = 'n';
	  $use_me = 'y' ;

      $imagename = strtolower($client_id."_".$trialDefaults["leadpop_id"]."_1_".$trialDefaults["leadpop_vertical_id"]."_".$trialDefaults["leadpop_vertical_sub_id"]."_".$trialDefaults['leadpop_template_id']."_".$trialDefaults["leadpop_version_id"]."_".$trialDefaults["leadpop_version_seq"]."_".$image_name);
      $cmd = '/bin/cp  /var/www/vhosts/launch.leadpops.com/trial/classicimages/' . $image_name . '  /var/www/vhosts/itclix.com/images/clients/' . substr($client_id,0,1) . '/' . $client_id . '/pics/' .$imagename ;
      exec($cmd);
      //$ssh->exec($cmd);

      $cmd = '/bin/cp  /var/www/vhosts/launch.leadpops.com/trial/classicimages/' . $image_name . '  /var/www/vhosts/myleads.leadpops.com/images/clients/' . substr($client_id,0,1) . '/' . $client_id . '/pics/' .$imagename ;
      //$ssh->exec($cmd);
      exec($cmd);

		$s = "insert into leadpop_images (id,client_id,leadpop_id,leadpop_type_id,";
		$s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,";
		$s .= "leadpop_version_id,leadpop_version_seq,use_default,";
		$s .= "image_src,use_me,numpics) values (null,";
	    $s .= $client_id.",".$trialDefaults["leadpop_id"].",1,".$trialDefaults["leadpop_vertical_id"].",".$trialDefaults["leadpop_vertical_sub_id"].",";
	    $s .= $trialDefaults['leadpop_template_id'].",".$trialDefaults["leadpop_version_id"].",".$trialDefaults["leadpop_version_seq"].",";
		$s .= "'".$use_default."','".$imagename."','".$use_me."',1) ";
	//	print($s);
        $xzdb->query($s);

	  $img = getHttpServer () . '/images/clients/' . substr($client_id,0,1) . '/' . $client_id . '/pics/' .$imagename ;
      return $img;
}


function insertClientNotDefaultImage($trialDefaults,$client_id,$origleadpop_id,$origleadpop_type_id,$origvertical_id,$origsubvertical_id,
                            $origleadpop_template_id,$origleadpop_version_id,$origleadpop_version_seq) {
      global $xzdb;
      global $ssh;
      $use_default = 'n';
	  $use_me = 'y' ;

		$s = "select image_src from  leadpop_images where client_id = " . $client_id ;
		$s .= " and leadpop_id = " . $origleadpop_id;
		$s .= " and leadpop_type_id = " . $origleadpop_type_id;
		$s .= " and leadpop_vertical_id = " . $origvertical_id;
		$s .= " and leadpop_vertical_sub_id = " . $origsubvertical_id;
		$s .=  " and leadpop_template_id = " . $origleadpop_template_id;
		$s .= " and leadpop_version_id = " . $origleadpop_version_id;
		$s .= " and leadpop_version_seq = " . $origleadpop_version_seq;
		$s .= " and use_default = 'n' and use_me = 'y' limit 1 ";

        $res = $xzdb->fetchAll($s);
		if ($res) { // using an uploaded image
              $image = end(explode("_",$res[0]['image_src']));
			  $imagename = strtolower($client_id."_".$trialDefaults["leadpop_id"]."_1_".$trialDefaults["leadpop_vertical_id"]."_".$trialDefaults["leadpop_vertical_sub_id"]."_".$trialDefaults['leadpop_template_id']."_".$trialDefaults["leadpop_version_id"]."_".$trialDefaults["leadpop_version_seq"]."_".$image);
			  $cmd = '/bin/cp  /var/www/vhosts/itclix.com/images/clients/' . substr($client_id,0,1) . '/' . $client_id . '/pics/' . $res[0]['image_src'] . '  /var/www/vhosts/itclix.com/images/clients/' . substr($client_id,0,1) . '/' . $client_id . '/pics/' . $imagename;
			  exec($cmd);

			  $cmd = '/bin/cp  /var/www/vhosts/myleads.leadpops.com/images/clients/' . substr($client_id,0,1) . '/' . $client_id . '/pics/' . $res[0]['image_src'] . '  /var/www/vhosts/myleads.leadpops.com/images/clients/' . substr($client_id,0,1) . '/' . $client_id . '/pics/' . $imagename;
			  exec($cmd);

			$s = "insert into leadpop_images (id,client_id,leadpop_id,leadpop_type_id,";
			$s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,";
			$s .= "leadpop_version_id,leadpop_version_seq,use_default,";
			$s .= "image_src,use_me,numpics) values (null,";
			$s .= $client_id.",".$trialDefaults["leadpop_id"].",1,".$trialDefaults["leadpop_vertical_id"].",".$trialDefaults["leadpop_vertical_sub_id"].",";
			$s .= $trialDefaults['leadpop_template_id'].",".$trialDefaults["leadpop_version_id"].",".$trialDefaults["leadpop_version_seq"].",";
			$s .= "'n','".$imagename."','y',1) ";
			$xzdb->query($s);

		}
        else {
			  $imagename = strtolower($client_id."_".$trialDefaults["leadpop_id"]."_1_".$trialDefaults["leadpop_vertical_id"]."_".$trialDefaults["leadpop_vertical_sub_id"]."_".$trialDefaults['leadpop_template_id']."_".$trialDefaults["leadpop_version_id"]."_".$trialDefaults["leadpop_version_seq"]."_".$trialDefaults['image_name']);
			  $cmd = '/bin/cp  /var/www/vhosts/launch.leadpops.com/trial/classicimages/' . $trialDefaults['image_name'] . '  /var/www/vhosts/itclix.com/images/clients/' . substr($client_id,0,1) . '/' . $client_id . '/pics/' .$imagename ;
			  exec($cmd);

			  $cmd = '/bin/cp  /var/www/vhosts/launch.leadpops.com/trial/classicimages/' . $trialDefaults['image_name'] . '  /var/www/vhosts/myleads.leadpops.com/images/clients/' . substr($client_id,0,1) . '/' . $client_id . '/pics/' .$imagename ;
			  exec($cmd);

			$s = "insert into leadpop_images (id,client_id,leadpop_id,leadpop_type_id,";
			$s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,";
			$s .= "leadpop_version_id,leadpop_version_seq,use_default,";
			$s .= "image_src,use_me,numpics) values (null,";
			$s .= $client_id.",".$trialDefaults["leadpop_id"].",1,".$trialDefaults["leadpop_vertical_id"].",".$trialDefaults["leadpop_vertical_sub_id"].",";
			$s .= $trialDefaults['leadpop_template_id'].",".$trialDefaults["leadpop_version_id"].",".$trialDefaults["leadpop_version_seq"].",";
			$s .= "'y','".$imagename."','n',1) ";
			$xzdb->query($s);

        }

	  $img = getHttpServer () . '/images/clients/' . substr($client_id,0,1) . '/' . $client_id . '/pics/' .$imagename ;
      return $img;
}


function insertClientDefaultImage($trialDefaults,$client_id) {
      global $xzdb;
      global $ssh;
      $use_default = 'n';
	  $use_me = 'y' ;

      $imagename = strtolower($client_id."_".$trialDefaults["leadpop_id"]."_1_".$trialDefaults["leadpop_vertical_id"]."_".$trialDefaults["leadpop_vertical_sub_id"]."_".$trialDefaults['leadpop_template_id']."_".$trialDefaults["leadpop_version_id"]."_".$trialDefaults["leadpop_version_seq"]."_".$trialDefaults['image_name']);
      $cmd = '/bin/cp  /var/www/vhosts/launch.leadpops.com/trial/classicimages/' . $trialDefaults['image_name'] . '  /var/www/vhosts/itclix.com/images/clients/' . substr($client_id,0,1) . '/' . $client_id . '/pics/' .$imagename ;
      exec($cmd);
      //$ssh->exec($cmd);

      $cmd = '/bin/cp  /var/www/vhosts/launch.leadpops.com/trial/classicimages/' . $trialDefaults['image_name'] . '  /var/www/vhosts/myleads.leadpops.com/images/clients/' . substr($client_id,0,1) . '/' . $client_id . '/pics/' .$imagename ;
      //$ssh->exec($cmd);
      exec($cmd);

		$s = "insert into leadpop_images (id,client_id,leadpop_id,leadpop_type_id,";
		$s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,";
		$s .= "leadpop_version_id,leadpop_version_seq,use_default,";
		$s .= "image_src,use_me,numpics) values (null,";
	    $s .= $client_id.",".$trialDefaults["leadpop_id"].",1,".$trialDefaults["leadpop_vertical_id"].",".$trialDefaults["leadpop_vertical_sub_id"].",";
	    $s .= $trialDefaults['leadpop_template_id'].",".$trialDefaults["leadpop_version_id"].",".$trialDefaults["leadpop_version_seq"].",";
		$s .= "'".$use_default."','".$imagename."','".$use_me."',1) ";
	//	print($s);
        $xzdb->query($s);

	  $img = getHttpServer () . '/images/clients/' . substr($client_id,0,1) . '/' . $client_id . '/pics/' .$imagename ;
      return $img;
}

function insertDefaultClientUploadLogo($logosrc,$trialDefaults,$client_id) {
      global $xzdb;
      $numpics = 0;
      $usedefault = 'y';

	  global $globallogosrc;
	  global $globalfavicon_dst;
	  global $globallogo_color;
	  global $globalcolored_dot;

      //$imagename = strtolower($client_id."_".$trialDefaults["leadpop_id"]."_1_".$trialDefaults["leadpop_vertical_id"]."_".$trialDefaults["leadpop_vertical_sub_id"]."_".$trialDefaults['leadpop_template_id']."_".$trialDefaults["leadpop_version_id"]."_".$trialDefaults["leadpop_version_seq"]."_".$trialDefaults['image_name']);
      //$cmd = '/bin/cp  /var/www/vhosts/launch.leadpops.com/trial/classicimages/' . $trialDefaults['image_name'] . '  /var/www/vhosts/itclix.com/images/clients/' . substr($client_id,0,1) . '/' . $client_id . '/pics/' .$imagename ;
     //exec($cmd);

	  $s = "insert into leadpop_logos (id,client_id,leadpop_id,leadpop_type_id,";
	  $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,";
	  $s .= "leadpop_version_id,leadpop_version_seq,use_default,";
	  $s .= "logo_src,use_me,numpics) values (null,";
	  $s .= $client_id.",".$trialDefaults["leadpop_id"].",1,".$trialDefaults["leadpop_vertical_id"].",".$trialDefaults["leadpop_vertical_sub_id"].",";
	  $s .= $trialDefaults['leadpop_template_id'].",".$trialDefaults["leadpop_version_id"].",".$trialDefaults["leadpop_version_seq"].",";
	  $s .= "'".$usedefault."','".$logosrc."','n',".$numpics.") ";
	  $xzdb->query($s);

	  $s = "insert into current_logo (id,client_id,leadpop_id,leadpop_type_id,";
      $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,";
      $s .= "leadpop_version_id,leadpop_version_seq,logo_src) values (null,";
	  $s .= $client_id.",".$trialDefaults["leadpop_id"].",1,".$trialDefaults["leadpop_vertical_id"].",".$trialDefaults["leadpop_vertical_sub_id"].",";
	  $s .= $trialDefaults['leadpop_template_id'].",".$trialDefaults["leadpop_version_id"].",".$trialDefaults["leadpop_version_seq"].",";
      $s .= "'" . $logosrc . "' ) ";
	  $xzdb->query($s);

	  $globallogosrc = $logosrc;
	  $globalfavicon_dst = "";
	  $globallogo_color = "";
	  $globalcolored_dot = "";
}

function newinsertClientUploadLogo($logoname,$trialDefaults,$client_id) {
      global $xzdb;
      global $ssh;

      $numpics = 1;
      $usedefault = 'n';

      $cmd = '/bin/cp /var/www/vhosts/myleads.leadpops.com/images/clients/' . substr($client_id,0,1) . '/' . $client_id . '/logos/' .$logoname  . '  /var/www/vhosts/itclix.com/images/clients/' . substr($client_id,0,1) . '/' . $client_id . '/logos/' .$logoname ;
      //$ssh->exec($cmd);
	  exec($cmd);

	  $s = "insert into leadpop_logos (id,client_id,leadpop_id,leadpop_type_id,";
	  $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,";
	  $s .= "leadpop_version_id,leadpop_version_seq,use_default,";
	  $s .= "logo_src,use_me,numpics) values (null,";
	  $s .= $client_id.",".$trialDefaults["leadpop_id"].",1,".$trialDefaults["leadpop_vertical_id"].",".$trialDefaults["leadpop_vertical_sub_id"].",";
	  $s .= $trialDefaults['leadpop_template_id'].",".$trialDefaults["leadpop_version_id"].",".$trialDefaults["leadpop_version_seq"].",";
	  $s .= "'".$usedefault."','".$logoname."','y',".$numpics.") ";
	  $xzdb->query($s);

	  $s = "insert into current_logo (id,client_id,leadpop_id,leadpop_type_id,";
      $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,";
      $s .= "leadpop_version_id,leadpop_version_seq,logo_src) values (null,";
	  $s .= $client_id.",".$trialDefaults["leadpop_id"].",1,".$trialDefaults["leadpop_vertical_id"].",".$trialDefaults["leadpop_vertical_sub_id"].",";
	  $s .= $trialDefaults['leadpop_template_id'].",".$trialDefaults["leadpop_version_id"].",".$trialDefaults["leadpop_version_seq"].",";
      $s .= "'" . $logoname . "' ) ";
	  $xzdb->query($s);

	  $logosrc = getHttpServer () . '/images/clients/' . substr($client_id,0,1) . '/' . $client_id . '/logos/' .$logoname ;
      return $logosrc;
}

function insertClientUploadLogo($uploadedLogo,$trialDefaults,$client_id) {
      global $xzdb;
      global $ssh;
      $numpics = 1;
      $usedefault = 'n';

	  $logoname = strtolower($client_id."_".$trialDefaults["leadpop_id"]."_1_".$trialDefaults["leadpop_vertical_id"]."_".$trialDefaults["leadpop_vertical_sub_id"]."_".$trialDefaults['leadpop_template_id']."_".$trialDefaults["leadpop_version_id"]."_".$trialDefaults["leadpop_version_seq"]."_".$uploadedLogo);
	  $section = substr($client_id,0,1);
//	  $logopath = $_SERVER['DOCUMENT_ROOT'].'/images/clients/'.$section.'/'. $client_id .'/logos/'.$logoname;

	  $cmd = '/bin/cp  /var/www/vhosts/launch.leadpops.com/images/temp/' . $uploadedLogo . '  /var/www/vhosts/itclix.com/images/clients/' . substr($client_id,0,1) . '/' . $client_id . '/logos/' .$logoname ;
      //$ssh->exec($cmd);
	  exec($cmd);

	  $cmd = '/bin/cp  /var/www/vhosts/launch.leadpops.com/images/temp/' . $uploadedLogo . '  /var/www/vhosts/myleads.leadpops.com/images/clients/' . substr($client_id,0,1) . '/' . $client_id . '/logos/' .$logoname ;
      //$ssh->exec($cmd);
	  exec($cmd);

	  $s = "insert into leadpop_logos (id,client_id,leadpop_id,leadpop_type_id,";
	  $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,";
	  $s .= "leadpop_version_id,leadpop_version_seq,use_default,";
	  $s .= "logo_src,use_me,numpics) values (null,";
	  $s .= $client_id.",".$trialDefaults["leadpop_id"].",1,".$trialDefaults["leadpop_vertical_id"].",".$trialDefaults["leadpop_vertical_sub_id"].",";
	  $s .= $trialDefaults['leadpop_template_id'].",".$trialDefaults["leadpop_version_id"].",".$trialDefaults["leadpop_version_seq"].",";
	  $s .= "'".$usedefault."','".$logoname."','y',".$numpics.") ";
	  $xzdb->query($s);

	  $s = "insert into current_logo (id,client_id,leadpop_id,leadpop_type_id,";
      $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,";
      $s .= "leadpop_version_id,leadpop_version_seq,logo_src) values (null,";
	  $s .= $client_id.",".$trialDefaults["leadpop_id"].",1,".$trialDefaults["leadpop_vertical_id"].",".$trialDefaults["leadpop_vertical_sub_id"].",";
	  $s .= $trialDefaults['leadpop_template_id'].",".$trialDefaults["leadpop_version_id"].",".$trialDefaults["leadpop_version_seq"].",";
      $s .= "'" . $logoname . "' ) ";
	  $xzdb->query($s);

	  $logosrc = getHttpServer () . '/images/clients/' . substr($client_id,0,1) . '/' . $client_id . '/logos/' .$logoname ;
      return $logosrc;
}

function getAutoResponderText ( $vertical_id, $subvertical_id, $leadpop_id ) {
	global $xzdb;
	$s = "select html,subject_line from autoresponder_defaults where  ";
	$s .= " leadpop_id = " . $leadpop_id;
    $s .= " and leadpop_vertical_id = " .  $vertical_id;
    $s .= " and leadpop_vertical_sub_id = " . $subvertical_id . " limit 1 ";
	$res = $xzdb->fetchAll($s);
	if ($res) {
	    return $res;
	}
	else {
	    return "not found";
	}
}

function getSubmissionText($leadpop_id,$vertical_id,$subvertical_id,$niners="888888") {
	global $xzdb;
	if ($niners == "999999") {
		$s = "select html from thankyou_defaults where  ";
		$s .= " leadpop_id = 999999 limit 1";
		$res = $xzdb->fetchAll($s);
	}
	else {
		$s = "select html from thankyou_defaults where  ";
		$s .= " leadpop_id = " . $leadpop_id;
		$s .= " and leadpop_vertical_id = " .  $vertical_id;
		$s .= " and leadpop_vertical_sub_id = " . $subvertical_id . " limit 1 ";
		$res = $xzdb->fetchAll($s);
	}
    return $res[0]["html"];
}

function insertPurchasedGoogle($client_id, $googleDomain) {
	global $xzdb;
	// package id does not now affect google analytics so put 2 for all
	$dt = date ( 'Y-m-d H:i:s' );
	$s = "insert into purchased_google_analytics (client_id,purchased,google_key,";
	$s .= "thedate,domain,active,package_id) values (" . $client_id . ",'y','','" . $dt . "','" . $googleDomain . "',";
	$s .= "'n',2)";
	$xzdb->query ( $s );
}

function getRandomCharacter() {
		$chars = "abcdefghijkmnopqrstuvwxyz";
		srand ( ( double ) microtime () * 1000000 );
		$i = 0;
		$char = '';
		while ( $i <= 1 ) {
			$num = rand () % 33;
			$tmp = substr ( $chars, $num, 1 );
			$char = $char . $tmp;
			$i ++;
		}
		return $char;
}

function encrypt($string) {
	$key = "petebird";
	$string = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $string, MCRYPT_MODE_CBC, md5(md5($key))));
	return $string;
}

function decrypt($string) {
	$key = "petebird";
	$string = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($string), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
	return $string;
}

function generateRandomString($length = 5) {
	return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
}


function checkIfNeedMultipleStepInsert($leadpop_description_id,$client_id) {
    global $xzdb;
	$s = "select * from leadpop_multiple where leadpop_description_id = " . $leadpop_description_id . " limit 1 ";
	$res = $xzdb->fetchAll ( $s );
	if ($res) {
		$s = "insert into leadpop_multiple_step (id,";
		$s .= "client_id,leadpop_description_id,leadpop_id,";
		$s .= "leadpop_template_id,stepone,steptwo,stepthree,";
		$s .= "stepfour,stepfive) values (null,";
		$s .= $client_id . "," . $res [0] ['leadpop_description_id'] . ",";
		$s .= $res [0] ['leadpop_id'] . "," . $res [0] ['leadpop_template_id'] . ",'";
		$s .= $res [0] ['stepone'] . "','" . $res [0] ['steptwo'] . "','" . $res [0] ['stepthree'];
		$s .= "','" . $res [0] ['stepfour'] . "','" . $res [0] ['stepfive'] . "')";
		$xzdb->query ( $s );
	}
}

function createClientInitialDirectories($client_id) {
    global $ssh;
		$cmd = '/bin/mkdir  -p -m 0777  /var/www/vhosts/itclix.com/images/clients/' . substr($client_id,0,1) . '/' . $client_id ;
	      //$ssh->exec($cmd);
	@exec($cmd);
		$cmd = '/bin/mkdir  -p -m 0777  /var/www/vhosts/myleads.leadpops.com/images/clients/' . substr($client_id,0,1). '/' . $client_id ;
      //$ssh->exec($cmd);
		@exec($cmd);

		$cmd = '/bin/mkdir  -p -m 0777  /var/www/vhosts/itclix.com/images/clients/' . substr($client_id,0,1) . '/' . $client_id  . '/logos' ;
      //$ssh->exec($cmd);
		@exec($cmd);
		$cmd = '/bin/mkdir  -p -m 0777  /var/www/vhosts/myleads.leadpops.com/images/clients/' . substr($client_id,0,1). '/' . $client_id . '/logos' ;
      //$ssh->exec($cmd);
		@exec($cmd);

		$cmd = '/bin/mkdir  -p -m 0777  /var/www/vhosts/itclix.com/images/clients/' . substr($client_id,0,1) . '/' . $client_id  . '/pics' ;
      //$ssh->exec($cmd);
		@exec($cmd);
		$cmd = '/bin/mkdir  -p -m 0777  /var/www/vhosts/myleads.leadpops.com/images/clients/' . substr($client_id,0,1). '/' . $client_id . '/pics' ;
      //$ssh->exec($cmd);
		@exec($cmd);
}

function  createExtraCkfinderDirectories($client_id,$list)  {
/* start directories */
global $db;
global $ssh;
$dt = date('Y-m-d H:i:s');

		$s = "select * from clients_leadpops where client_id = " . $client_id . " and leadpop_id in " . $list . " " ;

        $imgs = array();
        if ($img = $db->query($s)) {
            while($row = $img->fetch_assoc()) {
                $imgs[] = $row;
            }
			//var_dump($imgs);
            for($j=0; $j<count($imgs); $j++) {
                $s = "select * from leadpops where id = " . $imgs[$j]['leadpop_id'];
                if ($arec = $db->query($s)) {
                    $arow = $arec->fetch_assoc();
                    $s = "select id,lead_pop_vertical from leadpops_verticals where id = " . $arow['leadpop_vertical_id'];
					//print($s);
                    if ($brec = $db->query($s)) {
                        while($xrow = $brec->fetch_assoc()) {
                            $vertical_name = strtolower(str_replace(" ","",$xrow['lead_pop_vertical']));
					//		print("vertical name " . $vertical_name);
                            $cmd = '/bin/mkdir  -p -m 0777  /var/www/vhosts/myleads.leadpops.com/ckfinder/userfiles/' . substr($client_id,0,1). '/' . $client_id  . '/images/' . $vertical_name;
                            //$ssh->exec($cmd);
                            @exec($cmd);
                            $cmd = '/bin/mkdir  -p -m 0777  /var/www/vhosts/myleads.leadpops.com/ckfinder/userfiles/' . substr($client_id,0,1). '/' . $client_id  . '/images/' . $vertical_name . '/company_logos'  ;
                            //$ssh->exec($cmd);
                            @exec($cmd);

                            $cmd = '/bin/mkdir  -p -m 0777  /var/www/vhosts/myleads.leadpops.com/ckfinder/userfiles/' . substr($client_id,0,1). '/' . $client_id  . '/images/' . $vertical_name . '/general'  ;
                            //$ssh->exec($cmd);
                            @exec($cmd);

                            $cmd = '/bin/mkdir  -p -m 0777  /var/www/vhosts/myleads.leadpops.com/ckfinder/userfiles/' . substr($client_id,0,1). '/' . $client_id  . '/images/' . $vertical_name . '/general/call_to_action_buttons'  ;
                            //$ssh->exec($cmd);
                           @exec($cmd);

                            $cmd = '/bin/mkdir  -p -m 0777  /var/www/vhosts/myleads.leadpops.com/ckfinder/userfiles/' . substr($client_id,0,1). '/' . $client_id  . '/images/' . $vertical_name . '/general/homepage_graphics'  ;
                            //$ssh->exec($cmd);
                            @exec($cmd);

                            $s = "select lead_pop_vertical_sub from leadpops_verticals_sub where leadpop_vertical_id = " . $xrow['id'];
                            if ($zrec = $db->query($s)) {
                                while($hrow = $zrec->fetch_assoc()) {
                                    $subvertical_name = strtolower(str_replace(" ","",$hrow['lead_pop_vertical_sub']));
						//	print("subvertical name " . $subvertical_name);
                                    $cmd = '/bin/mkdir  -p -m 0777  /var/www/vhosts/myleads.leadpops.com/ckfinder/userfiles/' . substr($client_id,0,1). '/' . $client_id  . '/images/' . $vertical_name . '/' . $subvertical_name;
                                    //$ssh->exec($cmd);
                                    @exec($cmd);
                                    $cmd = '/bin/mkdir  -p -m 0777  /var/www/vhosts/myleads.leadpops.com/ckfinder/userfiles/' . substr($client_id,0,1). '/' . $client_id  . '/images/' . $vertical_name . '/' . $subvertical_name . '/call_to_action_buttons';
                                    //$ssh->exec($cmd);
                                   @exec($cmd);
                                    $cmd = '/bin/mkdir  -p -m 0777  /var/www/vhosts/myleads.leadpops.com/ckfinder/userfiles/' . substr($client_id,0,1). '/' . $client_id  . '/images/' . $vertical_name . '/' . $subvertical_name . '/homepage_graphics';
                                    //$ssh->exec($cmd);
                                    @exec($cmd);

                                }
                            }
                        }
                    }
                }
            }
        }

		$s = "select * from clients_leadpops where client_id = " . $client_id . " and leadpop_id in " . $list . " " ;
        $cimgs = array();
        if ($cimg = $db->query($s)) {
            while($zrow = $cimg->fetch_assoc()) {
                $cimgs[] = $zrow;
            }
            for($jj=0; $jj<count($cimgs); $jj++) {
                $s = "select * from leadpops where id = " . $cimgs[$jj]['leadpop_id'];
                if ($zarec = $db->query($s)) {
/* copy default logos */
                    $cmd = '/bin/cp -Rf /var/www/vhosts/myleads.leadpops.com/stockimages/default_logos/* /var/www/vhosts/myleads.leadpops.com/ckfinder/userfiles/' . substr($client_id,0,1). '/' . $client_id  . '/images/default_logos/';
                    //$ssh->exec($cmd);
                    @exec($cmd);

                    $cmd = '/bin/cp -Rf /var/www/vhosts/myleads.leadpops.com/stockimages/general/* /var/www/vhosts/myleads.leadpops.com/ckfinder/userfiles/' . substr($client_id,0,1). '/' . $client_id  . '/images/general/';
                    //$ssh->exec($cmd);
                    @exec($cmd);
/* copy default logos */
                    $zarow = $zarec->fetch_assoc();
                    $s = "select id,lead_pop_vertical from leadpops_verticals where id = " . $zarow['leadpop_vertical_id'];
                    if ($zbrec = $db->query($s)) {
                        while($zxrow = $zbrec->fetch_assoc()) {
                            $vertical_name = strtolower(str_replace(" ","",$zxrow['lead_pop_vertical']));
						//	print("second vertical name " . $vertical_name);

                            $cmd = '/bin/cp -Rf /var/www/vhosts/myleads.leadpops.com/stockimages/'.$vertical_name.'/* /var/www/vhosts/myleads.leadpops.com/ckfinder/userfiles/' . substr($client_id,0,1). '/' . $client_id  . '/images/' .$vertical_name . '/';
                            //$ssh->exec($cmd);
                            @exec($cmd);

                        }
                    }
                }
            }
        }

/* end directories */

}

function  createCkfinderDirectories($client_id)  {
/* start directories */
global $db;
global $ssh;
$dt = date('Y-m-d H:i:s');

		$cmd = '/bin/mkdir  -p -m 0777  /var/www/vhosts/myleads.leadpops.com/ckfinder/userfiles/' . substr($client_id,0,1). '/' . $client_id ;
        //$ssh->exec($cmd);
		@exec($cmd);

		$cmd = '/bin/mkdir  -p -m 0777  /var/www/vhosts/myleads.leadpops.com/ckfinder/userfiles/' . substr($client_id,0,1). '/' . $client_id  . '/' . '_thumbs';
        //$ssh->exec($cmd);
		@exec($cmd);

		$cmd = '/bin/mkdir  -p -m 0777  /var/www/vhosts/myleads.leadpops.com/ckfinder/userfiles/' . substr($client_id,0,1). '/' . $client_id  . '/' . '_thumbs' . '/Images' ;
        //$ssh->exec($cmd);
		@exec($cmd);

		$cmd = '/bin/mkdir  -p -m 0777  /var/www/vhosts/myleads.leadpops.com/ckfinder/userfiles/' . substr($client_id,0,1). '/' . $client_id  . '/' . 'files' ;
        //$ssh->exec($cmd);
		@exec($cmd);

		$cmd = '/bin/mkdir  -p -m 0777  /var/www/vhosts/myleads.leadpops.com/ckfinder/userfiles/' . substr($client_id,0,1). '/' . $client_id  . '/' . 'flash' ;
        //$ssh->exec($cmd);
		@exec($cmd);

		$cmd = '/bin/mkdir  -p -m 0777  /var/www/vhosts/myleads.leadpops.com/ckfinder/userfiles/' . substr($client_id,0,1). '/' . $client_id  . '/' . 'images' ;
        //$ssh->exec($cmd);
		@exec($cmd);

		$cmd = '/bin/mkdir  -p -m 0777  /var/www/vhosts/myleads.leadpops.com/ckfinder/userfiles/' . substr($client_id,0,1). '/' . $client_id  . '/' . 'uploads' ;
        //$ssh->exec($cmd);
		@exec($cmd);

		$cmd = '/bin/mkdir  -p -m 0777  /var/www/vhosts/myleads.leadpops.com/ckfinder/userfiles/' . substr($client_id,0,1). '/' . $client_id  . '/' . 'images/default_logos' ;
        //$ssh->exec($cmd);
		@exec($cmd);

		$cmd = '/bin/mkdir  -p -m 0777  /var/www/vhosts/myleads.leadpops.com/ckfinder/userfiles/' . substr($client_id,0,1). '/' . $client_id  . '/' . 'images/general' ;
        //$ssh->exec($cmd);
		@exec($cmd);

		$cmd = '/bin/mkdir  -p -m 0777  /var/www/vhosts/myleads.leadpops.com/ckfinder/userfiles/' . substr($client_id,0,1). '/' . $client_id  . '/' . 'images/general/call_to_action_buttons' ;
        //$ssh->exec($cmd);
		@exec($cmd);

		$cmd = '/bin/mkdir  -p -m 0777  /var/www/vhosts/myleads.leadpops.com/ckfinder/userfiles/' . substr($client_id,0,1). '/' . $client_id  . '/' . 'images/general/homepage_graphics' ;
	    //$ssh->exec($cmd);
	    @exec($cmd);

		$cmd = '/bin/mkdir  -p -m 0777  /var/www/vhosts/myleads.leadpops.com/ckfinder/userfiles/' . substr($client_id,0,1). '/' . $client_id  . '/' . 'images/background_images' ;
        //$ssh->exec($cmd);
		@exec($cmd);

		$s = "select * from clients_leadpops where client_id = " . $client_id;

        $imgs = array();
        if ($img = $db->query($s)) {
            while($row = $img->fetch_assoc()) {
                $imgs[] = $row;
            }
			//var_dump($imgs);
            for($j=0; $j<count($imgs); $j++) {
                $s = "select * from leadpops where id = " . $imgs[$j]['leadpop_id'];
                if ($arec = $db->query($s)) {
                    $arow = $arec->fetch_assoc();
                    $s = "select id,lead_pop_vertical from leadpops_verticals where id = " . $arow['leadpop_vertical_id'];
					//print($s);
                    if ($brec = $db->query($s)) {
                        while($xrow = $brec->fetch_assoc()) {
                            $vertical_name = strtolower(str_replace(" ","",$xrow['lead_pop_vertical']));
					//		print("vertical name " . $vertical_name);
                            $cmd = '/bin/mkdir  -p -m 0777  /var/www/vhosts/myleads.leadpops.com/ckfinder/userfiles/' . substr($client_id,0,1). '/' . $client_id  . '/images/' . $vertical_name;
                            //$ssh->exec($cmd);
                            @exec($cmd);
                            $cmd = '/bin/mkdir  -p -m 0777  /var/www/vhosts/myleads.leadpops.com/ckfinder/userfiles/' . substr($client_id,0,1). '/' . $client_id  . '/images/' . $vertical_name . '/company_logos'  ;
                            //$ssh->exec($cmd);
                            @exec($cmd);

                            $cmd = '/bin/mkdir  -p -m 0777  /var/www/vhosts/myleads.leadpops.com/ckfinder/userfiles/' . substr($client_id,0,1). '/' . $client_id  . '/images/' . $vertical_name . '/general'  ;
                            //$ssh->exec($cmd);
                            @exec($cmd);

                            $cmd = '/bin/mkdir  -p -m 0777  /var/www/vhosts/myleads.leadpops.com/ckfinder/userfiles/' . substr($client_id,0,1). '/' . $client_id  . '/images/' . $vertical_name . '/general/call_to_action_buttons'  ;
                            //$ssh->exec($cmd);
                           @exec($cmd);

                            $cmd = '/bin/mkdir  -p -m 0777  /var/www/vhosts/myleads.leadpops.com/ckfinder/userfiles/' . substr($client_id,0,1). '/' . $client_id  . '/images/' . $vertical_name . '/general/homepage_graphics'  ;
                            //$ssh->exec($cmd);
                            @exec($cmd);

                            $s = "select lead_pop_vertical_sub from leadpops_verticals_sub where leadpop_vertical_id = " . $xrow['id'];
                            if ($zrec = $db->query($s)) {
                                while($hrow = $zrec->fetch_assoc()) {
                                    $subvertical_name = strtolower(str_replace(" ","",$hrow['lead_pop_vertical_sub']));
						//	print("subvertical name " . $subvertical_name);
                                    $cmd = '/bin/mkdir  -p -m 0777  /var/www/vhosts/myleads.leadpops.com/ckfinder/userfiles/' . substr($client_id,0,1). '/' . $client_id  . '/images/' . $vertical_name . '/' . $subvertical_name;
                                    //$ssh->exec($cmd);
                                    @exec($cmd);
                                    $cmd = '/bin/mkdir  -p -m 0777  /var/www/vhosts/myleads.leadpops.com/ckfinder/userfiles/' . substr($client_id,0,1). '/' . $client_id  . '/images/' . $vertical_name . '/' . $subvertical_name . '/call_to_action_buttons';
                                    //$ssh->exec($cmd);
                                   @exec($cmd);
                                    $cmd = '/bin/mkdir  -p -m 0777  /var/www/vhosts/myleads.leadpops.com/ckfinder/userfiles/' . substr($client_id,0,1). '/' . $client_id  . '/images/' . $vertical_name . '/' . $subvertical_name . '/homepage_graphics';
                                    //$ssh->exec($cmd);
                                    @exec($cmd);

                                }
                            }
                        }
                    }
                }
            }
        }

        $s = "select * from clients_leadpops where client_id = " . $client_id;
        $cimgs = array();
        if ($cimg = $db->query($s)) {
            while($zrow = $cimg->fetch_assoc()) {
                $cimgs[] = $zrow;
            }
            for($jj=0; $jj<count($cimgs); $jj++) {
                $s = "select * from leadpops where id = " . $cimgs[$jj]['leadpop_id'];
                if ($zarec = $db->query($s)) {
/* copy default logos */
                    $cmd = '/bin/cp -Rf /var/www/vhosts/myleads.leadpops.com/stockimages/default_logos/* /var/www/vhosts/myleads.leadpops.com/ckfinder/userfiles/' . substr($client_id,0,1). '/' . $client_id  . '/images/default_logos/';
                    //$ssh->exec($cmd);
                    @exec($cmd);

                    $cmd = '/bin/cp -Rf /var/www/vhosts/myleads.leadpops.com/stockimages/general/* /var/www/vhosts/myleads.leadpops.com/ckfinder/userfiles/' . substr($client_id,0,1). '/' . $client_id  . '/images/general/';
                    //$ssh->exec($cmd);
                    @exec($cmd);
/* copy default logos */
                    $zarow = $zarec->fetch_assoc();
                    $s = "select id,lead_pop_vertical from leadpops_verticals where id = " . $zarow['leadpop_vertical_id'];
                    if ($zbrec = $db->query($s)) {
                        while($zxrow = $zbrec->fetch_assoc()) {
                            $vertical_name = strtolower(str_replace(" ","",$zxrow['lead_pop_vertical']));
						//	print("second vertical name " . $vertical_name);

                            $cmd = '/bin/cp -Rf /var/www/vhosts/myleads.leadpops.com/stockimages/'.$vertical_name.'/* /var/www/vhosts/myleads.leadpops.com/ckfinder/userfiles/' . substr($client_id,0,1). '/' . $client_id  . '/images/' .$vertical_name . '/';
                            //$ssh->exec($cmd);
                            @exec($cmd);

                        }
                    }
                }
            }
        }

/* end directories */

}

function  getMobileImageDimensions ($w,$h) {
		if ($w <= 320 && $h <= 71 ) {
			return $w . "~" . $h;
		}
		else { // must resize
			$ratio = ($w / $h);
			//die($ratio);
			// 1309/718
			do  {
				$w -= $ratio;
				$h -= 1;
			} while ($w > 320 || $h > 71);
			return $w . "~" . $h;
		}
}

function resizeImage($CurWidth,$CurHeight,$DestFolder,$SrcImage,$Quality,$ImageType,$resize,$TempSrc) {

		if($CurWidth <= 0 || $CurHeight <= 0)
		{
			return false;
		}

        if ($resize)  {
//			320 X 70

			$dimensions = explode("~", getMobileImageDimensions($CurWidth,$CurHeight));
			$NewWidth = $dimensions[0];
			$NewHeight = $dimensions[1];
			$NewCanves = imagecreatetruecolor($NewWidth, $NewHeight);
			switch ($ImageType)
			{
				case 'image/png':
					// integer representation of the color black (rgb: 0,0,0)
					$background = imagecolorallocate($NewCanves, 0, 0, 0);
					// removing the black from the placeholder
					imagecolortransparent($NewCanves, $background);

					// turning off alpha blending (to ensure alpha channel information
					// is preserved, rather than removed (blending with the rest of the
					// image in the form of black))
					imagealphablending($NewCanves, false);

					// turning on alpha channel information saving (to ensure the full range
					// of transparency is preserved)
					imagesavealpha($NewCanves, true);

					break;
				case "image/gif":
					// integer representation of the color black (rgb: 0,0,0)
					$background = imagecolorallocate($NewCanves, 0, 0, 0);
					// removing the black from the placeholder
					imagecolortransparent($NewCanves, $background);

					break;
			}

			// Resize Image
			try {
				imagecopyresampled($NewCanves, $SrcImage,0, 0, 0, 0, $NewWidth, $NewHeight, $CurWidth, $CurHeight);
			} catch (Exception $e) {
				die( ' imagecopyresampled : ' .  $e->getMessage());
			}
			try {
				imagepng($NewCanves,$DestFolder);
			} catch (Exception $e) {
				die( ' imagepng: ' .  $e->getMessage());
			}

		}
		else {
		    $cmd = '/bin/cp  ' . $TempSrc . '  ' . $DestFolder;
			exec($cmd);
		}

}


function colorizeBasedOnAplhaChannnel( $file, $targetR, $targetG, $targetB, $targetName ) {

			if(file_exists($targetName)){
				unlink($targetName);
			}

		    $im_src = imagecreatefrompng( $file );
		 	$width = imagesx($im_src);
		    $height = imagesy($im_src);

		    $im_dst = imagecreatefrompng( $file );

		    imagealphablending( $im_dst, false );
			imagesavealpha( $im_dst, true );
		    imagealphablending( $im_src, false );
			imagesavealpha( $im_src, true );
		    imagefilledrectangle( $im_dst, 0, 0, $width, $height, '0xFFFFFF' );

		    for( $x=0; $x<$width; $x++ ) {
		        for( $y=0; $y<$height; $y++ ) {

		            $alpha = ( imagecolorat( $im_src, $x, $y ) >> 24 & 0xFF );
		            $col = imagecolorallocatealpha( $im_dst,
		                $targetR - (int) ( 1.0 / 255.0  * $alpha * (double) $targetR ),
		                $targetG - (int) ( 1.0 / 255.0  * $alpha * (double) $targetG ),
		                $targetB - (int) ( 1.0 / 255.0  * $alpha * (double) $targetB ),
		                $alpha
		                );
						if ( false === $col ) {
							die( 'sorry, out of colors...' );
						}
		            imagesetpixel( $im_dst, $x, $y, $col );
		        }

		    }
		   	imagepng( $im_dst, $targetName);
		   	imagedestroy($im_dst);
}


function getHttpAdminServer() {
global $xzdb;
          $s = "select http from httpadminserver limit 1 " ;
          $http = $xzdb->fetchOne($s);
          return $http;
}

function hex2rgb($hex) {
		   $hex = str_replace("#", "", $hex);

		   if(strlen($hex) == 3) {
		      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
		      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
		      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
		   } else {
		      $r = hexdec(substr($hex,0,2));
		      $g = hexdec(substr($hex,2,2));
		      $b = hexdec(substr($hex,4,2));
		   }
		   $rgb = array($r, $g, $b);
		   //return implode(",", $rgb); // returns the rgb values separated by commas
		   return $rgb; // returns an array with the rgb values
}

//#!/usr/bin/php

error_reporting(255);
ini_set('memory_limit', '2024M');
ini_set('max_execution_time',300);
set_time_limit(0);
date_default_timezone_set('America/Los_Angeles');
/* connect to local leadpops */


require_once('/var/www/vhosts/launch.leadpops.com/localdb.php');

global $db;
global $xzdb;
global $thissub_domain;
global $thistop_domain;
global$leadpoptype;

global $globallogosrc;
global $globalfavicon_dst;
global $globallogo_color;
global $globalcolored_dot;

$thissub_domain = 1;
$thistop_domain = 2;
$leadpoptype = 1;

$s = "select * from add_client_funnels  where has_run = 'n' limit 1";
$run = $xzdb->fetchAll($s);
//var_dump($run);
//die();

$enterprise_verticals = array(7,3,2,6);
$enterprise_subverticals = array(14,33,35,39,72,20,40,42,65,66,71,31);
$enterprise_versions =      array(18,41,43,44,78,27,46,48,64,65,77,39);

$nonenterprise_verticals = array(1,2,3,5,6);
$nonenterprise_subverticals = array(1,2,3,4,5,6,7,8,10,11,15,44,45,46,47,48,
                              49,50,51,52,53,54,55,56,57,58,59,12,13,17,60,61,62,63,64,67,68,69,18,30,70,73,
							  74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99,
							  100,101,102,103,104,105,106,107,108,109,110,111,112,113 );
$nonenterprise_versions = array(2,3,4,5,6,7,8,9,11,13,14,15,16,20,22,23,38,50,51,52,53,54,55,56,57,58,59,60,61,62,
                              63,66,67,68,69,70,71,72,73,74,75,76,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99
							  100,101,102,103,104,105,106,107,108,109,110,111,112,113,114,115,116,117,118,119  );

	//5	73	79

//INSERT INTO `add_client_funnels` (`email`, `firstname`, `lastname`, `company`, `phone`, `client_id`, `vertical_id`, `subvertical_id`, `version_id`, `has_run`, `logo`, `mobilelogo`, `origvertical_id`, `origsubvertical_id`, `origversion_id`, `origleadpop_type_id`, `origleadpop_template_id`, `origleadpop_id`, `origleadpop_version_id`, `origleadpop_version_seq`) VALUES
//('', 'Conroy', 'Jackson', 'Poli Mortgage', '8775269779', '', '7', '35', '43', 'n', '', '', '', '', '', '', '', '', '', '');

if ($run) { // there is some work to do              1 1 8
    if (in_array($run[0]["vertical_id"],$enterprise_verticals) && in_array($run[0]["subvertical_id"],$enterprise_subverticals) &&  in_array($run[0]["version_id"],$enterprise_versions)) { // wanting to add a genericic enter prise page to a client
	        // vertical, subvertical,version are present
		if ($run[0]["client_id"] != "") { // enterprise veritcal and subvertical are entered  and it is for a current client
	        // vertical, subvertical,version are present  and also client id it not blank
		        addExistingClientGenericEnterprise($run[0]["vertical_id"], $run[0]["subvertical_id"], $run[0]["version_id"],$run[0]["client_id"]);
		}
		else if ($run[0]["email"] != "" && $run[0]["firstname"] != "" && $run[0]["lastname"] != "" && $run[0]["company"] != ""
		           && $run[0]["phone"] != "" && $run[0]["client_id"] == "") { //  new enterprise page  for new client
		        addNewClientGenericEnterprise($run[0]["vertical_id"], $run[0]["subvertical_id"],$run[0]["version_id"], $run[0]["email"],$run[0]["firstname"],$run[0]["lastname"],$run[0]["company"],$run[0]["phone"]);
		}
		else {
		    die("not enough information");
		}
	}
	else  if (in_array($run[0]["vertical_id"],$nonenterprise_verticals)
	        && !in_array($run[0]["subvertical_id"],$nonenterprise_subverticals)
	        && !in_array($run[0]["version_id"],$nonenterprise_versions)
	) {
	// trying to add whole non-enterprise vertical to existing client.
	           $atemp = $run[0]["vertical_id"];
               addNonEnterpriseVerticalToExistingClient($atemp,$run[0]["subvertical_id"],$run[0]["version_id"],$run[0]["client_id"],$run[0]["logo"],
		            $run[0]["mobilelogo"],$run[0]["origvertical_id"],$run[0]["origsubvertical_id"],$run[0]["origversion_id"],
		            $run[0]["origleadpop_type_id"], $run[0]["origleadpop_template_id"], $run[0]["origleadpop_id"],
		            $run[0]["origleadpop_version_id"],$run[0]["origleadpop_version_seq"]);
	}
	else  if (in_array($run[0]["vertical_id"],$nonenterprise_verticals)
	        && in_array($run[0]["subvertical_id"],$nonenterprise_subverticals)
	        && !in_array($run[0]["version_id"],$nonenterprise_versions)
	) {
	      die("dogs not allowed");
	}
	else  if (in_array($run[0]["vertical_id"],$nonenterprise_verticals)
	        && in_array($run[0]["subvertical_id"],$nonenterprise_subverticals)
	        && in_array($run[0]["version_id"],$nonenterprise_versions)
	) {

	// trying to add specific non-enterprise vertical, subvertical, version to existing client.
	      $tempvert = $run[0]["vertical_id"];
          addNonEnterpriseVerticalSubverticalVersionToExistingClient($tempvert , $run[0]["subvertical_id"],$run[0]["version_id"],$run[0]["client_id"],$run[0]["logo"],
		  $run[0]["mobilelogo"],$run[0]["origvertical_id"],$run[0]["origsubvertical_id"],$run[0]["origversion_id"],
		  $run[0]["origleadpop_type_id"], $run[0]["origleadpop_template_id"], $run[0]["origleadpop_id"],
		  $run[0]["origleadpop_version_id"],$run[0]["origleadpop_version_seq"]);
	}
	else {
	    die("not enough information");
	}
}




?>
