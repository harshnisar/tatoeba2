<?php
/*
    Tatoeba Project, free collaborative creation of multilingual corpuses project
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

$javascript->link('sentences_lists.remove_sentence_from_list.js', false);

echo '<div id="main_content">';
echo '<div class="module">';

$navigation->displaySentencesListsNavigation();

echo '<h2>'.$list['SentencesList']['name'].'</h2>';

if(count($list['Sentence']) > 0){
	echo '<ul id="'.$list['SentencesList']['id'].'" class="sentencesList">';
	foreach($list['Sentence'] as $sentence){
		echo '<li id="sentence'.$sentence['id'].'">';
			// display sentence
			$sentences->displaySentence($sentence);
			
			// remove from list option
			echo '<a id="'.$sentence['id'].'" class="removeFromListButton">';
			__('remove from list');
			echo '</a>';
		echo '</li>';
	}
	echo '</ul>';
}else{
	__('This list does not have any sentence');
}
echo '</div>';
echo '</div>';
?>