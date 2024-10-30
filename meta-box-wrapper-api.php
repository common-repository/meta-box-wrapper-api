<?php
/*
Plugin Name: Meta Box Wrapper API
Plugin URI: https://github.com/behrooz-tahanzadeh/meta-box-wrapper-api
Description: Simple is More!<br>This plugin is intended to provide a simple
			 and easy to hack API to add customized fields to post editor environment...  
Author: Behrooz Tahanzadeh
Version: 0.0
Author URI: http://b-tz.com/
*/

/*  Copyright YEAR  Behrooz Tahanzadeh  (email : behrooz.tahanzadeh@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/




class BtMetaGroup
{
	/**
	 * @var string ID String for use in the 'id' attribute of tags.
	 */
	public $id;
	
	
	
	
	/**
	 * @var string Title of the meta box.
	 */
	public $title;
	
	
	
	
	/**
	 * @var string		The screen on which to show the box (like a post type,
	 * 					'link', or 'comment'). Default is the current screen.
	 */
	public $screen;
	
	
	
	
	/**
	* @var string		The context within the screen where the boxes
 	*					should display. Available contexts vary from screen to
 	*					screen. Post edit screen contexts include 'normal', 'side',
 	*					and 'advanced'. Comments screen contexts include 'normal'
 	*					and 'side'. Menus meta boxes (accordion sections) all use
 	*					the 'side' context. Global default is 'advanced'.
	*/
	public $context;
	
	
	
	
	/**
	* @var string		The priority within the context where the boxes
 	*					should show ('high', 'low'). Default 'default'. 
	*/
	public $priority;

	
	
	
	/**
	* @var array		Contains all BtMetaField objects.		
	*/
	public $fields;
	
	
	
	
	/**
	 * Constructor
	 *
	 * @return BtMetaGroup
	 */
	function __construct($id, $title, $screen = null, $context = 'advanced', $priority = 'default', $fields=array())
	{
		$this->id = $id;
		$this->title = $title;
		$this->screen = $screen;
		$this->context = $context;
		$this->priority = $priority;
		$this->fields = $fields;
	}//eof
	
	
	
	
	/**
	* Push new field inti fields array.
	* 
	* @param BtMetaField $field
	* @return void
	*/
	public function addField($field)
	{
		$this->fields[] = $field;
	}//eof
	
	
	
	
	/**
	 * This function is callback function of add_meta_box function, which is called in addMetaBoxAction function.
	 * 
	 * @see addMetaBoxAction
	 * @param WP_Post $post
	 */
	public function render($post)
	{
		wp_nonce_field( $this->id.'_action', $this->id );
		
		foreach ($this->fields as $f):
			$f->render($post);
		endforeach;
	}//eof
	
	
	
	
	/**
	 * Add following line to your function.php file. This will render add meta box associated with this object.<br>
	 * add_action('add_meta_boxes', array(BtMetaGroupObject, 'addMetaBoxAction'));
	 * 
	 * @return void
	 */
	public function addMetaBoxAction()
	{
		if($this->screen == null):
			add_meta_box(
				$this->id,
				$this->title,
				array($this,'render'),
				$this->screen,
				$this->context,
				$this->priority
			);
		else:
			foreach ( $this->screen as $screen )
				add_meta_box(
					$this->id,
					$this->title,
					array($this,'render'),
					$screen,
					$this->context,
					$this->priority
				);
		endif;
	}//eof
	
	
	
	
	/**
	 * Add following line to your function.php file. This will save meta data fields.<br>
	 * add_action('save_post', array($btMetaGroup, 'saveMetaBoxAction'));
	 * 
	 * @param int $post_id
	 */
	public function savePostAction($post_id)
	{
		// Bail if we're doing an auto save
		if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
		 
		// if our nonce isn't there, or we can't verify it, bail
		if( !isset( $_POST[$this->id] ) || !wp_verify_nonce( $_POST[$this->id], $this->id.'_action' ) ) return;
		 
		// if our current user can't edit this post, bail
		if( !current_user_can( 'edit_post' ) ) return;
		
		foreach ($this->fields as $f):
			$f->save($post_id);
		endforeach;
	}//eof
	
	
	
	
}//eoc




require_once 'load.php';