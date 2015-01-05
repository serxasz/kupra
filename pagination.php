<?php
	$pagination = "";

	if($lastpage > 1)
	{	
		$pagination .= "<div class=\"pagination\">";

		//Go To first button
		if ($page != 1) {
			$pagination.= "<a href=\"$targetpage?page=1$customLimit\"><span class=\"glyphicon glyphicon-fast-backward\" ></span></a>";
		} else {
			$pagination.= "<span class=\"disabled glyphicon glyphicon-fast-backward\" ></span>";
		}

		//previous button
		if ($page > 1) 
			$pagination.= "<a href=\"$targetpage?page=$prev$customLimit\"><span class=\"glyphicon glyphicon-step-backward\" ></span></a>";
		else
			$pagination.= "<span class=\"disabled glyphicon glyphicon-step-backward\"></span>";	
		
		//pages	
		if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
					$pagination.= "<span class=\"current\">$counter</span>";
				else
					$pagination.= "<a href=\"$targetpage?page=$counter$customLimit\">$counter</a>";					
			}
		}
		elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
		{
			//close to beginning; only hide later pages
			if($page < 1 + ($adjacents * 2))		
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter$customLimit\">$counter</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage?page=$lpm1$customLimit\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage?page=$lastpage$customLimit\">$lastpage</a>";		
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$pagination.= "<a href=\"$targetpage?page=1$customLimit\">1</a>";
				$pagination.= "<a href=\"$targetpage?page=2$customLimit\">2</a>";
				$pagination.= "...";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter$customLimit\">$counter</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage?page=$lpm1$customLimit\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage?page=$lastpage$customLimit\">$lastpage</a>";		
			}
			//close to end; only hide early pages
			else
			{
				$pagination.= "<a href=\"$targetpage?page=1$customLimit\">1</a>";
				$pagination.= "<a href=\"$targetpage?page=2$customLimit\">2</a>";
				$pagination.= "...";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter$customLimit\">$counter</a>";					
				}
			}
		}
		
		//next button
		if ($page < $counter - 1) {
			$pagination.= "<a href=\"$targetpage?page=$next$customLimit\"><span class=\"glyphicon glyphicon-step-forward\" ></span></a>";
			$pagination.= "<a href=\"$targetpage?page=$lastpage$customLimit\"><span class=\"glyphicon glyphicon-fast-forward\" ></span></a>";
		} else {
			$pagination.= "<span class=\"disabled glyphicon glyphicon-step-forward\"></span>";
			$pagination.= "<span class=\"disabled glyphicon glyphicon-fast-forward\"></span>";
		}

		$pagination.= "</div>\n";
	}

	echo $pagination;
		?>