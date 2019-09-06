<?php 
/* ---------------------------------------------  */
// Function for converting hex to rgb
/* ---------------------------------------------  */

function be_themes_hexa_to_rgb( $color ) {

  if ( isset( $color[0] ) && $color[0] == '#' ) {
      $color = substr($color, 1);
  }

  if ( strlen( $color ) == 6 ) {
      list( $r, $g, $b ) = array( $color[0].$color[1], $color[2].$color[3], $color[4].$color[5] );
  } elseif (strlen($color) == 3) {
      list( $r, $g, $b ) = array( $color[0].$color[0], $color[1].$color[1], $color[2].$color[2] );
  } else {
      return false;
  }

  $r = hexdec( $r ); $g = hexdec( $g ); $b = hexdec( $b );

  return array( $r, $g, $b );
}


/* ---------------------------------------------  */
// Function for finding IE8 alpha from opacity
/* ---------------------------------------------  */

function be_themes_alpha_level( $opacity ) {
  $alpha_value =  dechex( $opacity * 255 );
  return $alpha_value;
}


/* ---------------------------------------------  */
// Function for printing background styles
/* ---------------------------------------------  */

// function be_themes_set_backgrounds( $section ) {
// 	global $be_themes_data;
	
// 	$background_color = '';
// 	$background_image = '';
// 	$background_repeat = '';
// 	$background_attachment = '';
// 	$background_position = '';
	
		
// 	if( isset( $be_themes_data[$section]['color'] ) ) {
// 		$background_color = $be_themes_data[$section]['color'];
// 	}

// 	if( isset( $be_themes_data[$section]['recur'] ) ) {
// 		$background_repeat = $be_themes_data[$section]['recur'];
// 	}
// 	if( isset( $be_themes_data[$section]['attach'] ) ) {
// 		$background_attachment = $be_themes_data[$section]['attach'];
// 	}

// 	if( isset( $be_themes_data[$section]['position'] ) ) {
// 		$background_position = $be_themes_data[$section]['position'];
// 	}

//   if( isset($be_themes_data[$section]['none'] ) ) {
//       echo 'background: none;';
//   } elseif( isset( $be_themes_data[$section]['custom'] ) ) {
//     	if( !empty( $be_themes_data[$section]['bgpattern'] ) ) {
//     		$background_image=$be_themes_data[$section]['bgpattern'];
//     		echo 'background: '.$background_color.' url('.$background_image.') '.$background_repeat.' '.$background_attachment.' '.$background_position.';';
//     	} else {
// 	    	if( !empty( $background_color ) ){
// 		    	be_themes_background_colors( $be_themes_data[$section]['color'], $be_themes_data[$section]['opacity'] );
// 	    	}
//     	}  
//   } elseif( $be_themes_data[$section]['background'] != "None" ) { 
//   		if( !empty( $be_themes_data[$section]['background'] ) ) {
//     		$background_image = 'url('.get_template_directory_uri().'/css/patterns/'.$be_themes_data[$section]['background'].'.png)';
//     	}   
//     	echo 'background: '.$background_color.' '.$background_image.' '.$background_repeat.' '.$background_attachment.' '.	$background_position.';';
 	   
//  	} else {
//       be_themes_background_colors($be_themes_data[$section]['color'],$be_themes_data[$section]['opacity']);
//   } 
// }

function be_themes_set_backgrounds( $section ) {
  global $be_themes_data;
  
  $background_color = '';
  $background_image = '';
  $background_repeat = '';
  $background_attachment = '';
  $background_position = '';
  

  if( isset( $be_themes_data[$section]['background-color'] ) ) {

    $background_color = $be_themes_data[$section]['background-color'];
  }

  if( isset( $be_themes_data[$section]['background-repeat'] ) ) {
    $background_repeat = $be_themes_data[$section]['background-repeat'];
  }
  if( isset( $be_themes_data[$section]['background-attachment'] ) ) {
    $background_attachment = $be_themes_data[$section]['background-attachment'];
  }

  if( isset( $be_themes_data[$section]['background-position'] ) ) {
    $background_position = $be_themes_data[$section]['background-position'];
  }
 if( 'transparent' == $background_color ) {
      echo 'background: none;';
  } 
  elseif( !empty( $be_themes_data[$section]['background-image'] ) ) {
      $background_image=$be_themes_data[$section]['background-image'];
      echo 'background: '.$background_color.' url('.$background_image.') '.$background_repeat.' '.$background_attachment.' '.$background_position.';';
  } 
  else {
      if( !empty( $background_color ) ){
        be_themes_background_colors( $be_themes_data[$section]['background-color'], 1);//$be_themes_data[$section]['opacity'] );
    }
  }  
} 


/* ---------------------------------------------  */
// Function for printing background colors
/* ---------------------------------------------  */

function be_themes_background_colors( $color, $opacity ) {
  $rgb = be_themes_hexa_to_rgb( $color );  
  $color = $rgb[0].','.$rgb[1].','.$rgb[2];
  echo 'background-color: rgb('.$color.');'; 
  echo 'background-color: rgba('.$color.','.$opacity.');'; 
}
function be_themes_get_background_colors( $color, $opacity ) {
	$rgb = be_themes_hexa_to_rgb( $color );  
	$color = $rgb[0].','.$rgb[1].','.$rgb[2];
	$output = '';
	$output .= 'background-color: rgb('.$color.');'; 
	$output .= 'background-color: rgba('.$color.','.$opacity.');';
	return $output;
}

/* ---------------------------------------------  */
// Function for printing border
/* ---------------------------------------------  */

function be_themes_borders( $section , $position ) {
  global $be_themes_data;

  if (array_key_exists($position, $be_themes_data[$section] ) ) {
    $output = $be_themes_data[$section][$position].' '.$be_themes_data[$section]['border-style'].' '.$be_themes_data[$section]['border-color'];
  }elseif (array_key_exists('border-'.$position, $be_themes_data[$section] ) ) {
    // var_dump($be_themes_data[$section]['border-'.$position]);
    $output = $be_themes_data[$section]['border-'.$position].' '.$be_themes_data[$section]['border-style'].' '.$be_themes_data[$section]['border-color'];
  }else {

    $output = '' ;
  }

  return $output;

  // echo 'border-top: '.$be_themes_data[$section]['border-top'].' '.$be_themes_data[$section]['border-style'].' '.$be_themes_data[$section]['border-color']. '; ';
  // echo 'border-right: '.$be_themes_data[$section]['border-right'].' '.$be_themes_data[$section]['border-style'].' '.$be_themes_data[$section]['border-color']. '; ';
  // echo 'border-bottom: '.$be_themes_data[$section]['border-bottom'].' '.$be_themes_data[$section]['border-style'].' '.$be_themes_data[$section]['border-color']. '; ';
  // echo 'border-left: '.$be_themes_data[$section]['border-left'].' '.$be_themes_data[$section]['border-style'].' '.$be_themes_data[$section]['border-color']. '; ';
}


/* ---------------------------------------------  */
// Function for handling typography options
/* ---------------------------------------------  */

function be_themes_print_typography( $tag ) {
	global $be_themes_data;	    
  //$get_font =  get_font( $be_themes_data[$tag]['font-family'] );
  if( isset( $be_themes_data[$tag]['font-weight'] ) ) { 
    $weight = $be_themes_data[$tag]['font-weight']; 
  } 
  if( isset( $be_themes_data[$tag]['font-style'] ) ) { 
    $style = $be_themes_data[$tag]['font-style']; 
  } else { 
    $style = 'normal'; 
  } 
  $size = ( isset( $be_themes_data[$tag]['font-size'] ) ) ? $be_themes_data[$tag]['font-size'] : "" ;
  $color = ( isset( $be_themes_data[$tag]['color'] ) ) ? $be_themes_data[$tag]['color'] : "" ;
  $line_height = isset( $be_themes_data[$tag]['line-height'] )  ? $be_themes_data[$tag]['line-height'] : "" ;
  $letter_spacing = isset( $be_themes_data[$tag]['letter-spacing'] )  ? $be_themes_data[$tag]['letter-spacing'] : "" ;
  $text_transform = isset( $be_themes_data[$tag]['text-transform'] )  ? $be_themes_data[$tag]['text-transform'] : "" ;

  echo 'font: '.$style.' '.$weight.' '.$size.' "'.$be_themes_data[$tag]['font-family'].'","Open Sans","Arial",sans-serif; 
  color: '.$color.';
  line-height: '.$line_height.';
  letter-spacing: '.$letter_spacing.';
  text-transform: '.$text_transform.';';
}


/* ---------------------------------------------  */
// Function to obtain font selected
/* ---------------------------------------------  */

function get_font( $font_family ) {
  $font = explode( '/', $font_family );
  $font_type = $font[0];
  $font_name = $font[1];
  $assign_font = array();

  if( $font_type == 'google' ) {
      $google_font = explode(':',$font_name);
      $assign_font['name'] = $google_font[0];
      if( $font_weight = filter_var( $google_font[1], FILTER_SANITIZE_NUMBER_INT ) ) {
          $assign_font['weight'] =  $font_weight;
      }       
      if( strstr( $google_font[1], 'italic' ) ) {
          $assign_font['style'] = 'italic';
      }
      return $assign_font;  
  } else {
      $assign_font['name'] = $font_name;
      return $assign_font;
  }    
}function be_themes_print_typography_special_heading( $tag='h1', $size='13px' ) {	global $be_themes_data;	    	$get_font =  get_font( $be_themes_data[$tag]['family'] );	if( isset( $get_font['weight'] ) ) {     $weight = $get_font['weight']; 	} else { 		$weight = $be_themes_data[$tag]['weight']; 	}	if( isset( $get_font['style'] ) ) { 		$style = $get_font['style']; 	} else { 		$style = 'normal'; 	} 	echo 'font: '.$style.' '.$weight.' '.$size.' "'.$get_font["name"].'","Open Sans","Arial",sans-serif;';}
?>