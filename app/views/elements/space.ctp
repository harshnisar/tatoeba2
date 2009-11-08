<?php
/*
    Tatoeba Project, free collaborativ creation of languages corpuses project
    Copyright (C) 2009 Etienne Deparis <etienne.deparis@umaneti.net>

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
$lang = 'eng';
if (isset($this->params['lang'])) {
	Configure::write('Config.language',  $this->params['lang']);
	$lang = $this->params['lang'];
}
?>
<strong><?php echo $session->read('Auth.User.username'); ?> : </strong>
<ul>
	<li><?php echo $html->link(__('Inbox', true), array('controller' => 'private_messages', 'action' => 'folder', 'Inbox')); ?></li>
	<li><?php echo $html->link(__('Comments',true), array('controller' => 'sentence_comments', 'action' => 'index')); ?></li>
	<li><?php echo $html->link(__('Log out',true), array('controller' => 'users', 'action' => 'logout')); ?></li>
</ul>
