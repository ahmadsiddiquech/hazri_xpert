<?php
foreach($dynamic_page->result() as $row)
{
	echo $row->page_content;
}
?>
