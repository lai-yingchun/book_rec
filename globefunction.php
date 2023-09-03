<?php
function showtitle()
{
	echo '圖書館 書刊推薦系統';
}

function showheader()
{
	echo '
		<div style="padding:5px 0px 0px 5px;" >
			<a href="./reader_index.php" title="書刊推薦系統 - 中山醫學大學 圖書館">
				<img src="../imgs/logo.jpg" align="center" id="headerimg" alt="中山醫學大學-圖書館 書刊推薦系統" style="width:23%;">
			</a>
			
			<a href="javascript:logout()" style="font-size:20px; font-family:DFKai-sb; color:#203057; float:right;
                             margin-top:50px; margin-right:10px;">登出</a>
							
			<a href="./reader_index.php" title="回首頁">			 
            	<img src="../imgs/home.jpg" style="float:right; margin-top:45px; margin-right:150px; width:2%;">
			</a>
		</div>';
}

function showheader1()
{
	echo '
		<div style="padding:5px 0px 0px 5px;" >
			<a href="admin_index.php" title="書刊推薦系統 - 中山醫學大學 圖書館">
				<img src="../imgs/logo.jpg" align="center" id="headerimg" alt="中山醫學大學-圖書館 書刊推薦系統" style="width:23%;">
			</a>
			
			<a href="javascript:logout()" style="font-size:20px; font-family:DFKai-sb; color:#203057; float:right;
                             margin-top:50px; margin-right:10px;">登出</a>
					
			<a href="admin_index.php" title="回首頁">			 
            	<img src="../imgs/home.jpg" style="float:right; margin-top:45px; margin-right:175px; width:2%;">
			</a>
		</div>';
}