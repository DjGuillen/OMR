<?php
	function session_validate()
	{
		if(isset($_SESSION['vrijeme_pristupa']))
		{
			$vrijeme = time();
			if($vrijeme - $_SESSION['vrijeme_pristupa']>900)
			{
				session_unset();
				header("Location:index.php");
			}
			else
			{
				$_SESSION['vrijeme_pristupa'] = $vrijeme;
			}
		}
		else
		{
			$vrijeme = time();
			$_SESSION['vrijeme_pristupa'] = $vrijeme;
		}
	}
?>