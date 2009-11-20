/*
    Tatoeba Project, free collaborative creation of multilingual corpuses project
    Copyright (C) 2009  HO Ngoc Phuong Trang <tranglich@gmail.com>

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

$(document).ready(function() {

	$("#romanizationOption").change(function(){
		var urlExercise = $('.printAsExerciseOption').attr('href');
		var urlCorrection = $('.printAsCorrectionOption').attr('href');
		
		if($(this).is(':checked')){
			$('.printAsExerciseOption').attr('href', urlExercise.replace(/hide_/, 'display_'));
			$('.printAsCorrectionOption').attr('href', urlCorrection.replace(/hide_/, 'display_'));
		}else{
			$('.printAsExerciseOption').attr('href', urlExercise.replace(/display_/, 'hide_'));
			$('.printAsCorrectionOption').attr('href', urlCorrection.replace(/display_/, 'hide_'));
		}
	}); // I'm too lazy to do something more generic, sorry.

});