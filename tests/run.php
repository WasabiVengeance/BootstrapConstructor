<?php

include_once(__DIR__.'/../lib/bsc.php');

global $output_path;
$output_path = '';
$nl = (isset($_SERVER['HTTP_HOST']))?'<br />':"\n";
$output  = __DIR__.'/generated/';
$compare = __DIR__.'/expected/';
$tests  = __DIR__.'/tests/';


$files = glob($output.'*');
foreach($files as $file)
{
	if(is_file($file))
		unlink($file); 
}


$fail_count = 0;
echo('Beginning test run'.$nl.' '.$nl);

$files = glob($tests.'*');
foreach($files as $file)
{
	if(is_file($file))
	{
		$name = str_replace(__DIR__.'/tests/','',str_replace('.php','',$file));
		$output_path = $output . $name.'.html';
		#echo($name.$nl);
		include($file);
		
		if(file_exists($output . $name.'.html'))
		{
			$to_test  = file_get_contents($output . $name.'.html');
		}
		else
		{
			$to_test = -1;
		}
		
		if(file_exists($output . $name.'.html'))
		{
			$good_val  = file_get_contents($compare . $name.'.html');
		}
		else
		{
			$good_val = -2;
		}
		
		echo($name.': ');
		
		if($to_test != $good_val)
			$fail_count++;
			
		$result = ($to_test == $good_val)?'SUCCESS':'FAIL';
		echo($result);
		echo($nl);
	}
}

echo('-----------------'.$nl);
if($fail_count == 0)
{
	echo('ALL TESTS PASS!'.$nl);
}
else
{
	echo($fail_count. ' TEST(S) FAILED'.$nl);
}



?>