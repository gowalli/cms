<?php

class content extends DatabaseObject {
	function __construct() {
		$this->_setPrimaryKey('content_id');
	}

	function load_page_content($page_id) {
		// Then get the content sections on this page
                $contents = Content::fetchArray(array('page_id' => $page_id));
                $root_content = (object)array('children' => array());
                $content_objects = array();
                foreach($contents as $content) {
                        // If this is a root content section, add it to the root
                        if($content->content_parent == 0) {
                                array_push($root_content->children, $content);
                        }
                        else {
                                $this->_insert_child_content($root_content, $content);
                        }

                        if(strlen($content->content_container)) {
                                $content_objects[$content->content_container] = $content;
                        }
                }

		// Go over the content objects and set their HTML
                foreach($content_objects as $content_object) {
                        $vars[$content_object->content_container] = $content_object->content_html;
                }

		return($content_objects);
	}

	function _insert_child_content(&$object, $content) {
                if(@$object->content_id == $content->content_parent) {
                        array_push($object->children, $content);
                }

                for($i = 0; $i < sizeof(@$object->children); $i++) {
                        if($object->children[$i]->content_id == $content->content_parent) {
                                if(is_array(@$object->children[$i]->children))
                                        array_push($object->children[$i]->children, $content);
                                else {
                                        $object->children[$i]->children = array();
                                        array_push($object->children[$i]->children, $content);
                                }
                        }
                        else {
                                $this->_insert_child_content($object->children[$i], $content);
                        }
                }
        }
}
