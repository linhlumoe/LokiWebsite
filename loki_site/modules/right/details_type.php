<div class="row">
	<?php
		$catalog_id = $_GET['id'];
		$sql_catalog = "select * from catalog where catalog_id = $catalog_id";
		$run_catalog = mysql_query($sql_catalog);
		$row_catalog = mysql_fetch_array($run_catalog);
		$parent_id = $row_catalog['parent_id'];
		$sql_parent = "select * from catalog where catalog_id = $parent_id";
		$run_parent = mysql_query($sql_parent);
		$row_parent = mysql_fetch_array($run_parent);
	?>
    <h3 align="center" class="col-md-12 col-sm-12 col-xs-12">
    	<a href="#" style="text-transform:uppercase; text-decoration:none;">
			<strong><?php echo $row_parent['catalog_name']?> - <?php echo $row_catalog['catalog_name']?></strong></a></h3>
    <div class="row" >

    </div>
    <br />
 	<?php
		if(isset($_GET['page'])) {
			$pg = $_GET['page'];
		} else {
			$pg = 1;
		}
		if ($pg == '' || $pg == 1) {
			$pg1 = 0;		
		}
		else
			$pg1 = ($pg - 1) * 16;
		$sql_date = "select * from product where catalog_id = $catalog_id order by date desc limit $pg1, 16";
		$run_date = mysql_query($sql_date);
		while ($row_date = mysql_fetch_array($run_date)) {
			if ($row_date['discount'] > 0) { $sale_price = $row_date['price'] * (1 - $row_date['discount']/100); 
	?>
    <div class="col-md-3"><span class="label label-danger" style="font-size:12px;">Sale <?php echo $row_date['discount'] ?>%</span>
        <div class="thumbnail"> 
            <div class="caption"> 
                <h4 style=" text-transform:capitalize;"><?php echo $row_date['product_name'] ?></h4>
                 
                <p class="price" style=" text-decoration:line-through; background-color:#C66;"> 
					<?php echo number_format($row_date['price'],0) ?> vnđ</p>
                <p style="font-size:17px; font-weight:bold; text-transform:uppercase; background-color:#C33;"> 
					<?php echo number_format($sale_price,0) ?> vnđ</p>
                <p style="margin-top:20px;">
                	<a href="index.php?view=details_product&id=<?php echo $row_date['product_id'] ?>" class="btn btn-success" rel="tooltip">Xem chi tiết</a> 
            </div> <img src="admincp/modules/mnproduct/uploaded/<?php echo $row_date['image']?>" alt="<?php echo $row_date['product_name'] ?>"> 
        </div> 
        
    </div> 
    <?php }else {?>
    <div class="col-md-3" style="margin-top:12px;">
        <div class="thumbnail"> 
            <div class="caption"> 
                <h4 style=" text-transform:capitalize;"><?php echo $row_date['product_name'] ?></h4> 
                <p class="price" style="background-color:#C33;"> <?php echo number_format($row_date['price'],0) ?> vnđ</p>
                <p style="margin-top:20px;"><a href="index.php?view=details_product&id=<?php echo $row_date['product_id'] ?>" class="btn btn-success" rel="tooltip">Xem chi tiết</a> 
            </div> <img src="admincp/modules/mnproduct/uploaded/<?php echo $row_date['image']?>" alt="<?php echo $row_date['product_name'] ?>"> 
        </div> 
    </div> 
    <?php
		}
		}
	?>       
    <span><br/></span> 
</div>

<center><ul class="pagination">
<?php
	if($pg == '' || $pg == 1)
		echo '<li class="disabled"><a href="#">&laquo;</a></li>';
	else
		echo '<li><a href="?view=details_type&id='.$catalog_id.'&page='.($pg - 1).'">&laquo;</a></li>';

	$query_page = mysql_query("select * from product where catalog_id = $catalog_id ");
	$count = mysql_num_rows($query_page);
	$page = ceil($count/16);

	for($i = 1; $i <= $page; $i++) {
		if($pg == $i)
			echo '<li class="active"><a href="?view=details_type&id='.$catalog_id.'&page='.$i.'"> '.$i.'</a></li>';
		else
			echo '<li><a href="?view=details_type&id='.$catalog_id.'&page='.$i.'"> '.$i.'</a></li>';
		
	}
	
	if($pg == $page)
		echo '<li class="disabled"><a href="#">&raquo;</a></li>';
	else
		echo '<li><a href="?view=details_type&id='.$catalog_id.'&page='.($pg + 1).'">&raquo;</a></li>';
?>

</ul></center>