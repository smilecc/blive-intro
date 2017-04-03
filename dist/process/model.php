
		<div style="
		background-image: url(<?php echo $bgimg; ?>);
		height: 225px;
		border-radius: 10px;
		overflow: hidden;
		box-shadow: 5px 5px 20px rgba(51, 51, 51, 0.5);
		">

		<?php foreach ($tabArr as $key => $value) {?>
		<div style="height: 225px;" id="can_node<?php echo $key; ?>">
			<div style="width: 100%;text-align: center;padding-top: 10px;padding-bottom: 5px;">
				<?php foreach ($tabArr as $k => $val) {?>
					<a href="<?php echo $liveurl; ?>#can_node<?php echo $k; ?>" target="_self" style="
					text-decoration:none;
					color: #FFF;
					border-radius: 2px;
					box-shadow: 1px 1px 15px rgba(51, 51, 51, 0.5);
					background-color: <?php echo $key==$k?$val['colorhigh']:$val['colorlow']; ?>;
					font-size: 16px;
					margin: 0px 15px 0px 0px;
					padding: 3px 5px;
	    			"><?php echo $val['name']; ?></a>
    			<?php } ?>
			</div>

			<div style="width: 200px; height: 186px;float: left;">
				<div style="border: 2px white solid;
width: 140px;
height: 140px;
margin-left: 25px;
margin-top: 10px;
background-size: 100% auto;background-image: url(<?php echo $displayimg; ?>);
border-radius: 50%;
"></div>
				<div style="color: white;text-align: center; margin-top: 3px;">来自 <a href="http://bintro.smilec.org/" style="color: #bbb;">Bilibili Live 简介生成器</a></div>
			</div>
			<div style="width: 753px; height: 186px;float: left;">
				<div style="background-color: rgba(255,255,255,0.5);
				color: black;
			    height: 140px;
			    margin-top: 9px;
				padding: 10px;
				border-radius: 5px;
				color: white;
				font-size: 15px;
				text-shadow: black 1px 1.5px 1px;">
				<?php echo $value['intro']; ?></div>
			</div>
			<div style="width: 200px; height: 186px;float: left;">
				<div style="border: 2px white solid;
width: 140px;
height: 140px;
margin-left: 25px;
margin-top: 10px;
background-size: 100% auto;
background-repeat: no-repeat;background-image: url(<?php echo $qrimg; ?>);">
				</div>
				<div style="color: white;text-align: center; margin-top: 3px;"><?php echo $qrintro; ?></div>
			</div>

		</div>
		<?php } ?>

		</div>
