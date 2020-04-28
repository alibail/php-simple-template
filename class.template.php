<?php
/***
 * A Really Simple PHP Template Class
 * Author: Alistair Baillie
 *
 * Copyright 2012 - 2020 Alistair Baillie
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 ***/

class Template {
 	var $variable_names = array();
	var $template_files = array();
	var $template_path = "";

	function __construct( $template_path ) {
		$this->template_path = $template_path;
	}

	function load( $template_id, $template_name, $path = "" ) {
		if ( $path == "" ) { $path = $this->template_path; }
		if ( !file_exists( $path.$template_name ) ) { die ( "Failed to locate template: " . $path.$template_name ); }
		$this->template_files[$template_id] = @fread( $fp = fopen( $path.$template_name, 'r'), filesize( $path.$template_name ) );
		fclose( $fp );
		$this->parse_sections( $template_id );
	}

	function parse_sections( $template_id ) {
		$tmp = "";
    $tmp = preg_replace_callback('/\[\[([A-Za-z]*)\]\]([\W\w.]*)\[\[\/\\1\]\]/', function ( $matches ) use ($template_id) {
      return $this->parse_sections_actual($template_id,$matches[1],$matches[2]);
    },$this->template_files[$template_id]);
    $this->template_files[$template_id] = $tmp;
	}

	function parse_sections_actual( $template_id, $id, $content ) {
		$this->template_files[$template_id . "." . $id] = $content;
		$this->parse_sections( $template_id . "." . $id );
		return "{{tplSub" . $id . "}}";
	}

  function add_var( $variable_name, $variable_value, $dovar_replace = false ){
   	if( !$dovar_replace ) {
      	$this->variable_names[$variable_name] = $variable_value;
		} else {
			  $this->variable_names[$variable_name] = preg_replace_callback('/{{([A-Za-z0-9]*)}}/',function ( $matches ) { return $this->variable_names[$matches[1]]; }, $variable_value);
    }
  }

  function do_var_replace( $string ) {
    return preg_replace_callback ('/{{([A-Za-z0-9]*)}}/', function ( $matches ) { return $this->variable_names[$matches[1]]; }, $string );
  }

  function build( $template_id ){
    $tmpFile = "";
    $tmpFile = preg_replace_callback ('/{{([A-Za-z0-9]*)}}/', function ( $match ) {
      return $this->variable_names[$match[1]]; }, $this->template_files[$template_id]);
    return $tmpFile;
  }

	function output_raw_template( $template_id ) {
		return $this->template_files[$template_id];
	}
 }
?>
