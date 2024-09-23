<?php

// https://github.com/veerkun/wordpress-mce-preview-and-shortcode-editor/blob/master/README.md

/**
 * Class dtbaker_Shortcode_Banner
 * handles the creation of [boutique_banner] shortcode
 * adds a button in MCE editor allowing easy creation of shortcode
 * creates a wordpress view representing this shortcode in the editor
 * edit/delete button on wp view as well makes for easy shortcode managements.
 *
 * separate css is in style.content.css - this is loaded in frontend and also backend with add_editor_style
 *
 * Author: dtbaker@gmail.com
 * Copyright 2014
 */

class AdminTinyMCEIconShortcode
{
    // private static $instance = null;
    // public static function get_instance() {
    //     if ( ! self::$instance )
    //         self::$instance = new self;
    //     return self::$instance;
    // }

	// public function init(){
	// 	// comment this 'add_action' out to disable shortcode backend mce view feature
	// 	add_action( 'admin_init', array( $this, 'init_plugin' ), 20 );

    //     add_shortcode('boutique_banner', array($this,'dtbaker_shortcode_banner'));
	// }

    public static function register_functions_admin()
	{
		$handler = new self();

        add_action( 'print_media_templates', [ $handler, 'print_media_templates' ] );

        add_action( 'admin_print_footer_scripts', [ $handler, 'admin_print_footer_scripts' ], 100 );

	    add_action( 'wp_ajax_dtbaker_mce_banner_button', [ $handler, 'wp_ajax_dtbaker_mce_banner_button' ] );

	    // if ( current_user_can('edit_posts') || current_user_can('edit_pages') )
		// {
		    add_filter( 'mce_external_plugins', [ $handler, 'mce_plugin'] );

		    add_filter( 'mce_buttons', [ $handler, 'mce_button'] );
	    // }

		add_action( 'admin_init', [ $handler, 'init_plugin' ], 20 );

        add_shortcode( 'boutique_banner', [ $handler, 'dtbaker_shortcode_banner' ] );
        
		// add_shortcode( 'mc-icon', [ $handler, 'add_shortcode_mc_icon' ] );
    }

	// front end shortcode displaying:

	// public function add_shortcode_mc_icon( $atts = [], $innercontent = '', $code = '' )
	
	public static function dtbaker_shortcode_banner( $atts = [], $innercontent = '', $code = '' )
	{
	    extract(
			shortcode_atts(
				[
					'id' => false,

					'title' => 'Special:',

					'link' => '',

					'linkhref' => '',
				],
				
				$atts
			)
		);

	    $banner_id = strtolower( preg_replace( '#\W+#', '', $title ) );

	    ob_start();

	    ?>
		<div class="full_banner" id="banner_<?php echo $banner_id;?>">
		    <span class="title"><?php echo $title;?></span>
		    <span class="content"><?php echo $innercontent;?></span>
		    <?php if($link && $linkhref){ ?>
		    <a href="<?php echo $linkhref;?>" class="link dtbaker_button_light"><?php echo $link;?></a>
		    <?php } ?>
		</div>
		<?php

	    return ob_get_clean();
	}

	public static function wp_ajax_dtbaker_mce_banner_button()
	{
		header("Content-type: text/javascript");

		?>
		( function() {
		    tinymce.PluginManager.add( 'dtbaker_mce_banner', function( editor, url ) {
		        editor.addButton( 'dtbaker_mce_banner_button', {
		            text: 'Banner',
		            icon: false,
		            onclick: function() {
		                wp.mce.boutique_banner.popupwindow(editor);
		            }
		        } );
		    } );
		} )();
		<?php

		die();
	}

	public static function mce_plugin( $plugin_array )
	{
		$plugin_array[ 'dtbaker_mce_banner' ] = admin_url( 'admin-ajax.php?action=dtbaker_mce_banner_button' );

		return $plugin_array;
	}

	public static function mce_button( $buttons )
	{
        array_push( $buttons, 'dtbaker_mce_banner_button' );

		return $buttons;
	}

    /**
     * Outputs the view inside the wordpress editor.
     */

    public static function print_media_templates()
	{
        if ( ! isset( get_current_screen()->id ) || get_current_screen()->base != 'post' )
            return;
        ?>
        <script type="text/html" id="tmpl-editor-boutique-banner">
			<div class="boutique_banner_{{ data.type }}"></div>
	        <div class="full_banner" id="banner_{{ data.id }}">
			    <span class="title">{{ data.title }}</span>
			    <span class="content">{{ data.innercontent }}</span>
		        <# if ( data.link ) { #>
		            <# if ( data.linkhref ) { #>
			            <a href="{{ data.linkhref }}" class="link dtbaker_button_light">{{ data.link }}</a>
					<# } #>
				<# } #>
			</div>
		</script>
        <?php
    }

    public static function admin_print_footer_scripts()
	{
        if ( ! isset( get_current_screen()->id ) || get_current_screen()->base != 'post' )
            return;
        ?>
	    <script type="text/javascript">
		    (function($){
			    var media = wp.media, shortcode_string = 'boutique_banner';
			    wp.mce = wp.mce || {};
			    wp.mce.boutique_banner = {
				    shortcode_data: {},
					View: {
						template: media.template( 'editor-boutique-banner' ),
						postID: $('#post_ID').val(),
						initialize: function( options ) {
							this.shortcode = options.shortcode;
							wp.mce.boutique_banner.shortcode_data = this.shortcode;

						},
						getHtml: function() {
							var options = this.shortcode.attrs.named;
							options['innercontent'] = this.shortcode.content;
							return this.template(options);
						}
					},
				    edit: function( node ) {
						var data = window.decodeURIComponent( $( node ).attr('data-wpview-text') );
					    console.debug(this);
					    var values = this.shortcode_data.attrs.named;
						values['innercontent'] = this.shortcode_data.content;
					    console.log(values);

					    wp.mce.boutique_banner.popupwindow(tinyMCE.activeEditor, values);
						//$( node ).attr( 'data-wpview-text', window.encodeURIComponent( shortcode ) );
					},
				    // this is called from our tinymce plugin, also can call from our "edit" function above
				    // wp.mce.boutique_banner.popupwindow(tinyMCE.activeEditor, "bird");
				    popupwindow: function(editor, values, onsubmit_callback){
					    if(typeof onsubmit_callback != 'function'){
						    onsubmit_callback = function( e ) {
		                        // Insert content when the window form is submitted (this also replaces during edit, handy!)
							    var s = '[' + shortcode_string;
							    for(var i in e.data){
								    if(e.data.hasOwnProperty(i) && i != 'innercontent'){
									    s += ' ' + i + '="' + e.data[i] + '"';
								    }
							    }
							    s += ']';
							    if(typeof e.data.innercontent != 'undefined'){
								    s += e.data.innercontent;
								    s += '[/' + shortcode_string + ']';
							    }
		                        editor.insertContent( s );
		                    };
					    }
		                editor.windowManager.open( {
		                    title: 'Banner',
		                    body: [
			                    {
			                        type: 'textbox',
			                        name: 'title',
			                        label: 'Title',
				                    value: values['title']
		                        },
			                    {
			                        type: 'textbox',
			                        name: 'link',
			                        label: 'Button Text',
				                    value: values['link']
		                        },
			                    {
			                        type: 'textbox',
			                        name: 'linkhref',
			                        label: 'Button URL',
				                    value: values['linkhref']
		                        },
			                    {
			                        type: 'textbox',
			                        name: 'innercontent',
			                        label: 'Content',
				                    value: values['innercontent']
		                        }
		                    ],
		                    onsubmit: onsubmit_callback
		                } );
				    }
				};
			    wp.mce.views.register( shortcode_string, wp.mce.boutique_banner );
			}(jQuery));
	    </script>

        <?php
    }
}

// dtbaker_Shortcode_Banner::get_instance()->init();