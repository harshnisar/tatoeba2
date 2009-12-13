<?php
/*
    Tatoeba Project, free collaborativ creation of languages corpuses project
    Copyright (C) 2009  HO Ngoc Phuong Trang (tranglich@gmail.com)

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU Affero General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU Affero General Public License for more details.

    You should have received a copy of the GNU Affero General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

class Sentence extends AppModel{
	var $name = 'Sentence';
	
	const MAX_CORRECTNESS = 6; // This is not much in use. Should probably remove it someday
	
	//var $languages = array('ar', 'bg', 'cs', 'de', 'el', 'en', 'eo', 'es', 'fr', 'he', 'it', 'id', 'jp', 'ko', 'nl', 'pt', 'ru', 'tr', 'uk', 'vn', 'zh', null);
    var $languages = array(
        'ara' ,'bul' ,'deu' ,'ell' ,'eng',
        'epo' ,'spa' ,'fra' ,'heb' ,'ind',
        'jpn' ,'kor' ,'nld' ,'por' ,'rus',
        'vie' ,'cmn' ,'ces' ,'fin' ,'ita',
        'tur' ,'ukr' ,'wuu' ,
         null
        );	
	var $validate = array(
		'lang' => array(
			'rule' => array() 	
			// The rule will be defined in the constructor. 
			// I would have declared a const LANGUAGES array 
			// to use it here, but apprently you can't declare 
			// const arrays in PHP.
		),
		'text' => array(
			'rule' => array('minLength', '1')
		)
	);	

	var $hasMany = array('Contribution', 'SentenceComment', 
			'Favorites_users' => array ( 
					'classname'  => 'favorites',
					'foreignKey' => 'favorite_id'  )
			 );
	
	var $belongsTo = array('User');
	
	var $hasAndBelongsToMany = array(
		'Translation' => array(
			'className' => 'Translation',
			'joinTable' => 'sentences_translations',
			'foreignKey' => 'translation_id',
			'associationForeignKey' => 'sentence_id'
		),
		'InverseTranslation' => array(
			'className' => 'InverseTranslation',
			'joinTable' => 'sentences_translations',
			'foreignKey' => 'sentence_id',
			'associationForeignKey' => 'translation_id'
		),
		'SentencesList'
	);
	
	/**
	 * The constructor is here only to set the rule for languages.
	 */
	function __construct() {
		parent::__construct();
		$this->validate['lang']['rule'] = array('inList', $this->languages);
	}
	
	function afterSave($created){
		if(isset($this->data['Sentence']['text'])){
			$whoWhenWhere = array(
				  'user_id' => $this->data['Sentence']['user_id']
				, 'datetime' => date("Y-m-d H:i:s")
				, 'ip' => $_SERVER['REMOTE_ADDR']
			);
			
			$data['Contribution'] = $whoWhenWhere;
			$data['Contribution']['sentence_id'] = $this->id;
			$data['Contribution']['sentence_lang'] = $this->data['Sentence']['lang'];
			$data['Contribution']['text'] = $this->data['Sentence']['text'];
			$data['Contribution']['type'] = 'sentence';
			
			if($created){
				$data['Contribution']['action'] = 'insert';
				
				if(isset($this->data['Translation'])){
					// Translation logs
					$data2['Contribution'] = $whoWhenWhere;
					$data2['Contribution']['sentence_id'] = $this->data['Translation']['Translation'][0];
					$data2['Contribution']['sentence_lang'] = $this->data['Sentence']['sentence_lang'];
					$data2['Contribution']['translation_id'] = $this->id;
					$data2['Contribution']['translation_lang'] = $this->data['Sentence']['lang'];
					$data2['Contribution']['action'] = 'insert';
					$data2['Contribution']['type'] = 'link';
					$contributions[] = $data2;
				}
				if(isset($this->data['InverseTranslation'])){
					// Inverse translation logs
					$data2['Contribution'] = $whoWhenWhere;
					$data2['Contribution']['sentence_id'] = $this->id;
					$data2['Contribution']['sentence_lang'] = $this->data['Sentence']['lang'];
					$data2['Contribution']['translation_id'] = $this->data['Translation']['Translation'][0];
					$data2['Contribution']['translation_lang'] = $this->data['Sentence']['sentence_lang'];
					$data2['Contribution']['action'] = 'insert';
					$data2['Contribution']['type'] = 'link';
					$contributions[] = $data2;
				}
				if(isset($contributions)){
					$this->Contribution->saveAll($contributions);
				}
				
			}else{
				$data['Contribution']['action'] = 'update';
			}
			$this->Contribution->save($data);
		}
	}
	
	function afterDelete(){
		$data['Contribution']['sentence_id'] = $this->data['Sentence']['id'];
		$data['Contribution']['sentence_lang'] = $this->data['Sentence']['lang'];
		$data['Contribution']['text'] = $this->data['Sentence']['text'];
		$data['Contribution']['action'] = 'delete';
		$data['Contribution']['user_id'] = $this->data['User']['id'];
		$data['Contribution']['datetime'] = date("Y-m-d H:i:s");
		$data['Contribution']['ip'] = $_SERVER['REMOTE_ADDR'];
		$data['Contribution']['type'] = 'sentence';
		$this->Contribution->save($data);
		
		foreach($this->data['Translation'] as $translation){
			$data2['Contribution']['sentence_id'] = $this->data['Sentence']['id'];
			$data2['Contribution']['sentence_lang'] = $this->data['Sentence']['lang'];
			$data2['Contribution']['translation_id'] = $translation['id'];
			$data2['Contribution']['translation_lang'] = $translation['lang'];
			$data2['Contribution']['action'] = 'delete';
			$data2['Contribution']['user_id'] = $this->data['User']['id'];
			$data2['Contribution']['datetime'] = date("Y-m-d H:i:s");
			$data2['Contribution']['ip'] = $_SERVER['REMOTE_ADDR'];
			$data2['Contribution']['type'] = 'link';
			$contributions[] = $data2;
			
			$data2['Contribution']['sentence_id'] = $translation['id'];
			$data2['Contribution']['sentence_lang'] = $translation['lang'];
			$data2['Contribution']['translation_id'] = $this->data['Sentence']['id'];
			$data2['Contribution']['translation_lang'] = $this->data['Sentence']['lang'];
			$data2['Contribution']['action'] = 'delete';
			$data2['Contribution']['user_id'] = $this->data['User']['id'];
			$data2['Contribution']['datetime'] = date("Y-m-d H:i:s");
			$data2['Contribution']['ip'] = $_SERVER['REMOTE_ADDR'];
			$data2['Contribution']['type'] = 'link';
			$contributions[] = $data2;
		}
		if(isset($contributions)){
			$this->Contribution->saveAll($contributions);
		}
	}

    /*
    ** search one random chinese/japanese sentence containing $sinogram
    ** return the id of this sentence
    */
    function searchOneExampleSentenceWithSinogram($sinogram){
        $results = $this->query("
        SELECT Sentence.id  FROM sentences AS Sentence 
            JOIN ( SELECT (RAND() *(SELECT MAX(id) FROM sentences)) AS id) AS r2
            WHERE Sentence.id >= r2.id
                AND Sentence.lang IN ( 'jpn','cmn','wuu')
                AND Sentence.text LIKE ('%$sinogram%')
            ORDER BY Sentence.id ASC LIMIT 1
       ");
       
       return $results[0]['Sentence']['id'] ;  
    }
    
    /*
    ** get the highest id for sentences
    */
    function getMaxId(){
        $resultMax = $this->query('SELECT MAX(id) FROM sentences');
        return $resultMax[0][0]['MAX(id)'];
    }
    
    /*
    ** get the id of a random sentence, from a particular language if $lang is set
    */
    function getRandomId($lang = null){
        /*
        ** this query take constant time when lang=null
        ** and linear time when lang is set, so do not touch this request
        */

        
        if ( $lang != null AND $lang !='any' ){
        $query= ("SELECT Sentence.id FROM sentences AS Sentence
                WHERE Sentence.lang = '$lang'
                ORDER BY RAND() LIMIT 1 "
                );

        } else {
        $query = 'SELECT Sentence.id  FROM sentences AS Sentence 
                JOIN ( SELECT (RAND() *(SELECT MAX(id) FROM sentences)) AS id) AS r2
                WHERE Sentence.id >= r2.id
                ORDER BY Sentence.id ASC LIMIT 1' ;
        }

        $results = $this->query($query);
        /*
        while( !isset($results[0])){
            $results = $this->query($query);
        }
        */
        return $results[0]['Sentence']['id']; 
    }

    /*
    ** get the sentence with the given id
    */
    function getSentenceWithId($id){
        $this->id = $id;
        return $this->read();

    }

}
?>
