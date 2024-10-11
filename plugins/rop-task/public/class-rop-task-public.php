<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.linkedin.com/in/asimehmood
 * @since      1.0.0
 *
 * @package    Rop_Task
 * @subpackage Rop_Task/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Rop_Task
 * @subpackage Rop_Task/public
 * @author     Asim <i.m.rajaasim@gmail.com>
 */
class Rop_Task_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		add_action('wp_head', array($this,'redirect_users_by_ip'));
		add_action('init', array($this,'register_projects_post_type'));
		add_action('init', array($this,'register_project_type_taxonomy'));
		add_shortcode('get_projects',array($this,'get_projects'));
		add_shortcode('get_coffee',array($this,'get_coffee'));
		add_shortcode('quotes',array($this,'quotes'));

	}

	public function quotes()
	{
		ob_start();
		?>
		<p><b>Random quotes by Kanye Rest Api</b></p>
		<ol>
		<?php	
		for ($i=0; $i < 5; $i++) { 
			$curl = curl_init();

			curl_setopt_array($curl, array(
				CURLOPT_URL => 'https://api.kanye.rest/',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'GET',
			));

			$response = curl_exec($curl);
			$resp = json_decode($response);
			?>
			<li><?php echo $resp->quote; ?></li>
			<?php
		}
		?>
		</ol>
		<?php
		return ob_get_clean();
	}

	public function get_coffee()
	{
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://coffee.alexflipnote.dev/random.json',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'GET',
		));

		$response = curl_exec($curl);
		$resp = json_decode($response);
		curl_close($curl);
		ob_start();
		?>
		<center><img src="<?php echo $resp->file; ?>"></center>
		<?php
		return ob_get_clean();
	}

	public function get_projects()
	{
		ob_start();
		echo "";
		?>
		<div id="show_json">Loading...</div>
		<?php
		return ob_get_clean();
	}

	public function redirect_users_by_ip()
	{
		$user_ip = $_SERVER['REMOTE_ADDR'];
		if (!strpos($user_ip, '77.29') === 0) {
			wp_redirect('https://www.example.com');
			exit();
		}
	}

	public function register_projects_post_type() {
		$labels = array(
			'name'               => _x('Projects', 'post type general name', 'textdomain'),
			'singular_name'      => _x('Project', 'post type singular name', 'textdomain'),
			'menu_name'          => _x('Projects', 'admin menu', 'textdomain'),
			'name_admin_bar'     => _x('Project', 'add new on admin bar', 'textdomain'),
			'add_new'            => _x('Add New', 'project', 'textdomain'),
			'add_new_item'       => __('Add New Project', 'textdomain'),
			'new_item'           => __('New Project', 'textdomain'),
			'edit_item'          => __('Edit Project', 'textdomain'),
			'view_item'          => __('View Project', 'textdomain'),
			'all_items'          => __('All Projects', 'textdomain'),
			'search_items'       => __('Search Projects', 'textdomain'),
			'parent_item_colon'  => __('Parent Projects:', 'textdomain'),
			'not_found'          => __('No projects found.', 'textdomain'),
			'not_found_in_trash' => __('No projects found in Trash.', 'textdomain')
		);

		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array('slug' => 'projects'),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments')
		);

		register_post_type('projects', $args);
	}

	public function register_project_type_taxonomy() {
		$labels = array(
			'name'              => _x('Project Types', 'taxonomy general name', 'textdomain'),
			'singular_name'     => _x('Project Type', 'taxonomy singular name', 'textdomain'),
			'search_items'      => __('Search Project Types', 'textdomain'),
			'all_items'         => __('All Project Types', 'textdomain'),
			'parent_item'       => __('Parent Project Type', 'textdomain'),
			'parent_item_colon' => __('Parent Project Type:', 'textdomain'),
			'edit_item'         => __('Edit Project Type', 'textdomain'),
			'update_item'       => __('Update Project Type', 'textdomain'),
			'add_new_item'      => __('Add New Project Type', 'textdomain'),
			'new_item_name'     => __('New Project Type Name', 'textdomain'),
			'menu_name'         => __('Project Types', 'textdomain'),
		);

		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array('slug' => 'project-type'),
		);

		register_taxonomy('project_type', array('projects'), $args);
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Rop_Task_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Rop_Task_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/rop-task-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Rop_Task_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Rop_Task_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( 'my-cstms-js', plugin_dir_url( __FILE__ ) . 'js/rop-task-public.js', array( 'jquery' ), $this->version, false );
		$cstm_ajax_data = array(
			'admin_url' => admin_url( 'admin-ajax.php' ),
			'nonce'     => wp_create_nonce( 'cstm_nonce' ),
		);
		wp_localize_script( 'my-cstms-js', 'cstm_ajax', $cstm_ajax_data );

	}

}
