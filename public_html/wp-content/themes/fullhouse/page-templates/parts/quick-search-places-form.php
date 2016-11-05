<?php 
if( class_exists( "OpalEstate_Search") ): 
	$slocation  = isset($_GET['location'])?$_GET['location']:0;
	$stypes 	= isset($_GET['types'])?$_GET['types']:0;
	$sstatus 	= isset($_GET['status'])?$_GET['status']:0;

	$search_min_price = isset($_GET['min_price']) ? $_GET['min_price'] : 0;
	$search_max_price = isset($_GET['max_price']) ? $_GET['max_price'] : 10000000;
?>
<form id="opalestate-quick-search-form" class="opalestate-quick-search-form" action="<?php echo opalestate_get_search_link(); ?>" method="get">
<div class="quick-search-places-form row"> 
	
	<div class="col-lg-9 col-sm-10 col-xs-9">
		<div class="form-group">
			<input class="form-control" name="search_text" placeholder="<?php esc_html_e('Nhập vào tên dự án', 'fullhouse');?>">
		</div>
		<button type="submit" class="btn btn-danger btn-search"><i class="fa fa-search"></i></button>

	</div>
</div>	
</form>
<?php endif; ?>