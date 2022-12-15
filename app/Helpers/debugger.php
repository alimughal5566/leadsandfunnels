<?php
if(!function_exists('lp_debug')){
    function lp_debug($expression, $expression_note="", $break=1, $backtrace_enable=false, $backtrace_limit=1){
        $bt = debug_backtrace();
        //$caller = array_shift($bt);
        $caller = $bt[$backtrace_limit-1];
        $file= @$caller['file'];
        $line= @$caller['line'];

        $file= str_replace($_SERVER['DOCUMENT_ROOT'], '', $file);

        if(php_sapi_name() === 'cli'){
            $is_cli = true;
            $break_tag = "\n";
            $reference_line = "--------------------------------------------------------------\n"."Line # ".$line." - ".$file.$break_tag."--------------------------------------------------------------\n";
        }else {
            $is_cli = false;
            $break_tag = "<br />";
            $reference_line = "&nbsp; <span style='color:#BB1F23'> &#8618; Line # ".$line." &nbsp;<strong>&#8667;</strong>&nbsp;  ".$file.'</span>'.$break_tag;

            if($backtrace_enable) {
                $backtrace = "";
                if ( isset( $bt[1] ) ) {
                    foreach ( $bt as $z => $k ) {
                        if ( $z == 0 ) {
                            continue;
                        }
                        if ( !array_key_exists('line', $k)) {
                            break;
                        }
                        $backtrace .= "&nbsp; <span style='color:#BB1F23'>— Line # " . @$k['line'] . " &nbsp;<strong>&#8667;</strong>&nbsp;  " . str_replace( $_SERVER['DOCUMENT_ROOT'], '', @$k['file'] ) . '</span>' . $break_tag;;

                        if(($z+1) == $backtrace_limit){
                            break;
                        }
                    }
                }

                if ( $backtrace ) {
                    $reference_line .= $backtrace . $break_tag;
                }
            }
        }

        echo $reference_line;
        if($expression_note) {
            if($is_cli){
                echo " ==> ==> ".$expression_note.$break_tag.$break_tag;
            }else{
                echo "<span style='color:#3100ED'>$expression_note <strong style='font-size: 14px'>&#8674;</strong> </span>";
            }
        }
        if(is_array($expression) || is_object($expression)){
            echo "<pre>".print_r($expression,1)."</pre>";
        }else{
            if(!$expression){
                echo var_dump($expression).$break_tag;
            }else{
                echo $expression.$break_tag;
            }
        }

        if($break){
            exit;
        }
    }
}

if(!function_exists('debug')){
    function debug($expression, $expression_note="", $break=1, $backtrace_enable=false, $backtrace_limit=2){
        lp_debug($expression, $expression_note, $break, $backtrace_enable, $backtrace_limit);
    }
}

if(!function_exists('lp_debug_txt')){
	function lp_debug_txt($expression, $expression_note="", $break=1){
		$bt = debug_backtrace();
		$caller = array_shift($bt);
		$file= basename($caller['file']);
		$line= $caller['line'];

		$file= str_replace($_SERVER['DOCUMENT_ROOT'], '', $file);

		$is_cli = true;
		$break_tag = "\n";
		$reference_line = "------------------------------\n"."Line - ".$line." - ".$file.$break_tag."------------------------------\n";

		echo $reference_line;
		if($expression_note) {
			echo "## [ ".$expression_note." ] ##".$break_tag;
		}
		if(is_array($expression) || is_object($expression)){
			echo print_r($expression,1);
		}else{
			if(!$expression){
				echo var_dump($expression).$break_tag;
			}else{
				echo $expression.$break_tag;
			}
		}

		echo $break_tag.$break_tag;

		if($break){
			exit;
		}
	}
}
