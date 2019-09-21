<?php

if (!function_exists('sub_string')) {

    function sub_string($string, $numberOfWords = 25, $pattern) {
        $contentWords = substr_count($string, " ") + 1;
        $words = explode(" ", $string, ($numberOfWords + 1));
        if ($contentWords > $numberOfWords) {
            $words[count($words) - 1] = $pattern;
        }
        return join(" ", $words);
    }

}

if ( ! function_exists('remove_directory'))
{
function remove_directory($directory, $empty=FALSE)
{
    if(substr($directory,-1) == '/') {
        $directory = substr($directory,0,-1);
    }

    if(!file_exists($directory) || !is_dir($directory)) {
        return FALSE;
    } elseif(!is_readable($directory)) {

    return FALSE;

    } else {

        $handle = opendir($directory);
        while (FALSE !== ($item = readdir($handle)))
        {
            if($item != '.' && $item != '..') {
                $path = $directory.'/'.$item;
                if(is_dir($path)) {
                    remove_directory($path);
                }else{
                    unlink($path);
                }
            }
        }
        closedir($handle);
        if($empty == FALSE)
        {
            if(!rmdir($directory))
            {
                return FALSE;
            }
        }
    return TRUE;
    }
}
}

if (!function_exists('filesize_r')) {
	function filesize_r($path){
	  if(!file_exists($path)) return 0;
	  if(is_file($path)) return filesize($path);
	  $ret = 0;
	  foreach(glob($path."/*") as $fn)
	    $ret += filesize_r($fn);
	  return $ret/1000000;
	}
}

if (!function_exists('format_date_without_date')) {

    function format_date_without_date($date) {
       
        $query3 = Modules::run('general_setting/_get_where', 1);
        foreach ($query3->result() as
                $row) {
            $date_format = $row->date_format;
        }
    

    if (isset($date_format)) {
        if ($date_format == 1) {
            if (isset($date) && $date != '' && $date != "1970-01-01") {
                return date('Y/m/d', strtotime($date));
            } else {
                return '';
            }
        } else if ($date_format == 2) {
            if (isset($date)&& $date != '' && $date != "1970-01-01") {
                return date('m/d/Y', strtotime($date));
            } else {
                 return '';
            }
        } else if ($date_format == 3) {
            if (isset($date)&& $date != '' && $date != "1970-01-01") {
                return date('d/m/Y', strtotime($date));
            } else {
                 return '';
            }
        }
    }
}
}

if (!function_exists('format_date_js')) {
    function format_date_js($date) {
            if (isset($date) && $date != "1970-01-01" && $date != '') {
				list($year,$month,$day) = explode('-',$date);
				$month = $month-1;
				$date  = $year .",".$month.",".$day;  
                return $date;
            } 
			else
			{
				return '';
			}
 }
}

if (!function_exists('format_date')) {

    function format_date($date) {

    	//print '<br> date here ====>>'.DEFAULT_DATE_FORMAT;exit;
    	//return($date);
       
      /*  $row = Modules::run('general_setting/_get_where_custom', 'outlet_id', DEFAULT_OUTLET)->row();

        print_r($row);exit;
        if (isset($row) && !empty($row))
        	$date_format = $row->date_format;
        else */
        	$date_format = DEFAULT_DATE_FORMAT;
        	//$date_format = 3;

        //print '<br> date here ====>>'.$date_format;
        //exit;
		//return($date);
    if (isset($date_format)) {
        if ($date_format == 1) {
            if (isset($date) && $date != "1970-01-01" && $date != '0000-00-00' && $date != '') {
                return date('Y/m/d', strtotime($date));
            } 
			else{
                return date('Y/m/d');
            }
        } 
		else if ($date_format == 2) {
            if (isset($date) && $date != "1970-01-01" && $date != '0000-00-00'  && $date != '') {

            	//print '<br> date here ====>>'.strtotime($date);
            	//print '<br> date here ====>>'.date('m/d/Y', strtotime($date));
               	return date('m/d/Y', strtotime($date));
            } 
			else {
                 return date('m/d/Y');
            }
        } 
		else if ($date_format == 3) {
            if (isset($date) && $date != "1970-01-01" && $date != '0000-00-00'  && $date != '') {
              return date('d/m/Y', strtotime($date));
            } 
			else {
                return date('d/m/Y');
            }
        }
    }
 }
}

if (!function_exists('format_date_time')) {

    function format_date_time($datetime) {
       
       $date_format = DEFAULT_DATE_FORMAT;
       $time_format = DEFAULT_TIME_FORMAT;
		
		if (isset($date_format)) {
		if ($date_format == 1) {
			$date =  "Y/m/d";
		}
		 else if ($date_format == 2) {
			
			$date =  "m/d/Y";
		}
		 else if ($date_format == 3) {
			$date =  "d/m/Y";
		}
	}
	if (isset($time_format)) {
		if ($time_format == 1) {
			$time =  "h:i AM";
		}
		 else if ($time_format == 2) {
			
			$time =  "h:i am";
		}
		 else if ($time_format == 3) {
			$time =  "H:i";
		}
	}
	
	if (isset($datetime) && $datetime != "0000-00-00 00:00:00" && $datetime != '') {
           return date($date.' '.$time, strtotime($datetime));
       }
	   else{
		   	return date($date.' '.$time);
		  }
}
}

if (!function_exists('get_general_date_format')) {

    function get_general_date_format() {
		//echo'cosntact==>>'.OUTLET_ID;
		$row = Modules::run('general_setting/_get_where_custom', 'outlet_id', DEFAULT_OUTLET)->row();
		if (isset($row) && !empty($row))
        	$date_format = $row->date_format;
        else 
        	$date_format = 1;

				    if (isset($date_format)) {
					if ($date_format == 1) {
							return "yyyy/mm/dd";
						}
					 else if ($date_format == 2) {
						
							return "mm/dd/yyyy";
						}
					 else if ($date_format == 3) {
						   return "dd/mm/yyyy";
						}
				}
			}
}
if (!function_exists('format_db_date')) {
	function format_db_date($datetime) {	
		$arr_date = explode(' ',$datetime);
		$date = $arr_date[0];
		$time = '';
		if(isset($arr_date[1]))
			$time = $arr_date[1];
		if(isset($arr_date[2]))
			$time = $time.' '.$arr_date[2];
        $date_format = DEFAULT_DATE_FORMAT;
		if (isset($date_format) && $date != '' && $time != '') {
			if ($date_format == 1) {
					$date = str_replace('/', '-', $date);
					if(isset($date) && !empty($date)) { 
					list($year,$month,$day) = explode('-',$date);
					$date  = $day."-".$month."-".$year.' '.$time;  
					$date = date('Y-m-d H:i', strtotime($date));
					return $date;
						}
			}
			 else if ($date_format == 2) {
					$date = str_replace('/', '-', $date);
					if(isset($date) && !empty($date)) { 
					list($month,$day,$year) = explode('-',$date);
					$date  = $day."-".$month."-".$year.' '.$time;  
					$date = date('Y-m-d H:i', strtotime($date));
					return $date;
					}
			 }
			 else if ($date_format == 3) {
				   	$date = str_replace('/', '-', $date);
					if(isset($date) && !empty($date)) { 
					list($day,$month,$year) = explode('-',$date);
					$date  = $day."-".$month."-".$year.' '.$time;  
					$date = date('Y-m-d H:i', strtotime($date));
					return $date;
					}
				}
		}	
			else if(isset($date_format)) {
				if ($date_format == 1) {
						$date = str_replace('/', '-', $datetime);
						if(isset($date) && !empty($date)) { 
						list($year,$month,$day) = explode('-',$date);
						$date  = $day."-".$month."-".$year;  
						$date = date('Y-m-d', strtotime($date));
						return $date;
							}
				}
				 else if ($date_format == 2) {
						$date = str_replace('/', '-', $datetime);
						
						if(isset($date) && !empty($date)) { 
						list($month,$day,$year) = explode('-',$date);
						$date  = $day."-".$month."-".$year;  
						$date = date('Y-m-d', strtotime($date));
						return $date;
						}
				 }
				 else if ($date_format == 3) {
					   	$date = str_replace('/', '-', $datetime);
						if(isset($date) && !empty($date)) { 
						list($day,$month,$year) = explode('-',$date);
						$date  = $day."-".$month."-".$year;  
						$date = date('Y-m-d', strtotime($date));
						return $date;
						}
					}
			}
		}
		}

if (!function_exists('current_date')) {

    function current_date() {
		
	//$row = Modules::run('general_setting/_get_where', 1)->row();
	$date_format = DEFAULT_DATE_FORMAT;
	if (isset($date_format)) {
		if ($date_format == 1) {
				return date("Y/m/d");
			}
			else if ($date_format == 2) {
				return date("m/d/Y");
			}
			else{ //$date_format == 3
			   return date("d/m/Y");
			}
		}

    }
}

if (!function_exists('date_time_format')) {

    function date_time_format() {
		
	$row = Modules::run('general_setting/_get_where', 1)->row();
	
	$date_format = $row->date_format;
	$time_format = $row->time_format;
	if (isset($date_format)) {
		if ($date_format == 1) {
			$date =  "yyyy/mm/dd";
		}
		 else if ($date_format == 2) {
			
			$date =  "mm/dd/yyyy";
		}
		 else if ($date_format == 3) {
			$date =  "dd/mm/yyyy";
		}
	}
	if (isset($time_format)) {
		if ($time_format == 1) {
			$time =  "hh:ii A";
		}
		 else if ($time_format == 2) {
			
			$time =  "hh:ii a";
		}
		 else if ($time_format == 3) {
			$time =  "hh:ii";
		}
	}
	
	return $date.' '.$time;
  }
 }

if (!function_exists('convert_number_to_words')) {
	function convert_number_to_words($number) {
		$hyphen      = '-';
		$conjunction = ' and ';
		$separator   = ', ';
		$negative    = 'negative ';
		$decimal     = ' point ';
		$dictionary  = array(0 => 'zero', 1 => 'one', 2 => 'two', 3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six', 7 => 'seven', 8 => 'eight', 9 => 'nine', 10 => 'ten', 11 => 'eleven', 12 => 'twelve', 13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen', 16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen', 19 => 'nineteen', 20 => 'twenty', 30 => 'thirty', 40 => 'fourty', 50 => 'fifty', 60 => 'sixty', 70 => 'seventy', 80 => 'eighty', 90 => 'ninety', 100 => 'hundred', 1000 => 'thousand', 1000000 => 'million', 1000000000 => 'billion', 1000000000000 => 'trillion', 1000000000000000 => 'quadrillion', 1000000000000000000 => 'quintillion');
		
		if (!is_numeric($number)) {
			return false;
		}
		
		if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
			trigger_error(
				'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
				E_USER_WARNING
			);
			return false;
		}
	
		if ($number < 0) {
			return $negative . convert_number_to_words(abs($number));
		}
		
		$string = $fraction = null;
		
		if (strpos($number, '.') !== false) {
			list($number, $fraction) = explode('.', $number);
		}
		
		switch (true) {
			case $number < 21:
				$string = $dictionary[$number];
				break;
			case $number < 100:
				$tens   = ((int) ($number / 10)) * 10;
				$units  = $number % 10;
				$string = $dictionary[$tens];
				if ($units) {
					$string .= $hyphen . $dictionary[$units];
				}
				break;
			case $number < 1000:
				$hundreds  = $number / 100;
				$remainder = $number % 100;
				$string = $dictionary[$hundreds] . ' ' . $dictionary[100];
				if ($remainder) {
					$string .= $conjunction . convert_number_to_words($remainder);
				}
				break;
			default:
				$baseUnit = pow(1000, floor(log($number, 1000)));
				$numBaseUnits = (int) ($number / $baseUnit);
				$remainder = $number % $baseUnit;
				$string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
				if ($remainder) {
					$string .= $remainder < 100 ? $conjunction : $separator;
					$string .= convert_number_to_words($remainder);
				}
				break;
		}
		
		if (null !== $fraction && is_numeric($fraction)) {
			$string .= $decimal;
			$words = array();
			foreach (str_split((string) $fraction) as $number) {
				$words[] = $dictionary[$number];
			}
			$string .= implode(' ', $words);
		}
		
		return ucwords($string);
	}
}

?>