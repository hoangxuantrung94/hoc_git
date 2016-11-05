
<!-- AddThis Smart Layers BEGIN -->
<!-- Go to http://www.addthis.com/get/smart-layers to customize -->
<?php $js_url= '//s7.addthis.com/js/300/addthis_widget.js';
        if(!empty($idAddthis)){
            $js_url.='#pubid='. $idAddthis;
        }
?>
    <script type="text/javascript" src="<?php echo esc_js( $js_url ); ?>"></script>
    <script type="text/javascript">
        var share_mobile = <?php echo ($instance['show_mobile']==1)? 'true' : 'false'; ?>;
        addthis.layers({
            'theme' : '<?php echo esc_js( $instance["skin"] ); ?>',
            'share' : {
                'position' : '<?php echo esc_js( $instance["position"] ); ?>',
                'services' : '<?php echo esc_js( $services); ?>',
                'desktop' : true,
                'mobile' : share_mobile,
                'theme' : '<?php echo esc_js( $instance["skin"] ); ?>'
            }
        });
    </script>
<!-- AddThis Smart Layers BEGIN -->
<!-- Go to http://www.addthis.com/get/smart-layers to customize -->
