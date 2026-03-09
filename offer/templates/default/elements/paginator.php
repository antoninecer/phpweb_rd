<nav>
	<?php
	if (isset($tpl['paginator']))
	{		
		if($tpl['paginator']['pages'] > 1)
		{
			$page = 1 ;
			$query_string = $_SERVER['QUERY_STRING'];
			if(empty($query_string)){
				$query_string = "controller=pjListings&amp;action=pjActionProperties";
			}
			if(isset($_GET['pjPage'])){
				$page = $_GET['pjPage'];
				$query_string = str_replace("&pjPage=" . $page, "", $query_string);
			}
			?>
			<ul class="pagination pjPplPagination">
				<?php
				$stages = 3;
				$lastpage = $tpl['paginator']['pages'];
									
				if ($page > 1)
				{
					?><li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo $query_string;?>&amp;pjPage=<?php echo $page - 1; ?>" ><?php __('front_layout1_prev');?></a></li><?php
				}
				 
				if ($lastpage < 7 + ($stages * 2))
				{
					for ($counter = 1; $counter <= $lastpage; $counter++)
					{
						if ($counter == $page)
						{
							?><li class="active"><span><?php echo $counter; ?></span></li><?php
						}else{
							?><li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo $query_string;?>&amp;pjPage=<?php echo $counter; ?>" ><?php echo $counter; ?></a></li><?php
						}
					}
				} else if ($lastpage > 5 + ($stages * 2)){
					
					if($page < 1 + ($stages * 2))		
					{
						for ($counter = 1; $counter < 4 + ($stages * 2); $counter++)
						{
							if ($counter == $page){
								?><li class="active"><span><?php echo $counter; ?></span></li><?php
							}else{
								?><li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo $query_string;?>&amp;pjPage=<?php echo $counter; ?>" ><?php echo $counter; ?></a></li><?php
							}	
						}
						?>
						<li><span>.</span></li>
						<li><span>.</span></li>
						<li><span>.</span></li>
						<li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo $query_string;?>&amp;pjPage=<?php echo $lastpage - 1; ?>" ><?php echo $lastpage - 1; ?></a></li>
						<li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo $query_string;?>&amp;pjPage=<?php echo $lastpage; ?>" ><?php echo $lastpage; ?></a></li>
						<?php
					}else if($lastpage - ($stages * 2) > $page && $page > ($stages * 2)){
						?>
						<li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo $query_string;?>&amp;pjPage=1" >1</a></li>
						<li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo $query_string;?>&amp;pjPage=2" >2</a></li>
						<li><span>.</span></li>
						<li><span>.</span></li>
						<li><span>.</span></li>
						<?php
						for ($counter = $page - $stages; $counter <= $page + $stages; $counter++){
							if ($counter == $page)
							{
								?><li class="active"><span><?php echo $counter; ?></span></li><?php
							}else{
								?><li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo $query_string;?>&amp;pjPage=<?php echo $counter; ?>" ><?php echo $counter; ?></a></li><?php
							}
						}
						?>
						<li><span>.</span></li>
						<li><span>.</span></li>
						<li><span>.</span></li>
						<li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo $query_string;?>&amp;pjPage=<?php echo $lastpage - 1; ?>" ><?php echo $lastpage - 1; ?></a></li>
						<li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo $query_string;?>&amp;pjPage=<?php echo $lastpage; ?>" ><?php echo $lastpage; ?></a></li>
						<?php
					}else{
						?>
						<li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo $query_string;?>&amp;pjPage=1" >1</a></li>
						<li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo $query_string;?>&amp;pjPage=2" >2</a></li>
						<li><span>.</span></li>
						<li><span>.</span></li>
						<li><span>.</span></li>
						<?php
						for ($counter = $lastpage - (2 + ($stages * 2)); $counter <= $lastpage; $counter++)
						{
							if ($counter == $page)
							{
								?><li class="active"><span><?php echo $counter; ?></span></li><?php
							}else{
								?><li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo $query_string;?>&amp;pjPage=<?php echo $counter; ?>" ><?php echo $counter; ?></a></li><?php
							}
						}
					}	
				}
				if ($page < $counter - 1){
					 ?><li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo $query_string;?>&amp;pjPage=<?php echo $page + 1; ?>" ><?php __('front_layout1_next');?></a></li><?php
				}
				?>
			</ul>
			<?php
		}
	} 
	?>
</nav>